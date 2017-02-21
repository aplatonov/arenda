@extends('layouts.app')

@section('scripts')
    <script>
        $(document).ready(function(){
            $('.confirmUser').submit(function(e){
                e.preventDefault();

                var user_id = $(this).find("input[name=user_id]").val();
    
                $.ajax({
                    type: 'POST',
                    url: '/admin/users/confirm/' + user_id,
                    cache: false,
                    dataType: 'json',
                    data: {user_id: user_id,
                           '_token': "{{csrf_token()}}"
                    },
                    success: function (response) {
                        if (response.text == 'success') {
                            $("#confirmedUser"+user_id).html('да');
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

            $('.blockUser').submit(function(e){
                e.preventDefault();
                var action = $(this).find("input[name=action]").val();
                var user_id = $(this).find("input[name=user_id]").val();
                if (action == 'Заблокировать') {
                    action = 0;
                } else {
                    action = 1;
                }
                $.ajax({
                    type: 'POST',
                    url: '/admin/users/block/' + user_id,
                    cache: false,
                    dataType: 'json',
                    data: {user_id: user_id,
                           action: action,
                           '_token': "{{csrf_token()}}"
                    },
                    success: function (response) {
                        if (response.text == 'success') {
                            if (action == 0) {
                                document.getElementById("blockedUser"+user_id).value = "Разблокировать";   
                            } else {
                                document.getElementById("blockedUser"+user_id).value = "Заблокировать";
                            }
                            
                            console.log("#blockedUser"+user_id);
                        } else {
                            console.log(response.text + ' Не хватает прав для блокировки/разблокировки пользователя.');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('oshibka');
                    }
                });
                return false;
            });            

            $('.adminUser').submit(function(e){
                e.preventDefault();
                var action = $(this).find("input[name=action]").val();
                var user_id = $(this).find("input[name=user_id]").val();
                if (action == 'Администратор') {
                    action = 1;
                } else {
                    action = 2;
                }
                console.log(action+'-'+user_id);
                $.ajax({
                    type: 'POST',
                    url: '/admin/users/role/' + user_id,
                    cache: false,
                    dataType: 'json',
                    data: {user_id: user_id,
                           action: action,
                           '_token': "{{csrf_token()}}"
                    },
                    success: function (response) {
                        if (response.text == 'success') {
                            if (action == 1) {
                                document.getElementById("adminedUser"+user_id).value = "Пользователь";   
                            } else {
                                document.getElementById("adminedUser"+user_id).value = "Администратор";
                            }
                            
                            console.log("#adminedUser"+user_id);
                        } else {
                            console.log(response.text + ' Не хватает прав для изменения роли пользователя.');
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
                <div class="panel-heading"><strong>Управление пользователями</strong></div>

                <div class="panel-body text-center"></div>
                
                <div class="table-responsive"> 

                    <table class="table table-striped table-hover table-condensed">
                    <tr>
                        <th><a href="?page={{ $data['users']->currentPage() }}&order=id&dir={{ $data['dir'] ? $data['dir'] : 'asc' }}">ID</a>{!! $data['page_appends']['order'] == 'id' ? $data['dir'] == 'desc' ? '<span class="glyphicon glyphicon-arrow-down"></span>' : '<span class="glyphicon glyphicon-arrow-up"></span>' : '' !!}</th>
                        <th><a href="?page={{ $data['users']->currentPage() }}&order=login&dir={{ $data['dir'] ? $data['dir'] : 'asc' }}">Login</a>{!! $data['page_appends']['order'] == 'login' ? $data['dir'] == 'desc' ? '<span class="glyphicon glyphicon-arrow-down"></span>' : '<span class="glyphicon glyphicon-arrow-up"></span>' : '' !!}</th>
                        <th><a href="?page={{ $data['users']->currentPage() }}&order=name&dir={{ $data['dir'] ? $data['dir'] : 'asc' }}">Имя</a>{!! $data['page_appends']['order'] == 'name' ? $data['dir'] == 'desc' ? '<span class="glyphicon glyphicon-arrow-down"></span>' : '<span class="glyphicon glyphicon-arrow-up"></span>' : '' !!}</th>
                        <th><a href="?page={{ $data['users']->currentPage() }}&order=phone&dir={{ $data['dir'] ? $data['dir'] : 'asc' }}">Телефон, e-mail</a>{!! $data['page_appends']['order'] == 'phone' ? $data['dir'] == 'desc' ? '<span class="glyphicon glyphicon-arrow-down"></span>' : '<span class="glyphicon glyphicon-arrow-up"></span>' : '' !!}</th>
                        <th class="text-center"><a href="?page={{ $data['users']->currentPage() }}&order=role_id&dir={{ $data['dir'] ? $data['dir'] : 'asc' }}">Дать роль</a>{!! $data['page_appends']['order'] == 'role_id' ? $data['dir'] == 'desc' ? '<span class="glyphicon glyphicon-arrow-down"></span>' : '<span class="glyphicon glyphicon-arrow-up"></span>' : '' !!}</th>
                        <th class="text-center"><a href="?page={{ $data['users']->currentPage() }}&order=confirmed&dir={{ $data['dir'] ? $data['dir'] : 'asc' }}">Подтвержден</a>{!! $data['page_appends']['order'] == 'confirmed' ? $data['dir'] == 'desc' ? '<span class="glyphicon glyphicon-arrow-down"></span>' : '<span class="glyphicon glyphicon-arrow-up"></span>' : '' !!}</th>
                        <th class="text-center"><a href="?page={{ $data['users']->currentPage() }}&order=valid&dir={{ $data['dir'] ? $data['dir'] : 'asc' }}">Просмотр контактов</a>{!! $data['page_appends']['order'] == 'valid' ? $data['dir'] == 'desc' ? '<span class="glyphicon glyphicon-arrow-down"></span>' : '<span class="glyphicon glyphicon-arrow-up"></span>' : '' !!}</th>
                        <th class="text-right">Удалить</th>
                    </tr>

                    @foreach($data['users'] as $user)
                        <tr> 
                            <td><a href="/users/{{ $user->id }}/edit">{{ $user->id }}</a></td>
                            <td><a href="/users/{{ $user->id }}/edit">{{ $user->login }}</a></td>
                            <td><a href="/users/{{ $user->id }}/edit">{{ $user->name }}<br><small>{{ $user->dopname }}</small></a></td>
                            <td><a href="/users/{{ $user->id }}/edit">{{ $user->phone }}<br>{{ $user->email }}</a></td>
                            <td class="text-center">
                                @if ($user->role_id == 1)
                                    <div id="adminUser{{ $user->id }}">
                                        <form class="adminUser" > 
                                            <input class="btn btn-xs btn-info" type="submit" name="action" id="adminedUser{{ $user->id }}" value="Пользователь">
                                            <input type="hidden" name="_token"  id="_token" value="{{csrf_token()}}"/>
                                            <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}"/>
                                        </form>
                                    </div>
                                @else
                                    <div id="adminUser{{ $user->id }}">
                                        <form class="adminUser" > 
                                            <input class="btn btn-xs btn-primary" type="submit" name="action" id="adminedUser{{ $user->id }}" value="Администратор">
                                            <input type="hidden" name="_token"  id="_token" value="{{csrf_token()}}"/>
                                            <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}"/>
                                        </form>
                                    </div>
                                @endif                                
                            </td>
                            <td class="text-center">
                                @if (!$user->confirmed)
                                    <div id="confirmedUser{{ $user->id }}">
                                        <form class="confirmUser" > 
                                            <input class="btn btn-xs btn-warning" type="submit" value="Подтвердить">
                                            <input type="hidden" name="_token"  id="_token" value="{{csrf_token()}}"/>
                                            <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}"/>
                                        </form>
                                    </div>
                                @else
                                    <div>да</div>
                                @endif
                            </td>

                            <td class="text-center">
                                @if ($user->valid)
                                    <div id="blockUser{{ $user->id }}">
                                        <form class="blockUser" > 
                                            <input class="btn btn-xs btn-danger" type="submit" name="action" id="blockedUser{{ $user->id }}" value="Заблокировать">
                                            <input type="hidden" name="_token"  id="_token" value="{{csrf_token()}}"/>
                                            <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}"/>
                                        </form>
                                    </div>
                                @else
                                    <div id="blockUser{{ $user->id }}">
                                        <form class="blockUser" > 
                                            <input class="btn btn-xs btn-success" type="submit" name="action" id="blockedUser{{ $user->id }}" value="Разблокировать">
                                            <input type="hidden" name="_token"  id="_token" value="{{csrf_token()}}"/>
                                            <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}"/>
                                        </form>
                                    </div>
                                @endif
                            <td class="text-right">
                                <form method="POST" action="{{action('UserController@destroyUser',['id'=>$user->id])}}">
                                    <input type="hidden" name="_method" value="delete"/>
                                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                    <input type="submit" class="btn btn-xs btn-default" value="Удалить"/>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </table>
                </div>
                <div class="panel-footer">{!! $data['users']->appends($data['page_appends'])->links('vendor.pagination.default') !!}</div>
            </div>
        </div>
    </div>
</div>
@endsection
