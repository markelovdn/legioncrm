<div class="card collapsed-card">
    <div class="card-header">
        <h3 class="card-title">Место учебы</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>

    <div class="card-body" style="display: none;">
        <dl class="row">
            <dt class="col-sm-4">Организация</dt>
            <dd class="col-sm-8">{{$athlete->studyplace->org_title}}</dd>
            <dt class="col-sm-4">Класс</dt>
            <dd class="col-sm-8">{{$athlete->studyplace->classnum}} {{$athlete->studyplace->letter}}</dd>
        </dl>

        @switch(\App\Models\User::getRoleCode())
            @case(\App\Models\Role::ROLE_SYSTEM_ADMIN)
            @case(\App\Models\Role::ROLE_ORGANIZATION_CHAIRMAN)
            @case(\App\Models\Role::ROLE_ORGANIZATION_ADMIN)
            <div class="row">
                <div class="col-auto mr-auto">
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-studyplace{{$athlete->user->id}}">
                        <i class="far fa-edit"></i>
                    </button>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-studyplace{{$athlete->user->id}}trash">
                        <i class="far fa-trash-alt"></i>
                    </button>
                </div>
            </div>
            {{--modal edit parent-birthsertificate-data--}}
            <div class="modal fade" id="modal-studyplace{{$athlete->user->id}}" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form method="POST" action="{{route('studyplace.update',[$athlete->studyplace->id])}}">
                                @method('PUT')
                                @csrf
                                <input type="text" name="user_id" style="display: none" value="{{$athlete->user->id}}">
                                <input type="text" name="role_code" style="display: none"
                                       value="{{\App\Models\Role::ROLE_ATHLETE}}">
                                <div class="row mb-3">
                                    <label for="org_title" class="col-md-4 col-form-label text-md-end">
                                        Организация
                                        <span class="text-danger">*</span></label>
                                    <div class="col-md-6">
                                        <input id="org_title" type="text"
                                               class="form-control @error('org_title') is-invalid @enderror"
                                               name="org_title" value="{{$athlete->studyplace->org_title}}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="classnum" class="col-md-4 col-form-label text-md-end">
                                        Класс
                                        <span class="text-danger">*</span></label>
                                    <div class="col-md-6">
                                        <input id="classnum" type="text"
                                               class="form-control @error('classnum') is-invalid @enderror"
                                               name="classnum" value="{{$athlete->studyplace->classnum}}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="class_letter" class="col-md-4 col-form-label text-md-end">
                                        Бува
                                        <span class="text-danger">*</span></label>
                                    <div class="col-md-6">
                                        <input id="letter" type="text"
                                               class="form-control @error('letter') is-invalid @enderror"
                                               name="letter" value="{{$athlete->studyplace->letter}}">
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="reset" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                    <button type="submit" class="btn btn-primary">Сохранить</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{--modal edit parent-birthsertificate-trash--}}
            <div class="modal fade" id="modal-studyplace{{$athlete->user->id}}trash" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Для удаления данных введите код</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{route('studyplace.destroy',[$athlete->studyplace->id])}}">
                                @method('DELETE')
                                @csrf
                                <input type="text" name="user_id" style="display: none" value="{{$athlete->user->id}}">
                                <div class="row mb-3">
                                    <label for="code" class="col-md-4 col-form-label text-md-end">Код<span class="text-danger">*</span></label>
                                    <div class="col-md-6">
                                        <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{old('code')}}">
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="reset" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                    <button type="submit" class="btn btn-primary">Отправить</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endswitch
    </div>
</div>
