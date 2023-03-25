<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

{{--    <link rel="stylesheet" href={{asset("dist/css/poomsae-tablo.scss")}}>--}}
{{--    <script src="{{ asset('js/app.js') }}" defer></script>--}}

    <style>
        html, body {
            height: 100%;
        //background-image: url("/storage/images/logo.png");
            background: #0a0e14;
        ::-webkit-scrollbar { width: 0;}

        }

        .grade {
            height: 15vh;
            text-align: center;
            color: white;
            font-family: "Helvetica Neue", sans-serif ;
            font-size: 400px;
            font-weight: bolder;
            margin-top: 200px;
        }

        .competitor {
            height: 15vh;
            text-align: center;
            color: white;
            font-family: "Helvetica Neue", sans-serif ;
            font-size: 150px;
            font-weight: bolder;
            margin-top: 100px;
        }

        .reload {
            color: #0c0c0d;
        }

        .judges {
        //white-space:nowrap;
        //height: 3vh;
        //background: #0a53be;
        //text-align: center;
        //text-decoration: white;
        //position: absolute;
        //width: 100vh;
        //bottom: 0px;
        //color: white;
        //font-family: "Helvetica Neue", sans-serif ;
        //font-size: 40px;
        //> div {
          //    width:90px;display:inline-block;border:1px solid black
            //}
        height: 15vh;
        text-align: center;
        background: #0a53be;
        color: white;
        font-family: "Helvetica Neue", sans-serif ;
        font-size: 40px;
        }

    </style>
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

