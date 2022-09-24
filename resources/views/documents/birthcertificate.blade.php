<div class="card collapsed-card">
    <div class="card-header">
        <h3 class="card-title">Свидетельство о рождении</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>

    <div class="card-body" style="display: none;">
        <dl class="row">
            <dt class="col-sm-4">Серия номер:</dt>
            <dd class="col-sm-8">{{$athlete->birthcertificate->series}} {{$athlete->birthcertificate->number}}</dd>
            <dt class="col-sm-4">Выдан:</dt>
            <dd class="col-sm-8">{{$athlete->birthcertificate->dateissue}}, {{$athlete->birthcertificate->issuedby}}</dd>
            <dt class="col-sm-4">Скачать:</dt>
            <dd class="col-sm-8"><a href="{{asset('storage/'.$athlete->birthcertificate->scanlink)}}">Скачать</a></dd>
        </dl>
    </div>
</div>
