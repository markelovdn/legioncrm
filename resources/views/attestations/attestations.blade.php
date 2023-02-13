@extends('layouts.main')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Список актуальных аттестаций</h1>
                </div><!-- /.col -->
                <!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @foreach ($attestations as $attestation)
            <div class="card card-info collapsed-card shadow-lg">
                <div class="card-header">
                    <h3 class="card-title"><b>{{$attestation->title}}</b></h3><br>
                    <p>Начало: {{ \Carbon\Carbon::parse($attestation->date)->format('d.m.Y')}}</p>
                    Участники:
                    <a href="{{route('attestation.athletes.index',[$attestation->id])}}"><i class="nav-icon fas fa-users"></i></a>
                    <br>
                    Регистрация:
                    <a href="{{route('attestation.athletes.create',[$attestation->id])}}"><i class="nav-icon fas fa-user-plus"></i></a><br>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>

                </div>

                <div class="card-body" style="display: none;">
                    <b>Место проведения: </b>
{{--                    {{$attestation->address}}--}}
                    <br>
                    <b>Дата проведения: </b>{{ \Carbon\Carbon::parse($attestation->date)->format('d.m.Y')}}<br>
                    <b>Зарегестированно всего:
{{--                    </b>{{ \App\Models\Competition::competitorsCount($competition->id)}}--}}
                    <br>
                </div>

{{--                <div class="card-footer">--}}
{{--                    <div class="row row-cols-2">--}}
{{--                        @if(\App\Models\Competition::getOwner($competition->id))--}}
{{--                            <div class="col text-left">--}}
{{--                                <a class="btn btn-primary" href="{{route('competitions.edit',[$competition->id])}}"><i class="fas fa-cog"></i></a>--}}
{{--                            </div>--}}
{{--                            <div class="col text-right">--}}
{{--                                <form method="POST" action="{{route('competitions.destroy',$competition->id)}}">--}}
{{--                                    @method('DELETE')--}}
{{--                                    @csrf--}}
{{--                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>--}}
{{--                                </form>--}}
{{--                            </div>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
    @endforeach
    <!-- /.card-body -->
        </div>
        <!-- /.card -->
        </div>
        <!-- /.col -->
        </div>
        <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection

