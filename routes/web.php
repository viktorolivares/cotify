<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\EstablishmentsController;
use App\Http\Controllers\QuotationsController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PersonsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;

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


Route::get('config-cache', function () {
    try {
        Artisan::call('config:cache');
        Log::info('Configuración cacheada exitosamente.');
        return response()->json(['success' => 'Configuración cacheada exitosamente.'], 200);
    } catch (Exception $e) {
        Log::error('Error al cachear la configuración: ' . $e->getMessage());
        return response()->json(['error' => 'Error al cachear la configuración.'], 500);
    }
})->name('config.cache');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

// Logout
Route::delete('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// General Routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Users
    Route::get('users', [UsersController::class, 'index'])->name('users');
    Route::get('users/create', [UsersController::class, 'create'])->name('users.create');
    Route::post('users', [UsersController::class, 'store'])->name('users.store');
    Route::get('users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [UsersController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');
    Route::put('users/{user}/restore', [UsersController::class, 'restore'])->name('users.restore');

    // Persons
    Route::get('persons', [PersonsController::class, 'index'])->name('persons');
    Route::get('persons/create', [PersonsController::class, 'create'])->name('persons.create');
    Route::post('persons', [PersonsController::class, 'store'])->name('persons.store');
    Route::get('persons/{person}/edit', [PersonsController::class, 'edit'])->name('persons.edit');
    Route::put('persons/{person}', [PersonsController::class, 'update'])->name('persons.update');
    Route::delete('persons/{person}', [PersonsController::class, 'destroy'])->name('persons.destroy');
    Route::put('persons/{person}/restore', [PersonsController::class, 'restore'])->name('persons.restore');

    // Companies
    Route::get('companies', [CompaniesController::class, 'index'])->name('companies');
    Route::get('companies/create', [CompaniesController::class, 'create'])->name('companies.create');
    Route::post('companies', [CompaniesController::class, 'store'])->name('companies.store');
    Route::get('companies/{company}/edit', [CompaniesController::class, 'edit'])->name('companies.edit');
    Route::put('companies/{company}', [CompaniesController::class, 'update'])->name('companies.update');
    Route::delete('companies/{company}', [CompaniesController::class, 'destroy'])->name('companies.destroy');
    Route::put('companies/{company}/restore', [CompaniesController::class, 'restore'])->name('companies.restore');
    Route::get('companies/getCompanies', [CompaniesController::class, 'getCompanies'])->name('companies.getCompanies');

    // Establishments
    Route::get('establishments', [EstablishmentsController::class, 'index'])->name('establishments');
    Route::get('establishments/create', [EstablishmentsController::class, 'create'])->name('establishments.create');
    Route::post('establishments', [EstablishmentsController::class, 'store'])->name('establishments.store');
    Route::get('establishments/{establishment}/edit', [EstablishmentsController::class, 'edit'])->name('establishments.edit');
    Route::put('establishments/{establishment}', [EstablishmentsController::class, 'update'])->name('establishments.update');
    Route::delete('establishments/{establishment}', [EstablishmentsController::class, 'destroy'])->name('establishments.destroy');
    Route::put('establishments/{establishment}/restore', [EstablishmentsController::class, 'restore'])->name('establishments.restore');


    // Quotations
    Route::get('quotations', [QuotationsController::class, 'index'])->name('quotations');
    Route::get('quotations/create/{company}', [QuotationsController::class, 'create'])->name('quotations.create');
    Route::post('quotations', [QuotationsController::class, 'store'])->name('quotations.store');
    Route::get('quotations/{quotation}/edit', [QuotationsController::class, 'edit'])->name('quotations.edit');
    Route::put('quotations/{quotation}', [QuotationsController::class, 'update'])->name('quotations.update');
    Route::get('/quotations/{id}/pdf', [QuotationsController::class, 'exportToPDF'])->name('quotations.pdf');


    // Templates
    Route::get('templates', [TemplateController::class, 'index'])->name('templates.index');
    Route::put('templates/{company}', [TemplateController::class, 'update'])->name('templates.update');

    // API Consults
    Route::get('apis/query', [ApiController::class, 'query'])->name('apis.query');

    // Reports
    Route::get('reports', [ReportsController::class, 'index'])->name('reports');

    // Images
    Route::get('/img/{path}', [ImagesController::class, 'show'])->where('path', '.*')->name('image');

    Route::get('storage-link', function () {
        $targetFolder = storage_path('app/public');
        // Ruta de la carpeta de enlace en el directorio public_html
        $linkFolder = $_SERVER['DOCUMENT_ROOT'] . '/storage';

        // Registrar las rutas para depuración
        Log::info("Ruta de destino: $targetFolder");
        Log::info("Ruta del enlace: $linkFolder");

        // Verificar si la carpeta de destino existe
        if (!file_exists($targetFolder)) {
            Log::error("La carpeta de destino no existe: $targetFolder");
            return response()->json(['error' => 'La carpeta de destino no existe.'], 404);
        }

        // Crear la carpeta de enlace si no existe
        if (!file_exists(dirname($linkFolder))) {
            Log::info("Creando la carpeta de enlace: " . dirname($linkFolder));
            mkdir(dirname($linkFolder), 0755, true);
        }

        // Verificar si la carpeta de enlace ya existe
        if (file_exists($linkFolder)) {
            Log::warning("La carpeta de enlace ya existe: $linkFolder");
            return response()->json(['warning' => 'La carpeta de enlace ya existe.'], 200);
        }

        // Crear el enlace simbólico
        try {
            symlink($targetFolder, $linkFolder);
            Log::info("Enlace simbólico creado: $linkFolder -> $targetFolder");
            return response()->json(['success' => 'Enlace simbólico creado exitosamente.'], 200);
        } catch (Exception $e) {
            Log::error("Error al crear el enlace simbólico: " . $e->getMessage());
            return response()->json(['error' => 'Error al crear el enlace simbólico.'], 500);
        }
    })->name('storage.link');

});