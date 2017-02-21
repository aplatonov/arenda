@extends('layouts.app')

@section('scripts')
    <script>
        $(document).ready(function(){
            $('.showRequestInfo').submit(function(e){
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

            $('.blockRequest').submit(function(e){
                e.preventDefault();
                var action = $(this).find("input[name=action]").val();
                var request_id = $(this).find("input[name=request_id]").val();
                if (action == 'Заблокировать') {
                    action = 1;
                } else {
                    action = 0;
                }
                $.ajax({
                    type: 'POST',
                    url: '/requests/block/' + request_id,
                    cache: false,
                    dataType: 'json',
                    data: {request_id: request_id,
                           action: action,
                           '_token': "{{csrf_token()}}"
                    },
                    success: function (response) {
                        if (response.text == 'success') {
                            if (action == 1) {
                                document.getElementById("blockedRequest"+request_id).value = "Разблокировать";   
                            } else {
                                document.getElementById("blockedRequest"+request_id).value = "Заблокировать";
                            }
                            
                            console.log("#blockedRequest"+request_id);
                        } else {
                            console.log(response.text + ' Не хватает прав для блокировки/разблокировки запроса.');
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
                <div class="panel-heading">Карточка заявки</div>

                <div class="panel-body">
                    <h2>#{{ $req->id }} - {{ $req->request_name }}</h2>
                    <p>{{ $req->comment }}</p>
                    @if (Auth::user()->id == $req->owner_id || Auth::user()->role_id == 1)
                        <a href="{{ url('/requests/'.$req->id.'/edit') }}"><button class="btn pull-left" type="button">Редактировать</button></a>
                    @endif
                </div>
                <div class="list-group">
                    <a href="#" class="list-group-item"><strong>Категория: </strong>{{ $req->category->name_cat }}</a>
                    <a href="#" class="list-group-item"><strong>Период с: </strong>{{ isset($req->start_date) ? Carbon\Carbon::parse($req->start_date)->format('d-m-Y') : '' }}</a>
                    <a href="#" class="list-group-item"><strong>Период по: </strong>{{ isset($req->finish_date) ? Carbon\Carbon::parse($req->finish_date)->format('d-m-Y') : '' }}</a>
                    @if (!Auth::guest() && Auth::user()->confirmed == 1 && Auth::user()->valid == 1)
                        <a href="#" class="list-group-item"><strong></strong>
                            <span id="requestInfo{{ $req->id }}">
                                <form class="showRequestInfo" > 
                                    <input class="btn btn-xs btn-block" type="submit" value="Контактная информация заявителя">
                                    <input type="hidden" name="_token"  id="_token" value="{{csrf_token()}}"/>
                                    <input type="hidden" name="request_id" id="request_id" value="{{ $req->id }}"/>
                                </form>
                            </span>
                        </a>
                    @endif
                    @if (Auth::user()->id == $req->owner_id || Auth::user()->role_id == 1)
                        <a href="#" class="list-group-item">
                            @if ($req->disabled)
                                <div id="blockRequest{{ $req->id }}">
                                    <form class="blockRequest" > 
                                        <input class="btn btn-xs btn-success btn-block" type="submit" name="action" id="blockedRequest{{ $req->id }}" value="Разблокировать">
                                        <input type="hidden" name="_token"  id="_token" value="{{csrf_token()}}"/>
                                        <input type="hidden" name="request_id" id="request_id" value="{{ $req->id }}"/>
                                    </form>
                                </div>
                            @else
                                <div id="blockRequest{{ $req->id }}">
                                    <form class="blockRequest" > 
                                        <input class="btn btn-xs btn-danger btn-block" type="submit" name="action" id="blockedRequest{{ $req->id }}" value="Заблокировать">
                                        <input type="hidden" name="_token"  id="_token" value="{{csrf_token()}}"/>
                                        <input type="hidden" name="request_id" id="request_id" value="{{ $req->id }}"/>
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