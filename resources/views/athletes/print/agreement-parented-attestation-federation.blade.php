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
        font-family: "dejavu serif", serif;
        font-size: 8px;
        color: #000;
        width: 210mm;
    }

    #container {
        position: relative;
        width: 205mm;
    }

    #parented_agreement_header {
        position: absolute;
        left: 97%;
        margin-left: -350px;
    }

    #text_header {
        text-align: left;
        width: 310px;
    }

    #p {
        margin-bottom: -8px;
    }

    #title {
        position: center;
        text-align: center;
        padding-top: 100px;
        margin-bottom: -15px;
        font-size: 10px;
    }

    #main_block {
        position: absolute;
        /*padding-top: 5px;*/
        width: 190mm;
        text-align: justify;
        text-indent: 30px;
    }

    #parented_agreement_footer {
        position: absolute;
        padding-top: 870px;
    }

</style>

<body>
<div id="container">
    <div id="parented_agreement_header">
        <div id="text_header">Президенту Волгоградской региональной общественной организации «Волгоградская Федерация тхэквондо»
        </div>
        <div id="text_header">
            <p id="p">
                <span><b>От:</b></span>
                @foreach($athlete->parenteds as $parented)
                        @if($parented->pivot->parented_type === \App\Models\Parented::FIRST_PARENTED)
                        <span>
                            {{morphos\Russian\inflectName($parented->user->secondname.' '.$parented->user->firstname.' '.$parented->user->patronymic, 'родительный')}}
                        </span>
                        @endif

            </p>
            <p id="p">
                <span><b>Место жительства:</b></span>
                <span>{{$athlete->user->address->max('address')}}</span>
            </p>
            <p id="p">
                <span><b>Паспортные данные:</b></span>
                <span>{{$parented->passport->series}}</span>
                <span>{{$parented->passport->number}}</span>
                <span>выдан: {{$parented->passport->issuedby}}</span>
                <span>
                    {{ \Carbon\Carbon::parse($parented->passport->dateissue)->format('d.m.Y')}}</span>
            </p>
        </div>
    </div>
    <div id="title">
        <p id="p"><strong>Согласие родителя (законного представителя)</strong></p>
        <p id="p"><strong>на обработку персональных данных несовершеннолетнего</strong></p>
    </div>
    <div id="main_block">
        <p id="p">Я, <u>{{$parented->user->secondname.' '.$parented->user->firstname.' '.$parented->user->patronymic}}</u>,
            являясь <u>родителем</u> (законным представителем) несовершеннолетнего
            <u>{{morphos\Russian\inflectName($athlete->user->secondname.' '.$athlete->user->firstname.' '.$athlete->user->patronymic, 'родительный')}}</u>,
            приходящегося мне
            <u>
                @if($athlete->gender === \App\Models\Athlete::GENDER_MALE)
                сыном
                    @else
                дочерью
                    @endif
            </u>,
            зарегистрированного по адресу: <u>{{$athlete->user->address->max('address')}}</u>,
            <u>
                @if(Carbon\Carbon::parse($athlete->user->date_of_birth)->diffInYears() >= 14)
                    паспорт {{$athlete->passport->series}} {{$athlete->passport->number}},
                    выдан: {{$athlete->passport->issuedby}},
                    {{ \Carbon\Carbon::parse($athlete->passport->dateissue)->format('d.m.Y')}}
                @endif
                @if(Carbon\Carbon::parse($athlete->user->date_of_birth)->diffInYears() < 14)
                        свидетельство о рождении {{$athlete->birthcertificate->series}} {{$athlete->birthcertificate->number}},
                    выдан: {{$athlete->birthcertificate->issuedby}},
                        {{ \Carbon\Carbon::parse($athlete->birthcertificate->dateissue)->format('d.m.Y')}}
                @endif
            </u>
            <br>
            в соответствии со статьей 9 Федерального закона от 27.07.2006 № 152-ФЗ даю согласие Волгоградской
            региональной общественной организации «Волгоградская Федерация тхэквондо»(далее - ФЕДЕРАЦИЯ)
            (ИНН 3442099810, ОГРН 1083400007503), расположенному по адресу, 400001, г. Волгоград, ул. Циолковского, д.
            18,
            на обработку персональных данных в ФЕДЕРАЦИИ включающую в себя следующие действия: сбор, запись,
            систематизацию,
            накопление, хранение, уточнение (обновление, изменение), извлечение, использование, передачу
            (распространение,
            предоставление, доступ), блокирование, удаление, уничтожение персональных данных моих персональных данных в
            целях:
        </p>
        <p id="p">- обеспечения соблюдения Конституции Российской Федерации, федеральных законов и иных нормативных
            правовых актов Российской Федерации;</p>
        <p id="p">- исполнения судебных актов, актов других органов или должностных лиц, подлежащих исполнению в
            соответствии с законодательством Российской Федерации об исполнительном производстве;</p>
        <p id="p">- проведения учебно-ознакомительной и преддипломной практики;</p>
        <p id="p">- организации и оформления награждений, поощрений, проведении аттестации работников;</p>
        <p id="p">- организации постановки на индивидуальный (персонифицированный) учет спортсменов в системах
            лицензирования, аттестации спортсменов, электронной регистрации участников соревнований, страхования
            спортсменов;</p>
        <p id="p">- выполнения задач и функций ФЕДЕРАЦИИ в рамках осуществления видов деятельности, предусмотренных
            Уставом ФЕДЕРАЦИИ и иными локальными нормативными актами ФЕДЕРАЦИИ;</p>
        <p id="p">- ведения списков ФЕДЕРАЦИИ, предусмотренных законодательством Российской Федерации, Уставом ФЕДЕРАЦИИ
            и иными локальными нормативными актами ФЕДЕРАЦИИ;</p>
        <p id="p">- заполнения и передачи в органы исполнительной власти и иные уполномоченные организации требуемых
            форм отчетности, заявок на участие в спортивных мероприятиях;</p>
        <p id="p">- подготовки, заключения, исполнения и прекращения гражданско-правовых договоров;</p>
        <p id="p">- формирования справочных материалов для внутреннего информационного обеспечения деятельности
            ФЕДЕРАЦИИ;</p>
        <p id="p">- обеспечения пропускного режима в здания и объекты спорта ФЕДЕРАЦИИ;</p>
        <p id="p">- обеспечения установленных законодательством Российской Федерации условий труда, гарантий,
            компенсаций и оздоровительного отдыха;</p>
        <p id="p">- осуществления спортивной подготовки по видам спорта, выполнения государственного задания;</p>
        <p id="p">- предоставления сведений о бывших государственных гражданских и муниципальных служащих;</p>
        <p id="p">- оформление спортивных званий и разрядов;</p>
        <p id="p">- организация медицинского обеспечения.</p>
        <p id="p"><strong>К моим персональным данным относится следующая информация:</strong></p>
        <p id="p">1. Фамилия, имя, отчество (в том числе прежние фамилия, имя или отчество в случае их изменения, когда,
            где и по какой причине изменяли);</p>
        <p id="p">2. Фотография;</p>
        <p id="p">3. Число, месяц, год рождения;</p>
        <p id="p">4. Место рождения;</p>
        <p id="p">5. Информация о гражданстве (в том числе прежние гражданства, иные гражданства);</p>
        <p id="p">6. Сведения об образовании, в том числе о послевузовском профессиональном образовании (наименование и
            год окончания образовательной организации, наименование и реквизиты документа об образовании, квалификация,
            специальность по документу об образовании);</p>
        <p id="p">7. Сведения о профессиональной переподготовке и (или) повышении квалификации;</p>
        <p id="p">8. Сведения об ученой степени, ученом звании;</p>
        <p id="p">9. Информация о владении иностранными языками, степень владения;</p>
        <p id="p">10. Серия, номер документа, удостоверяющего личность, наименование органа, выдавшего его, дата
            выдачи;</p>
        <p id="p">11. Место жительства (адрес регистрации, фактического проживания) и адреса прежних мест
            жительства;</p>
        <p id="p">12. Номер телефона (либо иной вид связи);</p>
        <p id="p">13. Реквизиты страхового свидетельства обязательного пенсионного страхования;</p>
        <p id="p">14. Идентификационный номер налогоплательщика;</p>
        <p id="p">15. Реквизиты полиса обязательного медицинского страхования;</p>
        <p id="p">16. Семейное положение, состав семьи и сведения о близких родственниках (в том числе бывших);</p>
        <p id="p">17. Сведения о наличии (отсутствии) в собственности жилых помещений;</p>
        <p id="p">18. Информация, содержащаяся в свидетельствах о государственной регистрации актов гражданского
            состояния;</p>
        <p id="p">19. Информация о наличии/отсутствия судимости;</p>
        <p id="p">20. Номер банковского счета;</p>
        <p id="p">21. Номер банковской карты;</p>
        <p id="p">22. Спортивный разряд, спортивные звания;</p>
        <p id="p">Согласен на осуществление ФЕДЕРАЦИЕЙ любых действий в отношении моих персональных данных, которые
            необходимы
            или желаемы для достижения указанных целей, в том числе выражаю согласие на обработку без ограничения моих
            персональных данных, включая сбор, систематизацию, накопление, хранение, уточнение, использование,
            распространение,
            обезличивание, блокирование, уничтожение персональных данных при автоматизированной и без использования
            средств
            автоматизации обработке; запись на электронные носители и их хранение; передачу ФЕДЕРАЦИЕЙ по своему
            усмотрению
            данных и соответствующих документов, содержащих персональные данные, третьим лицам: налоговым органам, в
            отделения
            государственных внебюджетных фондов, администрации Волгоградской области, администрации города Волгограда,
            комитету
            физической культуры и спорта Волгоградской области, комитету физической культуры и спорта города Волгограда,
            правоохранительным, надзорным и судебным органам по соответствующим запросам и распоряжениям, министерству
            физической
            культуры и спорта России, общественным организациям (федерациям спорта), спортивным клубам, спортивным
            школам,
            международным спортивным организациям в связи с оформлением заявок на участие в соревнованиях, аттестациях,
            семинарах,
            тренировочных мероприятиях.</p>
        <p id="p">Настоящее согласие на обработку персональных данных действует с момента представления бессрочно и
            может быть
            отозвано мной при представлении ФЕДЕРАЦИИ заявления в простой письменной форме.</p>
        <p id="p">Обязуюсь сообщать в семидневный срок об изменении местожительства, контактных телефонов, паспортных,
            документных и иных персональных данных. Об ответственности за достоверность представленных персональных
            сведений
            предупрежден.</p>
        <p id="p">Я подтверждаю, что, давая такое согласие, я действую по собственной воле и в интересах
            несовершеннолетнего.</p>
    </div>
    <div id="parented_agreement_footer">
        <span>{{\Carbon\Carbon::now()->format('d.m.Y')}}</span>
        <span>__________________________________________</span>
        <span>{{$parented->user->secondname.' '.mb_substr($parented->user->firstname, 0,1).'.'.mb_substr($parented->user->patronymic, 0,1).'.'}}</span>
    </div>
</div>
@endforeach
</body>
</html>
