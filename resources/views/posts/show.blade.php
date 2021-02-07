@extends('layouts.main')

@section('content')
    <a href="/posts">Go Back</a>
    <h1>{{$post->title}}</h1><br/>

        <h2 class="ui header">
          <div class="content">
            {{$post->body}}
          </div>
        </div>
      </h2>
      <img src="/storage/cover_images/{{$post->cover_image}}" class="ui medium image">

    @if(Auth::user()->id == $post->user_id)    
        <a class="ui primary small button" href="/posts/{{$post->id}}/edit">Edit Post</a>
        @if(!Auth::guest())
                {!!Form::open(['action'=>['PostsController@destroy',$post->id],'method'=>'POST'])!!}
                    {{Form::hidden('_method','DELETE')}}
                    {{Form::submit('Delete',['class'=>'ui danger button'])}}
                {!!Form::close()!!}
        @endif
    @endif
@endsection