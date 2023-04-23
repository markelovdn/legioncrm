<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$competitor->athlete->user->secondname.' '.$competitor->athlete->user->firstname}}</title>
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
            <div class="p-3" style="font-size: xx-large; margin-top: 300; text-align: center;"><strong></strong></div>
            <div class="p-3" style="font-size: x-large; margin-top: 20; text-align: center"><strong>{{$competitor->athlete->user->secondname.' '.$competitor->athlete->user->firstname}}</strong></div>
        </div>
        <div class="col-6">
            <div class="p-3" style="font-size: x-large; text-align: center"><strong>@if($competitor->athlete->gender == \App\Models\Athlete::GENDER_MALE) занявший @else занявшая @endif {{$competitor->place}} место</strong></div>
        </div>
        <div class="col-6">
            <div class="p-3" style="font-size: x-large; text-align: center">в {{Str::of($competition_title)->title()}} {{Str::of($competition->title)->after(' ')}}</div>
        </div>
        <div class="col-6">
            <div class="p-3" style="font-size: x-large; text-align: center">среди
                @if(Str::of($competitor->agecategory->title)->before(' ') == 'Дети'
                    && $competitor->athlete->gender == \App\Models\Athlete::GENDER_MALE) мальчиков
                @elseif(Str::of($competitor->agecategory->title)->before(' ') == 'Дети'
                    && $competitor->athlete->gender == \App\Models\Athlete::GENDER_FEMALE) девочек
                @elseif(Str::of($competitor->agecategory->title)->before(' ') == 'Юноши'
                && $competitor->athlete->gender == \App\Models\Athlete::GENDER_MALE) юношей
                @elseif(Str::of($competitor->agecategory->title)->before(' ') == 'Юноши'
                && $competitor->athlete->gender == \App\Models\Athlete::GENDER_FEMALE) девушек
                @elseif(Str::of($competitor->agecategory->title)->before(' ') == 'Юниоры'
                && $competitor->athlete->gender == \App\Models\Athlete::GENDER_MALE) юниоров
                @elseif(Str::of($competitor->agecategory->title)->before(' ') == 'Юниоры'
                && $competitor->athlete->gender == \App\Models\Athlete::GENDER_FEMALE) юниорок
                @elseif(Str::of($competitor->agecategory->title)->before(' ') == 'Взрослые'
                && $competitor->athlete->gender == \App\Models\Athlete::GENDER_MALE) мужчин
                @elseif(Str::of($competitor->agecategory->title)->before(' ') == 'Взрослые'
                && $competitor->athlete->gender == \App\Models\Athlete::GENDER_FEMALE) женщин
                @endif
                {{Str::of($competitor->agecategory->title)->after(' ')}}
            </div>
        </div>
        <div class="col-6">
            <div class="p-3" style="font-size: x-large; text-align: center">в весовой категории {{$competitor->weightcategory->title}}</div>
        </div>
        <div class="col-3">
            <div class="p-6" style="font-size: medium; margin-top: 100; margin-left: 70">Руководитель СК "Легион"</div>
        </div>
        <div class="col-2">
            <div class="p-3" style="font-size: medium; margin-top: -19; margin-left: 370">Маркелов Д.Н.</div>
        </div>
        <div class="col-2">
            <div style="font-size: medium; margin-top: 30; padding-bottom: -100px; text-align: center">Волгоград, {{ \Carbon\Carbon::parse($competition->date_start)->format('d.m.Y')}}</div>
        </div>
    </div>
</div>
</body>
</html>
