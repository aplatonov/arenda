@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Редактирование профиля пользователя</div>

                <div class="panel-body">

                    <form class="form-horizontal" role="form" method="POST" action="{{ action('UserController@update', ['user'=>$user->id]) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="form-group">
                            <label class="col-md-4 control-label">Логин</label>
                            <label class="col-md-6 control-label">{{ $user->login }}</label>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Имя (наименование)</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('dopname') ? ' has-error' : '' }}">
                            <label for="dopname" class="col-md-4 control-label">Контактное лицо</label>

                            <div class="col-md-6">
                                <input id="dopname" type="text" class="form-control" name="dopname" value="{{ $user->dopname }}" required>

                                @if ($errors->has('dopname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('dopname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-md-4 control-label">Телефон</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control" name="phone" value="{{ $user->phone }}" required>

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @if (!Auth::guest() && Auth::user()->confirmed == 0)
                            <div class="form-group">
                                <label class="col-md-10 control-label"><span class="badge badge-important">Логин не подтвержден!</span><br><small>Вы не можете добавлять объекты и просматривать контактные данные</small>
                            </div>
                        @endif
                        @if (!Auth::guest() && Auth::user()->valid == 0)
                            <div class="form-group">
                                <label class="col-md-4 control-label"></label>
                                <label class="col-md-6 control-label"><span class="badge badge-warning">Логин заблокирован!</span><br><small>обратитесь к администратору</small>
                            </div>
                        @endif

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4 text-right">
                                <button type="submit" class="btn btn-primary">
                                    Сохранить
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
