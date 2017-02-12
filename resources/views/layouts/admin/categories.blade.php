@extends('layouts.app')

@section('scripts')
    <script>
        $(document).ready(function(){
            $.fn.extend({
                treed: function (o) {
                    var openedClass = 'icon-minus-sign';
                    var closedClass = 'icon-plus-sign';
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
                    tree.find('.branch>a').each(function () {
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
                <div class="panel-heading"><strong>Управление категориями</strong></div>

                <div class="panel-body text-center"></div>

                <div class="panel-footer"></div>
                
            </div>
        </div>
    </div>
</div>
@endsection
