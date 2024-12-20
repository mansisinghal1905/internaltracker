<?php
use App\Http\Middleware;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ChangePasswordController;
use App\Http\Controllers\Admin\UserprofileController;
use App\Http\Controllers\Admin\ProjectStatusController;
use App\Http\Controllers\Admin\ClientUserController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\NewInterConnectionController;
use App\Http\Controllers\Admin\TradeVerificationController;

use App\Http\Controllers\Admin\RouteController;
use App\Http\Controllers\Admin\RouteSmsController;
use App\Http\Controllers\Admin\RouteVoiceController;
use App\Http\Controllers\Admin\NOCSmsController;
use App\Http\Controllers\Admin\NOCVoiceController;
use App\Http\Controllers\Admin\CustomerAccountController;
use App\Http\Controllers\Admin\VendorAccountController;
use App\Http\Controllers\Admin\TechnicalCustomerController;
use App\Http\Controllers\Admin\TechnicalVendorController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\TestResultController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\ForgetPasswordController;
use App\Http\Middleware\AuthCheck;

// Route::get('dashboard', [CustomAuthController::class, 'dashboard']); 
Route::get('/admin', [AuthenticatedSessionController::class, 'index'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.custom'); 
Route::get('registration', [AuthenticatedSessionController::class, 'registration'])->name('register-user');
Route::post('admin/registration', [AuthenticatedSessionController::class, 'registerUser'])->name('registerUser'); 

Route::get('admin/fortgot-password', [ForgetPasswordController::class, 'create'])->name('admin.forgotPassword');
Route::post('admin/fortgot-password', [ForgetPasswordController::class, 'store'])->name('admin.resetPassword');
Route::get('admin/reset-password/{token}', [ForgetPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('admin/reset-password', [ForgetPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

//****************************** Admin route start here ******************************************* */

Route::middleware([AuthCheck::class])->group(function(){

    Route::prefix('admin')->name('admin.')->group(function () {
        
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('adminDashboard');
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('adminlogout');
        Route::post('/change-password', [ChangePasswordController::class, 'changePassword'])->name('change.password');
        Route::post('/userprofile', [UserprofileController::class, 'store'])->name('profile.update');
        
        // user route
        Route::resource('users', UserController::class);
        Route::post('admin/users/user-ajax', [UserController::class, 'userAjax'])->name('userAjax');
        Route::post('change-user-status', [UserController::class, 'changeUserStatus'])->name('changeUserStatus');
        Route::post('admin/users/destory', [UserController::class, 'userdestory'])->name('userdestory');

        // client user route
        Route::resource('clientusers', ClientUserController::class);
        Route::post('admin/clientusers/user-ajax', [ClientUserController::class, 'clientuserAjax'])->name('clientuserAjax');
        Route::post('change-clientuser-status', [ClientUserController::class, 'ChangeClientUserStatus'])->name('ChangeClientUserStatus');
        Route::post('admin/clientusers/destory', [ClientUserController::class, 'clientuserdestory'])->name('clientuserdestory');

        Route::post('/getStatelistByCountryId', [UserController::class, 'getStatelistByCountryId'])->name('getStatelistByCountryId');
        Route::post('/getCitylistByStateId', [UserController::class, 'getCitylistByStateId'])->name('getCitylistByStateId');
           
        // task route
        Route::resource('tasks', TaskController::class);
        Route::post('admin/tasks/task-ajax', [TaskController::class, 'taskAjax'])->name('taskAjax');
        Route::post('admin/tasks/destory', [TaskController::class, 'taskdestory'])->name('taskdestory');
        Route::post('/update-status', [TaskController::class, 'updateProjectStatus'])->name('update.status');
        Route::post('change-task-status', [TaskController::class, 'ChangeTaskStatus'])->name('ChangeTaskStatus');

        Route::resource('newinterconnections', NewInterConnectionController::class);
        Route::resource('tradeverifications', TradeVerificationController::class);

        // Route route
        Route::resource('routes', RouteController::class);
        Route::post('admin/routes/customer-ajax', [RouteController::class, 'customerAjax'])->name('customerAjax');
        Route::get('/customers/view/{id?}', [RouteController::class, 'customershow'])->name('customershow');

        Route::resource('smsroutes', RouteSmsController::class);
        Route::resource('voiceroutes', RouteVoiceController::class);

        Route::resource('nocsms', NOCSmsController::class);
        Route::post('admin/nocsms/sms-ajax', [NOCSmsController::class, 'SmsAjax'])->name('SmsAjax');
        
        Route::resource('nocvoice', NOCVoiceController::class);
        Route::post('admin/nocvoice/voice-ajax', [NOCVoiceController::class, 'VoiceAjax'])->name('VoiceAjax');

        Route::get('vendors', [RouteController::class, 'vendorindex'])->name('vendorindex');
        Route::post('admin/vendors/vendor-ajax', [RouteController::class, 'vendorAjax'])->name('vendorAjax');
        Route::get('/vendors/view/{id?}', [RouteController::class, 'vendorshow'])->name('vendorshow');

        // Customer Account route
        Route::resource('customer-payments', CustomerAccountController::class);
        Route::post('admin/customer-payments/payment-ajax', [CustomerAccountController::class, 'paymentAjax'])->name('paymentAjax');
        Route::post('admin/payments/paymenthistory-ajax', [CustomerAccountController::class, 'paymenthistoryAjax'])->name('paymenthistoryAjax');
        
        // Vendor Account route
        Route::resource('vendor-payments', VendorAccountController::class);
        Route::post('admin/vendor-payments/payment-ajax', [VendorAccountController::class, 'vendorpaymentAjax'])->name('vendorpaymentAjax');
        Route::post('admin/vendorpayments/vendorpaymenthistory-ajax', [VendorAccountController::class, 'vendorpaymenthistoryAjax'])->name('vendorpaymenthistoryAjax');
        
        Route::resource('technical-customers', TechnicalCustomerController::class);
        Route::post('admin/technical-customers/technicalcustomer-ajax', [TechnicalCustomerController::class, 'technicalcustomerAjax'])->name('technicalcustomerAjax');
        Route::get('/download/{filename}', [TechnicalCustomerController::class, 'download'])->name('file.download');

        Route::resource('technical-vendors', TechnicalVendorController::class);
        Route::post('admin/technical-vendors/technicalvendor-ajax', [TechnicalVendorController::class, 'technicalvendorAjax'])->name('technicalvendorAjax');
        Route::get('/vendor-download/{filename}', [TechnicalVendorController::class, 'vendorfiledownload'])->name('file.vendorfiledownload');

        Route::resource('roles', RoleController::class);
        Route::post('admin/roles/role-ajax', [RoleController::class, 'roleAjax'])->name('roleAjax');

        Route::resource('ticket-system', TicketController::class);
        Route::post('admin/ticket-system/task-ajax', [TicketController::class, 'ticketAjax'])->name('ticketAjax');
        Route::post('admin/ticket-system/destory', [TicketController::class, 'ticketdestory'])->name('ticketdestory');
        Route::post('change-ticketsystem-status', [TicketController::class, 'ChangeTicketStatus'])->name('ChangeTicketStatus');

        Route::resource('testresults', TestResultController::class);
        Route::post('admin/testresults/testresult-ajax', [TestResultController::class, 'testresultAjax'])->name('testresultAjax');
        
    });
});


