<a href="" class="brand-link">
    <img src="{{asset("/storage/images/logo.png")}}" alt="LegionCRM Logo" class="brand-image">
    <span class="brand-text font-weight-light">LEGIONCRM</span>
</a>
<div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        <img src="{{asset("/storage/images/no_photo.jpg")}}" class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
        <a href="" class="d-block">{{\Illuminate\Support\Facades\Auth::user()->firstname}} {{\Illuminate\Support\Facades\Auth::user()->secondname}}</a>
    </div>
</div>
@switch(\App\Models\User::getRole())
    @case(\App\Models\Role::ROLE_SYSTEM_ADMIN)
        @include('menu.system_admin')
    @break

    @case(\App\Models\Role::ROLE_PARENTED)
        @include('menu.parented')
    @break

    @case(\App\Models\Role::ROLE_COACH)
        @include('menu.coach')
    @break

    @case(\App\Models\Role::ROLE_ORGANIZATION_CHAIRMAN)
        @include('menu.organization')
    @break

    @default
@endswitch
