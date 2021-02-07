@extends('layouts.admin')

@section('content')

    <div class="bgContainer"></div>
    @include('admin.dashnavbar')

    @yield('dashcontent')
   
@endsection