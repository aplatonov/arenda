@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button> 
                        <strong>{{ $message }}</strong>
                </div>
            @endif
            <div class="panel panel-default panel-primary">
                <div class="panel-heading">Форма обратной связи</div>

                <div class="panel-body">
                    <form action="{{action('EmailController@send')}}" method="POST" id="contact-form" class="form-horizontal" role="form">
                        <div for="name" class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label ">Имя</label>
                            <div class="col-md-6">
                                <input class="form-control" id="name" type="text" name="name" placeholder="Ваше имя" 
                                @if (Auth::guest())
                                    value="{{ old('name') }}"
                                @else
                                    value="{{ Auth::user()->name }} ({{ Auth::user()->login }})"
                                @endif
                                 required>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div for="email" class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-mail</label>
                            <div class="col-md-6">
                                <input class="form-control" id="email" type="email" name="email" placeholder="e-mail" 
                                @if (Auth::guest())
                                    value="{{ old('email') }}"
                                @else
                                    value="{{ Auth::user()->email }}"
                                @endif
                                 required>
                            </div>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif                    
                        </div>

                        <div for="user_message" class="form-group{{ $errors->has('user_message') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Сообщение</label>
                            <div class="col-md-6">
                                <textarea rows="16" class="form-control input-sm" name="user_message" required>{{ old('user_message') }}</textarea>
                                @if ($errors->has('user_message'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('user_message') }}</strong>
                                    </span>
                                @endif
                            </div>                      
                        </div>

                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4 text-right">
                                <input type="submit" class="btn btn-primary" value="Отправить сообщение">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
