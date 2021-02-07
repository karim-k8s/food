@extends('layouts.admin')


@section('content')
    <div class="bgContainer"></div>
    <div style="background-color: transparent!important;" class="ui inverted vertical center aligned segment">
        <div class="ui center aligned container">
            <img class="ui huge centered image" src="/css/images/logoadmin.png">
        </div>
    </div>

    
    <div style="margin-top:0em!important" class="ui center aligned inverted container">
        <div class="ui centered card">
            <div class="content">
                <img class="ui small image" src="/css/images/finally.png"/>
                

                @if(isset($admin_name))
                    <h1>{{$admin_name}}</h1>
                @endif

                {!! Form::open(['action' => 'AdminController@auth_admin','method'=>'POST','enctype'=>'multipart/form-data']) !!}
                    <div class="ui form">
                        <div class="ui left icon input field">
                            {{Form::text('email','',['placeholder'=>'Email'])}}
                            <i class="user icon"></i>
                        </div>
                        <div class="ui left icon input field">
                            {{Form::password('password',['placeholder'=>'Mot de passe','type'=>'password'])}}
                            <i class="lock icon"></i>
                        </div>
                        {{Form::submit('Submit',['class'=>'ui primary button'])}}
                        <button class="ui button" type="reset" onclick="location.replace('/')">Annuler</button>
                    </div>
                {!! Form::close() !!}

                @include('inc.messages')
            </div>
        </div>
    </div>

@endsection