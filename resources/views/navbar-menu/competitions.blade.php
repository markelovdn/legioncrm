@php
    $user = auth()->user();
    @endphp
@if(Str::contains(url()->current(), 'competitions') and !Str::contains(url()->current(), 'competitors'))
    @if($user && $user->isOrganizationAdmin(auth()->user()) || $user && $user->isOrganizationChairman(auth()->user()))
        <li class="nav-item">
            <a class="nav-link" href="{{route('competitions.create')}}" role="button">Добавить соревнование</a>
        </li>
    @endif

@endif

@if(Str::contains(url()->current(), 'competitors'))
    <li class="nav-item">
        <a class="nav-link" href="{{route('competitions.competitors.create', [$competition->id])}}" role="button">
            Добавить спортсмена</a>
    </li>
@endif
