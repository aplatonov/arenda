@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Редактирование категории</div>

                <div class="panel-body h6">

                    <form class="form-horizontal" role="form" method="POST" action="{{ action('CategoryController@update', ['category'=>$category->id]) }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label class="col-md-4 control-label">Родительская категория:</label>
                            <div class="col-md-6">
                                <p class="form-control-static">{{ $category->parent->name_cat or 'Корневая' }}</p>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('name_cat') ? ' has-error' : '' }}">
                            <label for="name_cat" class="col-md-4 control-label">Наименование категории</label>

                            <div class="col-md-6">
                                <input id="name_cat" type="text" class="form-control input-sm" name="name_cat" value="{{ $category->name_cat }}" required autofocus>

                                @if ($errors->has('name_cat'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name_cat') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
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
