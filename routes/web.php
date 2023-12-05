<?php
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CatController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\AdministratorController;

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// })->name('welcome');


Route::get('/', function () {
    return redirect('/login');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('user','fireauth');

// Route::get('/home/customer', [App\Http\Controllers\HomeController::class, 'customer'])->middleware('user','fireauth');

Route::get('/email/verify', [App\Http\Controllers\Auth\ResetController::class, 'verify_email'])->name('verify')->middleware('fireauth');

Route::post('login/{provider}/callback', 'Auth\LoginController@handleCallback');

Route::resource('/home/profile', App\Http\Controllers\Auth\ProfileController::class)->middleware('user','fireauth');

Route::resource('/password/reset', App\Http\Controllers\Auth\ResetController::class);

Route::resource('/img', App\Http\Controllers\ImageController::class);





Route::resource('products', ProductController::class);
Route::resource('request', CatController::class);
Route::resource('larawan', PhotoController::class);
Route::resource('admins', AdministratorController::class);
Route::get('/task_a', [App\Http\Controllers\ProductController::class, 'task_a'])->name('products.task_a');
Route::get('/admin_dashboard', [App\Http\Controllers\ProductController::class, 'admin_dashboard'])->name('products.admin_dashboard');
Route::get('/team', [App\Http\Controllers\ProductController::class, 'team'])->name('products.team');
Route::get('/add_report', [App\Http\Controllers\CatController::class, 'add_report'])->name('request.add_report');

Route::get('/admin_image', [App\Http\Controllers\PhotoController::class, 'admin_image'])->name('larawan.admin_image');

Route::get('/add_admin', [App\Http\Controllers\AdministratorController::class, 'add_admin'])->name('admins.add_admin');



Route::get('/products/{id}/edit', [App\Http\Controllers\ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');


Route::put('/products/{id}/update-status', [ProductController::class, 'updateStatus'])->name('update.status');




Route::get('/modify/cats/{id}/edit', [App\Http\Controllers\CatController::class, 'edit'])->name('cats.edit');
Route::put('/modify/cats/{id}', [App\Http\Controllers\CatController::class, 'update'])->name('cats.update');
Route::delete('/modify/cats/{cat}', [CatController::class, 'destroy'])->name('cats.destroy');


//when you click the edit button
Route::get('/admin-modify/administrators/{id}/edit', [App\Http\Controllers\AdministratorController::class, 'edit'])->name('administrators.edit');
//pag mag uupdate kana at na click update button yeah
Route::put('/admin-modify/administrators/{id}', [App\Http\Controllers\AdministratorController::class, 'update'])->name('administrators.update');
//for delete, obvious naman diba haha
Route::delete('/admin-modify/administrators/{administrator}', [AdministratorController::class, 'destroy'])->name('administrators.destroy');

//analytics
Route::get('/graph', [App\Http\Controllers\ProductController::class, 'graph'])->name('visual.graph');

// Route::get('/user_graph', [App\Http\Controllers\ProductController::class, 'user_graph'])->name('visual.user_graph');
Route::post('/visual/add_user_analytics', [ProductController::class, 'add_user_analytics'])->name('visual.add_user_analytics');




Route::get('/edit-user-analytics/fields/{id}/change', [App\Http\Controllers\ProductController::class, 'change'])->name('fields.change');
Route::put('/edit-user-analytics/fields/{id}', [ProductController::class, 'transform'])->name('fields.transform');




// Route::post('fileUpload', [
//     'as' =>'image.add',
//     'uses' => 'PhotoController@fileUpload'
// ]);



Route::get('/download-file/{id}', 'App\Http\Controllers\ProductController@downloadFile')->name('download.file');

// Route::get('/admin', [App\Http\Controllers\HomeController::class, 'index'])->name('admin')->middleware('user','fireauth');
// Route::get('/task_b', [App\Http\Controllers\ProductController::class, 'task_b'])->name('products.task_b');
// Route::get('/task_c', [App\Http\Controllers\ProductController::class, 'task_c'])->name('products.task_c');


// Route::get('/products/{id}/preview', 'ProductController@preview')->name('products.preview');

Route::get('/report/{id}/preview', [App\Http\Controllers\ProductController::class, 'preview'])->name('products.preview');

Route::post('/save-message', 'ProductController@saveMessage')->name('save-message');

Route::post('/save-message', [ProductController::class, 'saveMessage'])->name('convo.save-message');


Route::get('/userlist', [App\Http\Controllers\AdministratorController::class, 'userlist'])->name('users.userlist');

Route::post('/users/{id}/update-status', [App\Http\Controllers\AdministratorController::class, 'updateStatus'])->name('users.updateStatus');



Route::get('/automate_notifications', [App\Http\Controllers\AdministratorController::class, 'automate_notifications'])->name('reports.automate_notifications');

Route::post('/insert_data', [AdministratorController::class, 'insert_data'])->name('insert_data');



Route::delete('/rats/{rat}', [AdministratorController::class, 'deleteRat'])->name('deleteRat.rats');
Route::delete('/bats/{bat}', [AdministratorController::class, 'deleteBat'])->name('deleteBat.bats');
Route::delete('/dogs/{dog}', [AdministratorController::class, 'deleteDog'])->name('deleteDog.dogs');
Route::delete('/houses/{house}', [AdministratorController::class, 'deleteHouse'])->name('deleteHouse.houses');
Route::delete('/cars/{car}', [AdministratorController::class, 'deleteCar'])->name('deleteCar.cars');
Route::delete('/books/{book}', [AdministratorController::class, 'deleteBook'])->name('deleteBook.books');
Route::delete('/machines/{machine}', [AdministratorController::class, 'deleteMachine'])->name('deleteMachine.machines');
Route::delete('/pens/{pen}', [AdministratorController::class, 'deletePen'])->name('deletePen.pens');
Route::delete('/stacks/{stack}', [AdministratorController::class, 'deleteStack'])->name('deleteStack.stacks');
Route::delete('/chairs/{chair}', [AdministratorController::class, 'deleteChair'])->name('deleteChair.chairs');
Route::delete('/computers/{computer}', [AdministratorController::class, 'deleteComputer'])->name('deleteComputer.computers');



Route::get('/report_list', [App\Http\Controllers\AdministratorController::class, 'report_list'])->name('dynamic.report_list');
Route::post('/add_report_list', [AdministratorController::class, 'add_report_list'])->name('add_report_list');

Route::get('/modify_list/hogs/{id}/edit', [App\Http\Controllers\AdministratorController::class, 'edit_report_list'])->name('hogs.edit');
Route::put('/modify_list/hogs/{id}', [App\Http\Controllers\AdministratorController::class, 'update_report_list'])->name('hogs.update');
Route::delete('/modify_list/hogs/{hog}', [AdministratorController::class, 'destroy_report_list'])->name('hogs.destroy');


Route::get('/admin_page_edit/products/{id}/edit', [App\Http\Controllers\ProductController::class, 'admin_page_edit'])->name('products.admin_page_edit');
Route::get('/report/{id}/previewed', [App\Http\Controllers\ProductController::class, 'previewed'])->name('products.previewed');











