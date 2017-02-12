@extends('layouts.app')

@section('scripts')
    <script>
        $(document).ready(function(){
            $('.showObjectInfo').submit(function(e){
                e.preventDefault();

                var object_id = $(this).find("input[name=object_id]").val();
    
                $.ajax({
                    type: 'POST',
                    url: '/objects/info/' + object_id,
                    cache: false,
                    dataType: 'json',
                    data: {object_id: object_id,
                           '_token': "{{csrf_token()}}"
                    },
                    success: function (response) {
                        if (response.text == 'success') {
                            $("#objectInfo"+object_id).html(response.object_info);
                        } else {
                            console.log(response.text + ' Не хватает прав для подтверждения пользователя.');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('oshibka');
                    }
                });
                return false;
            }); 

            $('.blockObject').submit(function(e){
                e.preventDefault();
                var action = $(this).find("input[name=action]").val();
                var object_id = $(this).find("input[name=object_id]").val();
                if (action == 'Заблокировать') {
                    action = 1;
                } else {
                    action = 0;
                }
                $.ajax({
                    type: 'POST',
                    url: '/objects/block/' + object_id,
                    cache: false,
                    dataType: 'json',
                    data: {object_id: object_id,
                           action: action,
                           '_token': "{{csrf_token()}}"
                    },
                    success: function (response) {
                        if (response.text == 'success') {
                            if (action == 1) {
                                document.getElementById("blockedObject"+object_id).value = "Разблокировать";   
                            } else {
                                document.getElementById("blockedObject"+object_id).value = "Заблокировать";
                            }
                            
                            console.log("#blockedObject"+object_id);
                        } else {
                            console.log(response.text + ' Не хватает прав для блокировки/разблокировки объекта.');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('oshibka');
                    }
                });
                return false;
            });                
        });
    </script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if(Session::has('message'))
                <div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{Session::get('message')}}
                </div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">Карточка объекта</div>

                <div class="panel-body">
                    <h2>#{{ $object->id }} - {{ $object->object_name }}</h2>
                    <p>{{ $object->description }}</p>
                    @if (Auth::user()->id == $object->owner_id || Auth::user()->role_id == 1)
                        <a href="{{ url('/objects/'.$object->id.'/edit') }}"><button class="btn pull-left" type="button">Редактировать</button></a>
                    @endif
                </div>
                <div class="list-group">
                    <a href="#" class="list-group-item"><strong>Категория: </strong>{{ $object->category->name_cat }}</a>
                    <a href="#" class="list-group-item"><strong>Год выпуска: </strong>{{ $object->year }}</a>
                    <a href="#" class="list-group-item"><strong>Период сдачи: </strong>{{ isset($object->name_period) ? $object->name_period : 'не задан' }}</a>
                    <a href="#" class="list-group-item"><strong>Минимальный срок сдачи: </strong>{{isset($object->min_period) ? $object->min_period . ' ' . $object->name_period : 'не указан'}}</a>
                    <a href="#" class="list-group-item"><strong>Цена: </strong>{{ $object->price }}</a>
                    <a href="#" class="list-group-item"><strong>Свободен: </strong>{{ isset($object->free_since) ? 'c ' . Carbon\Carbon::parse($object->free_since)->format('d-m-Y') : 'сейчас' }}</a>
                    @if (!Auth::guest() && Auth::user()->confirmed == 1 && Auth::user()->valid == 1)
                        <a href="#" class="list-group-item"><strong></strong>
                            <span id="objectInfo{{ $object->id }}">
                                <form class="showObjectInfo" > 
                                    <input class="btn btn-xs btn-block" type="submit" value="Контактная информация владельца">
                                    <input type="hidden" name="_token"  id="_token" value="{{csrf_token()}}"/>
                                    <input type="hidden" name="object_id" id="object_id" value="{{ $object->id }}"/>
                                </form>
                            </span>
                        </a>
                    @endif
                    @if (Auth::user()->id == $object->owner_id || Auth::user()->role_id == 1)
                        <a href="#" class="list-group-item">
                            @if ($object->disabled)
                                <div id="blockObject{{ $object->id }}">
                                    <form class="blockObject" > 
                                        <input class="btn btn-xs btn-success btn-block" type="submit" name="action" id="blockedObject{{ $object->id }}" value="Разблокировать">
                                        <input type="hidden" name="_token"  id="_token" value="{{csrf_token()}}"/>
                                        <input type="hidden" name="object_id" id="object_id" value="{{ $object->id }}"/>
                                    </form>
                                </div>
                            @else
                                <div id="blockObject{{ $object->id }}">
                                    <form class="blockObject" > 
                                        <input class="btn btn-xs btn-danger btn-block" type="submit" name="action" id="blockedObject{{ $object->id }}" value="Заблокировать">
                                        <input type="hidden" name="_token"  id="_token" value="{{csrf_token()}}"/>
                                        <input type="hidden" name="object_id" id="object_id" value="{{ $object->id }}"/>
                                    </form>
                                </div>
                            @endif
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection