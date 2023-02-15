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

    @if(Str::contains(url()->current(), 'attestation'))
        @include('navbar-menu.attestations')
    @endif

    @if(Str::contains(url()->current(), 'athlete'))
        @include('navbar-menu.athletes')
    @endif
</ul>
<ul class="navbar-nav ml-auto">
    @if(!\Illuminate\Support\Facades\Auth::user())
        <li class="nav-item">
            <a href="{{route('login')}}" type="submit"><i class="fas fa-sign-in-alt"></i></a>
        </li>
    @endif

    @if(\Illuminate\Support\Facades\Auth::user())
        @include('navbar-menu.right.search')
        @include('navbar-menu.right.filter')
    @endif
</ul>
