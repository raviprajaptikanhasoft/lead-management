<?php

use App\Http\Livewire\Home;
use App\Http\Livewire\Information\InformationList;
use App\Http\Livewire\Lead\LeadList;
use App\Http\Livewire\Leads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

// Route::get('/', function () {
//     return view('auth.login');
// });


Auth::routes(['register' => false,]);

// Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home-main');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::post("/add-info", "App\Http\Controllers\HomeController@storeRecords")->name("add-info");

// Route::get('/leads-old', Leads::class)->name('leads-old.index');


Route::middleware(['auth'])->group(function () {
    Route::get('/', \App\Http\Livewire\Dashboard::class)->name('dashboard');
    Route::get('/information', InformationList::class)->name('information.index');
    // Route::get('/information', Home::class)->name('information.index');
    Route::get('/leads', LeadList::class)->name('leads.index');
    Route::get('/leads/{lead}', \App\Http\Livewire\Lead\Show::class)->name('leads.show');
});