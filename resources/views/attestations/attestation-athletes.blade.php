@extends('layouts.main')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="card collapsed-card">
            <div class="card-header">
                <h1 class="card-title">{{$attestation->title}} {{ \Carbon\Carbon::parse($attestation->date)->format('d.m.Y')}}</h1>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body" style="display: none;">
            </div>
        </div>

    </div>
    <!-- /.content-header -->
    <section class="content">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @foreach ($athletes as $athlete)
            <div @if($athlete->gender == \App\Models\Athlete::GENDER_MALE)class="card card-primary collapsed-card" @else class="card card-danger collapsed-card" @endif>
                <div class="card-header">
                    <span><img class="direct-chat-img" src="@if(!$athlete->photo){{asset('/storage/images/no_photo.jpg')}}@else{{$athlete->photo}}@endif" alt="message user image"></span>
                    <h3 class="card-title">{{$athlete->user->secondname}} {{$athlete->user->firstname}} {{$athlete->user->patronymic}}</h3><br>
                    @if(\Carbon\Carbon::parse($athlete->tehkval->last()->pivot->created_at)->format('d.m.Y') != \Carbon\Carbon::now()->format('d.m.Y'))
                    <h3 class="card-title">{{$athlete->tehkval->last()->title}} <i class="fas fa-arrow-right">
                        </i> {{\App\BusinessProcess\GetAttestationAthletes::getNextTehkval($athlete->id)}}
                    </h3>
                        <span class="badge badge-danger" data-toggle="modal" style="cursor: pointer" data-target="#modal-attestation-athlete{{$athlete->user->id}}">
                                <i class="far fa-clock"></i>присвоить</span>

                        {{--modal edit active-athlete--}}
                        <div class="modal fade" id="modal-attestation-athlete{{$athlete->user->id}}" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <form method="POST" enctype="multipart/form-data" action="{{route('tehkval.store')}}">
                                            <input type="text" name="athlete_id" style="display: none" value="{{$athlete->id}}">
                                            <input type="text" name="tehkval_id" style="display: none" value="{{$athlete->tehkval->last()->id + 1}}">
                                            @csrf

                                            <div class="modal-footer justify-content-between">

                                                <button type="reset" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                                <button type="submit" class="btn btn-primary">Сохранить</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="display: none;">
                    <b>Дата рождения: </b> {{ \Carbon\Carbon::parse($athlete->user->date_of_birth)->format('d.m.Y')}}<br>
                    <b>Техническая квалификация: </b>
                    <span @if(\App\Models\Athlete::isCoachAthlete($athlete->id)) data-toggle="modal" data-target="#modal-tehkval-{{$athlete->id}}" @endif>
                        {{$athlete->tehkval->last()->title}}
                    </span><br>
                </div>
                <div class="card-footer">
                    <div class="row row-cols-2">
                        @if(\App\Models\User::getRoleCode() == \App\Models\Role::ROLE_ORGANIZATION_ADMIN)
                        <div class="col text-left">
                                <a target="_blank" href="{{route('printSertificate',['id' => $athlete->id])}}"><i class="fas fa-file-contract"></i></a>
                        </div>
                        @endif
                        <div class="col text-right">
                            @if(\App\Models\Athlete::isCoachAthlete($athlete->id))
                            <form method="POST" action="">
                                @method('DELETE')
                                @csrf
                                <input type="number" style="display: none" class="form-control" id="competition_id" name="competition_id" value="{{$athlete->id}}">
                                <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
{{--                @include('athletes.tehkval-history-modal')--}}
        @endforeach
    </section>

@endsection

