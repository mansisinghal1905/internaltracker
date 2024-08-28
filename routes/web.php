<?php
use App\Http\Middleware;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ChangePasswordController;
use App\Http\Controllers\Admin\UserprofileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\QuotationController;
use App\Http\Controllers\Admin\SendPurposalController;
use App\Http\Controllers\Admin\ProjectStatusController;
use App\Http\Controllers\Admin\ClientUserController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\InvoiceController;
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
        
        // project route
        Route::resource('projects', ProjectController::class);
        Route::post('admin/projects/project-ajax', [ProjectController::class, 'projectAjax'])->name('projectAjax');
        Route::post('change-project-status', [ProjectController::class, 'changeProjectStatus'])->name('changeProjectStatus');
        Route::post('admin/projects/destory', [ProjectController::class, 'projectdestory'])->name('projectdestory');
        
        // category route
        Route::resource('category', CategoryController::class);
        Route::post('admin/category/category-ajax', [CategoryController::class, 'categoryAjax'])->name('categoryAjax');
        Route::post('change-category-status', [CategoryController::class, 'changeCategoryStatus'])->name('changeCategoryStatus');
        Route::post('admin/category/destory', [CategoryController::class, 'categorydestory'])->name('categorydestory');

        // project status route
        Route::resource('projectstatus', ProjectStatusController::class);
        Route::post('admin/projectstatus/projectstatus-ajax', [ProjectStatusController::class, 'projectstatusAjax'])->name('projectstatusAjax');
        Route::post('change-projectstatus-status', [ProjectStatusController::class, 'changeProjectstatusStatus'])->name('changeProjectstatusStatus');
        Route::post('admin/projectstatus/destory', [ProjectStatusController::class, 'projectstatusdestory'])->name('projectstatusdestory');

        // // quotation route
        Route::resource('quotation', QuotationController::class);
        Route::post('admin/quotation/quotation-ajax', [QuotationController::class, 'quotationAjax'])->name('quotationAjax');
        Route::post('change-quotation-status', [QuotationController::class, 'changeQuotationStatus'])->name('changeQuotationStatus');
        Route::post('admin/quotation/destory', [QuotationController::class, 'quotationdestory'])->name('quotationdestory');

        // quotation route
        // Route::resource('quotationmail', QuotationSendMailController::class);
        // Route::post('admin/quotationmail/quotationmail-ajax', [QuotationSendMailController::class, 'quotationmailAjax'])->name('quotationmailAjax');
        // Route::post('change-quotationmail-status', [QuotationSendMailController::class, 'changeQuotationMailStatus'])->name('changeQuotationMailStatus');
        // // Route::post('admin/quotationmail/destory', [QuotationSendMailController::class, 'quotationMaildestory'])->name('quotationMaildestory');

        // task route
        Route::resource('tasks', TaskController::class);
        Route::post('admin/tasks/task-ajax', [TaskController::class, 'taskAjax'])->name('taskAjax');
        Route::post('admin/tasks/destory', [TaskController::class, 'taskdestory'])->name('taskdestory');
        Route::post('/update-status', [TaskController::class, 'updateProjectStatus'])->name('update.status');

        // invoice route
        Route::resource('invoices', InvoiceController::class);
        Route::post('admin/invoices/invoice-ajax', [InvoiceController::class, 'invoiceAjax'])->name('invoiceAjax');
        Route::post('change-invoice-status', [InvoiceController::class, 'ChangeInvoiceStatus'])->name('ChangeInvoiceStatus');
        Route::post('admin/invoices/destory', [InvoiceController::class, 'invoicedestory'])->name('invoicedestory');
        
        Route::resource('sendpurposal', SendPurposalController::class);
        Route::post('admin/sendpurposal/sendpurposal-ajax', [SendPurposalController::class, 'sendpurposalAjax'])->name('sendpurposalAjax');
        Route::post('change-sendpurposal-status', [SendPurposalController::class, 'changeSendPurposalStatus'])->name('changeSendPurposalStatus');

    });
});


