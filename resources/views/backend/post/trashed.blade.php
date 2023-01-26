@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <h4 class="text-center">Trashed Post</h4>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="display:flex;align-items:center;justify-content:space-between"><p style="margin-bottom:0">Trashed Post</p></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table text-center">

                    <thead>
                        <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Image</th>
                        <th scope="col">Date</th>
                        <th scope="col">Restore</th>
                        <th scope="col">Delete Force</th>
                        </tr>
                    </thead>
                    @php($i = 1)
                    <tbody>
                        @foreach($trashed as $post)
                        <tr>
                            @php($post_date = date('d-m-Y', strtotime($post->created_at)))
                        <th scope="row">{{$i++}}</th>
                        <td>{{$post->title}}</td>
                        <td><img src="{{asset($post->image)}}" alt="" width="70" height="70"></td>
                        <td>{{$post_date}}</td>
                        <td><a href="{{route('post.restore', ['id' => $post->id])}}" class="btn btn-success">Restore</a></td>
                        <td><a href="{{route('post.force.delete', ['id' => $post->id])}}" class="btn btn-danger">Delete</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
