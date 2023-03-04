<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$athlete->user->secondname.' '.$athlete->user->firstname.' '.$athlete->user->patronymic}}</title>
</head>
<style>
    body {
        font-family: "dejavu sans", serif;
        font-size: 12px;
        color: #000;
    }
</style>
<body>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="p-3 mt-5" style="font-size: x-large; margin-top: 150; margin-left: 150;">О прохождении аттестационного семинара</div>
            <div class="p-3 mt-5" style="font-size: x-large; margin-left: 150">на <strong>{{$athlete->tehkval->last()->title}}</strong> по программе СК "Легион" выдан:</div>
        </div>
        <div class="col-6">
            <div class="p-3" style="font-size: x-large; margin-left: 150"><strong>{{morphos\Russian\inflectName($athlete->user->secondname.' '.$athlete->user->firstname.' '.$athlete->user->patronymic, 'дательный')}}</strong></div>
        </div>
        <div class="col-6">
            <div class="p-3" style="font-size: x-large; margin-left: 150">в подтверждении того, что {{ \Carbon\Carbon::now()->format('d.m.Y')}} года</div>
        </div>
        <div class="col-6">
            <div class="p-3" style="font-size: x-large; margin-left: 150">@if($athlete->gender == \App\Models\Athlete::GENDER_MALE) он прошел @else она прошла @endif программу подготовки</div>
        </div>
        <div class="col-6">
            <div class="p-3" style="font-size: x-large; margin-left: 150">на <strong>{{\Illuminate\Support\Str::lower($athlete->tehkval->last()->belt_color)}} пояс</strong> по тхэквондо</div>
        </div>
        <div class="col-3">
            <div class="p-6" style="font-size: medium; margin-top: 79; margin-left: 150">Председатель правления СК "Легион"</div>
        </div>
        <div class="col-2">
            <div class="p-3" style="font-size: medium; margin-top: -19; margin-left: 550">Маркелов Д.Н.</div>
        </div>
        <div class="col-2">
            <div style="font-size: medium; margin-top: 67px; padding-bottom: -100px; margin-left: 500px">Волгоград, {{ \Carbon\Carbon::now()->format('Y')}}</div>
        </div>
    </div>
</div>
</body>
</html>
