@extends('layouts.main')
@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Группы по технической квалификации
                <a href="{{route('competitions.edit',[$competition->id])}}">{{$competition->title}}</a>
            </h3>
        </div>

        <div class="card-body">
            <form method="POST" action="{{route('competitions.tehkvalgroups.store', [$competition->id])}}">
                @csrf
                <input type="text" name="competition_id" class="form-control" style="display: none"
                       value="{{$competition->id}}">
                <div class="row mb-2">
                    <div class="col-sm-3">
                        <strong>Возраст</strong>
                        <select name="agecategory_id" class="form-control">
                            @foreach($competition->agecategories as $agecategory)
                                <option value="{{$agecategory->id}}">{{$agecategory->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <strong>Минимальный гып</strong>
                        <select name="startgyp_id" class="form-control">
                            @foreach($tehkvals as $tehkval)
                                <option value="{{$tehkval->id}}">{{$tehkval->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <strong>Максимальный гып</strong>
                        <select name="finishgyp_id" class="form-control">
                            @foreach($tehkvals as $tehkval)
                                <option value="{{$tehkval->id}}">{{$tehkval->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <strong>Наименование</strong>
                        <input type="text" name="title" class="form-control">
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-success mt-4">Добавить</button>
                    </div>
                </div>
            </form>

            <strong>Действующие группы</strong>
            @if(isset($tehkvalgroups))
                @foreach($tehkvalgroups as $tehkvalgroup)
                    <form method="POST" action="{{route('tehkvalgroups.update', [$tehkvalgroup->id])}}">
                        @method('PUT')
                        @csrf
                        <input type="text" name="competition_id" class="form-control" style="display: none"
                               value="{{$competition->id}}">
                        <div class="row mt-2">
                            <div class="col-sm-3">
                                <select name="agecategory_id" class="form-control">
                                    @foreach($competition->agecategories as $agecategory)
                                        <option value="{{$agecategory->id}}" @if($agecategory->id==$tehkvalgroup->agecategory_id) selected @endif>{{$agecategory->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select name="startgyp_id" class="form-control">
                                    @foreach($tehkvals as $tehkval)
                                        <option value="{{$tehkval->id}}" @if($tehkval->id==$tehkvalgroup->startgyp_id) selected @endif>{{$tehkval->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select name="finishgyp_id" class="form-control">
                                    @foreach($tehkvals as $tehkval)
                                        <option value="{{$tehkval->id}}" @if($tehkval->id==$tehkvalgroup->finishgyp_id) selected @endif>{{$tehkval->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" name="title" class="form-control" value="{{$tehkvalgroup->title}}">
                            </div>
                            <div class="col-sm-2">
                                <button type="submit" class="btn btn-primary ml-1"><li class="fas fa-pencil-alt"></li></button>
                                <a href="{{route('tehkvalgroups.edit', [$tehkvalgroup->id])}}" class="btn btn-danger"><li class="fas fa-trash"></li></a>
                            </div>
                        </div>
                    </form>
                @endforeach
            @endif
        </div>
        <div class="card-footer">
            <a class="btn btn-default" href="{{route('competitions.edit',[$competition->id])}}">Назад</a>
        </div>
    </div>
@endsection

