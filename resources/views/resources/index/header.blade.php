<div class="flex items-center px-6 py-2 bg-gray-200 sm:rounded-t-md">
  <button id="sidebar-toggle" class="transition ease-in sm:invisible active:scale-90" title="{{ __('Show filters') }}">
    <svg class="fill-gray-700" width="40" height="40" viewBox="0 0 24 24">
      <path d="M 2 5 L 2 7 L 22 7 L 22 5 L 2 5 z M 2 11 L 2 13 L 22 13 L 22 11 L 2 11 z M 2 17 L 2 19 L 22 19 L 22 17
               L 2 17 z"></path>
    </svg>
  </button>
  <h1 class="mx-auto text-center text-2xl text-gray-700 font-bold">{{ __('Workshop') }}</h1>
  <a class="transition ease-in active:scale-90" title="{{ __('Publish a new resource') }}" href="{{ route('resources.create') }}">
    <svg class="fill-gray-700" width="48" height="48" viewBox="0 0 50 50">
      <path d="M 25 2 C 12.309295 2 2 12.309295 2 25 C 2 37.690705 12.309295 48 25 48 C 37.690705 48 48 37.690705 48
               25 C 48 12.309295 37.690705 2 25 2 z M 25 4 C 36.609824 4 46 13.390176 46 25 C 46 36.609824 36.609824
               46 25 46 C 13.390176 46 4 36.609824 4 25 C 4 13.390176 13.390176 4 25 4 z M 24 13 L 24 24 L 13 24 L 13
               26 L 24 26 L 24 37 L 26 37 L 26 26 L 37 26 L 37 24 L 26 24 L 26 13 L 24 13 z"></path>
    </svg>
  </a>
</div>
