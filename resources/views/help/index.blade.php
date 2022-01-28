@extends('layouts.app')

@section('content')
<main class="sm:container sm:mx-auto sm:py-4 sm:max-w-2xl">
  <section class="flex flex-col break-words bg-white sm:rounded-md sm:shadow-lg">
    <div class="flex items-center px-6 py-4 bg-gray-200 sm:rounded-t-md">
      <h1 class="mx-auto text-center text-2xl text-gray-700 font-bold">{{ __('Help') }}</h1>
    </div>
    <dl class="flex flex-col space-y-8 p-8">
      @foreach ($helpSubjects as $helpSubject)
        <div>
          <dt class="text-2xl text-center font-bold">{{ $helpSubject->title }}</dt>
          <dd class="mt-2 leading-relaxed text-lg">{!! nl2br($helpSubject->description) !!}</dd>
        </div>
      @endforeach
    </div>
  </section>
</main>
@endsection
