<div class="card collapsed-card">
    <div class="card-header">
        <h3 class="card-title">Общие данные</h3>
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
                    <dt class="col-sm-4">ФИО</dt>
                    <dd class="col-sm-8">{{$athlete->user->secondname}} {{$athlete->user->firstname}} {{$athlete->user->patronymic}}</dd>
                    <dt class="col-sm-4">Дата рождения</dt>
                    <dd class="col-sm-8">{{$athlete->user->date_of_birth}}</dd>
                </dl>
            </div>
        @switch(\App\Models\User::getRoleCode())
            @case(\App\Models\Role::ROLE_SYSTEM_ADMIN)
            @case(\App\Models\Role::ROLE_ORGANIZATION_CHAIRMAN)
            @case(\App\Models\Role::ROLE_ORGANIZATION_ADMIN)
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default{{$athlete->user->id}}">
                    <i class="far fa-edit"></i>
                </button>
            {{--modal edit parent-main-data--}}
            <div class="modal fade" id="modal-default{{$athlete->user->id}}" style="display: none;" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form method="POST" action="{{route('user.update',[$athlete->user->id])}}">
                                <input type="text" name="id" style="display: none" value="{{$athlete->user->id}}">
                                <input type="text" name="role_code" style="display: none"
                                       value="{{\App\Models\Role::ROLE_ATHLETE}}">
                                @method('PUT')
                                @csrf

                                <div class="row mb-3">
                                    <label for="secondname" class="col-md-4 col-form-label text-md-end">Фамилия<span
                                            class="text-danger">*</span></label>

                                    <div class="col-md-6">
                                        <input id="secondname" type="text"
                                               class="form-control @error('secondname') is-invalid @enderror"
                                               name="secondname"
                                               value="{{ $athlete->user->secondname }}">

                                        @error('secondname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="firstname" class="col-md-4 col-form-label text-md-end">Имя<span
                                            class="text-danger">*</span></label>

                                    <div class="col-md-6">
                                        <input id="firstname" type="text"
                                               class="form-control @error('firstname') is-invalid @enderror"
                                               name="firstname"
                                               value="{{ $athlete->user->firstname }}">

                                        @error('firstname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="patronymic"
                                           class="col-md-4 col-form-label text-md-end">Отчество<span
                                            class="text-danger">*</span></label>

                                    <div class="col-md-6">
                                        <input id="patronymic" type="text"
                                               class="form-control @error('patronymic') is-invalid @enderror"
                                               name="patronymic"
                                               value="{{ $athlete->user->patronymic}}">

                                        @error('patronymic')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="date_of_birth" class="col-md-4 col-form-label text-md-end">
                                        Дата рождения
                                        <span class="text-danger">*</span></label>

                                    <div class="col-md-6">
                                        <input id="date_of_birth" type="date"
                                               class="form-control @error('date_of_birth') is-invalid @enderror"
                                               name="date_of_birth" value="{{ $athlete->user->date_of_birth}}">

                                        @error('date_of_birth')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
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
        @endswitch
    </div>
</div>
