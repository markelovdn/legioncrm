<?php

namespace Database\Seeders;

use App\Models\Age;
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
use App\Models\SportsCategoriesTitle;
use App\Models\SportsCategory;
use App\Models\StudyPlace;
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
//        Coach::factory(3)->create();
//        Parented::factory(3)->create();
//        Athlete::factory(3)
//            ->hasAttached(Group::factory()->count(3), [
//                'created_at'=>Factory::create()->dateTime,
//                'updated_at'=>Factory::create()->dateTime])
//            ->hasAttached(Coach::factory()->count(3), [
//                'coach_type'=>Factory::create()->randomElement(['1','2','3','4']),
//                'created_at'=>Factory::create()->dateTime,
//                'updated_at'=>Factory::create()->dateTime])
//            ->hasAttached(Organization::factory()->count(3), [
//                'org_type'=>Factory::create()->randomElement(['1','2']),
//                'created_at'=>Factory::create()->dateTime,
//                'updated_at'=>Factory::create()->dateTime])
//            ->hasAttached(Department::factory()->count(3), [
//                'created_at'=>Factory::create()->dateTime,
//                'updated_at'=>Factory::create()->dateTime])
//            ->hasAttached(Parented::factory()->count(3), [
//                'parented_type'=>Factory::create()->randomElement(['1','2']),
//                'created_at'=>Factory::create()->dateTime,
//                'updated_at'=>Factory::create()->dateTime])
//            ->create();
//        Attestation::factory(3)->create();
//        AttestationResult::factory(3)->create();
//        Competition::factory(3)->create();
//        CompetitionsRanksPoint::factory(3)->create();
//        CompetitionsResult::factory(3)->create();
//        Decree::factory(3)->create();
//        Organization::factory(3)->create();
//        Department::factory(3)->create();
//        WorkPlace::factory(3)->create();
//        Group::factory(3)->create();
//        WeightCategory::factory(3)->create();
//        Insurance::factory(3)->create();
//        KindsOfSport::factory(3)->create();
//        License::factory(3)->create();
//        MedicalInspection::factory(3)->create();
//
//        Payment::factory(3)->create();
//        SportsCategory::factory(3)->create(); //Ошибка повторного сида
//        StudyPlace::factory(3)->create();

        Role::insert([
            ['id' => 1, 'name' => 'Администратор системы'],
            ['id' => 2, 'name' => 'Администратор организации'],
            ['id' => 3, 'name' => 'Руководитель организации'],
            ['id' => 4, 'name' => 'Тренер'],
            ['id' => 5, 'name' => 'Родитель'],
            ['id' => 6, 'name' => 'Спортсмен']
        ]);

        User::insert([
            'secondname' => 'Маркелов',
            'firstname' => 'Дмитрий',
            'patronymic' => 'Николаевич',
            'date_of_birth' => '1983-10-08',
            'email' => 'markelovdn@gmail.com',
            'phone' => '+7 (961) 087-67-12',
            'role_id' => '4',
            'password' => '123123',

        ]);

        Coach::insert([
            'user_id' => '1',
            'coach_code' => '1234',
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
    }
}
