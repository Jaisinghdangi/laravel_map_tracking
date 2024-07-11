@extends('layout.main')
@section('content')
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <h4>View Favourite</h4>
            </div>
            <div class="col-xs-12 col-md-2">
                <strong>Name:</strong>
            </div>
            <div class="col-xs-12 col-md-10">
                {{ $favorite->name }}
            </div>
            <div class="col-xs-12 col-md-2">
                <strong>Link:</strong>
            </div>
            <div class="col-xs-12 col-md-10">
                <a href="{{ $favorite->link }}" target="_blank">{{ $favorite->link }} </a>
            </div>
            <div class="col-xs-12 col-md-2">
                <strong>Type:</strong>
            </div>
            <div class="col-xs-12 col-md-10">
                {{ $favorite->type->name }}
            </div>
            <div class="col-xs-12 col-md-2">
                <strong>Category:</strong>
            </div>
            <div class="col-xs-12 col-md-10">
                {{ $favorite->category->name }}
            </div>
        </div>
    </div>
@endsection
