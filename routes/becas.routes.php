<?php

use App\Http\Controllers\AnswerScoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

#region CONTROLLERS BECAS
use App\Http\Controllers\UserController;
use App\Http\Controllers\PerimeterBecasController;
use App\Http\Controllers\DisabilityBecasController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\SchoolBecasController;
use App\Http\Controllers\Beca1StudentDataController;
use App\Http\Controllers\Beca1TutorDataController;
use App\Http\Controllers\Beca2FamilyDataController;
use App\Http\Controllers\Beca7DocumentDataController;
use App\Http\Controllers\BecaController;
use App\Http\Controllers\CounterController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RelationshipController;
use App\Http\Controllers\RoleController;

#endregion CONTROLLERS BECAS

Route::post('/login', [UserController::class, 'login']);
Route::post('/signup', [UserController::class, 'signup']);

Route::middleware('auth:sanctum')->group(function () {
   // Route::get('/getUser/{token}', [UserController::class,'getUser']); //cerrar sesión (eliminar los tokens creados)
   Route::get('/logout', [UserController::class, 'logout']); //cerrar sesión (eliminar los tokens creados)

   Route::controller(CounterController::class)->group(function () {
      Route::get('/counters/counterOfMenus', 'counterOfMenus');
   });

   Route::controller(RoleController::class)->group(function () {
      Route::get('/roles/role_id/{role_id}', 'index');
      Route::get('/roles/selectIndex/role_id/{role_id}', 'selectIndex');
      Route::get('/roles/{id}', 'show');
      Route::post('/roles', 'create');
      Route::post('/roles/update/{id?}', 'update');
      Route::post('/roles/destroy/{id}', 'destroy');

      Route::get('/roles/{id}/DisEnableRole/{active}', 'DisEnableRole');
      Route::post('/roles/updatePermissions', 'updatePermissions');
   });

   Route::controller(MenuController::class)->group(function () {
      Route::get('/menus', 'index');
      Route::get('/menus/selectIndex/{fieldLabel?}/{fieldId?}', 'selectIndex');
      Route::get('/menus/selectIndexToRole', 'selectIndexToRole');
      Route::get('/menus/headers/selectIndex', 'headersSelectIndex');
      Route::get('/menus/id/{id}', 'show');
      Route::post('/menus/create', 'createOrUpdate');
      Route::post('/menus/update/{id?}', 'createOrUpdate');
      Route::post('/menus/destroy/{id}', 'destroy');

      Route::get('/menus/MenusByRole/{pages_read}', 'MenusByRole');
      Route::post('/menus/getIdByUrl', 'getIdByUrl');
      Route::get('/menus/{id}/DisEnableMenu/{active}', 'DisEnableMenu');
   });

   Route::controller(UserController::class)->group(function () {
      // Route::get('/users', 'index');
      Route::get('/users/role_id/{role_id}', 'index');
      Route::get('/users/by/role_id/{role_id}', 'indexByRole');
      Route::get('/users/selectIndex', 'selectIndex');
      Route::get('/users/{id}', 'show');
      Route::post('/users', 'create');
      Route::put('/users/{id?}', 'update');
      Route::delete('/users/{id}', 'destroy');

      Route::get('/users/{id}/DisEnableUser/{active}', 'DisEnableUser');
      Route::post('/users/destroyMultiple', 'destroyMultiple');
      Route::post('/users/changePasswordAuth', 'changePasswordAuth');
   });


   Route::controller(PerimeterBecasController::class)->group(function () {
      Route::get('/perimeters', 'index');
      Route::get('/perimeters/selectIndex', 'selectIndex');
      Route::get('/perimeters/{id}', 'show');
      Route::post('/perimeters', 'create');
      Route::put('/perimeters/{id?}', 'update');
      Route::delete('/perimeters/{id}', 'destroy');
   });

   Route::controller(LevelController::class)->group(function () {
      Route::get('/levels', 'index');
      Route::get('/levels/selectIndex', 'selectIndex');
      Route::get('/levels/{id}', 'show');
      Route::post('/levels', 'create');
      Route::put('/levels/{id}', 'update');
      Route::put('/levels', 'update');
      Route::delete('/levels/{id}', 'destroy');
   });

   Route::controller(SchoolBecasController::class)->group(function () {
      Route::get('/schools', 'index');
      Route::get('/schools/selectIndex', 'selectIndex');
      Route::get('/schools/{id}', 'show');
      Route::post('/schools', 'create');
      Route::put('/schools/{id?}', 'update');
      Route::delete('/schools/{id}', 'destroy');
   });

   Route::controller(DisabilityBecasController::class)->group(function () {
      Route::get('/disabilities', 'index');
      Route::get('/disabilities/selectIndex', 'selectIndex');
      Route::get('/disabilities/{id}', 'show');
      Route::post('/disabilities', 'create');
      Route::put('/disabilities/{id?}', 'update');
      Route::delete('/disabilities/{id}', 'destroy');
   });

   Route::controller(RelationshipController::class)->group(function () {
      Route::get('/relationships', 'index');
      Route::get('/relationships/selectIndex', 'selectIndex');
      Route::get('/relationships/{id}', 'show');
      Route::post('/relationships', 'create');
      Route::put('/relationships/{id?}', 'update');
      Route::delete('/relationships/{id}', 'destroy');
   });

   Route::controller(Beca1TutorDataController::class)->group(function () {
      Route::get('/tutors', 'index');
      Route::get('/tutors/selectIndex', 'selectIndex');
      Route::get('/tutors/{id}', 'show');
      Route::get('/tutors/tutor_curp/{tutor_curp}', 'show');
      Route::post('/tutors', 'create');
      Route::put('/tutors/{id?}', 'update');
      Route::delete('/tutors/{id}', 'destroy');
   });

   Route::controller(Beca1StudentDataController::class)->group(function () {
      Route::get('/students', 'index');
      Route::get('/students/selectIndex', 'selectIndex');
      Route::get('/students/{id}', 'show');
      Route::get('/students/curp/{curp}', 'show');
      Route::post('/students', 'create');
      Route::put('/students/{id?}', 'update');
      Route::delete('/students/{id}', 'destroy');
   });

   Route::controller(BecaController::class)->group(function () {
      Route::get('/becas', 'index');
      Route::get('/becas/status/{status}', 'index');
      Route::get('/becas/selectIndex', 'selectIndex');
      Route::get('/becas/{id}', 'show');
      Route::post('/becas', 'create');
      Route::put('/becas/{id?}', 'update');
      Route::delete('/becas/{id}', 'destroy');

      Route::get('/becas/getLastFolio', 'getLastFolio');
      Route::get('/becas/user/{id}', 'getBecasByUser');
      Route::get('/becas/folio/{folio}', 'getBecaByFolio');
      Route::post('/becas/folio/{folio}/page/{page}/saveBeca', 'saveBeca');

      Route::get('/becas/report/folio/{folio}', 'getReportRequestByFolio');
      Route::post('/becas/updateStatus/folio/{folio}/status/{status}', 'updateStatus');

      Route::get('/becas/calculateRequest/folio/{folio}', 'calculateRequest');
   });

   Route::controller(Beca2FamilyDataController::class)->group(function () {
      Route::get('/families', 'index');
      Route::get('/families/selectIndex', 'selectIndex');
      Route::get('/families/id/{id}', 'show');
      Route::post('/families/create', 'createOrUpdateByBeca');
      Route::put('/families/update/{id?}', 'createOrUpdateByBeca');
      Route::delete('/families/delete/{id}', 'destroy');

      Route::get('/families/beca/{beca_id}', 'getIndexByBeca');
      Route::get('/families/beca/folio/{folio}', 'getIndexByFolio');
      Route::post('/families/destroy', 'delete');
   });

   Route::controller(Beca7DocumentDataController::class)->group(function () {
      Route::post('/documents/folio/{folio}/page/{page}/saveOrFinishReview', 'saveOrFinishReview');
      // Route::get('/becas/updateStatus/folio/{folio}/status/{status}', 'updateStatus');
   });

   Route::controller(AnswerScoreController::class)->group(function () {
      Route::get('/answersScores', 'index');
      Route::get('/answersScores/selectIndex', 'selectIndex');
      Route::get('/answersScores/id/{id}', 'show');
      Route::post('/answersScores/create', 'createOrUpdate');
      Route::post('/answersScores/update/{id?}', 'createOrUpdate');
      Route::delete('/answersScores/delete/{id}', 'destroy');

      Route::get('/answersScores/getAnswerScoreActive', 'getAnswerScoreActive');
   });
});
