@php
$action = '';

if (Str::contains(url()->current(), 'role-user/create')){
    $action = route('role-user.index');
}

if (Str::contains(url()->current(), 'athlete')){
    $action = route('athlete.index');
}

@endphp
<li class="nav-item">
    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
        <i class="fas fa-search"></i>
    </a>
    <search-header-input></search-header-input>
{{--    <div class="navbar-search-block">--}}
{{--        <form class="form-inline" method="GET" action="{{$action}}">--}}
{{--            <input class="form-control" style="display: none"  name="competition_id" type="text" value="">--}}
{{--            <div class="input-group input-group-sm">--}}
{{--                <input class="form-control form-control-navbar" name="search_field" type="search" placeholder="Найти по фамилии" aria-label="Search">--}}
{{--                <div class="input-group-append">--}}
{{--                    <button class="btn btn-navbar" type="submit">--}}
{{--                        <i class="fas fa-search"></i>--}}
{{--                    </button>--}}
{{--                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">--}}
{{--                        <i class="fas fa-times"></i>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </div>--}}
</li>
