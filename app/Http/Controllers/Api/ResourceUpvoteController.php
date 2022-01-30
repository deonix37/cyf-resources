<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use App\Models\ResourceUpvoter;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ResourceUpvoteController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(ResourceUpvoter::class, 'upvote');
    }

    public function index(Resource $resource)
    {
        $upvotes = ResourceUpvoter::whereBelongsTo($resource);

        return Response::json($upvotes->get(), 200, [
            'X-Total-Count' => $upvotes->count(),
            'X-User-Upvote-Id' => $upvotes->where('upvoter_id', Auth::id())
                ->pluck('id')->first(),
        ]);
    }

    public function store(Resource $resource)
    {
        try {
            $upvote = ResourceUpvoter::create([
                'resource_id' => $resource->id,
                'upvoter_id' => Auth::id(),
            ]);
        } catch (QueryException) {
            abort(400);
        }

        return Response::json($upvote, 201, [
            'Location' => Route('upvotes.show', $upvote),
        ]);
    }

    public function show(ResourceUpvoter $upvote)
    {
        return $upvote;
    }

    public function destroy(ResourceUpvoter $upvote)
    {
        $upvote->delete();

        return Response::noContent();
    }
}
