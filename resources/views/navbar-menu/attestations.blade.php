@php
    $user = auth()->user();
    @endphp
@if(Str::contains(url()->current(), 'attestation') and !Str::contains(url()->current(), 'athlete'))
    @if($user && $user->isOrganizationAdmin(auth()->user()) || $user && $user->isOrganizationChairman(auth()->user()))
        <li class="nav-item">
            <a class="nav-link" href="{{route('attestations.create')}}" role="button">Добавить аттестацию</a>
        </li>
    @endif

@endif

@if(Str::contains(url()->current(), 'athletes'))
    <li class="nav-item">
        <a class="nav-link" href="{{route('attestation.athletes.create', [$attestation->id])}}" role="button">
            Добавить спортсмена</a>
    </li>
    @if(\App\Models\Attestation::getOwner($attestation->id))
        <li class="nav-item">
            <a class="nav-link" href="{{route('attestationAthletesExport')}}" role="button">
                Скачать список</a>
        </li>
    @endif
{{--    @if(\App\Models\Competition::getOwner($competition->id))--}}
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" href="{{route('competitorsExport')}}" role="button">--}}
{{--                Скачать список</a>--}}
{{--        </li>--}}
{{--        @endif--}}
@endif
