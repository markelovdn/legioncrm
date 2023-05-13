<div class="card collapsed-card">
    <div class="card-header">
        <h3 class="card-title">Техническая квалификация ({{$athlete->tehkval->last()->title ?? ''}})</h3>
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
                    <dt class="col-sm-4">Пояс: {{$athlete->tehkval->last()->belt_color ?? ''}} ({{$athlete->tehkval->last()->title ?? ''}})</dt>
                    <dd class="col-sm-8"></dd>
            </dl>
        </div>
        @switch(\Illuminate\Support\Facades\Auth::user()->getRoleCode())
            @case(\App\Models\Role::ROLE_SYSTEM_ADMIN)
            @case(\App\Models\Role::ROLE_ORGANIZATION_CHAIRMAN)
            @case(\App\Models\Role::ROLE_ORGANIZATION_ADMIN)
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-tehkval{{$athlete->id}}">
                <i class="far fa-edit"></i>
            </button>

        @endswitch

    </div>
</div>


{{--modal-edit-tehkval--}}
<div class="modal fade" id="modal-tehkval{{$athlete->id}}" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                @foreach($athlete->tehkval as $tehkval)
                    <div class="row">
                        <div class="col-auto mr-auto">
                            {{$tehkval->title}}
                            @if($tehkval->pivot->sertificate_link)
                            <span data-toggle="modal" data-target="#sertificate_scan{{$tehkval->id}}">
                                <a href="" class="alert-link" style="text-underline-mode: true">Сертификат</a>
                        </span>
                            @endif
                            {{--modal sertificate_scan--}}
                            <div class="modal fade" id="sertificate_scan{{$tehkval->id}}" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <img class="img-fluid" src="{{$tehkval->pivot->sertificate_link}}" alt="message user image">
                                        </div>

                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-tehkval-destroy{{$athlete->id}}">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </div>

                        {{--modal-destroy-tehkval--}}
                        <div class="modal fade" id="modal-tehkval-destroy{{$athlete->id}}" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <form method="POST" action="{{route('tehkval.destroy', [$tehkval->id])}}">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Подтвердить<i class="fas fa-check"></i></button>
                                            <input type="text" style="display:none" name="athlete_id" value="{{$athlete->id}}">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                    <hr>
                    <strong><h6>Добавить</h6></strong>
                    <form method="POST" enctype="multipart/form-data" action="{{route('tehkval.store')}}">
                        <input type="text" name="athlete_id" style="display: none" value="{{$athlete->id}}">
{{--                        <input type="text" name="competitor_id" style="display: none" value="{{$competitor->id}}">--}}
{{--                        <input type="text" name="competition_id" style="display: none" value="{{$competition->id}}">--}}

                    @csrf
                    <div class="form-group row">
                        <label for="tehkval_id" class="col-sm-2 col-form-label">Пояс<span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <select type="text" class="form-control" name="tehkval_id" id="tehkval_id">
                                <option></option>
                            @foreach($tehkvals as $tehkval)
                                <option value="{{$tehkval->id}}" @if(old('tehkval_id') == $tehkval->id) selected @endif>{{$tehkval->belt_color}} ({{$tehkval->title}})</option>
                                @endforeach
                            </select>
                            @error('tehkval_id')<p class="text-danger">{{$errors->first('tehkval_id')}}</p>@enderror
                        @if (session('error_tehkval'))<p class="text-danger">{{ session('error_tehkval') }}</p>@endif
                        </div>
                        <label for="serticatenum" class="col-sm-2 col-form-label">Номер сертификата<span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="serticatenum">
                            @error('serticatenum')<p class="text-danger">{{$errors->first('serticatenum')}}</p>@enderror
                            @if (session('serticatenum'))<p class="text-danger">{{ session('serticatenum') }}</p>@endif
                        </div>
{{--                        <label for="tehkval_id" class="col-sm-2 col-form-label">Пояс<span class="text-danger">*</span></label>--}}
                        <div class="row mb-3">
                            <label for="sertificate_link" class="col-md-4 col-form-label text-md-end">Скан сертифиата<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file"
                                               class="custom-file-input @error('sertificate_link') is-invalid @enderror"
                                               name="sertificate_link" id="sertificate_link" value="file">
                                        <label class="custom-file-label" for="sertificate_link"></label>
                                    </div>
                                </div>
                                <span class="description font-italic">Принимаются файлы только изображений (jpg,jpeg,png,bmp) размер файла должен быть менее 1 мб</span>
                            </div>
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


