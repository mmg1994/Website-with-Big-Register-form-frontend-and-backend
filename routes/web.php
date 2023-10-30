<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\LoginController;

use App\Http\Controllers\ReportController;



use App\Http\Controllers\TestController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\DateRangeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AnnulerController;

use Dompdf\Dompdf;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {return view('home');});


// Home
Route::get('home/page',[App\Http\Controllers\HomeController::class,'index'])->name('home/page');

//home change de langue


// *********************************  pour le cote admin login ***************************************************************//

// login
Route::get('login/view/new',[App\Http\Controllers\LoginController::class,'viewLogin'])->name('login/view/new');
Route::post('login',[App\Http\Controllers\LoginController::class,'login'])->name('login');
Route::get('logout',[App\Http\Controllers\LoginController::class,'logout'])->name('.logout');


// *********************************  fin du cote admin login ***************************************************************//

// form test request
Route::get('form/register',[App\Http\Controllers\LoginController::class,'index'])->name('form/register');
Route::post('form/request/save',[App\Http\Controllers\LoginController::class,'storeRegister'])->name('form/request/save');


//Invoice to send to OBR
Route::get('form/users',[App\Http\Controllers\ReportController::class,'index'])->name('form/users');
Route::get('users', [ReportController::class, 'index'])->name('users.index');
Route::get('users/destroy/{id}/', [App\Http\Controllers\ReportController::class, 'destroy']);
Route::get('users/removeall', [App\Http\Controllers\ReportController::class, 'removeall'])->name('users.removeall');





// *********************************  pour le cote admin clients  ***************************************************************//

//show client liste
Route::get('/date', [ReportController::class,'index'])->name('/date');


//editer un client
Route::get('/clients/{id}/edit', [ReportController::class,'editClient'])->name('clients.edit');


//update un client
Route::post('/clients/{id}/update', [ReportController::class, 'updateClient'])->name('clients.update');


// le nombre d'ajout par jour
Route::get('/ajout_par_jour', [ReportController::class,'ajout_par_jour'])->name('/ajout_par_jour');

// le nombre d'ajout par mois
Route::get('/ajout_par_mois', [ReportController::class,'ajout_par_mois'])->name('/ajout_par_mois');



// routes for PDF Convert View
Route::get('/pdf_view', [ReportController::class, 'pdfView'])->name('pdf.view');

// routes for PDF Convert
Route::get('/pdf_convert', [ReportController::class, 'pdfGeneration'])->name('pdf.convert');


// routes for PDF Convert
Route::get('/generate-pdf/{clientID}', [ReportController::class, 'generatePDF'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);









Route::get('/generate-pdf', function () {
    $dompdf = new Dompdf();
    $html = view('pdf_view')->render();
    $dompdf->loadHtml($html);
    $dompdf->render();
    $dompdf->stream('document.pdf');
});







Route::get('/clients/print/{id}/print', [ReportController::class, 'print'])->name('clients.print');
//Route::get('/clients/{id}/edit', [ReportController::class,'editClient'])->name('clients.edit');



//Route::post('/generate-pdf/{clientID}', [ReportController::class, 'generatePDF'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
//Route::get('/generate-pdf/{clientId}', [ReportController::class, 'generatePDF'])->name('generate.pdf');

//Route::get('/generate-pdf/{clientID}', [ReportController::class, 'generatePDF']);



//Route::post('/generate-pdf', 'PDFController@generatePDF');

// ********************************* fin du  cote admin clients ***************************************************************//



// Display registration form
Route::get('/register', [App\Http\Controllers\UserController::class, 'showRegistrationForm'])->name('register.form');

// Handle registration form submission
Route::post('/register', [App\Http\Controllers\UserController::class, 'register'])->name('register');


// Display registration form
Route::get('/registerclient', [App\Http\Controllers\ClientsController::class, 'showRegistrationForm'])->name('registerclient.form');

// Handle registration form submission
Route::post('/registerclient', [App\Http\Controllers\ClientsController::class, 'register'])->name('registerclient');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
