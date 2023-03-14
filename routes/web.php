<?php

use App\Http\Controllers\CompetitorsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('user', \App\Http\Controllers\UsersController::class);

Route::middleware(['auth'])->group(function () {
    Route::resource('athlete', \App\Http\Controllers\AthletesController::class);
    Route::resource('organization', \App\Http\Controllers\OrganizationController::class);
    Route::resource('birthcertificate', \App\Http\Controllers\BirthCertificateController::class);
    Route::resource('passport', \App\Http\Controllers\PassportController::class);
    Route::resource('studyplace', \App\Http\Controllers\StudyPlaceController::class);
    Route::resource('addresses', \App\Http\Controllers\AddressesController::class);
    Route::resource('tehkval', \App\Http\Controllers\TehkvalsController::class);
    Route::resource('attestation.athletes', \App\Http\Controllers\AttestationAthletesController::class)->shallow();
    Route::resource('attestations', \App\Http\Controllers\AttestationsController::class);
    Route::any('printSertificate', [\App\BusinessProcess\PrintAttestationSertificate::class, 'printSertificate'])->name('printSertificate')->middleware('auth');
    Route::resource('events', \App\Http\Controllers\EventsController::class);
    Route::resource('events.users', \App\Http\Controllers\EventUserController::class)->shallow();
    Route::put('/event/{event_id}/user/{user_id}', [\App\Http\Controllers\EventUserController::class, 'update'])->name('eventUserUpdate');
    Route::delete('/event/{event_id}/user/{user_id}', [\App\Http\Controllers\EventUserController::class, 'destroy'])->name('userEventDestroy');
    Route::get('/competitorsExport', [CompetitorsController::class, 'competitorsExport'])->middleware('auth')->name('competitorsExport');
    Route::get('/eventUsersExport/event_id={id}', [\App\Http\Controllers\EventUserController::class, 'eventUsersExport'])->middleware('auth')->name('eventUsersExport');
    Route::get('/attestationAthletesExport', [\App\Http\Controllers\AttestationAthletesController::class, 'attestationAthleteExport'])->middleware('auth')->name('attestationAthletesExport');
    Route::resource('payment', \App\Http\Controllers\PaymentsController::class);
    Route::resource('competitions', \App\Http\Controllers\CompetitionsController::class);
    Route::resource('competitions.competitors', \App\Http\Controllers\CompetitorsController::class)->shallow();
    Route::resource('competitions.tehkvalgroups', \App\Http\Controllers\TehkvalGroupsController::class)->shallow();
    Route::any('/competitions/{id}/competitors-new-user', [\App\Http\Controllers\CompetitorsController::class, 'store_as_new_user']);
    Route::resource('grade', \App\Http\Controllers\GradesCntroller::class);
    Route::post('setNamePoomsaeTablo', [\App\Http\Controllers\GradesCntroller::class, 'setName'])->name('setNamePoomsaeTablo');
    Route::get('/poomsae-competitors', [\App\Http\Controllers\CompetitorsController::class, 'addCompetitorsToPoomsaeTablo'])->name('poomsae-competitors');

});

Route::middleware(['auth', 'system_admin'])->group(function () {
    Route::resource('role-user', \App\Http\Controllers\RoleUserController::class);
    Route::get('/loginAs', function (\Illuminate\Http\Request $request) {
        $id = $request->get('id');
        \Illuminate\Support\Facades\Auth::loginUsingId($id);
        return back();
    })->name('loginas');
});


Route::resource('coach', \App\Http\Controllers\CoachController::class)->middleware(['auth', 'coach']);
//Route::get('coach/{id}/athletes', [\App\Http\Controllers\CoachController::class, 'show'])->middleware(['auth', 'coach']);
Route::resource('referee', \App\Http\Controllers\RefereesController::class)->middleware(['auth', 'referee']);
Route::resource('parented', \App\Http\Controllers\ParentedsController::class)->middleware(['auth', 'parented']);

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
}); //Сделал отдельный метод потомучто не удавалось войти в систему повторно после использования стандартного метода logout щаблон не видел переменную тренера или родителя при повторном входе.
