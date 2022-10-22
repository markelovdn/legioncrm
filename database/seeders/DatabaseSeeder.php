<?php

namespace Database\Seeders;

use App\Models\Age;
use App\Models\AgeCategory;
use App\Models\Athlete;
use App\Models\Attestation;
use App\Models\AttestationResult;
use App\Models\BirthCertificate;
use App\Models\Coach;
use App\Models\Competition;
use App\Models\CompetitionsRanksPoint;
use App\Models\CompetitionsResult;
use App\Models\Country;
use App\Models\Decree;
use App\Models\Department;
use App\Models\District;
use App\Models\Group;
use App\Models\Insurance;
use App\Models\KindsOfSport;
use App\Models\License;
use App\Models\MedicalInspection;
use App\Models\Organization;
use App\Models\ParentedAthlete;
use App\Models\Parented;
use App\Models\Payment;
use App\Models\PaymentsTitle;
use App\Models\Region;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Sportkval;
use App\Models\SportsCategoriesTitle;
use App\Models\SportsCategory;
use App\Models\StudyPlace;
use App\Models\Tehkval;
use App\Models\TehkvalGroup;
use App\Models\Tqtitle;
use App\Models\User;
use App\Models\WeightCategory;
use App\Models\WorkPlace;
use Database\Factories\DepartmentFactory;
use Database\Factories\PaymentFactory;
use Database\Factories\PaymentsTitleFactory;
use Database\Factories\PaymentTitleFactory;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([
            ['code' => 'system_admin', 'name' => 'Администратор системы'],
            ['code' => 'organization_admin', 'name' => 'Администратор организации'],
            ['code' => 'organization_chairman', 'name' => 'Руководитель организации'],
            ['code' => 'coach', 'name' => 'Тренер'],
            ['code' => 'parented', 'name' => 'Родитель'],
            ['code' => 'athlete', 'name' => 'Спортсмен'],
            ['code' => 'referee', 'name' => 'Судья']
        ]);

        Organization::insert([
            ['fulltitle'=>'Волгоградская региональная детско-юношеская спортивная общественная организация "Спортивный клуб "Легион"',
            'address'=>'Волгоградская область, Городищенский район, п. Каменный, д. 17, кв. 1',
            'shorttitle'=>'ВРДЮСОО СК "Легион"',
            'code'=>'2217'],
            ['fulltitle'=>'Волгоградская региональная общественная организация "Спортивный клуб "Дубовский чемпион"',
            'address'=>'Волгоградская область, Дубовский район',
            'shorttitle'=>'ВРОО СК "Дубовский чемпион"',
            'code'=>'2234']

        ]);

        Country::insert([[
            'title'=>'Россия',
            'code'=>'RU'
        ]]);

        District::insert([
            ['fulltitle'=>'Южный федеральный округ','shorttitle'=>'ЮФО'],
            ['fulltitle'=>'Центральный федеральный округ','shorttitle'=>'ЦФО'],
            ['fulltitle'=>'Северо-Западный федеральный округ','shorttitle'=>'СЗФО'],
            ['fulltitle'=>'Северо-Кавказский федеральный округ','shorttitle'=>'СКФО'],
            ['fulltitle'=>'Приволжский федеральный округ','shorttitle'=>'ПФО'],
            ['fulltitle'=>'Уральский федеральный округ','shorttitle'=>'УрФО'],
            ['fulltitle'=>'Сибирский федеральный округ','shorttitle'=>'СФО'],
            ['fulltitle'=>'Дальневосточный федеральный округ','shorttitle'=>'ДвФО'],

        ]);

        Region::insert([
            ['title'=>'Республика Адыгея', 'code'=>'1'],
            ['title'=>'Республика Башкортостан', 'code'=>'2'],
            ['title'=>'Республика Бурятия', 'code'=>'3'],
            ['title'=>'Республика Алтай (Горный Алтай)', 'code'=>'4'],
            ['title'=>'Республика Дагестан', 'code'=>'5'],
            ['title'=>'Республика Ингушетия', 'code'=>'6'],
            ['title'=>'Кабардино-Балкарская Республика', 'code'=>'7'],
            ['title'=>'Республика Калмыкия', 'code'=>'8'],
            ['title'=>'Республика Карачаево-Черкессия', 'code'=>'9'],
            ['title'=>'Республика Карелия', 'code'=>'10'],
            ['title'=>'Республика Коми', 'code'=>'11'],
            ['title'=>'Республика Марий Эл', 'code'=>'12'],
            ['title'=>'Республика Мордовия', 'code'=>'13'],
            ['title'=>'Республика Саха (Якутия)', 'code'=>'14'],
            ['title'=>'Республика Северная Осетия-Алания', 'code'=>'15'],
            ['title'=>'Республика Татарстан', 'code'=>'16'],
            ['title'=>'Республика Тыва', 'code'=>'17'],
            ['title'=>'Удмуртская Республика', 'code'=>'18'],
            ['title'=>'Республика Хакасия', 'code'=>'19'],
            ['title'=>'Чувашская Республика', 'code'=>'21'],
            ['title'=>'Алтайский край', 'code'=>'22'],
            ['title'=>'Краснодарский край', 'code'=>'23'],
            ['title'=>'Красноярский край', 'code'=>'24'],
            ['title'=>'Приморский край', 'code'=>'25'],
            ['title'=>'Ставропольский край', 'code'=>'26'],
            ['title'=>'Хабаровский край', 'code'=>'27'],
            ['title'=>'Амурская область', 'code'=>'28'],
            ['title'=>'Архангельская область', 'code'=>'29'],
            ['title'=>'Астраханская область', 'code'=>'30'],
            ['title'=>'Белгородская область', 'code'=>'31'],
            ['title'=>'Брянская область', 'code'=>'32'],
            ['title'=>'Владимирская область', 'code'=>'33'],
            ['title'=>'Волгоградская область', 'code'=>'34'],
            ['title'=>'Вологодская область', 'code'=>'35'],
            ['title'=>'Воронежская область', 'code'=>'36'],
            ['title'=>'Ивановская область', 'code'=>'37'],
            ['title'=>'Иркутская область', 'code'=>'38'],
            ['title'=>'Калининградская область', 'code'=>'39'],
            ['title'=>'Калужская область', 'code'=>'40'],
            ['title'=>'Камчатский край', 'code'=>'41'],
            ['title'=>'Кемеровская область', 'code'=>'42'],
            ['title'=>'Кировская область', 'code'=>'43'],
            ['title'=>'Костромская область', 'code'=>'44'],
            ['title'=>'Курганская область', 'code'=>'45'],
            ['title'=>'Курская область', 'code'=>'46'],
            ['title'=>'Ленинградская область', 'code'=>'47'],
            ['title'=>'Липецкая область', 'code'=>'48'],
            ['title'=>'Магаданская область', 'code'=>'49'],
            ['title'=>'Московская область', 'code'=>'50'],
            ['title'=>'Мурманская область', 'code'=>'51'],
            ['title'=>'Нижегородская область', 'code'=>'52'],
            ['title'=>'Новгородская область', 'code'=>'53'],
            ['title'=>'Новосибирская область', 'code'=>'54'],
            ['title'=>'Омская область', 'code'=>'55'],
            ['title'=>'Оренбургская область', 'code'=>'56'],
            ['title'=>'Орловская область', 'code'=>'57'],
            ['title'=>'Пензенская область', 'code'=>'58'],
            ['title'=>'Пермский край', 'code'=>'59'],
            ['title'=>'Псковская область', 'code'=>'60'],
            ['title'=>'Ростовская область', 'code'=>'61'],
            ['title'=>'Рязанская область', 'code'=>'62'],
            ['title'=>'Самарская область', 'code'=>'63'],
            ['title'=>'Саратовская область', 'code'=>'64'],
            ['title'=>'Сахалинская область', 'code'=>'65'],
            ['title'=>'Свердловская область', 'code'=>'66'],
            ['title'=>'Смоленская область', 'code'=>'67'],
            ['title'=>'Тамбовская область', 'code'=>'68'],
            ['title'=>'Тверская область', 'code'=>'69'],
            ['title'=>'Томская область', 'code'=>'70'],
            ['title'=>'Тульская область', 'code'=>'71'],
            ['title'=>'Тюменская область', 'code'=>'72'],
            ['title'=>'Ульяновская область', 'code'=>'73'],
            ['title'=>'Челябинская область', 'code'=>'74'],
            ['title'=>'Забайкальский край', 'code'=>'75'],
            ['title'=>'Ярославская область', 'code'=>'76'],
            ['title'=>'Москва', 'code'=>'77'],
            ['title'=>'Санкт-Петербург', 'code'=>'78'],
            ['title'=>'Еврейская автономная область', 'code'=>'79'],
            ['title'=>'Республика Крым', 'code'=>'82'],
            ['title'=>'Ненецкий автономный округ', 'code'=>'83'],
            ['title'=>'Ханты-Мансийский автономный округ-Югра', 'code'=>'86'],
            ['title'=>'Чукотский автономный округ', 'code'=>'87'],
            ['title'=>'Ямало-Ненецкий автономный округ', 'code'=>'89'],
            ['title'=>'Севастополь', 'code'=>'92'],
            ['title'=>'Чеченская республика', 'code'=>'95'],
        ]);

        AgeCategory::insert([
            ['title' => 'Дети 8-9 лет',  'age_start' => '8', 'age_finish' => '9'],
            ['title' => 'Дети 10-11 лет',  'age_start' => '10', 'age_finish' => '11'],
            ['title' => 'Юноши 12-14 лет',  'age_start' => '12', 'age_finish' => '14'],
            ['title' => 'Юниоры 15-17 лет',  'age_start' => '15', 'age_finish' => '17'],
            ['title' => 'Юниоры до 21 года',  'age_start' => '16', 'age_finish' => '20'],
            ['title' => 'Взрослые',  'age_start' => '17', 'age_finish' => '100']
        ]);

        Tehkval::insert([
            ['title' => 'Нет',  'belt_color' => 'Нет'],
            ['title' => '10 гып',  'belt_color' => 'Белый'],
            ['title' => '9 ып',  'belt_color' => 'Бело-желтый'],
            ['title' => '8 гып',  'belt_color' => 'Желтый'],
            ['title' => '7 гып',  'belt_color' => 'Желто-зеленый'],
            ['title' => '6 гып',  'belt_color' => 'Зеленый'],
            ['title' => '5 гып',  'belt_color' => 'Зелено-синий'],
            ['title' => '4 гып',  'belt_color' => 'Синий'],
            ['title' => '3 гып',  'belt_color' => 'Сине-красный'],
            ['title' => '2 гып',  'belt_color' => 'Красный'],
            ['title' => '1 гып',  'belt_color' => 'Коричневый'],
            ['title' => '1 пум/дан',  'belt_color' => 'Черный'],
            ['title' => '2 пум/дан',  'belt_color' => 'Черный'],
            ['title' => '3 дан',  'belt_color' => 'Черный'],
            ['title' => '4 дан',  'belt_color' => 'Черный'],
            ['title' => '5 дан',  'belt_color' => 'Черный'],
        ]);

        Sportkval::insert([
        ['short_title' => 'Нет', 'full_title' => 'Нет'],
        ['short_title' => '3 юн.', 'full_title' => '3 юношеский'],
        ['short_title' => '2 юн.', 'full_title' => '2 юношеский'],
        ['short_title' => '1 юн.', 'full_title' => '1 юношеский'],
        ['short_title' => '3 р.', 'full_title' => '3 разряд'],
        ['short_title' => '2 р.', 'full_title' => '2 разряд'],
        ['short_title' => '1 р.', 'full_title' => '1 разряд'],
        ['short_title' => 'КМС', 'full_title' => 'Кандидат в мастера спорта'],
        ['short_title' => 'МС', 'full_title' => 'Мастер спорта'],
        ['short_title' => 'МСМК', 'full_title' => 'Мастер спорта международного класса']
        ]);

        WeightCategory::insert([
            ['title'=> 'до 45 кг.','gender'=>1,'weight_start'=>  '30','weight_finish'=> '45.09','agecategory_id'=> '4'],
            ['title'=> 'до 48 кг.','gender'=>1,'weight_start'=>  '45.1','weight_finish'=> '48.09','agecategory_id'=> '4'],
            ['title'=> 'до 51 кг.','gender'=>1,'weight_start'=>  '48.1','weight_finish'=> '51.09','agecategory_id'=> '4'],
            ['title'=> 'до 55 кг.','gender'=>1,'weight_start'=>  '51.1','weight_finish'=> '55.09','agecategory_id'=> '4'],
            ['title'=> 'до 59 кг.','gender'=>1,'weight_start'=>  '55.1','weight_finish'=> '59.09','agecategory_id'=> '4'],
            ['title'=> 'до 63 кг.','gender'=>1,'weight_start'=>  '59.1','weight_finish'=> '63.09','agecategory_id'=> '4'],
            ['title'=> 'до 68 кг.','gender'=>1,'weight_start'=>  '63.1','weight_finish'=> '68.09','agecategory_id'=> '4'],
            ['title'=> 'до 73 кг.','gender'=>1,'weight_start'=>  '68.1','weight_finish'=> '73.09','agecategory_id'=> '4'],
            ['title'=> 'до 78 кг.','gender'=>1,'weight_start'=>  '73.1','weight_finish'=> '78.09','agecategory_id'=> '4'],
            ['title'=> 'св. 78 кг.','gender'=>1,'weight_start'=>  '78.1','weight_finish'=> '200','agecategory_id'=> '4'],
            ['title'=> 'до 42 кг.','gender'=>2,'weight_start'=>  '25','weight_finish'=> '42.09','agecategory_id'=> '4'],
            ['title'=> 'до 44 кг.','gender'=>2,'weight_start'=>  '42.1','weight_finish'=> '44.09','agecategory_id'=> '4'],
            ['title'=> 'до 46 кг.','gender'=>2,'weight_start'=>  '44.1','weight_finish'=> '46.09','agecategory_id'=> '4'],
            ['title'=> 'до 49 кг.','gender'=>2,'weight_start'=>  '46.1','weight_finish'=> '49.09','agecategory_id'=> '4'],
            ['title'=> 'до 52 кг.','gender'=>2,'weight_start'=>  '49.1','weight_finish'=> '52.09','agecategory_id'=> '4'],
            ['title'=> 'до 55 кг.','gender'=>2,'weight_start'=>  '52.1','weight_finish'=> '55.09','agecategory_id'=> '4'],
            ['title'=> 'до 59 кг.','gender'=>2,'weight_start'=>  '55.1','weight_finish'=> '59.09','agecategory_id'=> '4'],
            ['title'=> 'до 63 кг.','gender'=>2,'weight_start'=>  '59.1','weight_finish'=> '63.09','agecategory_id'=> '4'],
            ['title'=> 'до 68 кг.','gender'=>2,'weight_start'=>  '63.1','weight_finish'=> '68.09','agecategory_id'=> '4'],
            ['title'=> 'св. 68 кг.','gender'=>2,'weight_start'=>  '68.1','weight_finish'=> '200','agecategory_id'=> '4'],
            ['title'=> 'до 33 кг.','gender'=>1,'weight_start'=>  '20','weight_finish'=> '33.09','agecategory_id'=> '3'],
            ['title'=> 'до 37 кг.','gender'=>1,'weight_start'=>  '33.1','weight_finish'=> '37.09','agecategory_id'=> '3'],
            ['title'=> 'до 41 кг.','gender'=>1,'weight_start'=>  '37.1','weight_finish'=> '41.09','agecategory_id'=> '3'],
            ['title'=> 'до 45 кг.','gender'=>1,'weight_start'=>  '41.1','weight_finish'=> '45.09','agecategory_id'=> '3'],
            ['title'=> 'до 49 кг.','gender'=>1,'weight_start'=>  '45.1','weight_finish'=> '49.09','agecategory_id'=> '3'],
            ['title'=> 'до 53 кг.','gender'=>1,'weight_start'=>  '49.1','weight_finish'=> '53.09','agecategory_id'=> '3'],
            ['title'=> 'до 57 кг.','gender'=>1,'weight_start'=>  '53.1','weight_finish'=> '57.09','agecategory_id'=> '3'],
            ['title'=> 'до 61 кг.','gender'=>1,'weight_start'=>  '57.1','weight_finish'=> '61.09','agecategory_id'=> '3'],
            ['title'=> 'до 65 кг.','gender'=>1,'weight_start'=>  '61.1','weight_finish'=> '65.09','agecategory_id'=> '3'],
            ['title'=> 'св. 65 кг.','gender'=>1,'weight_start'=>  '65.1','weight_finish'=> '200','agecategory_id'=> '3'],
            ['title'=> 'до 29 кг.','gender'=>2,'weight_start'=>  '15','weight_finish'=> '29.09','agecategory_id'=> '3'],
            ['title'=> 'до 33 кг.','gender'=>2,'weight_start'=>  '29.1','weight_finish'=> '33.09','agecategory_id'=> '3'],
            ['title'=> 'до 37 кг.','gender'=>2,'weight_start'=>  '33.1','weight_finish'=> '37.09','agecategory_id'=> '3'],
            ['title'=> 'до 41 кг.','gender'=>2,'weight_start'=>  '37.1','weight_finish'=> '41.09','agecategory_id'=> '3'],
            ['title'=> 'до 44 кг.','gender'=>2,'weight_start'=>  '41.1','weight_finish'=> '44.09','agecategory_id'=> '3'],
            ['title'=> 'до 47 кг.','gender'=>2,'weight_start'=>  '44.1','weight_finish'=> '47.09','agecategory_id'=> '3'],
            ['title'=> 'до 51 кг.','gender'=>2,'weight_start'=>  '47.1','weight_finish'=> '51.09','agecategory_id'=> '3'],
            ['title'=> 'до 55 кг.','gender'=>2,'weight_start'=>  '51.1','weight_finish'=> '55.09','agecategory_id'=> '3'],
            ['title'=> 'до 59 кг.','gender'=>2,'weight_start'=>  '55.1','weight_finish'=> '59.09','agecategory_id'=> '3'],
            ['title'=> 'св. 59 кг.','gender'=>2,'weight_start'=>  '59.1','weight_finish'=> '200','agecategory_id'=> '3'],
            ['title'=> 'до 27 кг.','gender'=>1,'weight_start'=>  '15','weight_finish'=> '27.09','agecategory_id'=> '2'],
            ['title'=> 'до 30 кг.','gender'=>1,'weight_start'=>  '27.1','weight_finish'=> '30.09','agecategory_id'=> '2'],
            ['title'=> 'до 33 кг.','gender'=>1,'weight_start'=>  '30.1','weight_finish'=> '33.09','agecategory_id'=> '2'],
            ['title'=> 'до 36 кг.','gender'=>1,'weight_start'=>  '33.1','weight_finish'=> '36.09','agecategory_id'=> '2'],
            ['title'=> 'до 40 кг.','gender'=>1,'weight_start'=>  '36.1','weight_finish'=> '40.09','agecategory_id'=> '2'],
            ['title'=> 'до 44 кг.','gender'=>1,'weight_start'=>  '40.1','weight_finish'=> '44.09','agecategory_id'=> '2'],
            ['title'=> 'до 48 кг.','gender'=>1,'weight_start'=>  '44.1','weight_finish'=> '48.09','agecategory_id'=> '2'],
            ['title'=> 'до 52 кг.','gender'=>1,'weight_start'=>  '48.1','weight_finish'=> '52.09','agecategory_id'=> '2'],
            ['title'=> 'до 57 кг.','gender'=>1,'weight_start'=>  '52.1','weight_finish'=> '57.09','agecategory_id'=> '2'],
            ['title'=> 'св. 57 кг.','gender'=>1,'weight_start'=>  '57.1','weight_finish'=> '200','agecategory_id'=> '2'],
            ['title'=> 'до 27 кг.','gender'=>2,'weight_start'=>  '15','weight_finish'=> '27.09','agecategory_id'=> '2'],
            ['title'=> 'до 30 кг.','gender'=>2,'weight_start'=>  '27.1','weight_finish'=> '30.09','agecategory_id'=> '2'],
            ['title'=> 'до 33 кг.','gender'=>2,'weight_start'=>  '30.1','weight_finish'=> '33.09','agecategory_id'=> '2'],
            ['title'=> 'до 36 кг.','gender'=>2,'weight_start'=>  '33.1','weight_finish'=> '36.09','agecategory_id'=> '2'],
            ['title'=> 'до 40 кг.','gender'=>2,'weight_start'=>  '36.1','weight_finish'=> '40.09','agecategory_id'=> '2'],
            ['title'=> 'до 44 кг.','gender'=>2,'weight_start'=>  '40.1','weight_finish'=> '44.09','agecategory_id'=> '2'],
            ['title'=> 'до 48 кг.','gender'=>2,'weight_start'=>  '44.1','weight_finish'=> '48.09','agecategory_id'=> '2'],
            ['title'=> 'до 52 кг.','gender'=>2,'weight_start'=>  '48.1','weight_finish'=> '52.09','agecategory_id'=> '2'],
            ['title'=> 'до 57 кг.','gender'=>2,'weight_start'=>  '52.1','weight_finish'=> '57.09','agecategory_id'=> '2'],
            ['title'=> 'св. 57 кг.','gender'=>2,'weight_start'=>  '57.1','weight_finish'=> '200','agecategory_id'=> '2'],
            ['title'=> 'до 24 кг.','gender'=>1,'weight_start'=>  '15','weight_finish'=> '24.09','agecategory_id'=> '1'],
            ['title'=> 'до 26 кг.','gender'=>1,'weight_start'=>  '24.1','weight_finish'=> '26.09','agecategory_id'=> '1'],
            ['title'=> 'до 28 кг.','gender'=>1,'weight_start'=>  '26.1','weight_finish'=> '28.09','agecategory_id'=> '1'],
            ['title'=> 'до 30 кг.','gender'=>1,'weight_start'=>  '28.1','weight_finish'=> '30.09','agecategory_id'=> '1'],
            ['title'=> 'до 32 кг.','gender'=>1,'weight_start'=>  '30.1','weight_finish'=> '32.09','agecategory_id'=> '1'],
            ['title'=> 'до 34 кг.','gender'=>1,'weight_start'=>  '32.1','weight_finish'=> '34.09','agecategory_id'=> '1'],
            ['title'=> 'до 37 кг.','gender'=>1,'weight_start'=>  '34.1','weight_finish'=> '37.09','agecategory_id'=> '1'],
            ['title'=> 'до 41 кг.','gender'=>1,'weight_start'=>  '37.1','weight_finish'=> '41.09','agecategory_id'=> '1'],
            ['title'=> 'до 45 кг.','gender'=>1,'weight_start'=>  '41.1','weight_finish'=> '45.09','agecategory_id'=> '1'],
            ['title'=> 'св. 45 кг.','gender'=>1,'weight_start'=>  '45.1','weight_finish'=> '200','agecategory_id'=> '1'],
            ['title'=> 'до 24 кг.','gender'=>2,'weight_start'=>  '15','weight_finish'=> '24.09','agecategory_id'=> '1'],
            ['title'=> 'до 26 кг.','gender'=>2,'weight_start'=>  '24.1','weight_finish'=> '26.09','agecategory_id'=> '1'],
            ['title'=> 'до 28 кг.','gender'=>2,'weight_start'=>  '26.1','weight_finish'=> '28.09','agecategory_id'=> '1'],
            ['title'=> 'до 30 кг.','gender'=>2,'weight_start'=>  '28.1','weight_finish'=> '30.09','agecategory_id'=> '1'],
            ['title'=> 'до 32 кг.','gender'=>2,'weight_start'=>  '30.1','weight_finish'=> '32.09','agecategory_id'=> '1'],
            ['title'=> 'до 34 кг.','gender'=>2,'weight_start'=>  '32.1','weight_finish'=> '34.09','agecategory_id'=> '1'],
            ['title'=> 'до 37 кг.','gender'=>2,'weight_start'=>  '34.1','weight_finish'=> '37.09','agecategory_id'=> '1'],
            ['title'=> 'до 41 кг.','gender'=>2,'weight_start'=>  '37.1','weight_finish'=> '41.09','agecategory_id'=> '1'],
            ['title'=> 'до 45 кг.','gender'=>2,'weight_start'=>  '41.1','weight_finish'=> '45.09','agecategory_id'=> '1'],
            ['title'=> 'св. 45 кг.','gender'=>2,'weight_start'=>  '45.1','weight_finish'=> '200','agecategory_id'=> '1'],
            ['title'=> 'до 54 кг.','gender'=>1,'weight_start'=>  '45','weight_finish'=> '54.09','agecategory_id'=> '5'],
            ['title'=> 'до 58 кг.','gender'=>1,'weight_start'=>  '54.1','weight_finish'=> '58.09','agecategory_id'=> '5'],
            ['title'=> 'до 63 кг.','gender'=>1,'weight_start'=>  '58.1','weight_finish'=> '63.09','agecategory_id'=> '5'],
            ['title'=> 'до 68 кг.','gender'=>1,'weight_start'=>  '63.1','weight_finish'=> '68.09','agecategory_id'=> '5'],
            ['title'=> 'до 74 кг.','gender'=>1,'weight_start'=>  '68.1','weight_finish'=> '74.09','agecategory_id'=> '5'],
            ['title'=> 'до 80 кг.','gender'=>1,'weight_start'=>  '74.1','weight_finish'=> '80.09','agecategory_id'=> '5'],
            ['title'=> 'до 87 кг.','gender'=>1,'weight_start'=>  '80.1','weight_finish'=> '87.09','agecategory_id'=> '5'],
            ['title'=> 'св. 87 кг.','gender'=>1,'weight_start'=>  '87.1','weight_finish'=> '200','agecategory_id'=> '5'],
            ['title'=> 'до 46 кг.','gender'=>2,'weight_start'=>  '35','weight_finish'=> '46.09','agecategory_id'=> '5'],
            ['title'=> 'до 49 кг.','gender'=>2,'weight_start'=>  '46.1','weight_finish'=> '49.09','agecategory_id'=> '5'],
            ['title'=> 'до 53 кг.','gender'=>2,'weight_start'=>  '49.1','weight_finish'=> '53.09','agecategory_id'=> '5'],
            ['title'=> 'до 57 кг.','gender'=>2,'weight_start'=>  '53.1','weight_finish'=> '57.09','agecategory_id'=> '5'],
            ['title'=> 'до 62 кг.','gender'=>2,'weight_start'=>  '57.1','weight_finish'=> '62.09','agecategory_id'=> '5'],
            ['title'=> 'до 67 кг.','gender'=>2,'weight_start'=>  '62.1','weight_finish'=> '67.09','agecategory_id'=> '5'],
            ['title'=> 'до 73 кг.','gender'=>2,'weight_start'=>  '67.1','weight_finish'=> '73.09','agecategory_id'=> '5'],
            ['title'=> 'св. 73 кг.','gender'=>2,'weight_start'=>  '73.1','weight_finish'=> '200','agecategory_id'=> '5'],
            ['title'=> 'до 54 кг.','gender'=>1,'weight_start'=>  '45','weight_finish'=> '54.09','agecategory_id'=> '6'],
            ['title'=> 'до 58 кг.','gender'=>1,'weight_start'=>  '54.1','weight_finish'=> '58.09','agecategory_id'=> '6'],
            ['title'=> 'до 63 кг.','gender'=>1,'weight_start'=>  '58.1','weight_finish'=> '63.09','agecategory_id'=> '6'],
            ['title'=> 'до 68 кг.','gender'=>1,'weight_start'=>  '63.1','weight_finish'=> '68.09','agecategory_id'=> '6'],
            ['title'=> 'до 74 кг.','gender'=>1,'weight_start'=>  '68.1','weight_finish'=> '74.09','agecategory_id'=> '6'],
            ['title'=> 'до 80 кг.','gender'=>1,'weight_start'=>  '74.1','weight_finish'=> '80.09','agecategory_id'=> '6'],
            ['title'=> 'до 87 кг.','gender'=>1,'weight_start'=>  '80.1','weight_finish'=> '87.09','agecategory_id'=> '6'],
            ['title'=> 'св. 87 кг.','gender'=>1,'weight_start'=>  '87.1','weight_finish'=> '200','agecategory_id'=> '6'],
            ['title'=> 'до 46 кг.','gender'=>2,'weight_start'=>  '35','weight_finish'=> '46.09','agecategory_id'=> '6'],
            ['title'=> 'до 49 кг.','gender'=>2,'weight_start'=>  '46.1','weight_finish'=> '49.09','agecategory_id'=> '6'],
            ['title'=> 'до 53 кг.','gender'=>2,'weight_start'=>  '49.1','weight_finish'=> '53.09','agecategory_id'=> '6'],
            ['title'=> 'до 57 кг.','gender'=>2,'weight_start'=>  '53.1','weight_finish'=> '57.09','agecategory_id'=> '6'],
            ['title'=> 'до 62 кг.','gender'=>2,'weight_start'=>  '57.1','weight_finish'=> '62.09','agecategory_id'=> '6'],
            ['title'=> 'до 67 кг.','gender'=>2,'weight_start'=>  '62.1','weight_finish'=> '67.09','agecategory_id'=> '6'],
            ['title'=> 'до 73 кг.','gender'=>2,'weight_start'=>  '67.1','weight_finish'=> '73.09','agecategory_id'=> '6'],
            ['title'=> 'св. 73 кг.','gender'=>2,'weight_start'=>  '73.1','weight_finish'=> '200','agecategory_id'=> '6'],

        ]);

        TehkvalGroup::insert([
            ['title'=>'Группа С (до 8 гыпа)','startgyp_id'=> '1','finishgyp_id'=>  '4','agecategory_id'=>  '1'],
            ['title'=>'Группа B (от 7 до 4 гыпа)','startgyp_id'=> '5','finishgyp_id'=>  '8','agecategory_id'=>  '1'],
            ['title'=>'Группа А (от 3 и выше)','startgyp_id'=> '9','finishgyp_id'=>  '14','agecategory_id'=>  '1'],
            ['title'=>'Группа С (до 8 гыпа)','startgyp_id'=> '1','finishgyp_id'=>  '4','agecategory_id'=>  '2'],
            ['title'=>'Группа B (от 7 до 4 гыпа)','startgyp_id'=> '5','finishgyp_id'=>  '8','agecategory_id'=>  '2'],
            ['title'=>'Группа А (от 3 и выше)','startgyp_id'=> '9','finishgyp_id'=>  '14','agecategory_id'=>  '2'],
            ['title'=>'Группа С (до 8 гыпа)','startgyp_id'=> '1','finishgyp_id'=>  '4','agecategory_id'=>  '3'],
            ['title'=>'Группа B (от 7 до 4 гыпа)','startgyp_id'=> '5','finishgyp_id'=>  '8','agecategory_id'=>  '3'],
            ['title'=>'Группа А (от 3 и выше)','startgyp_id'=> '9','finishgyp_id'=>  '14','agecategory_id'=>  '3'],
            ['title'=>'Группа С (до 8 гыпа)','startgyp_id'=> '1','finishgyp_id'=>  '4','agecategory_id'=>  '4'],
            ['title'=>'Группа B (от 7 до 4 гыпа)','startgyp_id'=> '5','finishgyp_id'=>  '8','agecategory_id'=>  '4'],
            ['title'=>'Группа А (от 3 и выше)','startgyp_id'=> '9','finishgyp_id'=>  '14','agecategory_id'=>  '4'],
            ['title'=>'Группа С (до 8 гыпа)','startgyp_id'=> '1','finishgyp_id'=>  '4','agecategory_id'=>  '5'],
            ['title'=>'Группа B (от 7 до 4 гыпа)','startgyp_id'=> '5','finishgyp_id'=>  '8','agecategory_id'=>  '5'],
            ['title'=>'Группа А (от 3 и выше)','startgyp_id'=> '9','finishgyp_id'=>  '14','agecategory_id'=>  '5'],
            ['title'=>'Группа С (до 8 гыпа)','startgyp_id'=> '1','finishgyp_id'=>  '4','agecategory_id'=>  '6'],
            ['title'=>'Группа B (от 7 до 4 гыпа)','startgyp_id'=> '5','finishgyp_id'=>  '8','agecategory_id'=>  '6'],
            ['title'=>'Группа А (от 3 и выше)','startgyp_id'=> '9','finishgyp_id'=>  '14','agecategory_id'=>  '6'],

        ]);

        User::factory(3)->create();

        Coach::factory(3)->create();
        Parented::factory(3)->create();
        Attestation::factory(3)->create();
        AttestationResult::factory(3)->create();
        Competition::factory(3)->create();
        CompetitionsRanksPoint::factory(3)->create();
        CompetitionsResult::factory(3)->create();
        Decree::factory(3)->create();
        Department::factory(3)->create();
        WorkPlace::factory(3)->create();
        Group::factory(3)->create();
        Insurance::factory(3)->create();
        KindsOfSport::factory(3)->create();
        License::factory(3)->create();
        MedicalInspection::factory(3)->create();
        Payment::factory(3)->create();
        StudyPlace::factory(3)->create();
        Athlete::factory(3)
            ->hasAttached(Parented::factory(3))
            ->create();

        DB::table('role_user')->insert([
                ['role_id' => 1, 'user_id' => 1],
                ['role_id' => 2, 'user_id' => 2],
                ['role_id' => 3, 'user_id' => 3],
                ['role_id' => 4, 'user_id' => 4],
                ['role_id' => 5, 'user_id' => 5],
                ['role_id' => 6, 'user_id' => 6],
                ['role_id' => 7, 'user_id' => 7],
            ]
        );


    }
}
