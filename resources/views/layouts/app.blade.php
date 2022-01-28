<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', config('app.name', 'Laravel'))</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
  @section('css')
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  @show
  @section('js')
    <script src="{{ mix('js/app.js') }}" defer></script>
  @show
</head>
<body class="bg-gray-100 antialiased leading-none font-sans">
  <div id="app">
    <header class="bg-gray-600 py-1">
      <div class="container flex flex-col mx-auto justify-between items-center px-6 sm:flex-row">
        <div>
          <a href="{{ url('/') }}" class="text-lg font-bold text-gray-100 no-underline">
            {{ config('app.name', 'Laravel') }}
          </a>
        </div>
        <nav class="space-x-4 flex justify-center w-full text-gray-300 text-base sm:w-auto">
          @guest
            <a class="no-underline hover:underline" href="{{ route('login') }}">{{ __('Login') }}</a>
            @if (Route::has('register'))
              <a class="no-underline hover:underline" href="{{ route('register') }}">{{ __('Register') }}</a>
            @endif
          @else
            <span class="overflow-hidden text-ellipsis">{{ Auth::user()->username }}</span>
            <form id="logout-form" class="inline" action="{{ route('logout') }}" method="post">
              @csrf
              <button class="hover:underline">{{ __('Logout') }}</button>
            </form>
          @endguest
        </nav>
      </div>
    </header>
    <header class="bg-gray-700 py-3">
      <div class="container mx-auto flex items-center px-6">
        <nav class="space-x-3 text-gray-300 text-lg">
          @foreach ([
            'resources.index' => 'Workshop',
            'help' => 'Help',
          ] as $route => $title)
            <a class="@if (Request::route()->named($route)) font-bold @endif"
              href="{{ route($route) }}">{{ __($title) }}</a>
          @endforeach
        </nav>
      </div>
    </header>

    @yield('content')
  </div>
</body>
</html>
