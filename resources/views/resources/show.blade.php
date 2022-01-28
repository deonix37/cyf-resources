@extends('layouts.app')

@section('title', $resource->title)

@section('js')
  @parent
  <script src="{{ mix('js/resources.js') }}" defer></script>
  <script src="{{ mix('js/resources.show.js') }}" defer></script>
@endsection

@section('content')
<main class="sm:container sm:mx-auto sm:py-4 sm:max-w-xl">
  <section class="flex flex-col break-words bg-white sm:rounded-md sm:shadow-lg">
    <div class="relative flex justify-center items-center px-6 py-4 bg-gray-200 sm:rounded-t-md">
      <h1 class="px-12 max-w-full text-center text-2xl text-gray-700 font-bold">{{ $resource->title }}</h1>
      @can('update', $resource)
        <a class="absolute right-0 px-6 py-4" href="{{ route('resources.edit', $resource) }}" title="{{ __('Edit') }}">
          <svg class="fill-slate-700" width="24px" height="24px" viewBox="0 0 860 860">
            <path d="M515.582,157.916l-439.199,439.2l4.6,10.1l27.1,58.8l41.6,22c9.8,5.2,17.7,13.101,22.9,22.9l22,41.6l58.8,27.101
                     l10.101,4.6l439.2-439.2L515.582,157.916z"/>
            <path d="M853.282,159.216l-151.8-151.8c-4.9-4.9-11.3-7.3-17.7-7.3s-12.8,2.4-17.7,7.3l-129.3,129.3l187.2,187.2l129.3-129.3
                     C863.082,184.816,863.082,169.016,853.282,159.216z"/>
            <path d="M46.083,650.016l-4.3,16.9l-41,162.5c-4.1,16.2,8.5,31.1,24.1,31.1c2,0,4.1-0.3,6.2-0.8l162.5-41l16.9-4.3l16.9-4.3
                     l13.3-3.4l-30.9-14.2l-29.5-13.5c-5-2.3-9.1-6.199-11.7-11l-18.6-35.1l-4.3-8c-2.3-4.4-6-8.1-10.4-10.4l-8-4.3l-35.1-18.6
                     c-4.9-2.601-8.7-6.7-11-11.7l-13.5-29.5l-14.2-30.9l-3.4,13.301L46.083,650.016z"/>
          </svg>
        </a>
      @endcan
    </div>
    <div class="p-4" data-resource="{{ $resource->slug }}">
      @if ($resource->is_draft)
        <div class="p-4 rounded-md bg-sky-200 text-sky-800 text-lg font-bold mb-4">
          {{ __("This submission is awaiting moderator's approval.") }}
        </div>
      @endif
      @php $upvoted = $resource->upvoters->contains(Auth::id()) @endphp
      @php $uploaderName = $resource->uploader->username ?? __('???') @endphp
      <div class="relative w-full">
        <img class="w-full object-cover object-top rounded-lg
                    @if ($resource->youtube_video_id) invisible @endif"
             src="{{ url('images/preview-default.png') }}"
             alt="{{ __('Preview') }}" width="320" height="180">
        @if ($resource->youtube_video_id)
          <iframe class="absolute top-0 left-0 w-full h-full rounded-lg" title="YouTube video player"
                  src="https://www.youtube.com/embed/{{ $resource->youtube_video_id }}"
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                  allowfullscreen></iframe>
        @endif
      </div>
      <div class="px-4">
        <div class="flex flex-col justify-between items-center mt-4 w-full space-y-2 sm:flex-row sm:space-y-0">
          <div class="text-center sm:text-left leading-tight">
            <div>
              <span>{{ __($resource->is_draft ? 'Draft by' : 'Published by') }}</span>
              <span class="font-bold break-all">{{ $uploaderName }}</span>
            </div>
            <div class="mt-1">
              <span>{{ __('on') }}</span>
              <span class="font-bold">{{ $resource->created_at->toFormattedDateString() }}</span>
            </div>
          </div>
          <div class="flex justify-center">
            @if (Auth::user()->is_staff ?? false)
              <form id="status-form" class="ml-2" action="{{ route('resources.updateStatus', $resource) }}"
                    method="post">
                @csrf
                @method('PATCH')
                <input name="is_draft" type="hidden" value="{{ $resource->is_draft ? '0' : '1' }}">
                <button class="p-2 w-20 border-2 rounded-full font-bold active:scale-90
                               @if ($resource->is_draft) bg-black text-white @else border-black @endif"
                        title="{{ __('Status') }}">
                  <span class="mx-0.5 overflow-hidden whitespace-nowrap text-ellipsis">
                    {{ __($resource->is_draft ? 'Draft' : 'Public') }}
                  </span>
                </button>
              </form>
            @endif
            <button class="flex ml-2 p-2 w-20 border-2 rounded-full font-bold active:scale-90
                           @if ($upvoted) bg-rose-600 text-white @else border-black bg-white @endif"
                    title="{{ __('Upvote') }}" data-upvote-btn
                    data-upvote="{{ $resource->currentUserUpvote->id ?? null }}">
              <svg class="min-w-4 @if ($upvoted) fill-white @else fill-black @endif" width="16px" height="16px"
                   viewBox="0 2 24 24" data-icon>
                <path d="M4 14h4v7a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-7h4a1.001 1.001 0 0 0
                         .781-1.625l-8-10c-.381-.475-1.181-.475-1.562 0l-8 10A1.001 1.001 0 0 0 4 14z"/>
              </svg>
              <span class="flex-1 min-w-0 mx-0.5 overflow-hidden whitespace-nowrap text-ellipsis" data-counter>
                {{ $resource->upvoters_count }}
              </span>
            </button>
          </div>
        </div>
        @if ($resource->description)
          <div class="mt-4 pt-4 w-full text-center leading-normal border-t border-gray-200">
            {!! nl2br(e($resource->description)) !!}
          </div>
        @endif
        <div class="flex flex-wrap gap-2 mt-4 w-full whitespace-nowrap">
          @if ($resource->resourceType)
            <div class="flex items-center px-3 py-2 max-w-full bg-{{ $resource->resourceType->color }}-600 rounded-full font-bold
                        text-white" title="{{ __('Resource type') }}">
              <span class="overflow-hidden text-ellipsis">{{ $resource->resourceType->title }}</span>
            </div>
          @endif
          @if ($resource->engineRelease->engine ?? null)
            <div class="flex items-center px-3 py-2 max-w-full border-2 border-black rounded-full font-bold"
                 title="{{ __('Engine release') }}">
              <span class="overflow-hidden text-ellipsis">
                {{ $resource->engineRelease->engine->title }} {{ $resource->engineRelease->version }}
              </span>
            </div>
          @endif
        </div>
        <ul class="mt-4 w-full h-full text-md text-center space-y-1">
          @foreach ($resource->resourceLinks as $resourceLink)
            @php $color = ['blue', 'indigo', 'violet', 'purple', 'fuchsia'][$loop->index % 5] @endphp
            <li class="flex rounded-md bg-{{ $color }}-400 shadow hover:opacity-80 active:scale-95">
              <a class="w-full p-3 font-bold text-gray-900" href="{{ $resourceLink->url }}"
                 target="_blank" rel="noreferrer nofollow">{{ __('Download') }} #{{ $loop->iteration }}</a>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
  </section>
</main>
@endsection
