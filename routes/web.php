<?php
//legal123/*789
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', 'Auth\LoginController@showLoginForm', function () {
    Auth::logout();
});
//ROUTE LOGIN
Route::post('/login', 'Auth\LoginController@login')->name('login');
//ROUTE LOGOUT
Route::get('/logout')->middleware('auth', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');
Route::post('/logout', 'Auth\LoginController@logout')->middleware('auth')->name('logout-post');
//ROUTE REGISTER
Route::get('/registrate', 'Auth\RegisterController@index')->name('register');
Route::post('/registrate/guardar', 'Auth\RegisterController@store')->name('register.store');
//ROUTE VERIFICATION
Route::get('/registrate/verificacion/{id}', 'Auth\RegisterController@verification')->name('verification');
//ROUTE RESEND PASSWORD CONTRAT
Route::post('/resendPasswordContrat', 'Auth\RegisterController@resendPasswordContrat')->name('resendpass.contrat');
//ROUTE ERRORS
Route::name('errors.')->prefix('error/')->group(function() {
    Route::get('403', 'ErrorsController@index403')->name('403');
    Route::get('404', 'ErrorsController@index404')->name('404');
    Route::get('405', 'ErrorsController@index405')->name('405');
    Route::get('500', 'ErrorsController@index500')->name('500');
    Route::get('505', 'ErrorsController@index505')->name('505');
});
//ROUTE COMBOBOX STATES
Route::post('estados', 'Dashboard\Settings\StateController@indexAjax')->name('state.indexAjax');

//ROUTES WEBHOOKS FOR WEESIGN
Route::post('estados', 'Dashboard\Settings\StateController@indexAjax')->name('state.indexAjax');
Route::post('estados', 'Dashboard\Settings\StateController@indexAjax')->name('state.indexAjax');


//ROUTE COMBOX CITIES BY STATE
Route::post('municipios/por-estado', 'Dashboard\Settings\MunicipalityController@indexAjaxByState')->name('municipality.indexAjaxByState');
//ROUTE PDF
Route::get('contratos/simple/descarga/{contrat}', 'FileController@getPdf')->name('file.pdf');
//ROUTE FILES
Route::get('polizas/upgrade/descarga/{file}', 'FileController@getPolicyFiles')->name('policies.upgrade.file');
//ROUTE CONTRATS FORM
Route::name('contrats.simple.')->prefix('contratos/simple')->group(function() {
    Route::get('/', 'FormController@index')->name('index');
    Route::post('/store', 'FormController@store')->name('store');
    Route::get('/informacion/{contrat}/{message}/{color}', 'FormController@message')->name('message');
    Route::get('/descarga/{contrat}/{phone}', 'FormController@download')->name('download');
});
//ROUTE PAYMENTS
Route::name('payments.')->prefix('pagos/')->group(function() {
    Route::post('amount', 'PaymentController@amount')->name('amount');
    Route::post('store', 'PaymentController@store')->name('store');
    Route::post('order', 'PaymentController@order')->name('order');
});

//ROUTE CONTRAT UPGRADE
Route::name('contrats.upgrade.')->prefix('contratos/upgrade/')->group(function() {
    Route::get('/informacion/{contrat}', 'FormController@messageSignLogin')->name('sign');
});
//ROUTE POLICIES UPGRADE
Route::name('policies.upgrade.')->prefix('polizas/upgrade/')->group(function() {
    Route::get('propietarios/{policy}', 'UpgradeController@owner')->name('owner');
    Route::post('propietarios/store', 'UpgradeController@storeOwner')->name('storeOwner');
    Route::get('inquilinos/{policy}', 'UpgradeController@tenant')->name('tenant');
    Route::post('inquilinos/store', 'UpgradeController@storeTenant')->name('storeTenant');
    Route::get('fiador-obligado/{policy}', 'UpgradeController@guarantor')->name('guarantor');
    Route::post('fiador-obligado/store', 'UpgradeController@storeGuarantor')->name('storeGuarantor');
    Route::get('/informacion/{policy}/{message}/{color}', 'FormController@message')->name('message');
});
Route::get('home', 'Dashboard\HomeController@index')->name('home');
//ROUTES IN THE DASHBOARD
Route::name('dashboard.')->prefix('dashboard/')->middleware('auth')->group(function() {
    //ROUTE ERRORS DASHBOARD
    Route::name('errors.')->prefix('error/')->group(function() {
        Route::get('403', 'ErrorsController@index403')->name('403');
        Route::get('404', 'ErrorsController@index404')->name('404');
        Route::get('405', 'ErrorsController@index405')->name('405');
        Route::get('500', 'ErrorsController@index500')->name('500');
        Route::get('505', 'ErrorsController@index505')->name('505');
    });
    //ROUTE HOME
    Route::get('escritorio', 'Dashboard\HomeController@index')->name('home');
    // ROUTE PROFILE
    Route::get('profile', 'Dashboard\HomeController@profile')->name('profile');
    Route::get('editProfile', 'Dashboard\HomeController@editProfile')->name('editProfile');
    Route::post('updateProfile', 'Dashboard\HomeController@updateProfile')->name('updateProfile');

    // Route::get('solicitud/simple', 'Dashboard\Contratos\ContratosController@simple')->name('solicitud.simple');
    // Route::get('solicitud/simple/edit/{id}', 'Dashboard\Contratos\ContratosController@simpleEdit')->name('solicitud.simple.edit');
    // Route::post('registrar/simple', 'Dashboard\Contratos\ContratosController@storeSimple')->name('register.simple');
    // Route::post('solicitud/simple/edit/{id}', 'Dashboard\Contratos\ContratosController@updateSimple')->name('register.simple.edit');
    // Route::get('solicitud/generate/document/{id}', 'Dashboard\Contratos\ContratosController@generateDocument')->name('solicitud.generateDocument');
    // Route::get('solicitud/own', 'Dashboard\Contratos\ContratosController@own')->name('solicitud.own');
    // Route::get('solicitud/getOwnContratos', 'Dashboard\Contratos\ContratosController@getOwnContratos')->name('solicitud.getOwnContratos');
    //ROUTES FOR SETTINGS
    Route::name('settings.')->prefix('configuraciones/')->group(function() {
        //ROUTE PERMISSIONS
        Route::get('permisos', 'Dashboard\Settings\PermissionController@index')->name('permission.index');
        Route::post('permisos/indexAjax', 'Dashboard\Settings\PermissionController@indexAjax')->name('permission.indexAjax');
        Route::get('permisos/crear', 'Dashboard\Settings\PermissionController@create')->name('permission.create');
        Route::post('permisos/guardar', 'Dashboard\Settings\PermissionController@store')->name('permission.store');
        Route::get('permisos/editar/{id}', 'Dashboard\Settings\PermissionController@edit')->name('permission.edit');
        Route::put('permisos/actualizar/{id}', 'Dashboard\Settings\PermissionController@update')->name('permission.update');
        //ROUTE ROLES
        Route::get('roles', 'Dashboard\Settings\RoleController@index')->name('role.index');
        Route::get('roles/crear', 'Dashboard\Settings\RoleController@create')->name('role.create');
        Route::post('roles/guardar', 'Dashboard\Settings\RoleController@store')->name('role.store');
        Route::get('roles/editar/{id}', 'Dashboard\Settings\RoleController@edit')->name('role.edit');
        Route::put('roles/actualizar/{id}', 'Dashboard\Settings\RoleController@update')->name('role.update');
        //ROUTE USERS
        Route::get('usuarios', 'Dashboard\Settings\UserController@index')->name('user.index');
        Route::get('usuarios/crear', 'Dashboard\Settings\UserController@create')->name('user.create');
        Route::post('usuarios/guardar', 'Dashboard\Settings\UserController@store')->name('user.store');
        Route::get('usuarios/editar/{id}', 'Dashboard\Settings\UserController@edit')->name('user.edit');
        Route::put('usuarios/actualizar/{id}', 'Dashboard\Settings\UserController@update')->name('user.update');
        Route::get('usuarios/eliminar/{id}', 'Dashboard\Settings\UserController@destroy')->name('user.destroy');
        //ROUTE PROFILE
        Route::get('perfil', 'Dashboard\Settings\ProfileController@index')->name('profile.index');
        Route::put('perfil/actualizar/{id}', 'Dashboard\Settings\ProfileController@update')->name('profile.update');
        //ROUTE STATES
        Route::get('estados', 'Dashboard\Settings\StateController@index')->name('state.index');
        Route::get('estados/crear', 'Dashboard\Settings\StateController@create')->name('state.create');
        Route::post('estados/guardar', 'Dashboard\Settings\StateController@store')->name('state.store');
        Route::get('estados/editar/{id}', 'Dashboard\Settings\StateController@edit')->name('state.edit');
        Route::put('estados/actualizar/{id}', 'Dashboard\Settings\StateController@update')->name('state.update');
        Route::get('estados/eliminar/{id}', 'Dashboard\Settings\StateController@destroy')->name('state.destroy');
        //ROUTE CITIES
        Route::get('ciudades', 'Dashboard\Settings\CityController@index')->name('city.index');
        Route::post('ciudades', 'Dashboard\Settings\CityController@indexAjax')->name('city.indexAjax');
        Route::get('ciudades/crear', 'Dashboard\Settings\CityController@create')->name('city.create');
        Route::post('ciudades/guardar', 'Dashboard\Settings\CityController@store')->name('city.store');
        Route::get('ciudades/editar/{id}', 'Dashboard\Settings\CityController@edit')->name('city.edit');
        Route::put('ciudades/actualizar/{id}', 'Dashboard\Settings\CityController@update')->name('city.update');
        Route::get('ciudades/eliminar/{id}', 'Dashboard\Settings\CityController@destroy')->name('city.destroy');
        //ROUTE EMAILS
        Route::get('emails', 'Dashboard\Settings\EmailController@index')->name('email.index');
        Route::get('emails/crear', 'Dashboard\Settings\EmailController@create')->name('email.create');
        Route::post('emails/guardar', 'Dashboard\Settings\EmailController@store')->name('email.store');
        Route::get('emails/editar/{id}', 'Dashboard\Settings\EmailController@edit')->name('email.edit');
        Route::put('emails/actualizar/{id}', 'Dashboard\Settings\EmailController@update')->name('email.update');
        Route::get('emails/eliminar/{id}', 'Dashboard\Settings\EmailController@destroy')->name('email.destroy');
        //ROUTE TYPES
        Route::get('tipos', 'Dashboard\Settings\TypeController@index')->name('type.index');
        Route::get('tipos/crear', 'Dashboard\Settings\TypeController@create')->name('type.create');
        Route::post('tipos/guardar', 'Dashboard\Settings\TypeController@store')->name('type.store');
        Route::get('tipos/editar/{id}', 'Dashboard\Settings\TypeController@edit')->name('type.edit');
        Route::put('tipos/actualizar/{id}', 'Dashboard\Settings\TypeController@update')->name('type.update');
        Route::get('tipos/eliminar/{id}', 'Dashboard\Settings\TypeController@destroy')->name('type.destroy');
        //ROUTE TEMPLATES
        Route::get('plantillas', 'Dashboard\Settings\TemplateController@index')->name('template.index');
        Route::get('plantillas/crear', 'Dashboard\Settings\TemplateController@create')->name('template.create');
        Route::post('plantillas/guardar', 'Dashboard\Settings\TemplateController@store')->name('template.store');
        Route::get('plantillas/editar/{id}', 'Dashboard\Settings\TemplateController@edit')->name('template.edit');
        Route::put('plantillas/actualizar/{id}', 'Dashboard\Settings\TemplateController@update')->name('template.update');
        Route::get('plantillas/eliminar/{id}', 'Dashboard\Settings\TemplateController@destroy')->name('template.destroy');
    });
    
    //ROUTES FOR DOCUMENTS 
    Route::name('management.')->prefix('mis-contratos/')->group(function() {
        //ROUTE EXTINTIONS
        Route::get('contrato-extincion', 'Dashboard\Management\ExtincionController@index')->name('extintions.index');
        //ROUTE POLICIES
        Route::name('policies.')->prefix('polices/')->group(function() {

            Route::get('/list', 'Dashboard\Management\PolicyController@index')->name('index');
            Route::get('/create', 'Dashboard\Management\PolicyController@create')->name('create');
            Route::post('/amount', 'Dashboard\Management\PolicyController@amount')->name('amount');
            Route::post('/exportPdf', 'Dashboard\Management\PolicyController@exportPdfAjax')->name('exportPdf');
            Route::get('descarga/{policy}', 'FileController@getPolicyPdf')->name('file.pdf');
        });
        //ROUTE SIGN
        Route::name('signs.')->prefix('signs/')->group(function() {
            Route::get('test', 'Dashboard\Management\SignController@test')->name('test');
            Route::get('/list', 'Dashboard\Management\SignController@index')->name('index');
            Route::post('/details', 'Dashboard\Management\SignController@details')->name('details');
            Route::post('/restartProcess', 'Dashboard\Management\SignController@restartProcess')->name('restartProcess');
            Route::post('/exportPdf', 'Dashboard\Management\SignController@exportPdfAjax')->name('exportPdf');
            Route::get('descarga/{policy}', 'FileController@getPolicyPdf')->name('file.pdf');
        });
         //ROUTE INVESTIGATION
         Route::name('investigations.')->prefix('investigations/')->group(function() {
            Route::get('/list', 'Dashboard\Management\InvestigationController@index')->name('index');
            Route::post('/exportPdf', 'Dashboard\Management\InvestigationController@exportPdfAjax')->name('exportPdf');
            Route::get('descarga/{policy}', 'FileController@getPolicyPdf')->name('file.pdf');
        });
    });
});