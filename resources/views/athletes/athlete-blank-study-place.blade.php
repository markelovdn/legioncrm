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
        <form method="POST" action="/studyplace">
            @csrf
            <div class="row mb-3">
                <input type="text" style="display: none" name="user_id" value="{{$athlete->user_id}}">
                <label for="org_title" class="col-md-4 col-form-label text-md-end">Сокращенное название учебного заведения<span class="text-danger">*</span></label>

                <div class="col-md-6">
                    <input id="org_title" type="text" class="form-control @error('org_title') is-invalid @enderror" name="org_title" value="">

                    @error('org_title')
                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="classnum" class="col-md-4 col-form-label text-md-end">Класс/группа<span class="text-danger">*</span></label>

                <div class="col-md-6">
                    <input id="classnum" type="text" class="form-control @error('classnum') is-invalid @enderror" name="classnum" value="">

                    @error('classnum')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="letter" class="col-md-4 col-form-label text-md-end">Буква(при наличии)</label>

                <div class="col-md-6">
                    <input id="letter" type="text" class="form-control @error('letter') is-invalid @enderror" name="letter" value="">

                    @error('letter')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
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
