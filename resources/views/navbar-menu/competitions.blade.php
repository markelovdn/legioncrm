@if(Str::contains(url()->current(), 'competitions') and !Str::contains(url()->current(), 'competitors'))
    <li class="nav-item">
        <a class="nav-link" href="{{route('competitions.create')}}" role="button">Добавить соревнование</a>
    </li>
@endif

@if(Str::contains(url()->current(), 'competitors'))
    <li class="nav-item">
        <a class="nav-link" href="{{route('competitions.competitors.create', [$competition->id])}}" role="button">Добавить спортсмена</a>
    </li>
@endif
