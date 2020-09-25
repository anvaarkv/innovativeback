@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="postAdd col-lg-12" style="margin-bottom: 20px;">
                <a href="{{route('films.index')}}" class="btn btn-info">Back</a>
            </div>
        </div>
        <add-film></add-film>

    </div>
@endsection
