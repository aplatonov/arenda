<ul class="dropdown-menu">
    @foreach($childs as $child)
        @if(count($child->childs))
            <li class="dropdown-submenu">
                <a class="dropdown-toggle" href="{{ url('/requests/category/' . $child->id ) }}">{{ $child->name_cat }} <span class="badge">{{ count($child->requests) }}</span></a>
                @include('layouts.manageReqChildMenu',['childs' => $child->childs])
            </li>
        @else
            <li><a href="{{ url('/requests/category/' . $child->id ) }}">{{ $child->name_cat }} <span class="badge">{{ count($child->requests) }}</span></a></li>
        @endif
    @endforeach
</ul>