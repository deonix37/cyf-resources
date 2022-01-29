@extends('layouts.app')

@section('title', __('Edit resource'))

@section('js')
  @parent
  <script src="{{ mix('js/resources.edit.js') }}" defer></script>
@endsection

@section('content')
<main class="sm:container sm:mx-auto sm:py-4 sm:max-w-lg">
  <section class="flex flex-col break-words bg-white sm:rounded-md sm:shadow-lg">
    <div class="flex items-center px-6 py-4 bg-gray-200 sm:rounded-t-md">
      <h1 class="mx-auto text-center text-2xl text-gray-700 font-bold">{{ __('Edit resource') }}</h1>
    </div>
    <div class="p-6">
      <form action="{{ route('resources.update', $resource) }}" method="post">
        @csrf
        @method('PUT')
        <div>
          <label class="flex flex-col">
            <span class="text-lg font-medium">{{ __('Title') }} *</span>
            <input class="mt-2 px-3 py-2 border border-gray-300 rounded-md" name="title" placeholder="Poseur Reskin 1.0"
                  value="{{ old('title', $resource->title) }}" required>
          </label>
          @error('title')
            <div class="mt-2 text-sm font-bold text-red-600">{{ $message }}</div>
          @enderror
        </div>
        <div class="mt-4">
          <label class="flex flex-col">
            <span class="text-lg font-medium">{{ __('Description') }}</span>
            <textarea class="mt-2 px-3 py-2 border border-gray-300 rounded-md leading-normal" name="description"
                      placeholder="Finally done after three years">{{ old('description', $resource->description) }}</textarea>
          </label>
          @error('description')
            <div class="mt-2 text-sm font-bold text-red-600">{{ $message }}</div>
          @enderror
        </div>
        <div class="mt-4">
          <label class="flex flex-col">
            <span class="text-lg font-medium">{{ __('Preview URL') }}</span>
            <input class="mt-2 px-3 py-2 border border-gray-300 rounded-md" name="preview_url"
                   placeholder="https://i.imgur.com/DET98vU.jpg"
                   value="{{ old('preview_url', $resource->preview_url) }}">
            <span class="mt-1 text-sm text-gray-500">
              Allowed formats: jpg, jpeg, png
            </span>
          </label>
          @error('preview_url')
            <div class="mt-2 text-sm font-bold text-red-600">{{ $message }}</div>
          @enderror
        </div>
        <div class="mt-4">
          <label class="flex flex-col">
            <span class="text-lg font-medium">{{ __('Youtube video ID') }}</span>
            <input class="mt-2 px-3 py-2 border border-gray-300 rounded-md" name="youtube_video_id"
                   placeholder="dQw4w9WgXcQ" value="{{ old('youtube_video_id', $resource->youtube_video_id) }}">
            <span class="mt-1 text-sm text-gray-500">
              https://youtube.com/watch?v=<span class="font-bold">ID</span>?t=123
            </span>
          </label>
          @error('youtube_video_id')
            <div class="mt-2 text-sm font-bold text-red-600">{{ $message }}</div>
          @enderror
        </div>
        <div class="mt-4">
          <label class="flex flex-col">
            <span class="text-lg font-medium">{{ __('Engine') }}</span>
            <select class="mt-2 p-2 border border-gray-300 rounded-md" name="engine_release_id">
              <option value="">{{ __('Select an engine release') }}</option>
              @foreach ($engineReleases as $engineRelease)
                <option value="{{ $engineRelease->id }}"
                        @if ($engineRelease->id == old('engine_release_id', $resource->engine_release_id)) selected @endif>
                  {{ $engineRelease->engine->title }} {{ $engineRelease->version }}
                </option>
              @endforeach
            </select>
          </label>
          @error('engine_release_id')
            <div class="mt-2 text-sm font-bold text-red-600">{{ $message }}</div>
          @enderror
        </div>
        <div class="mt-4">
          <div class="text-lg font-medium">{{ __('Type') }} *</div>
          <div class="flex flex-col mt-2 space-y-2">
            @foreach ($resourceTypes as $resourceType)
              <label>
                <input class="mr-1" type="radio" name="resource_type_id" value="{{ $resourceType->id }}" required
                       @if ($resourceType->id == old('resource_type_id', $resource->resource_type_id)) checked @endif>
                {{ $resourceType->title }}
              </label>
            @endforeach
          </div>
          @error('resource_type_id')
            <div class="mt-2 text-sm font-bold text-red-600">{{ $message }}</div>
          @enderror
        </div>
        <div class="mt-5 pt-3 border-t-2 border-gray-200">
          <div class="flex flex-col">
            <span class="text-lg font-medium">{{ __('Download links') }} *</span>
            @foreach (range(0, 2) as $i)
              <input class="mt-2 px-3 py-2 border border-gray-300 rounded-md" name="links[{{ $loop->index }}]"
                     placeholder="https://example.com/resource"
                     value="{{ old('links.' . $loop->index, $resource->resourceLinks[$loop->index]->url ?? null) }}">
              @error('links.' . $loop->index)
                <div class="mt-2 text-sm font-bold text-red-600">{{ $message }}</div>
              @enderror
            @endforeach
            @error('links')
              <div class="mt-2 text-sm font-bold text-red-600">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <button class="block mt-4 mx-auto px-10 py-4 w-full rounded-2xl bg-gray-700 font-bold text-xl text-white
                       hover:opacity-90">{{ __('Submit') }}</button>
      </form>
      <form id="destroy-form" class="mt-2" action="{{ route('resources.destroy', $resource) }}" method="post">
        @csrf
        @method('DELETE')
        <button class="block mx-auto px-10 py-4 w-full rounded-2xl bg-rose-600 font-bold text-xl text-white
                       hover:opacity-90">{{ __('Delete') }}</button>
      </form>
    </div>
  </section>
</main>
@endsection
