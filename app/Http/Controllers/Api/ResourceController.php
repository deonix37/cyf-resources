<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Generic\ResourceController as GenericResourceController;
use App\Http\Requests\ResourceRequest;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ResourceController extends GenericResourceController
{
    public function __construct()
    {
        $this->middleware('verified:sanctum')->except(['index', 'show']);
        parent::__construct();
    }

    public function index(Request $request)
    {
        return $this->getResources($request)->paginate(15);
    }

    public function store(ResourceRequest $request)
    {
        $resource = parent::store($request);

        return Response::json($resource, 201, [
            'Location' => route('resources.show', $resource),
        ]);
    }

    public function update(ResourceRequest $request, Resource $resource)
    {
        return parent::update($request, $resource);
    }

    public function destroy(Resource $resource)
    {
        parent::destroy($resource);

        return Response::noContent();
    }
}
