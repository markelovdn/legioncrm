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
        <dl class="row">
            <dt class="col-sm-4">Страна:</dt>
            @foreach(\App\Models\Athlete::getAddress($athlete->user_id) as $athlete_address)
                <dd class="col-sm-8">{{$athlete_address->country->title}}</dd>
            <dt class="col-sm-4">Округ:</dt>
                <dd class="col-sm-8">{{$athlete_address->district->shorttitle}}</dd>
            <dt class="col-sm-4">Регион:</dt>
                <dd class="col-sm-8">{{$athlete_address->region->title}}</dd>
            <dt class="col-sm-4">Адресс:</dt>
                <dd class="col-sm-8">{{$athlete_address->address}}</dd>
            <dt class="col-sm-4">Скан документа о прописке:</dt>
                <dd class="col-sm-8"><a href="{{$athlete_address->scanlink}}">Скачать</a></dd>
            @endforeach
        </dl>
    </div>
</div>
