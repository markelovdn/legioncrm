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

<p>О прохождении аттестационного семинара на {{$athlete->tehkval->last()->title}} по программе СК "Легион"</p>
<p>настоящий диплом выдан:</p>
    <strong>{{morphos\Russian\inflectName($athlete->user->secondname.' '.$athlete->user->firstname.' '.$athlete->user->patronymic, 'дательный')}}</strong>
<p>в подтверждении того что
    @if($athlete->gender == \App\Models\Athlete::GENDER_MALE) он прошел @else она прошла @endif программу подготовки на {{\Illuminate\Support\Str::lower($athlete->tehkval->last()->belt_color)}} пояс</p>
<p>{{ \Carbon\Carbon::now()->format('d.m.Y')}}</p>
<p>Председатель правления СК Легион</p>
<p>Маркелов Д.Н.</p>
<p>Волгоград, {{ \Carbon\Carbon::now()->format('Y')}}</p>
</body>
</html>
