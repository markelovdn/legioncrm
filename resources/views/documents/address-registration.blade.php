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
            @foreach($athlete->user->address as $address_country)
            <dd class="col-sm-8">{{$address_country->country->title}}</dd>
            @endforeach
            <dt class="col-sm-4">Округ:</dt>
            @foreach($athlete->user->address as $address_district)
                <dd class="col-sm-8">{{$address_district->district->shorttitle}}</dd>
            @endforeach
            <dt class="col-sm-4">Регион:</dt>
            @foreach($athlete->user->address as $address_region)
                <dd class="col-sm-8">{{$address_region->region->title}}</dd>
            @endforeach
            <dt class="col-sm-4">Адресс:</dt>
            @foreach($athlete->user->address as $address)
                <dd class="col-sm-8">{{$address->address}}</dd>
            @endforeach
            <dt class="col-sm-4">Скан документа о прописке:</dt>
            @foreach($athlete->user->address as $address)
                <dd class="col-sm-8"><a href="{{$address->scanlink}}">Скачать</a></dd>
            @endforeach
        </dl>
    </div>
</div>
