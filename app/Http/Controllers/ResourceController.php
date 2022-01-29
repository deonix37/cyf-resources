<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResourceRequest;
use App\Models\Engine;
use App\Models\EngineRelease;
use App\Models\Resource;
use App\Models\ResourceType;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ResourceController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified')->except(['index', 'show']);
        $this->authorizeResource(Resource::class, null, [
            'except' => ['index', 'show'],
        ]);
    }

    public function index(Request $request)
    {
        return view('resources.index', [
            'resources' => $this->getResources($request),
            'resourceTypes' => $this->getResourceTypes(),
            'engines' => $this->getEngines(),
        ]);
    }

    public function create()
    {
        return view('resources.create', [
            'resourceTypes' => $this->getResourceTypes(),
            'engineReleases' => $this->getEngineReleases(),
        ]);
    }

    public function store(ResourceRequest $request)
    {
        $resource = Resource::create(
            Arr::except($request->validated(), 'links'),
        );
        $resource->resourceLinks()->createMany(
            $request->validated()['links'],
        );

        return Redirect::route('resources.show', $resource);
    }

    public function show(Resource $resource)
    {
        return view('resources.show', [
            'resource' => $this->getResource($resource),
        ]);
    }

    public function edit(Resource $resource)
    {
        return view('resources.edit', [
            'resource' => $this->getResource($resource),
            'resourceTypes' => $this->getResourceTypes(),
            'engineReleases' => $this->getEngineReleases(),
        ]);
    }

    public function update(ResourceRequest $request, Resource $resource)
    {
        $resource->update(Arr::except(
            $request->validated(),
            ['uploader_id', 'slug', 'links'],
        ));
        $resource->resourceLinks()->delete();
        $resource->resourceLinks()->createMany(
            $request->validated()['links'],
        );

        return Redirect::route('resources.show', $resource);
    }

    public function updateStatus(Request $request, Resource $resource)
    {
        $resource->update($request->validate([
            'is_draft' => ['required', 'boolean'],
        ]));

        return Redirect::route('resources.show', $resource);
    }

    public function destroy(Resource $resource)
    {
        $resource->delete();

        return Redirect::route('resources.index');
    }

    protected function getResource(Resource $resource) {
        return $resource->load([
            'uploader', 'resourceType', 'engineRelease.engine',
            'resourceLinks', 'upvoters', 'currentUserUpvote',
        ])->loadCount('upvoters');
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
                $request->input('engines'),
                function ($query, $engines) {
                    if (is_array($engines)) {
                        $query->whereHas(
                            'engineRelease.engine',
                            fn ($subquery) =>
                                $subquery->whereIn('id', $engines),
                        );
                    }
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
            )->with([
                'uploader', 'resourceType', 'engineRelease', 'resourceLinks',
                'upvoters', 'currentUserUpvote',
            ])->paginate(15);
    }

    protected function getResourceTypes() {
        return ResourceType::all();
    }

    protected function getEngines() {
        return Engine::all();
    }

    protected function getEngineReleases() {
        return EngineRelease::select('engine_releases.*')
            ->with('engine')
            ->join(
                'engines', 'engine_releases.engine_id', '=', 'engines.id',
            )
            ->orderBy('engines.title')
            ->orderBy('version', 'desc')
            ->get();
    }

    protected function resourceAbilityMap()
    {
        return parent::resourceAbilityMap() + [
            'updateStatus' => 'updateStatus',
        ];
    }
}
