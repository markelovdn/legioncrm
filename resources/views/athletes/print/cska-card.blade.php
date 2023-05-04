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

    .front {
        position: relative;
        width: 272mm;
        height: 184mm;
        /*border-color: #0a0e14;*/
        /*border-style: dotted;*/
    }

    .back {
        position: relative;
        width: 272mm;
        height: 184mm;
        /*border-color: #0a53be;*/
        /*border-style: dotted;*/
    }

    .f_left {
        display: inline-block;
        width: 129mm;
        /*border-color: #0a53be;*/
        /*border-style: dotted;*/
        vertical-align: bottom;
        margin-top: -16mm;
    }

    .f_right {
        position: absolute;
        display: inline-block;
        margin-left: 5mm;
        width: 134mm;
    }

    .b_left {
        display: inline-block;
        width: 129mm;
        /*border-color: #0a53be;*/
        /*border-style: dotted;*/
        vertical-align: bottom;
        margin-top: -17mm;
    }

    .b_right {
        position: absolute;
        display: inline-block;
        margin-left: 5mm;
        width: 134mm;
    }

    .gerb_cska {
        position: relative;
        display: inline-block;
        width: 30mm;
        height: 40mm;
        text-align: center;
        margin-top: 13mm;

        /*border-color: #0a53be;*/
        /*border-style: dotted;*/
    }

    .right_header {
        position: absolute;
        text-align: center;
        display: inline-block;
        width: 100mm;
        /*border-color: #0a53be;*/
        /*border-style: dotted;*/
    }

    .photo {
        position: relative;
        display: inline-block;
        width: 30mm;
        height: 40mm;
        text-align: center;
        margin-top: -10mm;


        /*border-color: #0a53be;*/
        /*border-style: dotted;*/
    }

    .main_ifo {
        position: absolute;
        display: inline-block;
        width: 100mm;
        /*border-color: #0a53be;*/
        /*border-style: dotted;*/
    }

    #r_table {
        border: 0px solid black;
        border-collapse: collapse;
    }

    #r_table2 {
        border: 0px solid black;
    }

    #r_table_bottom {
        border: 0px solid black;
        border-collapse: collapse;
    }

    #r_table2_bottom {
        border: 0px solid black;
    }

    #l_table {
        border: 0px solid black;
        width: 100%;
        border-collapse: collapse;
    }

    #l_table2 {
        margin-top: 90px;
        border: 0px solid black;
        width: 100%;
        border-collapse: collapse;
    }

    #l_table_bottom {
        margin-top: 1mm;
        border: 0px solid black;
        width: 100%;
        border-collapse: collapse;
    }

    #l_table2_bottom {
        margin-top: 45px;
        border: 0px solid black;
        width: 100%;
        border-collapse: collapse;
    }

    #l_td {
        border: 2px solid black;
        height: 30px;
        text-align: center;
    }

    #th_s {
        border: 0px solid black;
        text-align: center;
    }

    #th_s2 {
        border: 2px solid black;
        text-align: center;
    }

    #td_s {
        border-bottom: 2px solid black;
        height: 5px;
    }

    #td_hr {
        border-bottom: 2px solid black;
        height: 10px;
    }

    #foto {
        width: 30mm;
        height: 40mm;
        padding-right: 10px;
    }

    #logo {
        width: 114px;
        height: 152px;
    }

    #header {
        font-size: 25px;
        font-weight: bolder;
        vertical-align: top;
        text-align: center;
        padding-top: -10mm;

    }

    #header2 {
        font-size: 25px;
        font-weight: bolder;
        vertical-align: top;
        text-align: center;
    }

    #lable {
        font-size: 14px;
        vertical-align: top;
        text-align: center;
        height: 35mm;
    }

    #med_t {
        border: 1px solid black;
        display: grid;
        grid-auto-flow: column;
    }

    #td_hiden_text {
        width: 33%;
        border: 2px solid black;
        height: 30px;
    }


</style>
<body>
<div class="front">
    <div class="f_left">
        <table id="l_table">
            <tbody>
            <tr>
                <th id="th_s" colspan="3">Выполнение спортивных разрядов и технических нормативов</th>
            </tr>
            <tr>
                <th id="th_s2">Разряд</th>
                <th id="th_s2">Дата присвоения</th>
                <th id="th_s2">Основание</th>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            </tbody>
        </table>
        <table id="l_table2">
            <tbody>
            <tr>
                <th id="th_s" colspan="3">Полис страхования от несчастных случаев:</th>
            </tr>
            <tr>
                <th id="th_s2">№№</th>
                <th id="th_s2">Наименование страховой организации</th>
                <th id="th_s2">Действителен до:</th>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="f_right">
        <table id="r_table">
            <tbody>
            <tr>
                <td rowspan="2">
                    <img id="logo" src="{{asset('/storage/images/cska.png')}}">
                </td>
                <td colspan="3" id="header">филиал ФАУ МО РФ ЦСКА<br>(СКА, г.Ростов-на-Дону)</td>
            </tr>
            <tr>
                <td colspan="3" id="lable">Личная карточка спортсмена<br>Спортивная школа олимпийского резерва<br>(комплексная)
                </td>
            </tr>
            <tr>
                <td width="4%" rowspan="6">
                    <img id="foto" src="{{$athlete->photo}}" alt="">
                </td>
                <td>Фамилия</td>
                <td colspan="2" id="td_s">{{$athlete->user->secondname}}</td>
            </tr>
            <tr>
                <td>Имя</td>
                <td colspan="2" id="td_s">{{$athlete->user->firstname}}</td>
            </tr>
            <tr>
                <td>Отчество</td>
                <td colspan="2" id="td_s">{{$athlete->user->patronymic}}</td>
            </tr>
            <tr>
                <td>Дата рождения</td>
                <td colspan="2" id="td_s">{{\Carbon\Carbon::parse($athlete->user->date_of_birth)->format('d.m.Y')}}</td>
            </tr>
            <tr>
                <td>Телефон</td>
                <td colspan="2" id="td_s">{{$athlete->user->phone}}</td>
            </tr>
            <tr>
                <td>Школа, класс</td>
                <td colspan="2" id="td_s">{{$athlete->study_place}}</td>
            </tr>
            <tr>
                <td colspan="1">Домашний адрес</td>
                <td colspan="3" id="td_s">{{$athlete->user->address->max('address')}}</td>
            </tr>

            <tr>
                <td>Округ (район)</td>
                <td colspan="3" id="td_s">{{$athlete->user->address->max('district')->shorttitle ?? ''}}</td>
            </tr>
            <tr>
                @if(Carbon\Carbon::parse($athlete->user->date_of_birth)->diffInYears() >= 14)
                    <td colspan="2">Паспорт</td>
                    <td colspan="2" id="td_s">{{$athlete->passport->series ?? ''}} {{$athlete->passport->number ?? ''}},
                    выдан: {{ \Carbon\Carbon::parse($athlete->passport->dateissue ?? '')->format('d.m.Y')}},
                    </td>
            <tr>
                <td colspan="4" id="td_s">{{$athlete->passport->issuedby ?? 'нет данных'}}</td>
            </tr>
                @endif
                @if(Carbon\Carbon::parse($athlete->user->date_of_birth)->diffInYears() < 14)
                        <td colspan="2">Свидетельство о рождении</td>
                        <td colspan="2" id="td_s">
                            {{$athlete->birthcertificate->series ?? ''}} {{$athlete->birthcertificate->number ?? ''}},
                            выдан: {{ \Carbon\Carbon::parse($athlete->birthcertificate->dateissue)->format('d.m.Y') ?? ''}},
                        </td>
            </tr>
            <tr>
                <td colspan="4" id="td_s">{{$athlete->birthcertificate->issuedby}}</td>
            </tr>
            @endif
            <tr>
                <td nowrap="" colspan="3">Полис, обязательного медицинского страхования</td>
                <td id="td_s"></td>
            </tr>

            <tr>
                <td colspan="2">Дата зачисления в школу</td>
                <td id="td_s"></td>
                <td id="td_s"></td>
            </tr>
            </tbody>
        </table>

        <table id="r_table2" width="100%">
            <tbody>
            <tr>
                <th colspan="2" id="header2">Сведения о родителях</th>
            </tr>
            @foreach($athlete->parenteds as $parented)
            <tr>
                <td width="35%">Мать:</td>

                <td id="td_s">
                    @if($parented->pivot->parented_type === \App\Models\Parented::FIRST_PARENTED)
                    {{$parented->user->secondname.' '.$parented->user->firstname.'
                    '.$parented->user->patronymic}}
                        @endif
                </td>
            </tr>
            <tr>
                <td>контактные телефоны:</td>
                <td id="td_s">
                    @if($parented->pivot->parented_type === \App\Models\Parented::FIRST_PARENTED)
                    {{$parented->user->phone}}
                    @endif
                </td>
            </tr>
            <tr>
                <td width="35%">Отец:</td>

                <td id="td_s">
                    @if($parented->pivot->parented_type === \App\Models\Parented::SECOND_PARENTED)
                        {{$parented->user->secondname.' '.$parented->user->firstname.'
                        '.$parented->user->patronymic}}
                    @endif
                </td>
            </tr>
            <tr>
                <td>контактные телефоны:</td>
                <td id="td_s">
                    @if($parented->pivot->parented_type === \App\Models\Parented::SECOND_PARENTED)
                        {{$parented->user->phone}}
                    @endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</div>

<div class="back">
    <div class="b_left">
        <table id="l_table_bottom">
            <tbody>
            <tr>
                <td>Зачислен в группу:</td>
                <td id="td_s"></td>
                <td>Тренер:</td>
                <td id="td_s">
                    @foreach($athlete->coaches as $coach)
                        @if($coach->pivot->coach_type === \App\Models\Coach::REAL_COACH)
                    <u>{{$coach->user->secondname.' '.mb_substr($coach->user->firstname, 0,1).'.'.mb_substr($coach->user->patronymic, 0,1).'.'}}</u>
                        @endif
                    @endforeach
                </td>
            </tr>
            <tr>
                <td width="135px">№ приказа:</td>
                <td id="td_s">_</td>
            </tr>
            <tr>
                <td colspan="4" id="td_hr"></td>
            </tr>
            <tr>
                <td>Зачислен в группу:</td>
                <td id="td_s"></td>
                <td>Тренер:</td>
                <td id="td_s"></td>
            </tr>
            <tr>
                <td width="135px">№ приказа:</td>
                <td id="td_s"></td>
            </tr>
            <tr>
                <td colspan="4" id="td_hr"></td>
            </tr>
            <tr>
                <td>Зачислен в группу:</td>
                <td id="td_s"></td>
                <td>Тренер:</td>
                <td id="td_s"></td>
            </tr>
            <tr>
                <td width="135px">№ приказа:</td>
                <td id="td_s"></td>
            </tr>
            <tr>
                <td colspan="4" id="td_hr"></td>
            </tr>
            <tr>
                <td>Зачислен в группу:</td>
                <td id="td_s"></td>
                <td>Тренер:</td>
                <td id="td_s"></td>
            </tr>
            <tr>
                <td width="135px">№ приказа:</td>
                <td id="td_s"></td>
            </tr>
            <tr>
                <td colspan="4" id="td_hr"></td>
            </tr>
            <tr>
                <td>Зачислен в группу:</td>
                <td id="td_s"></td>
                <td>Тренер:</td>
                <td id="td_s"></td>
            </tr>
            <tr>
                <td width="135px">№ приказа:</td>
                <td id="td_s"></td>
            </tr>
            <tr>
                <td colspan="4" id="td_hr"></td>
            </tr>
            <tr>
                <td>Зачислен в группу:</td>
                <td id="td_s"></td>
                <td>Тренер:</td>
                <td id="td_s"></td>
            </tr>
            <tr>
                <td width="135px">№ приказа:</td>
                <td id="td_s"></td>
            </tr>
            <tr>
                <td colspan="4" id="td_hr"></td>
            </tr>
            <tr>
                <td>Зачислен в группу:</td>
                <td id="td_s"></td>
                <td>Тренер:</td>
                <td id="td_s"></td>
            </tr>
            <tr>
                <td width="135px">№ приказа:</td>
                <td id="td_s"></td>
            </tr>
            <tr>
                <td colspan="4" id="td_hr"></td>
            </tr>
            <tr>
                <td>Зачислен в группу:</td>
                <td id="td_s"></td>
                <td>Тренер:</td>
                <td id="td_s"></td>
            </tr>
            <tr>
                <td width="135px">№ приказа:</td>
                <td id="td_s"></td>
            </tr>
            <tr>
                <td colspan="4" id="td_hr"></td>
            </tr>
            </tbody>
        </table>
        <table id="l_table2_bottom">
            <tbody>
            <tr>
                <th id="th_s" colspan="3">Даты прохождения диспансеризации:</th>
            </tr>
            <tr></tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr></tr>
            </tbody>
        </table>
    </div>
    <div class="b_right">
        <table id="l_table">
            <tbody>
            <tr>
                <th id="th_s" colspan="3">Участие в главных соревнованиях года:</th>
            </tr>
            <tr>
                <th id="th_s2">Дата</th>
                <th id="th_s2">Наименование соревнований</th>
                <th id="th_s2">Результат</th>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            <tr>
                <td id="l_td"></td>
                <td id="l_td"></td>
                <td id="l_td"></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>


</body>
</html>
