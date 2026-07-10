@extends('main')

@section('title')
    Main
@endsection

@section('content')
    @include('component.main-slider', ['slides' => $main_banner])
    @include('component.about')
    @include('component.catalog', ['catalog' => $catalog])
    @include('component.reviews')
    @include('component.main-blog')
@endsection
