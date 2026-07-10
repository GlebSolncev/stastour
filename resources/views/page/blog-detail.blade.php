@extends('main')

@section('title')
    {{$item->name}}
@endsection

@section('content')
    @include('component.blog-detail')
@endsection
