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
        @if(\Illuminate\Support\Facades\Auth::user()->isOrganizationChairman(auth()->user()) || \Illuminate\Support\Facades\Auth::user()->isOrganizationAdmin(auth()->user()))
{{--            <a href="/organization/{{\App\Models\Organization::getOrganizationId()}}" class="d-block">{{\App\Models\User::getRole()}}--}}
{{--                (кабинет)</a>--}}

        @else
        <a href="{{asset(\Illuminate\Support\Facades\Auth::user()->getRoleCode())}}" class="d-block">{{\Illuminate\Support\Facades\Auth::user()->getRole()}}
            (кабинет)</a>
        @endif
        @if(\Illuminate\Support\Facades\Auth::user())
            <a href="/logout" type="submit"><i class="fas fa-sign-out-alt"></i></a>
        @endif
    </div>
</div>

@include('left-menu.competitions')

@switch(\Illuminate\Support\Facades\Auth::user()->getRoleCode())

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

    @case(\App\Models\Role::ROLE_PARENTED)
    @case(\App\Models\Role::ROLE_ATHLETE)
    @include('left-menu.attestation')
    @include('left-menu.events')
    @include('left-menu.about-organizations')

@endswitch
