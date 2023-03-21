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
    @if(\App\Models\Competition::getOwner($competition->id))
        <get-route-competitors-export :competition_id="{{$competition->id}}"></get-route-competitors-export>

        <li class="nav-item">
            <a class="nav-link" href="{{route('competitorsExport', [$competition->id, 2, 4])}}" role="button">
                Скачать список</a>
        </li>
        @endif
@endif
