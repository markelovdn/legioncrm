@if (session('status'))<div class="alert alert-danger">
    <p>{{ session('status') }}</p>
</div>@endif
<div class="card collapsed-card">
    <div class="card-header">
        <h3 class="card-title">Добавить занимающегося</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>

    <div class="card-body" style="display: none;">
        <form method="POST" action="/athlete" enctype="multipart/form-data">
            @csrf
            <div class="row mb-3">
                <label for="photo" class="col-md-4 col-form-label text-md-end">Фото<span class="text-danger">*</span></label>
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input  @error('photo') is-invalid @enderror" name="photo" id="photo" value="{{ old('photo') }}">
                            <label class="custom-file-label" for="photo"></label>
                        </div>
                    </div>
                    <span class="description font-italic">Принимаются файлы только изображений (jpg,jpeg,png,bmp)</span>
                </div>
            </div>
            <div class="row mb-3">
                <label for="gender" class="col-md-4 col-form-label text-md-end">Пол<span class="text-danger">*</span></label>
                <div class="col-md-6">
                    <select type="text" class="form-control @error('gender') is-invalid @enderror"  name="gender" id="gender" value="{{ old('gender') }}">
                        <option></option>
                        <option value="1" @if(old('gender') == 1) selected @endif>Мужской</option>
                        <option value="2" @if(old('gender') == 2) selected @endif>Женский</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label for="secondname" class="col-md-4 col-form-label text-md-end">Фамилия<span class="text-danger">*</span></label>

                <div class="col-md-6">
                    <input id="secondname" type="text" class="form-control @error('secondname') is-invalid @enderror" name="secondname" value="{{ old('secondname') }}">
                </div>
            </div>
            <div class="row mb-3">
                <label for="firstname" class="col-md-4 col-form-label text-md-end">Имя<span class="text-danger">*</span></label>

                <div class="col-md-6">
                    <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}">
                </div>
            </div>
            <div class="row mb-3">
                <label for="patronymic" class="col-md-4 col-form-label text-md-end">Отчество<span class="text-danger">*</span></label>

                <div class="col-md-6">
                    <input id="patronymic" type="text" class="form-control @error('patronymic') is-invalid @enderror" name="patronymic" value="{{ old('patronymic') }}">
                </div>
            </div>
            <div class="row mb-3">
                <label for="date_of_birth" class="col-md-4 col-form-label text-md-end">Дата рождения<span class="text-danger">*</span></label>

                <div class="col-md-6">
                    <input id="date_of_birth" type="date" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth') }}">
                </div>
            </div>
            <div class="row mb-3">
                <label for="coach_id" class="col-md-4 col-form-label text-md-end">Тренер<span class="text-danger">*</span></label>
                <div class="col-md-6">
                    <select type="text" class="form-control @error('coach_id') is-invalid @enderror" name="coach_id" id="coach_id"  value="{{ old('coach_id') }}">
                        <option value=""></option>
                        @foreach($coaches as $coach)
                            <option value="{{$coach->id}}" @if(old('coach_id') == $coach->id) selected @endif>{{$coach->user->secondname}} {{$coach->user->firstname}} {{$coach->user->patronymic}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label for="reg_code" class="col-md-4 col-form-label text-md-end">Код тренера<span class="text-danger">*</span></label>
                <div class="col-md-6">
                    <input type="number" class="form-control @error('reg_code') is-invalid @enderror @if(session('status')) is-invalid @endif"  id="reg_code" name="reg_code" value="{{old('reg_code')}}">
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

