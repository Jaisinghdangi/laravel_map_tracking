@extends('layout.main')

@section('content')
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left mb-2">
                    <h2>Add a Favourite</h2>
                </div>
            </div>
        </div>
        @if (session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{ route('favorites.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong> Name:</strong>
                        <input type="text" name="name" class="form-control" placeholder="Name">
                        @error('name')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Link:</strong>
                        <input type="text" name="link" class="form-control" placeholder="Link to your favorite">
                        @error('link')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Type:</strong>
                        <br/>
                        <select name="type" id="type">
                            @foreach ($types as $type)
                                <option value={{ $type->id }}>{{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('type')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Category:</strong>
                        <br />
                        <select name="category" id="category">
                            @foreach ($categories as $category)
                                <option value={{ $category->id }}>{{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div><br>
                    <button type="submit" class="btn btn-success ml-3">Submit</button>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('favorites.index') }}"> Back</a>
                    </div>
        </form>
    </div>
@endsection
