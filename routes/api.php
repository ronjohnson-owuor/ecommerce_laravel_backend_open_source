<?php

use App\Http\Controllers\orderController;
use App\Http\Controllers\productController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::post("/signup", [UserController::class, 'signup']);
Route::post("/login", [UserController::class, 'login']);
Route::post("/allproduct", [productController::class, 'getproduct']);


Route::middleware(['auth:sanctum'])->group(function () {
	Route::post("/addproduct", [productController::class, 'addproduct']);
	Route::post("/deleteproduct", [productController::class, 'deleteproduct']);
    Route::post("/customorder", [orderController::class, 'customorder']);
	Route::post("/processorder", [orderController::class, 'makeorder']);
	Route::post("/getorder", [orderController::class, 'getorder']);
	Route::post("/delivered-order", [orderController::class, 'delivered']);
	Route::post("/report", [UserController::class, 'report']);
	Route::post("/addmessage", [UserController::class, 'addmessage']);
	Route::post("/editproduct", [productController::class, 'editProduct']);
	
});


