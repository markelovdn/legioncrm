<div class="card collapsed-card">
    <div class="card-header">
        <h3 class="card-title">Паспортные данные</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="card-body" style="display: none;">
        <div class="card-body">
            <form method="POST" action="/passport" enctype="multipart/form-data">
                @csrf
                <input type="text" style="display: none" name="role_code" value="athlete">
                <input type="text" style="display: none" name="athlete_id" value="{{$athlete->user->athlete->id}}">
                <input type="text" style="display: none" name="user_id" value="{{$athlete->user->id}}">

            <div class="row mb-3">
                    <label for="passport_series" class="col-md-4 col-form-label text-md-end">Серия<span class="text-danger">*</span></label>

                    <div class="col-md-6">
                        <input id="passport_series"
                               type="text"
                               class="form-control @error('passport_series') is-invalid @enderror"
                               name="passport_series"
                               value="{{ old('passport_series') }}">
                    </div>
                </div>
            <div class="row mb-3">
                <label for="passport_number" class="col-md-4 col-form-label text-md-end">Номер<span class="text-danger">*</span></label>
                <div class="col-md-6">
                    <input id="passport_number"
                           type="text"
                           class="form-control @error('passport_number') is-invalid @enderror"
                           name="passport_number"
                           value="{{ old('passport_number') }}">
                </div>
            </div>
            <div class="row mb-3">
                <label for="passport_date_issue" class="col-md-4 col-form-label text-md-end">Дата выдачи<span class="text-danger">*</span></label>

                <div class="col-md-6">
                    <input id="passport_date_issue"
                           type="date"
                           class="form-control @error('passport_date_issue') is-invalid @enderror"
                           name="passport_date_issue"
                           value="{{ old('passport_date_issue') }}">
                </div>
            </div>
            <div class="row mb-3">
                <label for="passport_issued_by" class="col-md-4 col-form-label text-md-end">Кем выдан<span class="text-danger">*</span></label>
                <div class="col-md-6">
                    <input id="passport_issued_by"
                           type="text"
                           class="form-control @error('passport_issued_by') is-invalid @enderror"
                           name="passport_issued_by"
                           value="{{ old('passport_issued_by') }}">
                </div>
            </div>
            <div class="row mb-3">
                <label for="passport_subcode" class="col-md-4 col-form-label text-md-end">Код подразделения<span class="text-danger">*</span></label>

                <div class="col-md-6">
                    <input id="passport_subcode"
                           type="text"
                           class="form-control @error('passport_subcode') is-invalid @enderror"
                           name="passport_subcode"
                           value="{{ old('passport_subcode') }}">
                </div>
            </div>
            <div class="row mb-3">
                    <label for="passport_scan" class="col-md-4 col-form-label text-md-end">Скан<span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file"
                                       class="custom-file-input @error('passport_scan') is-invalid @enderror"
                                       name="passport_scan"
                                       id="passport_scan"
                                       value="{{ old('passport_scan') }}">
                                <label class="custom-file-label" for="passport_scan">Выбрать файл</label>
                            </div>
                        </div>
                        <span class="description font-italic">Принимаются файлы только изображений (jpg,jpeg,png,bmp) размер файла должен быть менее 1 мб</span>
                    </div>
                </div>
                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4 mb-4">
                        <button id="submit"
                                type="submit"
                                onclick="blocked()"
                                class="btn btn-primary">Отправить</button>
                        <div class="spinner-border" id="loader" style="display: none" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
