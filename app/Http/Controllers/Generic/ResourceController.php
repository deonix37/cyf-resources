<?php

namespace App\Http\Controllers\Generic;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResourceRequest;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class ResourceController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Resource::class, null, [
            'except' => ['index', 'show'],
        ]);
    }

    public function index(Request $request)
    {
        return $this->getResources($request);
    }

    public function store(ResourceRequest $request)
    {
        $data = $request->validated();
        $resource = Resource::create(Arr::except($data, 'links'));
        $resource->resourceLinks()->createMany($data['links']);

        return $resource;
    }

    public function show(Resource $resource)
    {
        return $resource;
    }

    public function update(ResourceRequest $request, Resource $resource)
    {
        $data = $request->validated();
        $resource->update(Arr::except($data, 'links'));
        $resource->resourceLinks()->delete();
        $resource->resourceLinks()->createMany($data['links']);

        return $resource;
    }

    public function updateStatus(Request $request, Resource $resource)
    {
        $resource->update($request->validate([
            'is_draft' => ['required', 'boolean'],
        ]));

        return $resource;
    }

    public function destroy(Resource $resource)
    {
        $resource->delete();
    }

    protected function getResources(Request $request) {
        return Resource::withCount('upvoters')
            ->when(
                $request->input('q'),
                fn ($query, $q) => $query->where('title', 'like', "%$q%"),
            )->when(
                $request->input('sorting', 'newest'),
                function ($query, $sorting) {
                    switch ($sorting) {
                        case 'newest':
                            return $query->latest();
                        case 'oldest':
                            return $query->oldest();
                        case 'most_upvoted':
                            return $query->orderBy('upvoters_count', 'desc');
                        default:
                            return $query->latest();
                    }
                },
            )->when(
                $request->input('resource_types'),
                function ($query, $resourceTypes) {
                    if (is_array($resourceTypes)) {
                        $query->whereIn('resource_type_id', $resourceTypes);
                    }
                }
            )->when(
                $request->input('engine_release'),
                function ($query, $engineRelease) {
                    $query->where('engine_release_id', $engineRelease);
                }
            )->when(
                $request->boolean('user_published'),
                function ($query) {
                    if (Auth::check()) {
                        $query->whereBelongsTo(Auth::user(), 'uploader');
                    }
                },
            )->when(
                $request->boolean('user_upvoted'),
                function ($query) {
                    if (Auth::check()) {
                        $query->whereRelation(
                            'upvoters', 'upvoter_id', Auth::id(),
                        );
                    }
                },
            )->when(
                $request->input('status', 'public'),
                function ($query, $status) {
                    if (Auth::user()->is_staff ?? false) {
                        $query->where('is_draft', $status === 'draft');
                    } else {
                        $query->where('is_draft', false);
                    }
                },
            );
    }

    protected function resourceAbilityMap()
    {
        return parent::resourceAbilityMap() + [
            'updateStatus' => 'updateStatus',
        ];
    }
}
