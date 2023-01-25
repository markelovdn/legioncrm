<div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        <img src="{{asset("/storage/images/no_photo.jpg")}}" class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
        <span class="d-block">
            <a href="">
                {{\Illuminate\Support\Facades\Auth::user()->firstname}}
                {{\Illuminate\Support\Facades\Auth::user()->secondname}}
            </a>
        </span>
        <a href="{{asset(\App\Models\User::getRoleCode())}}" class="d-block">{{\App\Models\User::getRole()}}
            (кабинет)</a>
        @if(\Illuminate\Support\Facades\Auth::user())
            <a href="/logout" type="submit"><i class="fas fa-sign-out-alt"></i></a>
        @endif
    </div>
</div>

@include('left-menu.competitions')

@switch(\App\Models\User::getRoleCode())

    @case(\App\Models\Role::ROLE_SYSTEM_ADMIN)
    @include('left-menu.roles')
    @include('left-menu.organizations')

    @case(\App\Models\Role::ROLE_SYSTEM_ADMIN)
    @case(\App\Models\Role::ROLE_ORGANIZATION_CHAIRMAN)
    @case(\App\Models\Role::ROLE_ORGANIZATION_ADMIN)
    @include('left-menu.coaches')
    @include('left-menu.referee')
    @include('left-menu.finance')

    @case(\App\Models\Role::ROLE_SYSTEM_ADMIN)
    @case(\App\Models\Role::ROLE_ORGANIZATION_CHAIRMAN)
    @case(\App\Models\Role::ROLE_ORGANIZATION_ADMIN)
    @case(\App\Models\Role::ROLE_COACH)
    @include('left-menu.athletes')
    @include('left-menu.parented')
    @case(\App\Models\Role::ROLE_REFEREE)
    @include('left-menu.poomsae-tablo')
    @include('left-menu.poomsae-competition')

@endswitch
