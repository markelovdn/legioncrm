<div class="card collapsed-card">
    <div class="card-header">
        <h3 class="card-title">Общие данные</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="card-body" style="display: none;">
        <form method="POST" action="/athlete" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">ФИО</dt>
                    <dd class="col-sm-8">{{$athlete->user->secondname}} {{$athlete->user->firstname}} {{$athlete->user->patronymic}}</dd>
                    <dt class="col-sm-4">Дата рождения</dt>
                    <dd class="col-sm-8">{{$athlete->user->date_of_birth}}</dd>
                </dl>
            </div>
        </form>
    </div>
</div>
