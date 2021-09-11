<?php header('Access-Control-Allow-Origin: *'); ?>

@extends('adminlte::page')

@section('title', 'Shows - kasdaiseis.lt Admin')

@section('content_header')
    <h1>Shows</h1>
@stop

@section('content')
    <div id="alert"></div>

    <div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="search-field">Search for shows</label>
            </div>
            <input type="text" class="form-control" id="search-field" placeholder="Search..." aria-label="" aria-describedby="basic-addon1">
        </div>
    </div>
    <div class="row justify-content-md-center">
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div id="search-result"></div>
        </div>
    </div>
    <div class="pt-5 all-shows">
        <table class="table table-hover table-responsive">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Image</th>
                <th scope="col">TVMaze ID</th>
                <th scope="col">IMDb ID</th>
                <th scope="col">Name</th>
                <th scope="col">Rating</th>
                <th scope="col">Next Episode</th>
                <th scope="col">Popular</th>
                <th scope="col">Update</th>
                <th scope="col">Delete</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($shows as $show)
              <tr id="tr-{{$show->id}}">
                <th scope="row">{{$show->id}}</th>
                <th scope="row"><img src="{{$show->image_url}}" alt="Show Image" class="img-responsive" height="100"/></th>
                <th scope="row">{{$show->tvmaze_id}}</th>
                <th scope="row"><a href="https://imdb.com/title/{{$show->imdb_id}}">{{$show->imdb_id}}</a></th>
                <th scope="row">{{$show->name}}</th>
                <th scope="row">{{$show->rating}}</th>
                <th scope="row">
                    @if ($show->nextepisode_season)
                        <a href="{{$show->nextepisode_url}}">s{{$show->nextepisode_season}}e{{$show->nextepisode_episode}}</a>
                    @endif
                </th>
                <th scope="row">
                    <input type="checkbox" id="cb-popular-{{$show->id}}" {{$show->popular ? 'checked' : ''}}>
                </th>
                <th scope="row">
                    <button class="update btn-info" data-id="{{$show->id}}">Update</button>
                </th> 
                <th scope="row">
                    <button class="delete btn-danger" data-id="{{$show->id}}">Delete</button>
                </th> 
              </tr>
            @endforeach
            </tbody>
        </table> 
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $('document').ready(function(){
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.update').on('click', function() {
                const id = $(this).data('id');
                const popular = $('#cb-popular-'+id).is(':checked') ? 1 : 0;
                $.ajax({
                    type: 'PUT',
                    url: '/admin/shows/updateIsPopular',
                    data: {
                        id: id,
                        popular: popular
                    },
                    dataType: 'json',
                    success: function (data) {
                        showAlert('success', data.success);
                    },
                    error: function (data) {
                        showAlert('danger', data.error);
                    }
                }); 
            });
            $('.delete').on('click', function() {
                const id = $(this).data('id');
                $.ajax({
                    type: 'DELETE',
                    url: '/admin/shows/delete',
                    data: {
                        id: id,
                    },
                    dataType: 'json',
                    success: function (data) {
                        showAlert('success', data.success);
                        $('#tr-'+id).html('');
                    },
                    error: function (data) {
                        showAlert('danger', data.error);
                    }
                });
            });
            $('#search-field').on('input', async function (){
                const input = $(this).val();
                const apiUrl = 'https://api.tvmaze.com/singlesearch/shows?q='+input+'&embed=nextepisode';
                await fetch(apiUrl)
                    .then(response => response.json())
                    .then((data) => {
                        var seasonEpisode = '';
                        var nextepisode = null;
                        var addShowData = ``;
                        try {
                            nextepisode = data._embedded.nextepisode;
                        } catch (error) {
                            
                        }
                        try {
                            addShowData += `data-id="${data.id}" `;
                            addShowData += `data-name="${data.name}" `;
                            addShowData += `data-imdbid="${data.externals.imdb}" `;
                            addShowData += `data-rating="${data.rating.average}" `;
                            addShowData += `data-imageurl="${data.image.medium}" `;
                            addShowData += `data-nextepisode_season="${nextepisode.season}" `;
                            addShowData += `data-nextepisode_episode="${nextepisode.number}" `;
                            addShowData += `data-nextepisode_url="${nextepisode.url}" `;
                            addShowData += `data-nextepisode_airstamp="${nextepisode.airstamp}" `;

                        } catch (error) {
                            
                        }
                        
                        if(nextepisode != null){
                            seasonEpisode = `
                            <div class="row">
                                    <div class="col">
                                        <div class="badge badge-danger">
                                            s${nextepisode.season}e${nextepisode.number}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="badge badge-success">
                                            ${new Date(nextepisode.airdate).toLocaleString()}
                                        </div>
                                    </div>
                            </div>
                            `
                        }
                        $('#search-result').html(
                        `
                        <div class="card">
                            <div class="card-header text-center">${data.name}</div>
                            <div class="card-content">
                                <img class="card-img-top" src="${data.image.medium}" alt="Card image cap">
                                ${seasonEpisode}
                                <div class="row text-center">
                                    <div class="col">
                                        <button ${addShowData}" class="add-show btn btn-success">Add this show</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                        `);
                    });
            });
            $(document).on('click', '.add-show', function () {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const imdbid = $(this).data('imdbid');
                const rating = $(this).data('rating');
                const imageurl = $(this).data('imageurl');
                const nextepisode_season = $(this).data('nextepisode_season');
                const nextepisode_episode = $(this).data('nextepisode_episode');
                const nextepisode_url = $(this).data('nextepisode_url');
                const nextepisode_airstamp = $(this).data('nextepisode_airstamp');
                $.ajax({
                    type: 'POST',
                    url: '/admin/shows/store',
                    data: {
                        id: id,
                        name: name,
                        imdbid: imdbid,
                        rating: rating,
                        imageurl: imageurl,
                        nextepisode: {
                            season: nextepisode_season,
                            episode: nextepisode_episode,
                            url: nextepisode_url,
                            airstamp: nextepisode_airstamp
                        }
                    },
                    dataType: 'json',
                    success: function (data) {
                        showAlert('success', data.success);
                    },
                    error: function (data) {
                        showAlert('danger', data.error);
                    }
                });
            });
            function showAlert(type, message) {
                $('#alert').addClass('alert alert-'+type);
                $('#alert').text(message);
                $('#alert').fadeTo(2000, 500).slideUp(500, function(){
                    $('#alert').slideUp(500);
                });
            }
        });
    </script>
@stop
