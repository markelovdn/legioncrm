<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    {{--    <title>{{$athlete->user->secondname.' '.$athlete->user->firstname.' '.$athlete->user->patronymic}}</title>--}}
</head>
<style>
    body {
        font-family: "dejavu sans", serif;
        font-size: 12px;
        color: #000;
    }

    .header {
        display: inline-block;
        position: relative;
        left: 50%;
        width: 8cm;
    }

    .title {
        display: inline-block;
        position: relative;
        text-align: center;
        top: 1cm;
        width: 100%;
        font-weight: bold;
    }

    .main_info {
        display: inline-block;
        position: relative;
        top: 1cm;
        width: 100%;
    }

    p {
        margin-bottom: -6px;
    }

    .about_parent {
        display: inline-block;
        position: relative;
        top: 2cm;
        width: 100%;
    }

    .footer {
        display: inline-block;
        position: relative;
        top: 3cm;
        width: 100%;
    }

</style>
<body>
<div class="header">
    <p>Начальнику филиала ФАУ МО РФ</p>
    <p>ЦСКА (СКА. г. Ростов-на-Дону)</p>
    <p>ЧЕПУРНОВУ В.Л.</p>
    <p>от
        @foreach($athlete->parenteds as $parented)
            @if($parented->pivot->parented_type === \App\Models\Parented::FIRST_PARENTED)
                <span>
                            {{morphos\Russian\inflectName($parented->user->secondname.' '.$parented->user->firstname.' '.$parented->user->patronymic, 'родительный')}}
                        </span>
            @endif
            @endforeach
    </p>
    <p>адрес: {{$athlete->user->address->max('address')}}</p>
    <p>паспорт: <span>{{$parented->passport->series}}</span> <span>{{$parented->passport->number}}</span></p>
    <p>выдан: <span>{{$parented->passport->issuedby}},</span>
              <span>{{ \Carbon\Carbon::parse($parented->passport->dateissue)->format('d.m.Y')}}</span>
    </p>
 </div>

<div class="title">
    <p>ЗАЯВЛЕНИЕ</p>
</div>

<div class="main_info">
    <p>Прошу Вас принять моего
        <u>
            @if($athlete->gender === \App\Models\Athlete::GENDER_MALE)
                сына:
            @else
                дочь:
            @endif
        </u></p>
    <p>Ф.И.О. полностью: <u>{{morphos\Russian\inflectName($athlete->user->secondname.' '.$athlete->user->firstname.' '.$athlete->user->patronymic, 'родительный')}}</u></p>
    <p>число, месяц, год рождения: <u>{{ \Carbon\Carbon::parse($athlete->user->date_of_birth)->format('d.m.Y')}}</u></p>
    <p>проживающего по адресу: <u>{{$athlete->user->address->max('address')}}</u></p>

    @if(Carbon\Carbon::parse($athlete->user->date_of_birth)->diffInYears() >= 14)
        <p>паспорт <u>{{$athlete->passport->series}} {{$athlete->passport->number}}</u>,</p>
        <p>выдан: <u>{{$athlete->passport->issuedby}}, {{ \Carbon\Carbon::parse($athlete->passport->dateissue)->format('d.m.Y')}}</u></p>
    @endif
    @if(Carbon\Carbon::parse($athlete->user->date_of_birth)->diffInYears() < 14)
        <p>свидетельство о рождении <u>{{$athlete->birthcertificate->series}} {{$athlete->birthcertificate->number}}</u>,</p>
        <p>выдан: <u>{{$athlete->birthcertificate->issuedby}}, {{ \Carbon\Carbon::parse($athlete->birthcertificate->dateissue)->format('d.m.Y')}}</u></p>
    @endif

    <p>обучается в школе (дошкольное учреждение): <u>{{$athlete->studyplace->org_title}} класс(группа) {{$athlete->studyplace->classnum}}</u></p>
    <p>обучается в школе (дошкольное учреждение): <u>МОУ СШ №93 класс 1 «Г»</u></p>
    <p>конт. телефон <u>89177234589</u></p>
    <p>в СОГ(ФОГ)<u>по тхэквондо</u></p>
</div>

<div class="about_parent">
    <p style="text-align: center"><b>Данные о родителях (законных представителях, уполномоченных лицах):</b></p>
    <p>Мать: Ф.И.О. <u>Иванова Ольга Сергеевна</u></p>
    <p>Адрес, телефон: дом/моб <u>г. Волгоград, ул им. Карла Маркса , д. 25 , кВ. 82, 89173447861</u></p>
    <p>Отец: Ф.И.О. <u>Иванов Антон Юрьевич</u></p>
    <p>Адрес, телефон: дом/моб <u>г. Волгоград, ул им. Карла Маркса , д. 25 , кВ. 82, 89173447861</u></p>
</div>

<div class="footer">
    <p>С порядком и условиями предоставления услуги ознакомлен и согласен.</p>
    <p style="margin-top: 0.5cm">«______» _________________20___ г. ________________/_______________</p>
    <p style="margin-top: 1cm; text-align: justify">С Уставом ФАУ МО РФ ЦСКА, Положением об оказании платных услуг, Договором публичной оферты и другими документами, регламентирующими организацию и осуществление занятий в спортивно-оздоровительных группах по видам спорта, соблюдение правил техники безопасности и санитарно-гигиенических норм, ознакомлен(а).</p>
    <p style="margin-top: 0.5cm">«______» _________________20___ г. ________________/_______________</p>
    <p style="margin-top: 1cm; text-align: justify">В соответствии с Федеральным законом № 152-ФЗ «О персональных данных» от 27.07.2006, подтверждаю своё согласие на обработку персональных данных: сбор, систематизацию, накопление, хранение, уточнение (обновление, изменение), использование, блокирование, обезличивание, уничтожение.</p>
    <p style="margin-top: 0.5cm">«______» _________________20___ г. ________________/_______________</p>
    <p style="margin-top: 0.5cm">Принят с ____________________________. Время и дни занятий______________________</p>
    <p style="margin-top: 0.5cm">Тренер ______________________________________________________________________</p>
    <p style="margin-top: 0.5cm">Ответственное лицо ________________/_______________</p>
</div>

</body>
</html>
