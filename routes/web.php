<?php

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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/my-component-route', function () {
//     return LivewireController::render('my-component');
// });

Route::get('/companyDocuments/{id}/download', function ($id) {
    
    $document = App\Models\CompanyDocument::findOrFail($id);
    if ($document->company_id !== auth()->user()->company_id) {
        abort(403); // Deny access if company mismatch
    }

    if (is_null($document->path) || empty($document->path)) {
        abort(404); // Document doesn't exist
    }

    return response()->download(storage_path('app/companyDocuments/' . $document->path));
})->name('companyDocuments.download');

Route::get('/companyDocuments/{id}/open', function ($id) {
    $document = App\Models\CompanyDocument::findOrFail($id);
    if ($document->company_id !== auth()->user()->company_id) {
        abort(403); // Deny access if company mismatch
    }
    if (is_null($document->path) || empty($document->path)) {
        abort(404); // Document doesn't exist
    }
    // Get appropriate headers based on file type
    $headers = [
        'Content-Type' => mime_content_type(storage_path('app/companyDocuments/' . $document->path)),
    ];
    return response()->make(file_get_contents(storage_path('app/companyDocuments/' . $document->path)), 200, $headers);
})->name('companyDocuments.open');
