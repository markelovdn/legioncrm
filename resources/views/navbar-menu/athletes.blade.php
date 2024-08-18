@if(Str::contains(url()->current(), 'athlete'))
    <li class="nav-item">
{{--        <a class="nav-link" href="{{route('athlete.create')}}" role="button">Добавить спортсмена</a>--}}
    </li>
@endif

{{--@if(Str::contains(url()->current(), 'athlete') && $user->isOrganizationAdmin(auth()->user()) || $user->isOrganizationChairman(auth()->user()))--}}
{{--    <li>--}}
{{--        <a class="nav-link" href="#" data-target="#modal-athlete-user-add"--}}
{{--           data-toggle="modal">Новый</a>--}}
{{--    </li>--}}
{{--@endif--}}
