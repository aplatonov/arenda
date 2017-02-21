@extends('layouts.app')

@section('scripts')
    <script>
        $(document).ready(function(){
            $('.showRequestContact').submit(function(e){
                e.preventDefault();

                var request_id = $(this).find("input[name=request_id]").val();
    
                $.ajax({
                    type: 'POST',
                    url: '/requests/info/' + request_id,
                    cache: false,
                    dataType: 'json',
                    data: {request_id: request_id,
                           '_token': "{{csrf_token()}}"
                    },
                    success: function (response) {
                        if (response.text == 'success') {
                            $("#requestInfo"+request_id).html(response.request_info);
                        } else {
                            console.log(response.text + ' Не хватает прав для получения информации о запросе.');
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
                <div class="panel-heading"><strong>Список заявок</strong></div>

                <div class="panel-body text-center"></div>
                
                <div class="table-responsive"> 

                    <table class="table table-striped table-hover table-condensed">
                    <tr>
                        <th class="text-center"><a href="/requests?page={{ $data['requests']->currentPage() }}&order=id&dir={{ $data['dir'] ? $data['dir'] : 'asc' }}">Код</a>{!! $data['page_appends']['order'] == 'id' ? $data['dir'] == 'desc' ? '<span class="glyphicon glyphicon-arrow-down"></span>' : '<span class="glyphicon glyphicon-arrow-up"></span>' : '' !!}</th>
                        <th><a href="/requests?page={{ $data['requests']->currentPage() }}&order=request_name&dir={{ $data['dir'] ? $data['dir'] : 'asc' }}">Наименование</a>{!! $data['page_appends']['order'] == 'request_name' ? $data['dir'] == 'desc' ? '<span class="glyphicon glyphicon-arrow-down"></span>' : '<span class="glyphicon glyphicon-arrow-up"></span>' : '' !!}</th>
                        <th class="text-center"><a href="/requests?page={{ $data['requests']->currentPage() }}&order=start_date&dir={{ $data['dir'] ? $data['dir'] : 'asc' }}">Начало периода</a>{!! $data['page_appends']['order'] == 'start_date' ? $data['dir'] == 'desc' ? '<span class="glyphicon glyphicon-arrow-down"></span>' : '<span class="glyphicon glyphicon-arrow-up"></span>' : '' !!}</th>
                        <th class="text-center"><a href="/requests?page={{ $data['requests']->currentPage() }}&order=finish_date&dir={{ $data['dir'] ? $data['dir'] : 'asc' }}">Конец периода</a>{!! $data['page_appends']['order'] == 'finish_date' ? $data['dir'] == 'desc' ? '<span class="glyphicon glyphicon-arrow-down"></span>' : '<span class="glyphicon glyphicon-arrow-up"></span>' : '' !!}</th>
                        <th class="text-center">Конт. инф.</th>
                        <th class="text-right"></th>
                    </tr>

                    @foreach($data['requests'] as $req)
                        <tr> 
                            <td class="text-center">{{ $req->id }}</td>
                            <td><a href="/requests/{{ $req->id }}">{{ $req->request_name }}</a><br><small>Категория <strong>{{ $req->category->name_cat }}</strong></small></td>
                            <td class="text-center">{{ isset($req->start_date) ? Carbon\Carbon::parse($req->start_date)->format('d-m-Y') : '' }}</td>
                            <td class="text-center">{{ isset($req->finish_date) ? Carbon\Carbon::parse($req->finish_date)->format('d-m-Y') : '' }}</td>
                            <td class="text-center">
                                @if (!Auth::guest() && Auth::user()->confirmed == 1 && Auth::user()->valid == 1)
                                    <div id="requestInfo{{ $req->id }}">
                                        <form class="showRequestContact" > 
                                            <input class="btn btn-xs" type="submit" value="Показать">
                                            <input type="hidden" name="_token"  id="_token" value="{{csrf_token()}}"/>
                                            <input type="hidden" name="request_id" id="request_id" value="{{ $req->id }}"/>
                                        </form>
                                    </div>
                                @else
                                    <div><span class="badge badge-warning">Нет прав</span></div>
                                @endif
                            </td>

                            <td class="text-right">
                                @if (Auth::user()->id == $req->owner_id || Auth::user()->role_id == 1)
                                    <form method="POST" action="{{action('RequestController@destroyRequest',['id'=>$req->id])}}">
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
                <div class="panel-footer">{!! $data['requests']->appends($data['page_appends'])->links('vendor.pagination.default') !!}</div>
            </div>
        </div>
    </div>
</div>
@endsection
