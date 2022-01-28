<form id="sidebar" class="hidden sm:block space-y-6 p-6 w-64">
  <div>
    <label class="flex flex-col">
      <span class="text-lg font-medium">{{ __('Title') }}</span>
      <input class="mt-2 px-3 py-2 w-full border border-gray-300 rounded-md"
             name="q" value="{{ Request::input('q') }}">
    </label>
  </div>
  <div class="pt-4 border-t">
    <div class="text-lg font-medium">{{ __('Sorting') }}</div>
    <div class="flex flex-col mt-2 space-y-2">
      @foreach ([
        'newest' => 'Newest',
        'oldest' => 'Oldest',
        'most_upvoted' => 'Most upvoted',
        ] as $value => $title)
        <label>
          <input class="mr-1" type="radio" name="sorting" value="{{ $value }}"
                 @if ($value == Request::input('sorting', 'newest')) checked @endif>
          {{ __($title) }}
        </label>
      @endforeach
    </div>
  </div>
  @if (Auth::user()->is_staff ?? false)
    <div class="pt-4 border-t">
      <div class="text-lg font-medium">{{ __('Status') }}</div>
      <div class="flex flex-col mt-2 space-y-2">
        @foreach ([
          'public' => 'Public',
          'draft' => 'Draft',
        ] as $value => $title)
          <label>
            <input class="mr-1" type="radio" name="status" value="{{ $value }}"
                   @if ($value == Request::input('status', 'public')) checked @endif>
            {{ __($title) }}
          </label>
        @endforeach
      </div>
    </div>
  @endif
  @auth
    <div class="pt-4 border-t">
      <div class="text-lg font-medium">{{ __('Personal') }}</div>
      <div class="flex flex-col mt-2 space-y-2">
        @foreach ([
          'user_published' => 'Published',
          'user_upvoted' => 'Upvoted',
        ] as $value => $title)
          <label>
            <input class="mr-1" type="checkbox" name="{{ $value }}"
                   @if (Request::boolean($value)) checked @endif>
            {{ $title }}
          </label>
        @endforeach
      </div>
    </div>
  @endauth
  <div class="pt-4 border-t">
    <div class="text-lg font-medium">{{ __('Type') }}</div>
    <div class="flex flex-col mt-2 space-y-2">
      @foreach ($resourceTypes as $resourceType)
        <label>
          <input class="mr-1" type="checkbox" name="resource_types[]" value="{{ $resourceType->id }}"
                 @if (is_array(Request::input('resource_types'))
                      && in_array($resourceType->id, Request::input('resource_types'))) checked @endif>
          {{ $resourceType->title }}
        </label>
      @endforeach
    </div>
  </div>
  <div class="pt-4 border-t">
    <div class="text-lg font-medium">{{ __('Engine') }}</div>
    <div class="flex flex-col mt-2 space-y-2">
      @foreach ($engines as $engine)
        <label>
          <input class="mr-1" type="checkbox" name="engines[]" value="{{ $engine->id }}"
                 @if (is_array(Request::input('engines'))
                      && in_array($engine->id, Request::input('engines'))) checked @endif>
          {{ $engine->title }}
        </label>
      @endforeach
    </div>
  </div>
  <div class="pt-4 border-t">
    <button class="p-3 w-full rounded-2xl bg-gray-700 font-bold text-white hover:opacity-90 active:scale-95">
      {{ __('Search') }}
    </button>
  </div>
</form>
