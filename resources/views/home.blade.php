@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="well well-sm">
            <script type="text/javascript">
                $(function () {
                    $('#beginDate').datepicker({
                        format: "yyyy-mm-dd",
                        weekStart: 1,
                        autoClose: true
                    });
                });
            </script>
            <form class="form-inline text-right" method="GET" action="{{url('/home')}}">
                <div class="form-group">
                    <input type="text" class="form-control input-sm" id="objectName" name="objectName" value="{{ Request::get('objectName') }}" placeholder="Название объекта">
                </div>

                <div class="form-group">
                    <input type="text" class="form-control input-sm" id="beginDate" name="beginDate"  value="{{ Request::get('beginDate') }}" placeholder="Дата после">
                </div>

                <button type="submit" class="btn btn-info btn-sm">Применить фильтр</button>
                <a href="{{ url('/home') }}"><button type="button" class="btn btn-default btn-sm">Очистить фильтр</button></a>
            </form>
        </div>
        <div class="col-sm-6">
            <div class="table-responsive"> 
                <table class="table table-striped table-hover table-condensed">
                    <tr>
                        <th class="text-left">Объект</th>
                        <th class="text-center">Цена</th>
                        <th class="text-center">Дата</th>
                    </tr>
                    @foreach($data['objects'] as $object)
                        <tr> 
                            <td class="text-left">
                                <a href="/objects/{{ $object->id }}">{{ $object->object_name }} (#{{ $object->id }})</a><br><small>Категория <strong>{{ $object->category->name_cat }}</strong></small>
                            </td>
                            <td class="text-center">
                                {{ $object->price }}{{ isset($object->name_period) ? '/' . $object->name_period : '' }}<br>
                                {{ isset($object->min_period) ? 'Мин. заказ ' . $object->min_period . ' ' . $object->name_period : ''}}
                            </td>
                            <td class="text-center">
                                {{ isset($object->free_since) ? \Carbon\Carbon::now()<$object->free_since ? 'c ' . \Carbon\Carbon::parse($object->free_since)->format('d-m-Y') : 'сейчас' : 'сейчас' }}
                            </td>
                        </tr>
                    @endforeach                
                </table>
                
            </div>
            {!! $data['objects']->setPageName('page_o')->links('vendor.pagination.default') !!}
        </div>  
        <div class="col-sm-6">
            <div class="table-responsive"> 
                <table class="table table-striped table-hover table-condensed">
                    <tr>
                        <th class="text-left">Заявка</th>
                        <th class="text-center">Период</th>
                    </tr>
                    @foreach($data['requests'] as $req)
                        <tr> 
                            <td class="text-left">
                                <a href="/requests/{{ $req->id }}">{{ $req->request_name }} (#{{ $req->id }})</a><br><small>Категория <strong>{{ $req->category->name_cat }}</strong></small>
                            </td>
                            <td class="text-center">
                                {{ isset($req->start_date) ? Carbon\Carbon::parse($req->start_date)->format('d-m-Y') : '' }} - {{ isset($req->finish_date) ? Carbon\Carbon::parse($req->finish_date)->format('d-m-Y') : '' }}
                            </td>
                        </tr>
                    @endforeach
                </table>
                
            </div>
            {!! $data['requests']->setPageName('page_r')->links('vendor.pagination.default') !!}
        </div> 
    </div>
</div>
@endsection
