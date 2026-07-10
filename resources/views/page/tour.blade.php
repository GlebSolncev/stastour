@extends('main')

@section('title')
    {{$tour->title}}
@endsection

@section('content')
    @include('component.tour', ['tour' => $tour->entity])
    @include('component.similar-tours')
@endsection
