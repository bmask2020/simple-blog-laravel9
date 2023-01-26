@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> <span>Post Edit</span></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{route('post.update', ['id' => $Posts->id])}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Title</label>
                            <input type="text" value="{{$Posts->title}}" name="title" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            @error('title')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">content</label>
                           <textarea name="content" class="form-control" rows="10">{{$Posts->content}}</textarea>
                           @error('content')
                                <span class="text-danger">{{$message}}</span>
                           @enderror
                        </div>
                      
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Post Image</label>
                            <input class="form-control" type="file" name="image" id="formFile">
                            @error('image')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <input type="hidden" name="old_img" value="{{$Posts->image}}">

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


