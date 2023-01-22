<div class="card collapsed-card">
    <div class="card-header">
        <h3 class="card-title">Адрес по прописке</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="card-body" style="display: none;">
        <form method="POST" action="/addresses" enctype="multipart/form-data">
            @csrf
            <div class="row mb-3">
                <input type="text" style="display: none" name="user_id" value="{{$athlete->user_id}}">
                <label for="country_id" class="col-md-4 col-form-label text-md-end">Страна<span class="text-danger">*</span></label>
                <div class="col-md-6">
                    <select type="text" class="form-control" name="country_id" id="country_id">
                        @foreach($countries as $country)
                            <option value="{{$country->id}}" @if($country->code == 'RU') selected @endif>{{$country->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label for="district_id" class="col-md-4 col-form-label text-md-end">Округ<span class="text-danger">*</span></label>
                <div class="col-md-6">
                    <select type="text" class="form-control" name="district_id" id="district_id">
                        @foreach($districts as $district)
                            <option value="{{$district->id}}" @if($district->shorttitle == 'ЮФО') selected @endif>{{$district->fulltitle}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label for="region_id" class="col-md-4 col-form-label text-md-end">Регион<span class="text-danger">*</span></label>
                <div class="col-md-6">
                    <select type="text" class="form-control" name="region_id" id="region_id">
                        @foreach($regions as $region)
                            <option value="{{$region->id}}" @if($region->code == '34') selected @endif>{{$region->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label for="address" class="col-md-4 col-form-label text-md-end">Адрес<span class="text-danger">*</span></label>

                <div class="col-md-6">
                    <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}">
                    <span class="description font-italic">Пример: г. Волгоград, ул. Строителей, д. 20, кв. 2</span>
                </div>

            </div>
            <div class="row mb-3">
                <label for="registration_scan" class="col-md-4 col-form-label text-md-end">Скан документа о прописке<span class="text-danger">*</span></label>
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('address') is-invalid @enderror" name="registration_scan" id="registration_scan" value="file">
                            <label class="custom-file-label" for="registration_scan"></label>
                        </div>
                    </div>
                    @if(Carbon\Carbon::parse($athlete->user->date_of_birth)->diffInYears() >= 14)
                        <span class="description font-italic">Скан страницы паспорта с последней записью о регистрации</span>
                        <br>
                    @endif
                    @if(Carbon\Carbon::parse($athlete->user->date_of_birth)->diffInYears() <= 14)
                        <span class="description font-italic">Документ с красной печатью о регистрации ребенка по месту жительства.</span>
                        <span class="description font-italic">Принимаются файлы только изображений (jpg,jpeg,png,bmp) размер файла должен быть менее 1 мб</span>
                        <br>
                    @endif

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
