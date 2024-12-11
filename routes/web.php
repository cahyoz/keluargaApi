<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeluargaController;

Route::prefix('api')->group(function () {
    Route::apiResource('keluarga', KeluargaController::class);
    Route::get('keluarga/children/{parentId}', [KeluargaController::class, 'getChildrenByParentId']);
    Route::get('keluarga/grandchildren/{grandparentId}', [KeluargaController::class, 'getGrandchildrenByGrandparentId']);
    Route::get('keluarga/granddaughters/{grandparentId}', [KeluargaController::class, 'getGranddaughtersByGrandparentId']);
    Route::get('keluarga/aunts/{memberId}', [KeluargaController::class, 'getAuntsByMemberId']);
    Route::get('keluarga/male-cousins/{memberId}', [KeluargaController::class, 'getMaleCousinsByMemberId']);


});