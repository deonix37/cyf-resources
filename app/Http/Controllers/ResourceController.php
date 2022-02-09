<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Generic\ResourceController as GenericResourceController;
use App\Http\Requests\ResourceRequest;
use App\Models\Engine;
use App\Models\EngineRelease;
use App\Models\Resource;
use App\Models\ResourceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ResourceController extends GenericResourceController
{
    public function __construct()
    {
        $this->middleware('verified')->except(['index', 'show']);
        parent::__construct();
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
        return Redirect::route('resources.show', parent::store($request));
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
        return Redirect::route(
            'resources.show', parent::update($request, $resource),
        );
    }

    public function updateStatus(Request $request, Resource $resource)
    {
        return Redirect::route(
            'resources.show', parent::updateStatus($request, $resource),
        );
    }

    public function destroy(Resource $resource)
    {
        parent::destroy($resource);

        return Redirect::route('resources.index');
    }

    protected function getResource(Resource $resource) {
        return $resource->load([
            'uploader', 'resourceType', 'engineRelease.engine',
            'resourceLinks', 'upvoters', 'currentUserUpvote',
        ])->loadCount('upvoters');
    }

    protected function getResources(Request $request) {
        return parent::getResources($request)->with([
            'uploader', 'resourceType', 'engineRelease', 'resourceLinks',
            'upvoters', 'currentUserUpvote',
        ])->paginate(15);
    }

    protected function getResourceTypes() {
        return ResourceType::orderBy('title')->get();
    }

    protected function getEngines() {
        return Engine::orderBy('title')->get();
    }

    protected function getEngineReleases() {
        return EngineRelease::with('engine')
            ->orderBy(Engine::select('title')->whereColumn(
                'id', 'engine_releases.engine_id',
            ))
            ->orderBy('version', 'desc')
            ->get();
    }
}
