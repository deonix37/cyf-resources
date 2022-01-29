@extends('layouts.app')

@section('title', __('Publish a new resource'))

@section('content')
<main class="sm:container sm:mx-auto sm:py-4 sm:max-w-lg">
  <section class="flex flex-col break-words bg-white sm:rounded-md sm:shadow-lg">
    <div class="flex items-center px-6 py-4 bg-gray-200 sm:rounded-t-md">
      <h1 class="mx-auto text-center text-2xl text-gray-700 font-bold">{{ __('Publish a new resource') }}</h1>
    </div>
    <form class="p-6" action="{{ route('resources.store') }}" method="post">
      @csrf
      <div>
        <label class="flex flex-col">
          <span class="text-lg font-medium">{{ __('Title') }} *</span>
          <input class="mt-2 px-3 py-2 border border-gray-300 rounded-md" name="title" placeholder="Poseur Reskin 1.0"
                 value="{{ old('title') }}" required>
        </label>
        @error('title')
          <div class="mt-2 text-sm font-bold text-red-600">{{ $message }}</div>
        @enderror
      </div>
      <div class="mt-4">
        <label class="flex flex-col">
          <span class="text-lg font-medium">{{ __('Description') }}</span>
          <textarea class="mt-2 px-3 py-2 border border-gray-300 rounded-md leading-normal" name="description"
                    placeholder="Finally done after three years">{{ old('description') }}</textarea>
        </label>
        @error('description')
          <div class="mt-2 text-sm font-bold text-red-600">{{ $message }}</div>
        @enderror
      </div>
      <div class="mt-4">
        <label class="flex flex-col">
          <span class="text-lg font-medium">{{ __('Preview URL') }}</span>
          <input class="mt-2 px-3 py-2 border border-gray-300 rounded-md" name="preview_url"
                 placeholder="https://i.imgur.com/DET98vU.jpg" value="{{ old('preview_url') }}">
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
                 placeholder="dQw4w9WgXcQ" value="{{ old('youtube_video_id') }}">
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
                      @if ($engineRelease->id == old('engine_release_id')) selected @endif>{{ $engineRelease->engine->title }} {{ $engineRelease->version }}</option>
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
                     @if ($resourceType->id == old('resource_type_id')) checked @endif>{{ $resourceType->title }}
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
                   placeholder="https://example.com/resource" value="{{ old('links.' . $loop->index) }}">
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
  </section>
</main>
@endsection
