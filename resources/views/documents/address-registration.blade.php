<div class="card collapsed-card">
    <div class="card-header">
        <h3 class="card-title">Адрес по месту прописки</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>

    <div class="card-body" style="display: none;">
        @foreach(\App\Models\Athlete::getAddress($athlete->user_id) as $athlete_address)
{{--            TODO: делать запросы из вьюх это плохо--}}
        <dl class="row">
            <dt class="col-sm-4">Страна:</dt>
                <dd class="col-sm-8">{{$athlete_address->country->title}}</dd>
            <dt class="col-sm-4">Округ:</dt>
                <dd class="col-sm-8">{{$athlete_address->district->shorttitle}}</dd>
            <dt class="col-sm-4">Регион:</dt>
                <dd class="col-sm-8">{{$athlete_address->region->title}}</dd>
            <dt class="col-sm-4">Адресс:</dt>
                <dd class="col-sm-8">{{$athlete_address->address}}</dd>
            <dt class="col-sm-4">Скан документа о прописке:</dt>
                <dd class="col-sm-8"><button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-address{{$athlete->user->id}}scan">
                        <i class="far fa-eye"></i></button></dd>

                {{--modal address-data-scan--}}
                <div class="modal fade" id="modal-address{{$athlete->user->id}}scan" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body media">
                                <img src="{{$athlete_address->scanlink}}" class="img-fluid" style="width: 100%;" alt="">
                            </div>
                            <div class="modal-footer justify-content-between">
                                <a href="{{$athlete_address->scanlink}}" download=""><button class="btn button-primary">Скачать</button></a>
                            </div>
                        </div>
                    </div>
                </div>

                @switch(\App\Models\User::getRoleCode())
                    @case(\App\Models\Role::ROLE_SYSTEM_ADMIN)
                    @case(\App\Models\Role::ROLE_ORGANIZATION_CHAIRMAN)
                    @case(\App\Models\Role::ROLE_ORGANIZATION_ADMIN)
                        <div class="col-auto mr-auto">
                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-address{{$athlete->user->id}}">
                                <i class="far fa-edit"></i>
                            </button>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-address{{$athlete->user->id}}trash">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </div>
                       {{--modal edit address-data--}}
                    <div class="modal fade" id="modal-address{{$athlete->user->id}}" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Адрес по прописке: {{$athlete->user->secondname}} {{$athlete->user->firstname}}</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" enctype="multipart/form-data" action="{{route('addresses.update',[$athlete_address->id])}}">
                                        @method('PUT')
                                        @csrf
                                        <input type="text" name="user_id" style="display: none" value="{{$athlete->user->id}}">
                                        <div class="row mb-3">
                                            <input type="text" style="display: none" name="user_id" value="{{$athlete->user_id}}">
                                            <label for="country_id" class="col-md-4 col-form-label text-md-end">Страна<span class="text-danger">*</span></label>
                                            <div class="col-md-6">
                                                <select type="text" class="form-control" name="country_id" id="country_id">
                                                    @foreach($countries as $country)
                                                        <option value="{{$country->id}}" @if($country->title == $athlete_address->country->title) selected @endif>{{$country->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="district_id" class="col-md-4 col-form-label text-md-end">Округ<span class="text-danger">*</span></label>
                                            <div class="col-md-6">
                                                <select type="text" class="form-control" name="district_id" id="district_id">
                                                    @foreach($districts as $district)
                                                        <option value="{{$district->id}}" @if($district->shorttitle == $athlete_address->district->shorttitle) selected @endif>{{$district->fulltitle}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="region_id" class="col-md-4 col-form-label text-md-end">Регион<span class="text-danger">*</span></label>
                                            <div class="col-md-6">
                                                <select type="text" class="form-control" name="region_id" id="region_id">
                                                    @foreach($regions as $region)
                                                        <option value="{{$region->id}}" @if($region->title == $athlete_address->region->title) selected @endif>{{$region->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="address" class="col-md-4 col-form-label text-md-end">Адрес<span class="text-danger">*</span></label>
                                            <div class="col-md-6">
                                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{$athlete_address->address}}">
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
                                                @if(Carbon\Carbon::parse($athlete->date_of_birth)->diffInYears() >= 14)
                                                    <span class="description font-italic">Скан страницы паспорта с последней записью о регистрации</span>
                                                    <br>
                                                @endif
                                                @if(Carbon\Carbon::parse($athlete->date_of_birth)->diffInYears() <= 14)
                                                    <span class="description font-italic">Документ с красной печатью о регистрации ребенка по месту жительства.</span>
                                                    <span class="description font-italic">Принимаются файлы только изображений (jpg,jpeg,png,bmp) размер файла должен быть менее 1 мб</span>
                                                    <br>
                                                @endif

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

                    {{--modal edit address-trash--}}
                    <div class="modal fade" id="modal-address{{$athlete->user->id}}trash" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Для удаления данных введите код</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{route('addresses.destroy',[$athlete_address->id])}}">
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
        </dl>
        @endforeach
    </div>
</div>
