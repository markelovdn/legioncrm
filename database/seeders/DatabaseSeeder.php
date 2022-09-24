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

        District::insert([[
            'fulltitle'=>'Южный федеральный округ',
            'shorttitle'=>'ЮФО'
        ]]);

        Region::insert([[
            'title'=>'Волгоградская область',
            'code'=>'34'
        ]]);
    }
}
