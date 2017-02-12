@extends('layouts.app')

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
                <div class="panel-heading">Error 404</div>

                <div class="panel-body">
                    Запрашиваемая страница не найдена!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
