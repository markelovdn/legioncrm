<form method="POST" action="{{route('payment.store')}}" enctype="multipart/form-data">
    @csrf
    <div class="row mb-3">
        <input type="text" style="display: none" name="user_id" value="{{$athlete->user_id}}">
        <input type="text" style="display: none" name="paymenttitle_id" value="{{\App\Models\Payment::ID_YEAR_PAYMENT}}">
        <label for="date_payment" class="col-md-4 col-form-label text-md-end">Дата платежа<span
                class="text-danger">*</span></label>
        <div class="col-md-6">
            <input id="date_payment" type="date"
                   class="form-control @error('date_payment') is-invalid @enderror" name="date_payment"
                   value="{{ old('date_payment') }}">
        </div>
    </div>
    <div class="row mb-3">
        <label for="sum_payment" class="col-md-4 col-form-label text-md-end">Сумма платежа<span
                class="text-danger">*</span></label>
        <div class="col-md-6">
            <input id="sum_payment" type="number"
                   class="form-control @error('sum_payment') is-invalid @enderror" name="sum_payment"
                   value="{{ old('sum_payment') }}">
        </div>
    </div>
    <div class="row mb-3">
        <label for="scan_payment_document" class="col-md-4 col-form-label text-md-end">Чек об оплате<span
                class="text-danger">*</span></label>
        <div class="col-md-6">
            <div class="input-group">
                <div class="custom-file">
                    <input type="file"
                           class="custom-file-input @error('scan_payment_document') is-invalid @enderror"
                           name="scan_payment_document" id="scan_payment_document" value="file">
                    <label class="custom-file-label" for="scan_payment_document"></label>
                </div>
            </div>
            <span class="description font-italic">Принимаются файлы только изображений (jpg,jpeg,png,bmp) размер файла должен быть менее 1 мб</span>
        </div>
    </div>
    <div class="row mb-0">
        <div class="col-md-6 offset-md-4 mb-4">
            <button id="submit" type="submit" onclick="blocked()" class="btn btn-primary">
                Отправить
            </button>
            <div class="spinner-border" id="loader" style="display: none" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
</form>
