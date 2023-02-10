<div class="card collapsed-card">
    <div class="card-header">
        <h3 class="card-title">Тренеры</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="card-body" style="display: none;">
            @csrf
            <div class="card-body">
                <dl class="row">
                    @foreach(\App\Models\Athlete::getCoaches($athlete->id)->coaches as $coach)
                        @if($coach->pivot->coach_type == \App\Models\Coach::FIRST_COACH)
                        <dt class="col-sm-4">Первый тренер</dt>
                        <dd class="col-sm-8">{{$coach->user->secondname}}</dd>
                        @endif
                        @if($coach->pivot->coach_type == \App\Models\Coach::SECOND_COACH)
                            <dt class="col-sm-4">Второй тренер</dt>
                            <dd class="col-sm-8">{{$coach->user->secondname}}</dd>
                        @endif
                        @if($coach->pivot->coach_type == \App\Models\Coach::THIRD_COACH)
                            <dt class="col-sm-4">Третий тренер</dt>
                            <dd class="col-sm-8">{{$coach->user->secondname}}</dd>
                        @endif
                        @if($coach->pivot->coach_type == \App\Models\Coach::REAL_COACH)
                            <dt class="col-sm-4">Действующий тренер</dt>
                            <dd class="col-sm-8">{{$coach->user->secondname}}</dd>
                        @endif
                    @endforeach

                </dl>
            </div>
        @switch(\App\Models\User::getRoleCode())
            @case(\App\Models\Role::ROLE_SYSTEM_ADMIN)
            @case(\App\Models\Role::ROLE_ORGANIZATION_CHAIRMAN)
            @case(\App\Models\Role::ROLE_ORGANIZATION_ADMIN)
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">
                    <i class="far fa-edit"></i>
                </button>

        @endswitch
    </div>
</div>
