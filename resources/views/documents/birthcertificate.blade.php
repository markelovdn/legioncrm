<div class="card collapsed-card">
    <div class="card-header">
        <h3 class="card-title">Свидетельство о рождении</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="card-body" style="display: none;">
        <dl class="row">
            <dt class="col-sm-4">Серия номер:</dt>
            <dd class="col-sm-8">{{$athlete->birthcertificate->series}} {{$athlete->birthcertificate->number}}</dd>
            <dt class="col-sm-4">Выдан:</dt>
            <dd class="col-sm-8">{{$athlete->birthcertificate->dateissue}}, {{$athlete->birthcertificate->issuedby}}</dd>
            <dt class="col-sm-4">Скачать:</dt>
            <dd class="col-sm-8">
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-berthsertificate{{$athlete->user->id}}scan">
                    <i class="far fa-eye"></i>
                </button></dd>
        </dl>
        {{--modal edit parent-birthsertificate-data-scan--}}
        <div class="modal fade" id="modal-berthsertificate{{$athlete->user->id}}scan" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body media">
                        <img src="{{$athlete->birthcertificate->scanlink}}" class="img-fluid" style="width: 100%;" alt="">
                    </div>
                    <div class="modal-footer justify-content-between">
                        <a href="{{$athlete->birthcertificate->scanlink}}" download=""><button class="btn button-primary">Скачать</button></a>
                    </div>
                </div>
            </div>
        </div>

    @switch(\Illuminate\Support\Facades\Auth::user()->getRoleCode())
            @case(\App\Models\Role::ROLE_SYSTEM_ADMIN)
            @case(\App\Models\Role::ROLE_ORGANIZATION_CHAIRMAN)
            @case(\App\Models\Role::ROLE_ORGANIZATION_ADMIN)
        <div class="row">
             <div class="col-auto mr-auto">
                 <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-berthsertificate{{$athlete->user->id}}">
                     <i class="far fa-edit"></i>
                 </button>
             </div>
            <div class="col-auto">
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-berthsertificate{{$athlete->user->id}}trash">
                    <i class="far fa-trash-alt"></i>
                </button>
            </div>
        </div>
            {{--modal edit parent-birthsertificate-data--}}
            <div class="modal fade" id="modal-berthsertificate{{$athlete->user->id}}" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form method="POST" enctype="multipart/form-data" action="{{route('birthcertificate.update',[$athlete->birthcertificate->id])}}">
                                @method('PUT')
                                @csrf
                                <input type="text" name="user_id" style="display: none" value="{{$athlete->user->id}}">
                                <input type="text" name="role_code" style="display: none"
                                       value="{{\App\Models\Role::ROLE_ATHLETE}}">
                                <div class="row mb-3">
                                    <label for="birthcertificate_series" class="col-md-4 col-form-label text-md-end">Серия<span class="text-danger">*</span></label>
                                    <div class="col-md-6">
                                        <input id="birthcertificate_series" type="text" class="form-control @error('birthcertificate_series') is-invalid @enderror" name="birthcertificate_series" value="{{$athlete->birthcertificate->series}}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="birthcertificate_number" class="col-md-4 col-form-label text-md-end">Номер<span class="text-danger">*</span></label>

                                    <div class="col-md-6">
                                        <input id="birthcertificate_number" type="text" class="form-control @error('birthcertificate_number') is-invalid @enderror" name="birthcertificate_number" value="{{$athlete->birthcertificate->number}}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="birthcertificate_date_issue" class="col-md-4 col-form-label text-md-end">Дата выдачи<span class="text-danger">*</span></label>

                                    <div class="col-md-6">
                                        <input id="birthcertificate_date_issue" type="date" class="form-control @error('birthcertificate_date_issue') is-invalid @enderror" name="birthcertificate_date_issue" value="{{$athlete->birthcertificate->dateissue}}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="birthcertificate_issued_by" class="col-md-4 col-form-label text-md-end">Кем выдан<span class="text-danger">*</span></label>

                                    <div class="col-md-6">
                                        <input id="birthcertificate_issued_by" type="text" class="form-control @error('birthcertificate_issued_by') is-invalid @enderror" name="birthcertificate_issued_by" value="{{$athlete->birthcertificate->issuedby}}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="birthcertificate_scan" class="col-md-4 col-form-label text-md-end">Скан<span class="text-danger">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file"
                                                       class="custom-file-input @error('birthcertificate_scan') is-invalid @enderror"
                                                       name="birthcertificate_scan" id="birthcertificate_scan">
                                                <label class="custom-file-label" for="birthcertificate_scan">Выбрать файл</label>
                                            </div>
                                        </div>
                                        <span class="description font-italic">Принимаются файлы только изображений (jpg,jpeg,png,bmp) размер файла должен быть менее 1 мб</span>
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
            <div class="modal fade" id="modal-berthsertificate{{$athlete->user->id}}trash" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Для удаления данных введите код</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{route('birthcertificate.destroy',[$athlete->birthcertificate->id])}}">
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


