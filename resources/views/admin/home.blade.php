@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-3 col-sm-4 col-xs-6">
            <div class="panel panel-dark panel-colorful">
                <div class="panel-body text-center">
                	<p class="text-uppercase mar-btm text-sm">Users</p>
                	<i class="fa fa-users fa-5x"></i>
                	<hr>
                	<p class="h2 text-thin">{{$user_count}}</p>
                	<small><span class="text-semibold">{{$admin_count}}</span> admin</small>
                </div>
            </div>
        </div> 
        <div class="col-md-3 col-sm-4 col-xs-6">
            <div class="panel panel-dark panel-colorful">
                <div class="panel-body text-center">
                	<p class="text-uppercase mar-btm text-sm">Shows</p>
                	<i class="fa fa-tv fa-5x"></i>
                	<hr>
                	<p class="h2 text-thin">{{$show_count}}</p>
                	<small><span class="text-semibold">{{$popular_count}}</span> popular</small>
                </div>
            </div>
        </div> 
    </div>
    <h1>Settings</h1>
    <div class="row">
        <div class="col-md-3 col-sm-4 col-xs-6">
            <div class="panel panel-dark panel-colorful">
                <div class="panel-body text-center">
                	<p class="text-uppercase mar-btm text-sm">Can register</p>
                	<i class="fa fa-user-plus fa-5x"></i>
                	<hr>
                	<p class="h2 text-thin">{{$canRegister}}</p>
                </div>
            </div>
        </div> 
        <div class="col-md-3 col-sm-4 col-xs-6">
            <div class="panel panel-dark panel-colorful">
                <div class="panel-body text-center">
                	<p class="text-uppercase mar-btm text-sm">Facebook</p>
                	<i class="fab fa-facebook-f fa-5x"></i>
                	<hr>
                	<div class="text-wrap">{{$fbUrl}}</div>
                </div>
            </div>
        </div> 
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
