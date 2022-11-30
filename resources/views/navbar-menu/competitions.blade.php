@if(Str::contains(url()->current(), 'competitions') and !Str::contains(url()->current(), 'competitors'))
    @if(\App\Models\User::isOrganizationAdmin() or \App\Models\User::isOrganizationChairman())
        <li class="nav-item">
            <a class="nav-link" href="{{route('competitions.create')}}" role="button">Добавить соревнование</a>
        </li>
    @endif

@endif

@if(Str::contains(url()->current(), 'competitors'))
    <li class="nav-item">
        <a class="nav-link" href="{{route('competitions.competitors.create', [$competition->id])}}" role="button">Добавить
            спортсмена</a>
    </li>
@endif
