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
                    @foreach(\App\Models\Athlete::getCoachesAthlete($athlete->id)->coaches as $coach)
                        @if($coach->pivot->coach_type == \App\Models\Coach::FIRST_COACH)
                        <dt class="col-sm-4">Первый тренер</dt>
                        <dd class="col-sm-8">{{$coach->user->secondname}} {{mb_substr($coach->user->firstname, 0,1)}}.{{mb_substr($coach->user->patronymic, 0,1)}}.</dd>
                        @endif
                        @if($coach->pivot->coach_type == \App\Models\Coach::SECOND_COACH)
                            <dt class="col-sm-4">Второй тренер</dt>
                            <dd class="col-sm-8">{{$coach->user->secondname}} {{mb_substr($coach->user->firstname, 0,1)}}.{{mb_substr($coach->user->patronymic, 0,1)}}.</dd>
                        @endif
                        @if($coach->pivot->coach_type == \App\Models\Coach::THIRD_COACH)
                            <dt class="col-sm-4">Третий тренер</dt>
                            <dd class="col-sm-8">{{$coach->user->secondname}} {{mb_substr($coach->user->firstname, 0,1)}}.{{mb_substr($coach->user->patronymic, 0,1)}}.</dd>
                        @endif
                        @if($coach->pivot->coach_type == \App\Models\Coach::REAL_COACH)
                            <dt class="col-sm-4">Действующий тренер</dt>
                            <dd class="col-sm-8">{{$coach->user->secondname}} {{mb_substr($coach->user->firstname, 0,1)}}.{{mb_substr($coach->user->patronymic, 0,1)}}.</dd>
                        @endif
                    @endforeach

                </dl>
            </div>
        @switch(\App\Models\User::getRoleCode())
            @case(\App\Models\Role::ROLE_SYSTEM_ADMIN)
            @case(\App\Models\Role::ROLE_ORGANIZATION_CHAIRMAN)
            @case(\App\Models\Role::ROLE_ORGANIZATION_ADMIN)
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default{{$athlete->id}}">
                    <i class="far fa-edit"></i>
                </button>

        @endswitch

        {{--modal edit coaches-data--}}
        <div class="modal fade" id="modal-default{{$athlete->id}}" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" action="{{route('athlete.update',[$athlete->id])}}">
                            <input type="text" name="athlete_id" style="display: none" value="{{$athlete->id}}">
                            @method('PUT')
                            @csrf
                            <div class="row mb-3">
                                <label for="first_coach" class="col-md-4 col-form-label text-md-end">Первый тренер<span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <select type="text" class="form-control @error('first_coach') is-invalid @enderror"  name="first_coach" id="first_coach">
                                        <option></option>
                                        @foreach(\App\Models\Coach::getAllCoaches() as $coach)
                                        <option value="{{$coach->id}}">
                                            {{$coach->user->secondname}} {{mb_substr($coach->user->firstname, 0,1)}}.{{mb_substr($coach->user->patronymic, 0,1)}}.
                                        </option>
                                        @endforeach
                                            {{-- TODO: делать запросы из вьюх это плоо--}}
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="second_coach" class="col-md-4 col-form-label text-md-end">Второй тренер<span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <select type="text" class="form-control @error('second_coach') is-invalid @enderror"  name="second_coach" id="second_coach">
                                        <option></option>
                                        @foreach(\App\Models\Coach::getAllCoaches() as $coach)
                                            <option value="{{$coach->id}}">
                                                {{$coach->user->secondname}} {{mb_substr($coach->user->firstname, 0,1)}}.{{mb_substr($coach->user->patronymic, 0,1)}}.
                                            </option>
                                        @endforeach
                                        {{--                                        TODO: делать запросы из втюх это плоо--}}
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="third_coach" class="col-md-4 col-form-label text-md-end">Третий тренер<span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <select type="text" class="form-control @error('third_coach') is-invalid @enderror"  name="third_coach" id="third_coach">
                                        <option></option>
                                        @foreach(\App\Models\Coach::getAllCoaches() as $coach)
                                            <option value="{{$coach->id}}">
                                                {{$coach->user->secondname}} {{mb_substr($coach->user->firstname, 0,1)}}.{{mb_substr($coach->user->patronymic, 0,1)}}.
                                            </option>
                                        @endforeach
                                        {{--                                        TODO: делать запросы из втюх это плоо--}}
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="real_coach" class="col-md-4 col-form-label text-md-end">Действующий тренер<span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <select type="text" class="form-control @error('real_coach') is-invalid @enderror"  name="real_coach" id="real_coach">
                                        <option></option>
                                        @foreach(\App\Models\Coach::getAllCoaches() as $coach)
                                            <option value="{{$coach->id}}">
                                                {{$coach->user->secondname}} {{mb_substr($coach->user->firstname, 0,1)}}.{{mb_substr($coach->user->patronymic, 0,1)}}.
                                            </option>
                                        @endforeach
                                        {{-- TODO: делать запросы из втюх это плоо--}}
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="reset" class="btn btn-default" data-dismiss="modal">Отмена
                                </button>
                                <button type="submit" class="btn btn-primary">Сохранить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
