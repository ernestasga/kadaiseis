@extends('adminlte::page')

@section('title', 'Users - kasdaiseis.lt Admin')

@section('content_header')
    <h1>Users</h1>
@stop

@section('content')
<div id="alert"></div>
<table class="table table-hover table-responsive">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Role</th>
        <th scope="col">Email</th>
        <th scope="col">Update</th>
        <th scope="col">Delete</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($users as $user)
      <tr id="tr-{{$user->id}}">
        <th scope="row">{{$user->id}}</th>
        <td>{{$user->name}}</td>
        <td>
            <div class="input-group mb-3">
                <select id="{{$user->id}}" class="select" name="role">
                  @foreach (range(1,5) as $i)
                      <option value="{{$i}}" {{$user->role == $i ? 'selected' : ''}}>{{$i}}</option>
                  @endforeach
                </select>
            </div>
        </td>
        <td>{{$user->email}}</td>
        <td><button class="btn-info update" data-id="{{$user->id}}">Update</button></td>
        <td><button class="btn-danger delete" data-id="{{$user->id}}">Delete</button></td>
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
                const role = $('#'+id).val();
                $.ajax({
                    type: 'PUT',
                    url: '/admin/users/updateRole',
                    data: {
                        id: id,
                        role: role
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
            $('.delete').on('click', function(){
                const id = $(this).data('id');
                $.ajax({
                    type: 'DELETE',
                    url: '/admin/users/delete',
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
