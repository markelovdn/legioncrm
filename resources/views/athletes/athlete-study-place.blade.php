<div class="card collapsed-card">
    <div class="card-header">
        <h3 class="card-title">Место учебы</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>

    <div class="card-body" style="display: none;">
        <dl class="row">
            <dt class="col-sm-4">Организация</dt>
            <dd class="col-sm-8">{{$athlete->studyplace->org_title}}</dd>
            <dt class="col-sm-4">Класс</dt>
            <dd class="col-sm-8">{{$athlete->studyplace->classnum}} {{$athlete->studyplace->letter}}</dd>
        </dl>
    </div>
</div>
