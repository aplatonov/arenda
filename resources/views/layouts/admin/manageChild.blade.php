<ul>
	@foreach($childs as $child)
		<li>
			@if(count($child->childs))
		    	<i class="indicator glyphicon glyphicon-plus-sign"></i>
		    @endif
		    {{ $child->name_cat }}
            @if (count($child->objects) > 0)
                <span class="label label-primary">{{ count($child->objects) }} объектов</span>
            @endif
            @if (count($child->requests) > 0)
                <span class="label label-info">{{ count($child->requests) }} заявок</span>
            @endif
            &nbsp;
            @if (count($child->objects) == 0 && count($child->requests) == 0)
                <a href="/admin/categories/delete/{{ $child->id }}" rel="tooltip" title="Удалить"><i class="glyphicon glyphicon-trash"></i></a>&nbsp;
            @endif
            <a href="/admin/categories/edit/{{ $child->id }}" rel="tooltip" title="Редактировать"><i class="glyphicon glyphicon-pencil"></i></a>&nbsp;
            <a href="/admin/categories/add/{{ $child->id }}" rel="tooltip" title="Добавить дочерний элемент"><i class="glyphicon glyphicon-leaf"></i></a>
			@if(count($child->childs))
	            @include('layouts.admin.manageChild',['childs' => $child->childs])
	        @endif
		</li>
	@endforeach
</ul>