@extends('layout.master')
@section('content')
@if (isset($users))
    <div class="text-center">
        <button data-toggle="modal" data-target="#add-user" class="btn btn-success text-center">
            {{ trans('multi_language.add_user') }}
        </button>
    </div>
    <table class="table table-striped table-hover">
        <thead>
            <th>{{ trans('multi_language.name') }}</th>
            <th>{{ trans('multi_language.username') }}</th>
            <th>{{ trans('multi_language.email') }}</th>
            <th>{{ trans('multi_language.type_user') }}</th>
            <th colspan="2"></th>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    @if ($user->level == 1)
                        <td>{{ trans('multi_language.share_user') }}</td>
                        <td>
                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning">
                                {{ trans('multi_language.edit') }}
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button class="btn btn-danger" onclick="return delete_user();">
                                    {{ trans('multi_language.delete') }}
                                </button>
                            </form>
                        </td>
                    @else
                        <td colspan="3">{{ trans('multi_language.admin') }}</td>
                    @endif
                </tr>
           @endforeach
        </tbody>
    </table>

    @if ((count($errors) > 0 && Session::has('add_user')) || Session::has('success_add'))
        <div class="add_user"></div>
    @endif
    <div class="modal fade" id="add-user" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title title">{{ trans('multi_language.add_user') }}</h2>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user.store') }}" method="POST" class="add-user">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        @if (Session::has('success_add'))
                            <div class="alert alert-success text-center">{{ Session::get('success_add') }}</div>
                        @endif

                        <label>{{ trans('multi_language.email') }}</label>
                        <span>{{ $errors->first('email') }}</span>
                        <input type="text" name="email" class="form-control" value="{{ old('email') }}">
        
                        <label>{{ trans('multi_language.name') }}</label>
                        <span>{{ $errors->first('name') }}</span>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}">

                        <label>{{ trans('multi_language.username') }}</label>
                        <span>{{ $errors->first('username') }}</span>
                        <input type="text" name="username" class="form-control" value="{{ old('username') }}">

                        <label>{{ trans('multi_language.password') }}</label>
                        <span>{{ $errors->first('password') }}</span>
                        <input type="password" name="password" class="form-control">

                        <label>{{ trans('multi_language.confirm_password') }}</label>
                        <span>{{ $errors->first('confirm_password') }}</span>
                        <input type="password" name="confirm_password" class="form-control">

                        <label>{{ trans('multi_language.type_user') }}</label>
                        <span>{{ $errors->first('level') }}</span>
                        <select name="level" class="form-control">
                            <option>{{ trans('multi_language.select_type_user') }}</option>
                            <option value="1">{{ trans('multi_language.share_user') }}</option>
                            <option value="2">{{ trans('multi_language.admin') }}</option>
                        </select>
    
                        <div align="center">
                            <button class="btn btn-primary">{{ trans('multi_language.add') }}</button>
                        </div>
                    </form>
                </div>
            </div>  
        </div>
    </div>
@elseif (isset($user_permission))
    <div class="alert alert-success heading-permission-user">
        <div class="col-md-4 col-sm-4 col-xs-4">
            @if (isset($path))
                <label id="{{ $folder_id }}">{!! trans('multi_language.path', ['path' => $path]) !!}</label>
            @endif
        </div>
        <button class="btn btn-primary">
            <input type="checkbox" name="select_all">
            <span>{{ trans('multi_language.select_all') }}</span>
        </button>
        <button class="btn btn-success">
            <span>{{ trans('multi_language.permission_select_user') }}</span>
        </button>
        <a href="{{ route('user.index') }}?folder_id={{ $folder_id }}&&permit=true" class="btn btn-danger">
            <span>{{ trans('multi_language.list_user_permission') }}</span>
        </a>
    </div>
    <table class="table table-striped table-hover">
        <thead>
            <th>{{ trans('multi_language.name') }}</th>
            <th>{{ trans('multi_language.username') }}</th>
            <th>{{ trans('multi_language.email') }}</th>
            <th></th>
        </thead>
        <tbody>
            @foreach ($user_permission as $user)
                <tr class="user-permission" id="user-permission-{{ $user->id }}">
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td><input type="checkbox" name="user_permission" value="{{ $user->id }}"></td>
                </tr>
           @endforeach
        </tbody>
    </table>
@elseif (isset($list_user_permission))
    <div class="alert alert-success">
        @if (isset($path))
            <label>{!! trans('multi_language.path', ['path' => $path]) !!}</label>
        @endif
    </div>
    <table class="table table-striped table-hover">
        <thead>
            <th>{{ trans('multi_language.name') }}</th>
            <th>{{ trans('multi_language.username') }}</th>
            <th>{{ trans('multi_language.email') }}</th>
        </thead>
        <tbody>
            @foreach ($list_user_permission as $user_permit)
                <tr>
                    <td>{{ $user_permit->user->name }}</td>
                    <td>{{ $user_permit->user->username }}</td>
                    <td>{{ $user_permit->user->email }}</td>
                </tr>
           @endforeach
        </tbody>
    </table>
@endif
@endsection
