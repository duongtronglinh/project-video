<div class="modal fade" id="login" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">{{ trans('multi_language.X') }}</button>
                <h2 class="modal-title title">{{ trans('multi_language.login') }}</h2>
            </div>
            <div class="modal-body">
                <div class="form-login">
                    <form action="{{ route('dang-nhap') }}" method="POST">
                    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <table>
                            @if (count($errors) > 0)
                                <div class="text-center alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $err)
                                            <li>{{ $err }}</li>
                                        @endforeach
                                    </ul> 
                                </div>
                            @elseif (Session::has('error_login'))
                                <div class="text-center alert alert-danger">{{ Session::get('error_login') }}</div>
                            @endif

                            <tr>
                                <td class="text-right">{{ trans('multi_language.email') }}</td>
                                <td>
                                    <input type="text" name="email" class="form-control" value="{{ old('email') }}">
                                </td>
                            </tr>

                            <tr>
                                <td class="text-right">{{ trans('multi_language.password') }}</td>
                                <td><input type="password" name="password" class="form-control"></td>
                            </tr>

                            <tr>
                                <td colspan="2" align="center">
                                    <input type="checkbox" name="remember_me"> 
                                    <label>{{ trans('multi_language.remember_me') }}</label>
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="text-center" colspan="2">
                                    <button type="submit">{{ trans('multi_language.login') }}</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>  
    </div>
</div>

