@extends('layouts.app')

@section('scripts')
    <script>        
        $(document).ready(function(){
            if ($("[rel=tooltip]").length) {
                $("[rel=tooltip]").tooltip();
            };
            $.fn.extend({
                treed: function (o) {
                    var openedClass = 'glyphicon-minus-sign';
                    var closedClass = 'glyphicon-plus-sign';
                    if (typeof o != 'undefined'){
                        if (typeof o.openedClass != 'undefined'){
                            openedClass = o.openedClass;
                        }
                        if (typeof o.closedClass != 'undefined'){
                            closedClass = o.closedClass;
                        }
                    };
                    /* initialize each of the top levels */
                    var tree = $(this);
                    tree.addClass("tree");
                    tree.find('li').has("ul").each(function () {
                        var branch = $(this);
                        branch.prepend("");
                        branch.addClass('branch');
                        branch.on('click', function (e) {
                            if (this == e.target) {
                                var icon = $(this).children('i:first');
                                icon.toggleClass(openedClass + " " + closedClass);
                                $(this).children().children().toggle();
                            }
                        })
                        branch.children().children().toggle();
                    });
                    /* fire event from the dynamically added icon */
                    tree.find('.branch .indicator').each(function(){
                        $(this).on('click', function () {
                            $(this).closest('li').click();
                        });
                    });
                    /* fire event to open branch if the li contains an anchor instead of text */
                    tree.find('.branch>a#tag').each(function () {
                        $(this).on('click', function (e) {
                            $(this).closest('li').click();
                            e.preventDefault();
                        });
                    });
                    /* fire event to open branch if the li contains a button instead of text */
                    tree.find('.branch>button').each(function () {
                        $(this).on('click', function (e) {
                            $(this).closest('li').click();
                            e.preventDefault();
                        });
                    });
                }
            });
            /* Initialization of treeviews */
            $('#tree1').treed();
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
                <div class="panel-heading"><strong>Управление категориями (не доделано)</strong></div>

                <div class="panel-body text-center"></div>

                <ul id="tree1" class="tree">
                    </li>
                    @foreach($categories as $category)
                        <li>
                            @if(count($category->childs))
                                <i class="indicator glyphicon glyphicon-plus-sign"></i>
                            @else
                                <i class="indicator glyphicon glyphicon-minus-sign"></i>
                            @endif
                            {{ $category->name_cat }}
                            @if (count($category->objects) > 0)
                                <span class="label label-primary">{{ count($category->objects) }} объектов</span>
                            @endif
                            @if (count($category->requests) > 0)
                                <span class="label label-info">{{ count($category->requests) }} заявок</span>
                            @endif
                            &nbsp;
                            @if (count($category->objects) == 0 && count($category->requests) == 0)
                                <a href="/admin/categories/delete/{{ $category->id }}" rel="tooltip" title="Удалить"><i class="glyphicon glyphicon-trash"></i></a>&nbsp;
                            @endif
                            <a href="/admin/categories/edit/{{ $category->id }}" rel="tooltip" title="Редактировать"><i class="glyphicon glyphicon-pencil"></i></a>&nbsp;
                            <a href="/admin/categories/add/{{ $category->id }}" rel="tooltip" title="Добавить дочерний элемент"><i class="glyphicon glyphicon-leaf"></i></a>
                            
                            @if(count($category->childs))
                                @include('layouts.admin.manageChild',['childs' => $category->childs])
                            @endif
                        </li>
                    @endforeach
                    <li><i class="indicator glyphicon glyphicon-leaf"></i>&nbsp;<a href="{{ url('/categories/add/0') }}">Добавить корневую категорию</a>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
