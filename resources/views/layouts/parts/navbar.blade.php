<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>

    @if(Str::contains(url()->current(), 'competitions'))
        @include('navbar-menu.competitions')
    @endif
</ul>