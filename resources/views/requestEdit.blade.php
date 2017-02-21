@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Редактирование заявки</div>

                <div class="panel-body h6">

                    <form class="form-horizontal" role="form" enctype="multipart/form-data" method="POST" action="{{ action('RequestController@update', ['req'=>$req->id]) }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('request_name') ? ' has-error' : '' }}">
                            <label for="request_name" class="col-md-4 control-label">Наименование заявки</label>

                            <div class="col-md-6">
                                <input id="request_name" type="text" class="form-control input-sm" name="request_name" value="{{ $req->request_name }}" required autofocus>

                                @if ($errors->has('request_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('request_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                            <label for="comment" class="col-md-4 control-label">Описание объекта</label>

                            <div class="col-md-4">
                                <textarea  rows="6" id="comment" type="text" class="form-control input-sm" name="comment" required>{{$req->comment}}</textarea>

                                @if ($errors->has('comment'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('comment') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                            <label for="category_id" class="col-md-4 control-label">Категория заявки</label>
                            <div class="col-md-4">
                                <select id="category_id" name="category_id" class="form-control input-sm" name="category_id">
                                    @foreach($allCategories as $category)
                                        @if ($req->category_id == $category->id)
                                                <option selected value="{{$category->id}}">{{$category->name_cat}}</option>
                                            @else
                                                <option value="{{$category->id}}">{{$category->name_cat}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
                            <label for="start_date" class="col-md-4 control-label">Период с</label>

                            <div class="col-md-6">
                                <input id="start_date" type="text" class="form-control input-sm" name="start_date" value="{{ isset($req->start_date) ? Carbon\Carbon::parse($req->start_date)->format('Y-m-d') : '' }}">

                                @if ($errors->has('start_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('start_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('finish_date') ? ' has-error' : '' }}">
                            <label for="finish_date" class="col-md-4 control-label">Период по</label>

                            <div class="col-md-6">
                                <input id="finish_date" type="text" class="form-control input-sm" name="finish_date" value="{{ isset($req->finish_date) ? Carbon\Carbon::parse($req->finish_date)->format('Y-m-d') : '' }}">

                                @if ($errors->has('finish_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('finish_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('disabled') ? ' has-error' : '' }}">
                            <label for="disabled" class="col-md-4 control-label">Заблокирован</label>
                            <div class="col-md-6">
                                <input type="checkbox" {{ $req->disabled ? 'checked' : ''}} class="text-left input-sm" name="disabled" value="0">
                            </div>
                        </div>
                        <br>

                        <script type="text/javascript">
                            $(function () {
                                $('#start_date').datepicker({
                                    format: "yyyy-mm-dd",
                                    weekStart: 1,
                                    autoClose: true
                                });

                                $('#finish_date').datepicker({
                                    format: "yyyy-mm-dd",
                                    weekStart: 1,
                                    autoClose: true
                                });
                            });
                        </script>

                        <input type="hidden" name="_method" value="put">

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
