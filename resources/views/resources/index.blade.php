@extends('layouts.app')

@section('js')
  @parent
  <script src="{{ mix('js/resources.js') }}" defer></script>
  <script src="{{ mix('js/resources.index.js') }}" defer></script>
@endsection

@section('content')
<main class="sm:container sm:mx-auto sm:py-4">
  <section class="flex flex-col break-words bg-white sm:rounded-md sm:shadow-lg">
    @section('header')
      @include('resources.index.header')
    @show

    <div class="flex">
      @section('sidebar')
        @include('resources.index.sidebar')
      @show
      @section('catalog')
        @include('resources.index.catalog')
      @show
    </div>
  </section>
</main>
@endsection
