    <div class="modal fade" id="modal-tehkval-{{$competitor->athlete->id}}" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">
                @foreach($competitor->athlete->tehkval as $tehkval)
                    <p>{{$tehkval->title}}</p>
                    @endforeach
                    <form method="POST" action="{{route('tehkval.store')}}">
                        <input type="text" name="athlete_id" style="display: none" value="{{$competitor->athlete->id}}">
                        <input type="text" name="competitor_id" style="display: none" value="{{$competitor->id}}">
                        <input type="text" name="competition_id" style="display: none" value="{{$competition->id}}">

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
