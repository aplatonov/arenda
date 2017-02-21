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
                            console.log(response.text + ' Не хватает прав для получения информации об объекте.');
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
        <div class="col-md-12">
            @if(Session::has('message'))
                <div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{Session::get('message')}}
                </div>
            @endif
            <div class="panel panel-default h6">
                <div class="panel-heading"><strong>Список объектов {{ $title or '' }}</strong></div>

                <div class="panel-body text-center"></div>
                
                <div class="table-responsive"> 

                    <table class="table table-striped table-hover table-condensed">
                    <tr>
                        <th class="text-center"><a href="?page={{ $data['objects']->currentPage() }}&order=id&dir={{ $data['dir'] ? $data['dir'] : 'asc' }}">Код</a>{!! $data['page_appends']['order'] == 'id' ? $data['dir'] == 'desc' ? '<span class="glyphicon glyphicon-arrow-down"></span>' : '<span class="glyphicon glyphicon-arrow-up"></span>' : '' !!}</th>
                        <th><a href="?page={{ $data['objects']->currentPage() }}&order=object_name&dir={{ $data['dir'] ? $data['dir'] : 'asc' }}">Название</a>{!! $data['page_appends']['order'] == 'object_name' ? $data['dir'] == 'desc' ? '<span class="glyphicon glyphicon-arrow-down"></span>' : '<span class="glyphicon glyphicon-arrow-up"></span>' : '' !!}</th>
                        <th class="text-center"><a href="?page={{ $data['objects']->currentPage() }}&order=year&dir={{ $data['dir'] ? $data['dir'] : 'asc' }}">Год</a>{!! $data['page_appends']['order'] == 'year' ? $data['dir'] == 'desc' ? '<span class="glyphicon glyphicon-arrow-down"></span>' : '<span class="glyphicon glyphicon-arrow-up"></span>' : '' !!}</th>
                        <th class="text-center"><a href="?page={{ $data['objects']->currentPage() }}&order=price&dir={{ $data['dir'] ? $data['dir'] : 'asc' }}">Цена</a>{!! $data['page_appends']['order'] == 'price' ? $data['dir'] == 'desc' ? '<span class="glyphicon glyphicon-arrow-down"></span>' : '<span class="glyphicon glyphicon-arrow-up"></span>' : '' !!}</th>
                        <th class="text-center"><a href="?page={{ $data['objects']->currentPage() }}&order=free_since&dir={{ $data['dir'] ? $data['dir'] : 'asc' }}">Доступен</a>{!! $data['page_appends']['order'] == 'free_since' ? $data['dir'] == 'desc' ? '<span class="glyphicon glyphicon-arrow-down"></span>' : '<span class="glyphicon glyphicon-arrow-up"></span>' : '' !!}</th>
                        <th class="text-center">Конт. инф.</th>
                        <th class="text-right"></th>
                    </tr>

                    @foreach($data['objects'] as $object)
                        <tr> 
                            <td class="text-center">{{ $object->id }}</td>
                            <td><a href="/objects/{{ $object->id }}">{{ $object->object_name }}</a><br><small>Категория <strong>{{ $object->category->name_cat }}</strong></small></td>
                            <td class="text-center">{{ $object->year }}</td>
                            <td class="text-center">
                                {{ $object->price }}{{ isset($object->name_period) ? '/' . $object->name_period : '' }}<br>
                                {{ isset($object->min_period) ? 'Мин. заказ ' . $object->min_period . ' ' . $object->name_period : ''}}</a>
                            </td>
                            <td class="text-center">{{ isset($object->free_since) ? \Carbon\Carbon::now()<$object->free_since ? 'c ' . \Carbon\Carbon::parse($object->free_since)->format('d-m-Y') : 'сейчас' : 'сейчас' }}</td>
                            <td class="text-center">
                                @if (!Auth::guest() && Auth::user()->confirmed == 1 && Auth::user()->valid == 1)
                                    <div id="objectInfo{{ $object->id }}">
                                        <form class="showObjectInfo" > 
                                            <input class="btn btn-xs" type="submit" value="Показать">
                                            <input type="hidden" name="_token"  id="_token" value="{{csrf_token()}}"/>
                                            <input type="hidden" name="object_id" id="object_id" value="{{ $object->id }}"/>
                                        </form>
                                    </div>
                                @else
                                    <div><span class="badge badge-warning">Нет прав</span></div>
                                @endif
                            </td>

                            <td class="text-right">
                                @if (Auth::user()->id == $object->owner_id || Auth::user()->role_id == 1)
                                    <form method="POST" action="{{action('ObjectController@destroyObject',['id'=>$object->id])}}">
                                        <input type="hidden" name="_method" value="delete"/>
                                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                        <input type="submit" class="btn btn-xs btn-default" value="Удалить"/>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </table>
                </div>
                <div class="panel-footer">{!! $data['objects']->appends($data['page_appends'])->links('vendor.pagination.default') !!}</div>
            </div>
        </div>
    </div>
</div>
@endsection
