@extends('layouts.main')

@section('content-layout')
  @include('layouts.inc.header')
  @include('layouts.inc.sidebar')

  <main id="main" class="main">
    @hasSection('title')
    <div class="pagetitle">
      <h1>
      @yield('title')
      </h1>
    </div>
    @endif

    @yield('content')

  </main>

@endsection