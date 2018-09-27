@extends('layout.master')
@section('content')
    @if (Auth::check() && Auth::user()->level == 2)
        <div class="alert alert-success heading-add-folder">
            <div class="col-md-5 col-sm-5 col-xs-5">
                @if (isset($path))
                    <label>{!! trans('multi_language.path', ['path' => $path]) !!}</label>
                @endif
            </div>
            @if (!isset($path))
                <button class="btn btn-success">{{ trans('multi_language.add_root_folder') }}</button>
            @endif

            <button class="btn btn-primary">
                <input type="checkbox" name="select_all">
                <span>{{ trans('multi_language.select_all') }}</span>
            </button>

            <button class="btn btn-danger">
                <span>{{ trans('multi_language.delete_select') }}</span>
            </button>
        </div>

        <div class="add-folder text-center"></div>

        <table class="table table-striped table-hover table-folder text-center">
            <thead>
                <th></th>
                <th>{{ trans('multi_language.name') }}</th>
                <th>
                    {{ trans('multi_language.date_created') }}
                    <i class="glyphicon glyphicon-triangle-top sort"></i>
                </th>
                <th>{{ trans('multi_language.number_subfolder') }}</th>
                <th></th>
            </thead>
            <tbody>
                @if (isset($folders))
                    @foreach ($folders as $key => $folder)
                        <tr id="tr-folder-{{ $folder->id }}">
                            <td class="value-folder">
                                <input type="checkbox" name="checkbox_folder" value="{{ $folder->id }}">
                            </td>
                            <td class="value-folder">
                                <a href="{{ route('folder.show', $folder->id) }}">
                                    <img src="{{ config('app.upload_file') }}/folder_open.jpg" class="folder-icon">
                                    <span>{{ $folder->name }}</span>
                                </a>
                            </td>
                            <td class="value-folder">{{ $folder->created_at }}</td>
                            <td class="value-folder number-sub">{{ $number_subfolders[$key] }}</td>
                            @if ($number_subfolders[$key] > 0)
                                <td class="td-button-folder">
                                    <button class="btn btn-primary" id="folder_{{ $folder->id }}">
                                        {{ trans('multi_language.add_subfolder') }}
                                    </button>
                                </td>
                            @else
                                <td class="td-button-folder">
                                    <button class="btn btn-primary" id="folder_{{ $folder->id }}">
                                        {{ trans('multi_language.add_subfolder') }}
                                    </button>
                                </td>
                            @endif
                            <td class="td-button-folder">
                                <a href="{{ route('user.index') }}?folder_id={{ $folder->id }}" class="btn btn-warning">
                                    {{ trans('multi_language.permission_folder') }}
                                </a>
                            </td>
                            <td class="td-button-folder">
                                <form action="{{ route('folder.destroy', $folder->id) }}" method="POST">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button class="btn btn-danger" onclick="return delete_folder();">
                                        {{ trans('multi_language.delete') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @elseif (isset($subfolders))
                    @foreach ($subfolders as $key => $sbf)
                        <tr id="tr-folder-{{ $sbf->id }}">
                            <td class="value-folder">
                                <input type="checkbox" name="checkbox_folder" value="{{ $sbf->id }}">
                            </td>
                            <td class="value-folder">
                                <a href="{{ route('folder.show', $sbf->id) }}">
                                    <img src="{{ config('app.upload_file') }}/folder_open.jpg" class="folder-icon">
                                    <span>{{ $sbf->name }}</span>
                                </a>
                            </td>
                            <td class="value-folder">{{ $sbf->created_at }}</td>
                            <td class="value-folder number-sub">{{ $number_subfolders[$key] }}</td>
                            @if ($number_subfolders[$key] > 0)
                                <td class="td-button-folder">
                                    <button class="btn btn-primary" id="folder_{{ $sbf->id }}">
                                        {{ trans('multi_language.add_subfolder') }}
                                    </button>
                                </td>
                            @else
                                <td class="td-button-folder">
                                    <button class="btn btn-primary" id="folder_{{ $sbf->id }}">
                                        {{ trans('multi_language.add_subfolder') }}
                                    </button>
                                </td>
                            @endif
                            <td class="td-button-folder">
                                <a href="{{ route('user.index') }}?folder_id={{ $sbf->id }}" class="btn btn-warning">
                                   {{ trans('multi_language.permission_folder') }}
                                </a>
                            </td>
                            <td class="td-button-folder">
                                <form action="{{ route('folder.destroy', $sbf->id) }}" method="POST">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button class="btn btn-danger" onclick="return delete_folder();">
                                        {{ trans('multi_language.delete') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    @elseif (Auth::check() && Auth::user()->level == 1)
        @if (isset($path))
            <div class="alert alert-success heading-add-folder">
                <label>{!! trans('multi_language.path', ['path' => $path]) !!}</label>
            </div>
        @endif

        <table class="table table-striped table-hover table-folder text-center">
            <thead>
                <th>{{ trans('multi_language.name') }}</th>
                <th>
                    {{ trans('multi_language.date_created') }}
                    <i class="glyphicon glyphicon-triangle-top sort"></i>
                </th>
                <th>{{ trans('multi_language.number_subfolder') }}</th>
            </thead>
            <tbody>
                @if (isset($folders))
                    @foreach ($folders as $key => $folder)
                        <tr id="tr-folder-{{ $folder->id }}">
                            <td class="value-folder">
                                @php
                                    $flag = false;
                                @endphp

                                <!-- @foreach(Auth::user()->permission as $user_permission)
                                    @if ($user_permission->folder_id == $folder->id)
                                        @php
                                            $flag = true;
                                        @endphp
                                        @break;
                                    @endif
                                @endforeach -->
    
                                @if (isset($ids_parent_folder))
                                    @foreach ($ids_parent_folder as $idp)
                                        @if ($idp == $folder->id)
                                            @php
                                                $flag = true;
                                            @endphp
                                            @break;
                                        @endif
                                    @endforeach
                                @endif
    
                                @if ($flag)   
                                    <a href="{{ route('folder.show', $folder->id) }}">
                                        <img src="{{ config('app.upload_file') }}/folder_open.jpg" class="folder-icon">
                                        <span>{{ $folder->name }}</span>
                                    </a>
                                @else
                                    <img src="{{ config('app.upload_file') }}/folder_lock.jpg" class="folder-icon">
                                    <span>{{ $folder->name }}</span>
                                @endif
                            </td>
                            <td class="value-folder">{{ $folder->created_at }}</td>
                            <td class="value-folder number-sub">{{ $number_subfolders[$key] }}</td>
                        </tr>
                    @endforeach
                @elseif (isset($subfolders))
                    @foreach ($subfolders as $key => $sbf)
                        <tr id="tr-folder-{{ $sbf->id }}">
                            <td>
                                @php
                                    $flag = false;
                                @endphp
    
                                @foreach($ids_subfolder as $ids)
                                    @if ($ids == $sbf->id)
                                        @php
                                            $flag = true;
                                        @endphp
                                        @break;
                                    @endif
                                @endforeach
    
                                @if ($flag == false)
                                    @foreach ($ids_parent_folder as $idp)
                                        @if ($idp == $sbf->id)
                                            @php
                                                $flag = true;
                                            @endphp
                                            @break;
                                        @endif
                                    @endforeach
                                @endif
                            
                                @if ($flag)
                                    <a href="{{ route('folder.show', $sbf->id) }}">
                                        <img src="{{ config('app.upload_file') }}/folder_open.jpg" class="folder-icon">
                                        <span>{{ $sbf->name }}</span>
                                    </a>
                                @else
                                    <img src="{{ config('app.upload_file') }}/folder_lock.jpg" class="folder-icon">
                                    <span>{{ $sbf->name }}</span>
                                @endif
                            </td>
                            <td class="value-folder">{{ $sbf->created_at }}</td>
                            <td class="value-folder number-sub">{{ $number_subfolders[$key] }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    @else
        <table class="table table-striped table-hover table-folder text-center">
            <thead>
                <th>{{ trans('multi_language.name') }}</th>
                <th>{{ trans('multi_language.date_created') }}</th>
                <th>{{ trans('multi_language.number_subfolder') }}</th>
            </thead>
            <tbody>
                @if (isset($folders))
                    @foreach ($folders as $key => $folder)
                        <tr id="tr-folder-{{ $folder->id }}">
                            <td class="value-folder">
                                <img src="{{ config('app.upload_file') }}/folder_lock.jpg" class="folder-icon">
                                <span>{{ $folder->name }}</span>
                            </td>
                            <td class="value-folder">{{ $folder->created_at }}</td>
                            <td class="value-folder number-sub">{{ $number_subfolders[$key] }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    @endif
@endsection
