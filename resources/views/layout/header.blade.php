<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span> 
            </button>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li class="active">
                    <label>{{ trans('multi_language.language') }}</label>
                    @if (Session::has('locale') && Session::get('locale') == 'vi')
                        <a href="{!! route('multi-language', ['vi']) !!}">
                            <img src="{{ config('app.upload_file') }}/flag_vn.png" class="selected_language">
                        </a>
                        <a href="{!! route('multi-language', ['en']) !!}">
                            <img src="{{ config('app.upload_file') }}/flag_en.png">
                        </a>
                    @else
                        <a href="{!! route('multi-language', ['vi']) !!}">
                            <img src="{{ config('app.upload_file') }}/flag_vn.png">
                        </a>
                        <a href="{!! route('multi-language', ['en']) !!}">
                            <img src="{{ config('app.upload_file') }}/flag_en.png" class="selected_language">
                        </a>
                    @endif
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::check())
                    <li><label>{{ Auth::user()->name }}</label></li>
                    @if (Auth::user()->level == 2)
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="management dropdown-toggle">
                                {{ trans('multi_language.management') }}
                                <span class="caret"></span>
                            </a>    
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('user.index') }}">
                                        {{ trans('multi_language.user_management') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('folder.index') }}">
                                        {{ trans('multi_language.folder_management') }}
                                    </a>
                                </li>
                                <li><a href=""></a></li>
                            </ul> 
                        </li>                      
                    @endif
                    <li><a href="{{ route('dang-xuat') }}">{{ trans('multi_language.logout') }}</a></li>                
                @else
                    <li><a data-toggle="modal" data-target="#login">{{ trans('multi_language.login') }}</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>

@if (((count($errors) > 0) && Session::has('login')) || Session::has('error_login'))
    <div class="error_login"></div>
@endif
