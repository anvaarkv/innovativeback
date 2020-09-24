@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="postAdd col-lg-12 text-right" style="margin-bottom: 20px;">
                <a href="{{route('films.create')}}" class="btn btn-primary">Add Film</a>
            </div>
        </div>
        <films-component></films-component>
    </div>
@endsection
