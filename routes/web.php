<?php

use App\Http\Controllers\CompetitorsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('user', \App\Http\Controllers\UsersController::class);
Route::resource('organization', \App\Http\Controllers\OrganizationController::class)->middleware(['auth']);
Route::resource('coach', \App\Http\Controllers\CoachController::class)->middleware(['auth', 'coach']);
Route::resource('referee', \App\Http\Controllers\RefereesController::class)->middleware(['auth', 'referee']);
Route::resource('parented', \App\Http\Controllers\ParentedsController::class)->middleware(['auth', 'parented']);
Route::resource('athlete', \App\Http\Controllers\AthletesController::class)->middleware(['auth']);
Route::resource('tehkval', \App\Http\Controllers\TehkvalsController::class)->middleware(['auth']);
Route::resource('passport', \App\Http\Controllers\PassportController::class)->middleware(['auth']);
Route::resource('birthcertificate', \App\Http\Controllers\BirthCertificateController::class)->middleware(['auth']);
Route::resource('studyplace', \App\Http\Controllers\StudyPlaceController::class)->middleware(['auth']);
Route::resource('addresses', \App\Http\Controllers\AddressesController::class)->middleware(['auth']);
//Route::resource('competitors', \App\Http\Controllers\Api\V1\CompetitorsController::class);
Route::resource('competitions', \App\Http\Controllers\CompetitionsController::class);
Route::resource('competitions.competitors', \App\Http\Controllers\CompetitorsController::class)->shallow()->middleware(['auth']);
Route::any('/competitions/{id}/competitors-new-user', [\App\Http\Controllers\CompetitorsController::class, 'store_as_new_user']);
Route::resource('competitions.tehkvalgroups', \App\Http\Controllers\TehkvalGroupsController::class)->shallow()->middleware(['auth']);
Route::get('/competitorsExport', [CompetitorsController::class, 'competitorsExport'])->middleware('auth')->name('competitorsExport');
Route::resource('role-user', \App\Http\Controllers\RoleUserController::class)->middleware(['auth', 'system_admin']);
Route::resource('grade', \App\Http\Controllers\GradesCntroller::class)->middleware(['auth']);
Route::resource('payment', \App\Http\Controllers\PaymentsController::class)->middleware(['auth']);
Route::post('setNamePoomsaeTablo', [\App\Http\Controllers\GradesCntroller::class, 'setName'])->middleware(['auth'])->name('setNamePoomsaeTablo');


Route::get('coach/{id}/athletes', [\App\Http\Controllers\CoachController::class, 'show'])->middleware(['auth']);

//Route::view('/poomsae-tablo', 'competitions.poomsae.poomsae-tablo')->name('poomsae-tablo');
Route::get('/poomsae-competitors', [\App\Http\Controllers\CompetitorsController::class, 'addCompetitorsToPoomsaeTablo'])->name('poomsae-competitors');

Route::get('/loginAs', function (\Illuminate\Http\Request $request) {
    $id = $request->get('id');
     \Illuminate\Support\Facades\Auth::loginUsingId($id);
    return back();
})->middleware(['auth', 'system_admin'])->name('loginas');

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
}); //Сделал отдельный метод потомучто не удавалось войти в систему повторно после использования стандартного метода logout щаблон не видел переменную тренера или родителя при повторном входе.
