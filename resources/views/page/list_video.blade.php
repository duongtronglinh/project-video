@extends('layout.master')
@section('content')
    <div class="alert alert-success heading-add-video">
    	<div class="col-md-5 col-sm-5 col-xs-5">
    	    @if (isset($path))
                <label>{!! trans('multi_language.path', ['path' => $path]) !!}</label>
            @endif
    	</div>
        <a href="video/create?id={{ $id_folder }}" class="btn btn-success">
            {{ trans('multi_language.add_video') }}
        </a>

        <button class="btn btn-primary">
            <input type="checkbox" name="select_all">
            <span>{{ trans('multi_language.select_all') }}</span>
        </button>

        <!-- <button class="btn btn-warning">
            <span>{{ trans('multi_language.download_select_video') }}</span>
        </button> -->

        <button class="btn btn-danger">
            <span>{{ trans('multi_language.delete_select_video') }}</span>
        </button>
    </div>

    @if (count($files) > 0)
        <table class="table table-striped table-hover table-folder text-center">
            <thead>
                <th></th>
                <th>{{ trans('multi_language.thumbnail') }}</th>
                <th>{{ trans('multi_language.name') }}</th>
                <th>
                    {{ trans('multi_language.date_created') }}
                    <i class="glyphicon glyphicon-triangle-top sort"></i>
                </th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($files as $file)
                    <tr id="tr-folder-{{ $file->id }}">
                    	<td class="td-no-video">
                    	    <input type="checkbox" name="checkbox_video" value="{{ $file->id }}">
                    	</td>
                        <td>
                            <img src="{{ config('app.upload_file') }}/{{ $file->thumbnail }}" class="thumbnail">
                        </td>
                        <td class="td-no-video">{{ $file->file_name }}</td>
                        <td class="td-no-video">{{ $file->created_at }}</td>
                        <td class="td-no-video-button">
                            <button class="btn btn-primary watch-video" 
                                value="{{ config('app.upload_file') }}/{{ $file->file_path }}">
                                {{ trans('multi_language.watch') }}
                            </button>

                            <form action="{{ route('video.destroy', $file->id) }}" method="POST">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button class="btn btn-danger" onclick="return delete_video();">
                                    {{ trans('multi_language.delete') }}
                                </button>
                            </form>

                            <a class="btn btn-warning" href="{{ route('download', $file->id) }}">
                                {{ trans('multi_language.download') }}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row">
            <div class="text-center">{{ $files->links() }}</div>
        </div>

        <div class="modal fade" id="watch-video" role="dialog"></div>
    @else
        <div class="text-center">
            <h1>{{ trans('multi_language.video_404') }}</h1>
        </div>
    @endif
@endsection
