<div id="catalog" class="w-full p-6 sm:border-l-2 border-gray-200">
  @if (!$resources->isEmpty())
    <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 auto-rows-max gap-8 justify-evenly
               justify-items-center items-center">
      @foreach ($resources as $resource)
        @php $resourceUrl = route('resources.show', $resource->slug) @endphp
        @php $uploaderName = $resource->uploader->username ?? __('???') @endphp
        <li class="overflow-hidden flex flex-col items-center p-3 border-2 rounded-xl bg-slate-800 shadow"
            data-resource="{{ $resource->slug }}">
          <a class="relative overflow-hidden w-full rounded-lg hover:opacity-80" href="{{ $resourceUrl }}">
            @if ($resource->preview_url)
              <img class="w-full max-h-60 object-cover" alt="{{ __('Preview') }}" src="{{ $resource->preview_url }}"
                   width="320" height="180">
            @elseif ($resource->youtube_video_id)
              <img class="w-full max-h-60 object-cover" alt="{{ __('Preview') }}" width="320" height="180"
                   src="https://img.youtube.com/vi/{{ $resource->youtube_video_id }}/mqdefault.jpg">
            @else
              <img class="w-full max-h-60 object-cover" alt="{{ __('Preview') }}" width="320" height="180"
                   src="{{ url('images/preview-default.png') }}">
            @endif
            <div class="absolute bottom-0 flex justify-between items-center w-full px-3 py-1 bg-gradient-to-t
                        from-slate-900 drop-shadow">
              <div class="overflow-hidden whitespace-nowrap text-ellipsis text-sm text-white font-bold"
                   title="{{ $uploaderName }}">&#64;{{ $uploaderName }}</div>
              <div class="flex items-center text-lg text-white font-bold">
                <svg class="fill-white" width="16px" height="16px" viewBox="0 1 24 24" data-icon>
                  <path d="M4 14h4v7a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-7h4a1.001 1.001 0 0
                           0.781-1.625l-8-10c-.381-.475-1.181-.475-1.562 0l-8 10A1.001 1.001 0 0 0 4 14z"/>
                </svg>
                <div class="ml-0.5">{{ $resource->upvoters_count }}</div>
              </div>
            </div>
          </a>
          <div class="flex flex-col items-center mt-4 w-full">
            <a class="leading-normal font-bold text-center text-lg text-white hover:underline"
               href="{{ $resourceUrl }}">
              {{ $resource->title }}
            </a>
            @if ($resource->resourceType)
              <div class="mt-2 px-3 py-0.5 max-w-full overflow-hidden bg-{{ $resource->resourceType->color }}-600
                          rounded-xl whitespace-nowrap font-bold text-ellipsis text-sm text-white">
                {{ $resource->resourceType->title }}
              </div>
            @endif
            <div class="flex flex-col items-center mt-2 text-white text-sm">
              {{ $resource->created_at->toFormattedDateString() }}
            </div>
          </div>
          <ul class="mt-4 w-full h-full text-md text-center space-y-1">
            @foreach ($resource->resourceLinks as $resourceLink)
              @php $color = ['blue', 'indigo', 'violet', 'purple', 'fuchsia'][$loop->index % 5] @endphp
              <li class="flex rounded-md bg-{{ $color }}-400 hover:opacity-80 active:scale-95">
                <a class="w-full p-3 font-bold text-gray-900" href="{{ $resourceLink->url }}"
                   target="_blank" rel="noreferrer nofollow">{{ __('Download') }} #{{ $loop->iteration }}</a>
              </li>
            @endforeach
          </ul>
        </li>
      @endforeach
    </ul>
    <div class="mt-8">{{ $resources->withQueryString()->links() }}</div>
  @else
    <div class="text-5xl text-gray-400 text-center font-bold select-none">{{ __('Nothing found') }}</div>
  @endif
</div>
