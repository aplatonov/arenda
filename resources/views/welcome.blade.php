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
            <div class="panel panel-default panel-primary">
                <div class="panel-heading">Страница приветствия</div>

                <div class="panel-body">
                    <p>Для входа в систему необходимо зарегистрироваться.<br><br>
                    Реализовано:<br>
                    <span class="badge">1</span> Регистрация пользователей, редактирование профиля<br>
                    <span class="badge">2</span> Размещение пользователем объекта<br>
                    <span class="badge">3</span> Управление администратором списком пользователей<br>
                    <span class="badge">4</span> Просмотр/редактирование объектов<br>
                    <span class="badge">5</span> Вывод списка объектов с возможностью сортировки<br>
                    <hr>
                    <span class="badge">6</span> Размещение пользователем заявки<br>
                    <span class="badge">7</span> Просмотр/редактирование заявок<br>
                    <span class="badge">8</span> Вывод списка заявок с возможностью сортировки<br>
                    <span class="badge">9</span> В карточке пользователя добавлено поле "Оплата до"<br>
                    <span class="badge">10</span> Главная страница зарегистрированного пользователя разделена на 2 части: объекты и заявки с возможностью установки фильтра<br>
                    <span class="badge">11</span> Невозможно снять права администратора с самого себя и администратора <span class="label label-primary">admin</span><br>
                    <hr>
                    <span class="badge">12</span> Древовидная структура категорий (добавление/редактирование/удаление)<br>
                    <span class="badge">13</span> Мои объекты/Мои заявки<br>
                    <span class="badge">14</span> Структура категорий интегрирована в меню<br>
                    <span class="badge">15</span> Сортировка пользователей<br>
                    <br>
                    Логин/пароль администратора: <span class="label label-primary">admin/admin</span><br>
                    Логин/пароль пользователя: <span class="label label-info">user/user</span><br>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
