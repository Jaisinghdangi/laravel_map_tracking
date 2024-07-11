@extends('layout.main')

@section('content')
    <h1>Project Olive</h1>
    <h4>All your favorites in one place</h4>
    <!-- will be used to show any messages -->
    @if (Session::has('success'))
        <div class="alert alert-info">{{ Session::get('success') }}</div>
    @endif
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <td>ID</td>
                <td>Name</td>
                <td>Link</td>
                <td>Type</td>
                <td>Category ID</td>
                <td>Actions</td>
            </tr>
        </thead>
        <tbody>
            <?php $SNO = 1; ?>
            @if(sizeof($favorites) > 0)
            @foreach ($favorites as $key => $value)
                <tr>
                    <td>{{  $SNO }}</td>
                    <td>{{ $value->name }}</td>
                    <td>{{ $value->link }}</td>
                    <td>{{ $value->type->name }}</td>
                    <td>{{ $value->category->name }}</td>
                    <td>
                        <a class="btn btn-small btn-success" href="{{ route('favorites.editMY', $value) }}">Edit</a>
                         <a class="btn btn-small btn-info" href="{{ route('favorites.show', $value) }}">Show</a>
                        <form action="{{ route('favorites.destroy', $value->id) }}" method="Post">
                            @csrf
                          @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Do you want to delete this product?');">Delete</button>
                        </form>
                        {{-- <a class="btn btn-small btn-warning" href="{{ route('favorites.destroy', $value->id) }}">Delete</a> --}}
                </tr>
                {{ $SNO++  }}
            @endforeach
            @else
            <tr>
                <td colspan="6">No favorites found</td>
            </tr>
            @endif
        </tbody>
    </table>
@endsection
