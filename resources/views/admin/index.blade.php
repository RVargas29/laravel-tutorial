@extends('layouts.admin')

@section('content')
    @if (Session::has('info'))
        <div class="row">
            <div class="col-md-12">
                <p class="alert alert-info">
                    {{ Session::get('info') }}
                </p>
            </div>
        </div>
    @endif    
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('admin.create') }}" class="btn btn-success">New Post</a>
        </div>
    </div>
    <hr>
    <table class="table table-striped">
        <tr>
            <th>Title</th>
            <th></th>
        </tr>
        @foreach ($posts as $post)
            <tr>
                <td>{{ $post['title'] }}</td>
                <td><a href="{{ route('admin.edit', ['id' => array_search($post, $posts)]) }}">Edit</a></td>
            </tr>
        @endforeach
    </table>    
@endsection