<aside class="control-sidebar control-sidebar-dark">
    <div class="p-3 control-sidebar-content">
        <form method="GET" action="{{url()->current()}}">
            <h6>Статус</h6>
            <div class="d-flex">
                <select class="custom-select mb-3 text-light border-0 bg-white" name="status">
                    <option>Все</option>
                    <option value="1">Ативные</option>
                    <option value="2">Не ативные</option>
                </select>
            </div>
            <h6>Тренер</h6>
            <div class="d-flex">
                    <select class="custom-select mb-3 text-light border-0 bg-white" name="coach_id">

                                @if($allcoaches)
                                    <option>Все</option>
                                @foreach($allcoaches as $coach)
                                        <option value="{{$coach->id}}">{{$coach->user->secondname}} {{mb_substr($coach->user->firstname, 0, 1)}}. {{mb_substr($coach->user->patronymic, 0, 1)}}.</option>
                                    @endforeach
                                @endif
                    </select>
            </div>
            <div class="d-flex">
                <button type="submit" class="btn btn-info">Выбрать</button>
            </div>
        </form>
    </div>

</aside>

{{--<div class="p-3 control-sidebar-content">--}}
{{--    <form method="GET" action="/competitors">--}}
{{--        <input class="form-control" style="display: none"  name="competition_id" type="text" value="">--}}
{{--        <h6>Возрастная категория</h6>--}}

{{--        <div class="d-flex">--}}
{{--            <select class="custom-select mb-3 text-light border-0 bg-white" name="agecategory_id">--}}
{{--                <option value="">Все</option>--}}

{{--                <option value="{}" f></option>--}}

{{--            </select>--}}
{{--        </div>--}}

{{--        <h6>Весовая категория</h6>--}}
{{--        <div class="d-flex">--}}
{{--            <select class="custom-select mb-3 text-light border-0 bg-white" name="weightcategory_id">--}}
{{--                <option value="">Все</option>--}}

{{--                <option value=""></option>--}}

{{--            </select>--}}
{{--        </div>--}}

{{--        <h6>Тренер</h6>--}}
{{--        <div class="d-flex">--}}
{{--            <select class="custom-select mb-3 text-light border-0 bg-white" name="coach_id">--}}
{{--                <option value="">Все</option>--}}

{{--                <option value=""></option>--}}

{{--            </select>--}}

{{--        </div>--}}
{{--        <div class="d-flex">--}}
{{--            <button type="submit" class="btn btn-info">Выбрать</button>--}}
{{--        </div>--}}
{{--    </form>--}}
{{--</div>--}}
