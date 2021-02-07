@extends('layouts.main')

@section('content')
    
    <br>
    <h1>Create post</h1>
    {!! Form::open(['action' => 'PostsController@store','method'=>'POST','enctype'=>'multipart/form-data']) !!}
        <div class="ui tiny primary form">
            <div class="three fields">
                <div class="field">
                    {{Form::label('title','Title')}}
                    {{Form::text('title','',['placeholder'=>'Title'])}}
                </div>
                <div class="field olive">
                    {{Form::label('body','Body')}}
                    {{Form::textarea('body','',['placeholder'=>'Body'])}}
                </div>
                <div class="field">
                    {{Form::file('cover_image')}}
                </div>
            </div>
            {{Form::submit('Submit',['class'=>'ui primary button'])}}
            <input class="ui button" value="Reset" type="reset">

        </div>
    {!! Form::close() !!} 
@endsection

        <!--<div class="field">
                <label>Title</label>
                <input name="first-name" placeholder="First Name" type="text">
            </div>
            <div class="field">
                <label>Last Name</label>
                <input name="last-name" placeholder="Last Name" type="text">
            </div>
            <div class="field">
                <div class="ui checkbox">
                <input tabindex="0" class="hidden" type="checkbox">
                <label>I agree to the Terms and Conditions</label>
                </div>
            </div>
            <button class="ui button" type="submit">Submit</button>-->