@extends('layouts.main')

@section('content')
    
    <br>
    <h1>Edit post</h1>
    {!! Form::open(['action' => ['PostsController@update',$post->id],'method','POST']) !!}
        <div class="ui tiny primary form">
            <div class="three fields">
                <div class="field">
                    {{Form::label('title','Title')}}
                    {{Form::text('title',$post->title,['placeholder'=>'Title'])}}
                </div>
                <div class="field olive">
                    {{Form::label('body','Body')}}
                    {{Form::textarea('body',$post->body,['placeholder'=>'Body'])}}
                </div>
            </div>
            {{Form::hidden('_method','PUT')}}
            {{Form::submit('Submit',['class'=>'ui primary button'])}}
            <input class="ui button" value="Reset" type="reset">

        </div>
    {!! Form::close() !!} 
@endsection