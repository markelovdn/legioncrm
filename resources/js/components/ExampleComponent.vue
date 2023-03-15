<template>
    <div class="row">
        Привет
<!--        @switch(\App\Models\User::getRoleCode())-->
<!--        @case(\App\Models\Role::ROLE_COACH)-->
<!--        @case(\App\Models\Role::ROLE_SYSTEM_ADMIN)-->
        <div class="col-auto mr-auto">
<!--            @if($athlete->status == \App\Models\Athlete::ACTIVE)-->
            <span class="badge badge-danger" data-toggle="modal" style="cursor: pointer" data-target="#modal-inactive-athlete"><i class="far fa-clock"></i>деактивировать</span>
<!--            @else-->
            <span class="badge badge-success" data-toggle="modal" style="cursor: pointer" data-target="#modal-inactive-athlete{"><i class="far fa-clock"></i>ативировать</span>
<!--            @endif-->
<!--            {{// &#45;&#45;modal edit active-athlete&#45;&#45;}}-->
            <div class="modal fade" id="modal-inactive-athlete_$athlete_user_id}}" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-body">
<!--                            @if($athlete->status == \App\Models\Athlete::ACTIVE)-->
                            <form method="POST" action="">
<!--                                @method('PUT')-->
<!--                                @csrf-->
                                <button type="submit" class="btn btn-danger">Подтвердить<i class="fas fa-check"></i></button>
<!--                                <input type="text" style="display:none" name="athlete_id" value="{{$athlete->id}}">-->
<!--                                <input type="text" style="display:none" name="user_id" value="{{$athlete->user->id}}">-->
<!--                                <input type="text" style="display:none" name="status" value="{{\App\Models\Athlete::INACTIVE}}">-->
                            </form>
<!--                            @else-->
                            <form method="POST" action="">
<!--                                @method('PUT')-->
<!--                                @csrf-->
                                <button type="submit" class="btn btn-success">Подтвердить<i class="fas fa-check"></i></button>
<!--                                <input type="text" style="display:none" name="athlete_id" value="{{$athlete->id}}">-->
<!--                                <input type="text" style="display:none" name="user_id" value="{{$athlete->user->id}}">-->
<!--                                <input type="text" style="display:none" name="status" value="{{\App\Models\Athlete::ACTIVE}}">-->
                            </form>
<!--                            @endif-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
<!--        @endswitch-->
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
