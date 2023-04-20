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

@if(Str::contains(url()->current(), 'competitors') && $competition->open_registration != \App\Models\Competition::REGISTRATION_CLOSE)
    <li class="nav-item">
        <a class="nav-link" href="{{route('competitions.competitors.create', [$competition->id])}}" role="button">
            Добавить спортсмена</a>
    </li>
    @if(Str::contains(url()->current(), 'competitors/create') && $competition->open_registration != \App\Models\Competition::REGISTRATION_CLOSE)
    <li>
        <a class="nav-link" href="#" data-target="#modal-athlete-user-add"
           data-toggle="modal">Новый</a>
    </li>
    @endif
@elseif(Str::contains(url()->current(), 'competitors') && \App\Models\Competition::getOwner($competition->id))
        <get-route-competitors-export :competition_id="{{$competition->id}}"
                                      :url="{{json_encode(asset('competitorsExport/competition_id='.$competition->id))}}"></get-route-competitors-export>
@endif

