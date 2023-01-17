@extends('layouts.main')

@section('content')
<div class="card collapsed-card">
    <div class="card-header">
        <h3 class="card-title">Адрес по прописке</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>

        <form method="POST" action="/post-reg" enctype="multipart/form-data">
            @csrf
            <div class="row mb-3">
                <label for="registration_scan" class="col-md-4 col-form-label text-md-end">Скан документа о прописке<span class="text-danger">*</span></label>
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('address') is-invalid @enderror" name="registration_scan" id="registration_scan" value="file">
                            <label class="custom-file-label" for="registration_scan"></label>
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

    <form method="POST" action="/post-foto" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <label for="registration_scan" class="col-md-4 col-form-label text-md-end">Фото<span class="text-danger">*</span></label>
            <div class="col-md-6">
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input @error('address') is-invalid @enderror" name="foto" id="registration_scan" value="file">
                        <label class="custom-file-label" for="registration_scan"></label>
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
@endsection
