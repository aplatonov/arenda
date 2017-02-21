<ul class="dropdown-menu">
    @foreach($childs as $child)
        @if(count($child->childs))
            <li class="dropdown-submenu">
                <a class="dropdown-toggle" href="{{ url('/objects/category/' . $child->id ) }}">{{ $child->name_cat }} <span class="badge">{{ count($child->objects) }}</span></a>
                @include('layouts.manageObjChildMenu',['childs' => $child->childs])
            </li>
        @else
            <li><a href="{{ url('/objects/category/' . $child->id ) }}">{{ $child->name_cat }} <span class="badge">{{ count($child->objects) }}</span></a></li>
        @endif
    @endforeach
</ul>