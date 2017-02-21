@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Редактирование объекта</div>

                <div class="panel-body h6">

                    <form class="form-horizontal" role="form" enctype="multipart/form-data" method="POST" action="{{ action('ObjectController@update', ['object'=>$object->id]) }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('object_name') ? ' has-error' : '' }}">
                            <label for="object_name" class="col-md-4 control-label">Наименование объекта</label>

                            <div class="col-md-6">
                                <input id="object_name" type="text" class="form-control input-sm" name="object_name" value="{{ $object->object_name }}" required autofocus>

                                @if ($errors->has('object_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('object_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-4 control-label">Описание объекта</label>

                            <div class="col-md-4">
                                <textarea  rows="6" id="description" type="text" class="form-control input-sm" name="description" required>{{$object->description}}</textarea>

                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                            <label for="category_id" class="col-md-4 control-label">Категория объекта</label>
                            <div class="col-md-4">
                                <select id="category_id" name="category_id" class="form-control input-sm" name="category_id">
                                    @foreach($allCategories as $category)
                                        @if ($object->category_id == $category->id)
                                                <option selected value="{{$category->id}}">{{$category->name_cat}}</option>
                                            @else
                                                <option value="{{$category->id}}">{{$category->name_cat}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('year') ? ' has-error' : '' }}">
                            <label for="year" class="col-md-4 control-label">Год выпуска</label>

                            <div class="col-md-6">
                                <input id="year" type="text" class="form-control input-sm" name="year" value="{{ $object->year }}" required onkeyup="this.value = this.value.replace (/\D/g, '')">

                                @if ($errors->has('year'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('year') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('name_period') ? ' has-error' : '' }}">
                            <label for="name_period" class="col-md-4 control-label">Период сдачи</label>

                            <div class="col-md-6">
                                <!--input id="name_period" type="text" class="form-control input-sm" name="name_period" value="{{ $object->name_period }}" placeholder="час, сутки и пр."-->
                                <select id="name_period" name="name_period" class="form-control input-sm" name="name_period">
                                    <option {{ $object->name_period == 'час' ? 'selected' : '' }} value="час">час</option>
                                    <option {{ $object->name_period == 'сут.' ? 'selected' : '' }} value="сут.">сут.</option>
                                    <option {{ $object->name_period == 'нед.' ? 'selected' : '' }} value="нед.">нед.</option>
                                    <option {{ $object->name_period == 'мес.' ? 'selected' : '' }} value="мес.">мес.</option>
                                </select>

                                @if ($errors->has('name_period'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name_period') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('min_period') ? ' has-error' : '' }}">
                            <label for="min_period" class="col-md-4 control-label">Минимальный период сдачи</label>

                            <div class="col-md-6">
                                <input id="min_period" type="text" class="form-control input-sm" name="min_period" value="{{ $object->min_period }}" onkeyup="this.value = this.value.replace (/\D/g, '')">

                                @if ($errors->has('min_period'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('min_period') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                            <label for="price" class="col-md-4 control-label">Цена</label>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">P</span>
                                    <input id="price" type="text" class="form-control input-sm" name="price" value="{{ $object->price }}" placeholder="Руб." onkeyup="this.value = this.value.replace (/\D/g, '')">
                                    <span class="input-group-addon">.00</span>

                                    @if ($errors->has('price'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('price') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('free_since') ? ' has-error' : '' }}">
                            <label for="free_since" class="col-md-4 control-label">Доступен с</label>

                            <div class="col-md-6">
                                <input id="free_since" type="text" class="form-control input-sm" name="free_since" value="{{ isset($object->free_since) ? Carbon\Carbon::parse($object->free_since)->format('Y-m-d') : '' }}">

                                @if ($errors->has('free_since'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('free_since') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('disabled') ? ' has-error' : '' }}">
                            <label for="disabled" class="col-md-4 control-label">Заблокирован</label>
                            <div class="col-md-6">
                                <input type="checkbox" {{ $object->disabled ? 'checked' : ''}} class="text-left input-sm" name="disabled" value="0">
                            </div>
                        </div>
                        <br>

                        <script type="text/javascript">
                            $(function () {
                                $('#free_since').datepicker({
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
