<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    @if(!Str::contains(url()->current(), 'competitions') and !\Illuminate\Support\Facades\Auth::user())
    <li class="nav-item">
        <a class="nav-link" href="{{route('competitions.index')}}">Соревнования</a>
    </li>
    @endif

    @if(Str::contains(url()->current(), 'competitions'))
        @include('navbar-menu.competitions')
    @endif

    @if(Str::contains(url()->current(), 'athlete'))
        @include('navbar-menu.athletes')
    @endif
</ul>
