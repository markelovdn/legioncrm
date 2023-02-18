@php
    $user = auth()->user();
    @endphp
@if(Str::contains(url()->current(), 'events') and !Str::contains(url()->current(), 'users'))
    @if($user && $user->isOrganizationAdmin(auth()->user()) || $user && $user->isOrganizationChairman(auth()->user()))
        <li class="nav-item">
            <a class="nav-link" href="{{route('events.create')}}" role="button">Добавить мероприятие</a>
        </li>
    @endif

@endif

@if(Str::contains(url()->current(), 'users'))
    <li class="nav-item">
        <a class="nav-link" href="{{route('events.users.create', [$event->id])}}" role="button">
            Добавить спортсмена</a>
    </li>
    @if(\App\Models\Event::getOwner($event->id))
        <li class="nav-item">
{{--            <a class="nav-link" href="{{route('competitorsExport')}}" role="button">--}}
{{--                Скачать список</a>--}}
        </li>
        @endif
@endif
