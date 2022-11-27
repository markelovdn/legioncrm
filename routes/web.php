<?php

use App\Http\Controllers\Api\V1\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('user', \App\Http\Controllers\Api\V1\UsersController::class);
Route::resource('organization', \App\Http\Controllers\Api\V1\OrganizationController::class)->middleware(['auth']);
Route::resource('coach', \App\Http\Controllers\Api\V1\CoachController::class)->middleware(['auth', 'coach']);
Route::resource('parented', \App\Http\Controllers\Api\V1\ParentedsController::class)->middleware(['auth', 'parented']);
Route::resource('athlete', \App\Http\Controllers\Api\V1\AthletesController::class)->middleware(['auth']);
Route::resource('passport', \App\Http\Controllers\Api\V1\PassportController::class)->middleware(['auth']);
Route::resource('birthcertificate', \App\Http\Controllers\Api\V1\BirthCertificateController::class)->middleware(['auth']);
Route::resource('studyplace', \App\Http\Controllers\Api\V1\StudyPlaceController::class)->middleware(['auth']);
Route::resource('addresses', \App\Http\Controllers\Api\V1\AddressesController::class)->middleware(['auth']);
//Route::resource('competitors', \App\Http\Controllers\Api\V1\CompetitorsController::class);
Route::resource('competitions', \App\Http\Controllers\Api\V1\CompetitionsController::class);
Route::resource('competitions.competitors', \App\Http\Controllers\Api\V1\CompetitorsController::class)->shallow()->middleware(['auth']);
Route::any('/competitions/{id}/competitors-new-user', [\App\Http\Controllers\Api\V1\CompetitorsController::class, 'store_as_new_user']);
Route::resource('competitions.tehkvalgroups', \App\Http\Controllers\Api\V1\TehkvalGroupsController::class)->shallow()->middleware(['auth']);
Route::resource('role-user', \App\Http\Controllers\Api\V1\RoleUserController::class)->middleware(['auth', 'system_admin']);

Route::get('coach/{id}/athletes', [\App\Http\Controllers\Api\V1\CoachController::class, 'show'])->middleware(['auth']);


Route::get('/loginAs', function (\Illuminate\Http\Request $request) {
    $id = $request->get('id');
     \Illuminate\Support\Facades\Auth::loginUsingId($id);
    return back();
})->name('loginas');

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
}); //Сделал отдельный метод потомучто не удавалось войти в систему повторно после использования стандартного метода logout щаблон не видел переменную тренера или родителя при повторном входе.

