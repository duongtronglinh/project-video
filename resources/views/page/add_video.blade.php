@extends('layout.master')
@section('content')
    <div class="row">
        <a href="{{ route('folder.show', $folder->id) }}" class="btn btn-danger">
            {{ trans('multi_language.back') }}
        </a>        
    </div>
    <div class="col-md-8 col-sm-8 col-xs-8 col-md-offset-2 col-sm-offset-2 col-xs-offset-2 div-add-video">
        <form action="{{ route('video.store') }}" method="POST" class="add-video" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <h1 class="title">{{ trans('multi_language.add_video') }}</h1>
            @if (Session::has('success_add'))
                <div class="alert alert-success text-center">{{ Session::get('success_add') }}</div>
            @elseif (Session::has('error_add_video'))
                <div class="alert alert-danger text-center">{{ Session::get('error_add_video') }}</div>
            @endif
        
            <label>{{ trans('multi_language.parent_folder') }}</label>
            <input type="text" class="form-control" disabled="" value="{{ $path }}">
            <input type="hidden" name="parent_folder_id" value="{{ $folder->id }}">
    
            <label>{{ trans('multi_language.video_name') }}</label>
            <span>{{ $errors->first('video_name') }}</span>
            <input type="text" name="video_name" class="form-control">

            <label>{{ trans('multi_language.thumbnail') }}</label>
            <span>{{ $errors->first('thumbnail_picture') }}</span>
            @if (Session::has('error_format_thumbnail'))
                <span>{{ Session::get('error_format_thumbnail') }}</span>
            @endif
            <input type="file" name="thumbnail_picture" class="form-control">
    
            <label>{{ trans('multi_language.video_file') }}</label>
            <span>{{ $errors->first('video_file') }}</span>
            @if (Session::has('error_format_video'))
                <span>{{ Session::get('error_format_video') }}</span>
            @endif
            <input type="file" name="video_file" class="form-control">
    
            <div align="center"><button class="btn btn-primary">{{ trans('multi_language.add') }}</button></div>
        </form>
    </div>
@endsection
