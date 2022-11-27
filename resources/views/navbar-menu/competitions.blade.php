@if(Str::contains(url()->current(), 'competitions') and !Str::contains(url()->current(), 'competitors'))
    @if(\App\Models\User::hasRole(\App\Models\Role::ROLE_ORGANIZATION_ADMIN, auth()->user()->id)
        or \App\Models\User::hasRole(\App\Models\Role::ROLE_ORGANIZATION_ADMIN, auth()->user()->id))
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
