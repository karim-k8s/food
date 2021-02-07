@extends('layouts.main')

@section('content')
    
    @if(count($posts)>0)
        <h1>Posts</h1><br/>
        <div class="ui link cards">
        @foreach($posts as $post)
            <div class="ui card">
                <div class="content">
                <div class="header">{{$post->title}}</div>
                </div>
                <div class="content">
                <div class="ui small feed">
                    <div class="event">
                    <div class="content">
                        <div class="summary">
                        <a>Post Body : </a>{{$post->body}}
                        </div>
                    </div>
                    </div>
                    <div class="event">
                    <div class="content">
                        <div class="summary">
                        <a>Created by : </a>{{$post->user->name}}
                        </div>
                    </div>
                    </div>
                   
                    <div class="event">
                    <div class="content">
                        <div class="summary">
                        <a href="/posts/{{$post->id}}">View Post</a>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        @endforeach
        
        </div>
    @else
        <h1>No Posts Found !</h1><br/>
    @endif
    <br/>
    {{$posts->links('pagination.semantic-ui')}}
@endsection