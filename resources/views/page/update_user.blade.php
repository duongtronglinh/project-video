@extends('layout.master')
@section('content')
    <div class="col-md-8 col-sm-8 col-xs-8 col-md-offset-2 col-sm-offset-2 col-xs-offset-2 div-edit-user">
        <form action="{{ route('user.update', $user->id) }}" method="POST" class="edit_user">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <h1 class="title">{{ trans('multi_language.edit_user') }}</h1>
            @if (Session::has('success_edit'))
                <div class="alert alert-success text-center">{{ Session::get('success_edit') }}</div>
            @endif

            <label>{{ trans('multi_language.email') }}</label>
            <input type="text" class="form-control" value="{{ $user->email }}" disabled="">
        
            <label>{{ trans('multi_language.name') }}</label>
            <input type="text" class="form-control" value="{{ $user->name }}" disabled="">

            <label>{{ trans('multi_language.username') }}</label>
            <input type="text" class="form-control" value="{{ $user->username }}" disabled="">

            <label>{{ trans('multi_language.password') }}</label>
            <span>{{ $errors->first('password') }}</span>
            <input type="password" name="password" class="form-control">
    
            <label>{{ trans('multi_language.confirm_password') }}</label>
            <span>{{ $errors->first('confirm_password') }}</span>
            <input type="password" name="confirm_password" class="form-control">
    
            <div align="center"><button class="btn btn-primary">{{ trans('multi_language.edit') }}</button></div>
        </form>
    </div>
@endsection
