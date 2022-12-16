<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href={{asset("dist/css/poomsae-tablo.scss")}}>
    <script src="{{ asset('js/app.js') }}" defer></script>

</head>
<body>
    <a href="{{route('grade.index')}}" class="reload">Обновить</a>

    @if(!isset($grade))
        <div class="grade">
            <span>Нет данных</span>
        </div>
        @elseif($grade != '0' || $grade == 'Ожидание оценок')
        <div class="grade">
            <span>{{$grade}}</span>
        </div>

        @else
        <div class="competitor">
            <span>{{$competitor->athlete->user->secondname}} {{$competitor->athlete->user->firstname}}</span>
            <img src="{{asset('storage/images/logo.png')}}" height="300px" alt="">
        </div>
        @endif

</body>
</html>

