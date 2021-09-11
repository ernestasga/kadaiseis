@extends('adminlte::page')

@section('title', 'Settings - kasdaiseis.lt Admin')

@section('content_header')
    <h1>Settings</h1>
@stop

@section('content')
<div id="alert"></div>
<table class="table table-hover table-responsive">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Value</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($settings as $setting)
      <tr>
        <th scope="row">{{$setting->id}}</th>
        <td>{{$setting->name}}</td>
        <td>
            @if ($setting->value == 0 || $setting->value ==1)
                <div class="input-group mb-3">
                    <select id="{{$setting->id}}">
                        <option value="0" {{$setting->value ? 'selected' : ''}}>False</option>
                        <option value="1" {{$setting->value ? 'selected' : ''}}>True</option>
                    </select>
                </div>
            @else
                <div class="input-group mb-3">
                    <input type="text" id="{{$setting->id}}" value="{{$setting->value}}"/>
                </div>
            @endif
        </td>
        <td><button class="btn-info update" data-id="{{$setting->id}}">Update</button></td>
      </tr>
    @endforeach
    </tbody>
</table>
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
            $('.update').on('click', function(){
                const id = $(this).data('id');
                const value = $('#'+id).val();
                $.ajax({
                    type: 'PUT',
                    url: '/admin/settings/update',
                    data: {
                        id: id,
                        value: value
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
