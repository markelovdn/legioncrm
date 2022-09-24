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
        <form method="POST" action="/birthcertificate" enctype="multipart/form-data">
            @csrf
            <div class="row mb-3">
                <input type="text" style="display: none" name="user_id" value="{{$athlete->user_id}}">
                <label for="birthcertificate_series" class="col-md-4 col-form-label text-md-end">Серия<span class="text-danger">*</span></label>

                <div class="col-md-6">
                    <input id="birthcertificate_series" type="text" class="form-control @error('birthcertificate_series') is-invalid @enderror" name="birthcertificate_series" value="{{ old('birthcertificate_series') }}">

                    @error('birthcertificate_series')
                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="birthcertificate_number" class="col-md-4 col-form-label text-md-end">Номер<span class="text-danger">*</span></label>

                <div class="col-md-6">
                    <input id="birthcertificate_number" type="text" class="form-control @error('birthcertificate_number') is-invalid @enderror" name="birthcertificate_number" value="{{ old('birthcertificate_number') }}">

                    @error('birthcertificate_number')
                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="birthcertificate_date_issue" class="col-md-4 col-form-label text-md-end">Дата выдачи<span class="text-danger">*</span></label>

                <div class="col-md-6">
                    <input id="birthcertificate_date_issue" type="date" class="form-control @error('birthcertificate_date_issue') is-invalid @enderror" name="birthcertificate_date_issue" value="{{ old('birthcertificate_date_issue') }}">

                    @error('birthcertificate_date_issue')
                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="birthcertificate_issued_by" class="col-md-4 col-form-label text-md-end">Кем выдан<span class="text-danger">*</span></label>

                <div class="col-md-6">
                    <input id="birthcertificate_issued_by" type="text" class="form-control @error('birthcertificate_issued_by') is-invalid @enderror" name="birthcertificate_issued_by" value="{{ old('birthcertificate_issued_by') }}">

                    @error('birthcertificate_issued_by')
                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="birthcertificate_scan" class="col-md-4 col-form-label text-md-end">Скан<span class="text-danger">*</span></label>
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="birthcertificate_scan" id="birthcertificate_scan">
                            <label class="custom-file-label" for="birthcertificate_scan">Выбрать файл</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-0">
                <div class="col-md-6 offset-md-4 mb-4">
                    <button id="submit" type="submit" onclick="blocked()" class="btn btn-primary">
                        Отправить</button>
                    <div class="spinner-border" id="loader" style="display: none" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
