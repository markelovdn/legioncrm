<div class="card collapsed-card">
    <div class="card-header">
        <h3 class="card-title">Паспортные данные</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="card-body" style="display: none;">
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-4">Серия номер:</dt>
                <dd class="col-sm-8">{{$athlete->passport->series}} {{$athlete->passport->number}}</dd>
                <dt class="col-sm-4">Выдан:</dt>
                <dd class="col-sm-8">{{$athlete->passport->dateissue}}, {{$athlete->passport->issuedby}}</dd>
                <dt class="col-sm-4">Код подразделения:</dt>
                <dd class="col-sm-8">{{$athlete->passport->code}}</dd>
                <dt class="col-sm-4">Скачать скан копию:</dt>
                <dd class="col-sm-8"><a href="{{$athlete->passport->scanlink}}">Скачать</a></dd>
            </dl>
        </div>
    </div>
</div>
