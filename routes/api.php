<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AssetTypeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\DashboardManagementController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\EmailTemplateWrapperController;

use App\Http\Controllers\BusinessController;
use App\Http\Controllers\BusinessTierController;
use App\Http\Controllers\BusinessTimesController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CustomWebhookController;
use App\Http\Controllers\DashboardManagementControllerV2;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\DropdownOptionsController;
use App\Http\Controllers\EmployeeRotaController;
use App\Http\Controllers\EmploymentStatusController;
use App\Http\Controllers\FileManagementController;
use App\Http\Controllers\HistoryDetailsController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\JobPlatformController;
use App\Http\Controllers\JobTypeController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LetterTemplateController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\NotificationController;


use App\Http\Controllers\NotificationTemplateController;
use App\Http\Controllers\PaymentTypeController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PayrunController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RecruitmentProcessController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ServicePlanController;
use App\Http\Controllers\SettingAttendanceController;
use App\Http\Controllers\SettingLeaveController;
use App\Http\Controllers\SettingLeaveTypeController;
use App\Http\Controllers\SettingPaymentDateController;
use App\Http\Controllers\SettingPayrollController;
use App\Http\Controllers\SocialSiteController;
use App\Http\Controllers\SystemSettingController;
use App\Http\Controllers\TaskCategoryController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TerminationReasonController;
use App\Http\Controllers\TerminationTypeController;
use App\Http\Controllers\UserAddressHistoryController;
use App\Http\Controllers\UserAssetController;
use App\Http\Controllers\UserDocumentController;
use App\Http\Controllers\UserEducationHistoryController;
use App\Http\Controllers\UserJobHistoryController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\UserNoteController;
use App\Http\Controllers\UserPassportHistoryController;
use App\Http\Controllers\UserPayslipController;
use App\Http\Controllers\UserPensionHistoryController;
use App\Http\Controllers\UserRecruitmentProcessController;
use App\Http\Controllers\UserRightToWorkHistoryController;
use App\Http\Controllers\UserSocialSiteController;
use App\Http\Controllers\UserSponsorshipHistoryController;
use App\Http\Controllers\UserVisaHistoryController;
use App\Http\Controllers\WorkLocationController;
use App\Http\Controllers\WorkShiftController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserLetterController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider jistoryin a group which x
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Define route for GET method
Route::get('/health', function () {
    return response()->json(['status' => 'Server is up and running'], 200);
});

// Define route for POST method
Route::post('/health', function () {
    return response()->json(['status' => 'Server is up and running'], 200);
});

// Define route for PUT method
Route::put('/health', function () {
    return response()->json(['status' => 'Server is up and running'], 200);
});

// Define route for DELETE method
Route::delete('/health', function () {
    return response()->json(['status' => 'Server is up and running'], 200);
});

// Define route for PATCH method
Route::patch('/health', function () {
    return response()->json(['status' => 'Server is up and running'], 200);
});









Route::post('/v1.0/files/single-file-upload', [FileManagementController::class, "createFileSingle"]);

Route::post('/v1.0/files/multiple-file-upload', [FileManagementController::class, "createFileMultiple"]);






Route::post('/v1.0/register', [AuthController::class, "register"]);
Route::post('/v1.0/login', [AuthController::class, "login"]);
Route::post('/v2.0/login', [AuthController::class, "loginV2"]);

Route::post('/v1.0/token-regenerate', [AuthController::class, "regenerateToken"]);

Route::post('/forgetpassword', [AuthController::class, "storeToken"]);
Route::post('/v2.0/forgetpassword', [AuthController::class, "storeTokenV2"]);

Route::post('/resend-email-verify-mail', [AuthController::class, "resendEmailVerifyToken"]);

Route::patch('/forgetpassword/reset/{token}', [AuthController::class, "changePasswordByToken"]);
Route::post('/auth/check/email', [AuthController::class, "checkEmail"]);

Route::post('/auth/check/business/email', [AuthController::class, "checkBusinessEmail"]);





















// !!!!!!!@@@@@@@@@@@@$$$$$$$$$$$$%%%%%%%%%%%%%%%%^^^^^^^^^^
// Protected Routes
// !!!!!!!@@@@@@@@@@@@$$$$$$$$$$$$%%%%%%%%%%%%%%%%^^^^^^^^^^

Route::middleware(['auth:api'])->group(function () {


Route::post('/v2.0/files/single-file-upload', [FileManagementController::class, "createFileSingleV2"]);
Route::post('/v2.0/files/multiple-file-upload', [FileManagementController::class, "createFileMultipleV2"]);
Route::get('/v1.0/file/{filename}', [FileManagementController::class, "getFile"]);

    Route::post('/v1.0/logout', [AuthController::class, "logout"]);
    Route::get('/v1.0/user', [AuthController::class, "getUser"]);
    Route::get('/v2.0/user', [AuthController::class, "getUserV2"]);
    Route::get('/v3.0/user', [AuthController::class, "getUserV3"]);

    // @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// notification management section
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
Route::get('/v1.0/notifications', [NotificationController::class, "getNotifications"]);

Route::get('/v1.0/notifications/{business_id}/{perPage}', [NotificationController::class, "getNotificationsByBusinessId"]);

Route::put('/v1.0/notifications/change-status', [NotificationController::class, "updateNotificationStatus"]);

Route::delete('/v1.0/notifications/{id}', [NotificationController::class, "deleteNotificationById"]);
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// notification management section
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@





// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// dashboard section
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

Route::get('/v1.0/superadmin-dashboard', [DashboardManagementController::class, "getSuperAdminDashboardData"]);
Route::post('/v1.0/dashboard-widgets', [DashboardManagementController::class, "createDashboardWidget"]);
Route::delete('/v1.0/dashboard-widgets/{ids}', [DashboardManagementController::class, "deleteDashboardWidgetsByIds"]);

Route::get('/v1.0/business-user-dashboard', [DashboardManagementController::class, "getBusinessUserDashboardData"]);

Route::get('/v1.0/business-employee-dashboard', [DashboardManagementController::class, "getBusinessEmployeeDashboardData"]);

Route::get('/v2.0/business-employee-dashboard', [DashboardManagementController::class, "getBusinessEmployeeDashboardDataV2"]);

Route::get('/v2.0/business-employee-dashboard/present-hours', [DashboardManagementController::class, "getBusinessEmployeeDashboardDataPresentHours"]);

Route::get('/v2.0/business-employee-dashboard/leaves', [DashboardManagementControllerV2::class, "getBusinessEmployeeDashboardDataLeaves"]);
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// end dashboard section
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%



Route::get('/v2.0/business-manager-dashboard', [DashboardManagementControllerV2::class, "getBusinessManagerDashboardData"]);

Route::get('/v1.0/business-manager-dashboard/other-widgets', [DashboardManagementControllerV2::class, "getBusinessManagerDashboardDataOtherWidgets"]);







Route::get('/v1.0/business-manager-dashboard/sponsorship-expiries/{duration}', [DashboardManagementControllerV2::class, "getBusinessManagerDashboardDataSponsorshipExpiries"]);


Route::get('/v1.0/business-manager-dashboard/right-to-work-expiries/{duration}', [DashboardManagementControllerV2::class, "getBusinessManagerDashboardDataRightToWorkExpiries"]);


Route::get('/v1.0/business-manager-dashboard/visa-expiries/{duration}', [DashboardManagementControllerV2::class, "getBusinessManagerDashboardDataVisaExpiries"]);

Route::get('/v1.0/business-manager-dashboard/passport-expiries/{duration}', [DashboardManagementControllerV2::class, "getBusinessManagerDashboardDataPassportExpiries"]);


Route::get('/v1.0/business-manager-dashboard/pension-expiries/{duration}', [DashboardManagementControllerV2::class, "getBusinessManagerDashboardDataPensionExpiries"]);



Route::get('/v1.0/business-manager-dashboard/combined-expiries', [DashboardManagementControllerV2::class, "getBusinessManagerDashboardDataCombinedExpiries"]);







Route::get('/v1.0/business-manager-dashboard/holidays', [DashboardManagementControllerV2::class, "getBusinessManagerDashboardDataHolidays"]);
Route::get('/v1.0/business-manager-dashboard/leaves', [DashboardManagementControllerV2::class, "getBusinessManagerDashboardDataLeaves"]);



Route::get('/v1.0/business-manager-dashboard/leaves/{status}/{duration}', [DashboardManagementControllerV2::class, "getBusinessManagerDashboardDataLeavesByStatus"]);

Route::get('/v1.0/business-manager-dashboard/holidays/{status}/{duration}', [DashboardManagementControllerV2::class, "getBusinessManagerDashboardDataHolidaysByStatus"]);

Route::get('/v1.0/business-manager-dashboard/leaves-holidays', [DashboardManagementControllerV2::class, "getBusinessManagerDashboardDataLeavesAndHolidays"]);


Route::get('/v1.0/business-manager-dashboard/pensions/{status}/{duration}', [DashboardManagementControllerV2::class, "getBusinessManagerDashboardDataPensionsByStatus"]);

Route::get('/v1.0/business-manager-dashboard/pensions', [DashboardManagementControllerV2::class, "getBusinessManagerDashboardDataPensions"]);





Route::get('/v1.0/business-manager-dashboard/present', [DashboardManagementControllerV2::class, "getBusinessManagerDashboardDataPresent"]);

Route::get('/v1.0/business-manager-dashboard/absent', [DashboardManagementControllerV2::class, "getBusinessManagerDashboardDataAbsent"]);






Route::get('/v1.0/business-manager-dashboard/open-roles/{duration}', [DashboardManagementControllerV2::class, "getBusinessManagerDashboardDataOpenRoles"]);


Route::get('/v1.0/business-manager-dashboard/total-employee/{duration}', [DashboardManagementControllerV2::class, "getBusinessManagerDashboardDataTotalEmployee"]);


Route::get('/v1.0/business-manager-dashboard/open-roles-and-total-employee', [DashboardManagementControllerV2::class, "getBusinessManagerDashboardDataOpenRolesAndTotalEmployee"]);













Route::get('/v2.0/business-manager-dashboard/present-absent', [DashboardManagementControllerV2::class, "getBusinessManagerDashboardDataPresentAbsent"]);


Route::get('/v2.0/business-manager-dashboard/present-absent-hours', [DashboardManagementControllerV2::class, "getBusinessManagerDashboardDataPresentAbsentHours"]);





});




Route::middleware(['auth:api',"business.subscription.check","authorization.check"])->group(function () {





    Route::patch('/auth/changepassword', [AuthController::class, "changePassword"]);
    Route::put('/v1.0/update-user-info', [AuthController::class, "updateUserInfo"]);




















// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// modules  management section
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

Route::put('/v1.0/modules/toggle-active', [ModuleController::class, "toggleActiveModule"]);

Route::put('/v1.0/business-modules/enable', [ModuleController::class, "enableBusinessModule"]);

Route::put('/v1.0/service-plan-modules/enable', [ModuleController::class, "enableServicePlanModule"]);



Route::get('/v1.0/business-modules/{business_id}', [ModuleController::class, "getBusinessModules"]);





Route::get('/v1.0/modules', [ModuleController::class, "getModules"]);


// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// end modules management section
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@


// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//  management section
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

Route::post('/v1.0/business-tiers', [BusinessTierController::class, "createBusinessTier"]);
Route::put('/v1.0/business-tiers', [BusinessTierController::class, "updateBusinessTier"]);
Route::get('/v1.0/business-tiers', [BusinessTierController::class, "getBusinessTiers"]);
Route::get('/v1.0/business-tiers/{id}', [BusinessTierController::class, "getBusinessTierById"]);
Route::delete('/v1.0/business-tiers/{ids}', [BusinessTierController::class, "deleteBusinessTiersByIds"]);

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// end job platform management section
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@


// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//  management section
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

Route::post('/v1.0/service-plans', [ServicePlanController::class, "createServicePlan"]);
Route::put('/v1.0/service-plans', [ServicePlanController::class, "updateServicePlan"]);
Route::get('/v1.0/service-plans', [ServicePlanController::class, "getServicePlans"]);
Route::get('/v1.0/service-plans/{id}', [ServicePlanController::class, "getServicePlanById"]);
Route::delete('/v1.0/service-plans/{ids}', [ServicePlanController::class, "deleteServicePlansByIds"]);

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// end job platform management section
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@






// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// user management section
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@



// ********************************************
// user management section --user
// ********************************************



Route::post('/v1.0/users', [UserManagementController::class, "createUser"]);
Route::get('/v1.0/users/{id}', [UserManagementController::class, "getUserById"]);
Route::put('/v1.0/users', [UserManagementController::class, "updateUser"]);

Route::put('/v1.0/users/update-password', [UserManagementController::class, "updatePassword"]);


Route::put('/v1.0/users/assign-roles', [UserManagementController::class, "assignUserRole"]);
Route::put('/v1.0/users/assign-permissions', [UserManagementController::class, "assignUserPermission"]);

Route::put('/v1.0/users/profile', [UserManagementController::class, "updateUserProfile"]);
Route::put('/v2.0/users/profile', [UserManagementController::class, "updateUserProfileV2"]);

Route::put('/v1.0/users/profile-picture', [UserManagementController::class, "updateUserProfilePicture"]);


Route::put('/v1.0/users/toggle-active', [UserManagementController::class, "toggleActiveUser"]);

Route::put('/v1.0/users/exit', [UserManagementController::class, "exitUser"]);
Route::put('/v1.0/users/rejoin', [UserManagementController::class, "rejoinUser"]);

Route::get('/v1.0/users', [UserManagementController::class, "getUsers"]);
Route::get('/v2.0/users', [UserManagementController::class, "getUsersV2"]);
Route::get('/v3.0/users', [UserManagementController::class, "getUsersV3"]);
Route::get('/v4.0/users', [UserManagementController::class, "getUsersV4"]);
Route::get('/v5.0/users', [UserManagementController::class, "getUsersV5"]);

Route::get('/v6.0/users', [UserManagementController::class, "getUsersV6"]);


Route::get('/v7.0/users', [UserManagementController::class, "getUsersV7"]);








Route::delete('/v1.0/users/{ids}', [UserManagementController::class, "deleteUsersByIds"]);
Route::get('/v1.0/users/get/user-activity', [UserManagementController::class, "getUserActivity"]);



Route::post('/v2.0/users', [UserManagementController::class, "createUserV2"]);


Route::get('/v1.0/user-test', [UserManagementController::class, "getUserTest"]);
Route::post('/v1.0/user-test', [UserManagementController::class, "createUserTest"]);
Route::post('/v2.0/user-test', [UserManagementController::class, "createUserTestV2"]);


Route::post('/v1.0/users/import', [UserManagementController::class, 'importUsers']);
Route::put('/v2.0/users', [UserManagementController::class, "updateUserV2"]);
Route::put('/v2.0/users/update-work-shift', [UserManagementController::class, "updateUserWorkShift"]);
Route::put('/v3.0/users', [UserManagementController::class, "updateUserV3"]);
Route::put('/v4.0/users', [UserManagementController::class, "updateUserV4"]);



Route::put('/v1.0/users/update-address', [UserManagementController::class, "updateUserAddress"]);
Route::put('/v1.0/users/update-bank-details', [UserManagementController::class, "updateUserBankDetails"]);

Route::put('/v1.0/users/update-joining-date', [UserManagementController::class, "updateUserJoiningDate"]);


Route::put('/v1.0/users/update-emergency-contact', [UserManagementController::class, "updateEmergencyContact"]);



Route::get('/v2.0/users/{id}', [UserManagementController::class, "getUserByIdV2"]);

Route::get('/v3.0/users/{id}', [UserManagementController::class, "getUserByIdV3"]);

Route::get('/v4.0/users/{id}', [UserManagementController::class, "getUserByIdV4"]);




Route::get('/v1.0/users/generate/employee-id', [UserManagementController::class, "generateEmployeeId"]);
Route::get('/v1.0/users/validate/employee-id/{user_id}', [UserManagementController::class, "validateEmployeeId"]);

Route::get('/v1.0/users/get-leave-details/{id}', [UserManagementController::class, "getLeaveDetailsByUserId"]);

Route::get('/v1.0/users/load-data-for-leaves/{id}', [UserManagementController::class, "getLoadDataForLeaveByUserId"]);


Route::get('/v1.0/users/load-data-for-attendances/{id}', [UserManagementController::class, "getLoadDataForAttendanceByUserId"]);


Route::get('/v1.0/load-global-data-for-attendances', [UserManagementController::class, "getLoadGlobalDataForAttendance"]);

Route::get('/v1.0/users/get-disable-days-for-attendances/{id}', [UserManagementController::class, "getDisableDaysForAttendanceByUserId"]);

Route::get('/v1.0/users/get-attendances/{id}', [UserManagementController::class, "getAttendancesByUserId"]);

Route::get('/v1.0/users/get-leaves/{id}', [UserManagementController::class, "getLeavesByUserId"]);

Route::get('/v1.0/users/get-holiday-details/{id}', [UserManagementController::class, "getholidayDetailsByUserId"]);

Route::get('/v1.0/users/get-schedule-information/by-user', [UserManagementController::class, "getScheduleInformation"]);



Route::get('/v1.0/users/get-recruitment-processes/{id}', [UserManagementController::class, "getRecruitmentProcessesByUserId"]);



// ********************************************
// user management section --role
// ********************************************
Route::get('/v1.0/initial-role-permissions', [RolesController::class, "getInitialRolePermissions"]);
Route::get('/v1.0/initial-permissions', [RolesController::class, "getInitialPermissions"]);
Route::post('/v1.0/roles', [RolesController::class, "createRole"]);
Route::put('/v1.0/roles', [RolesController::class, "updateRole"]);
Route::get('/v1.0/roles', [RolesController::class, "getRoles"]);

Route::get('/v1.0/roles/{id}', [RolesController::class, "getRoleById"]);
Route::delete('/v1.0/roles/{ids}', [RolesController::class, "deleteRolesByIds"]);
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// end user management section
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%




// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// business management section
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
Route::post('/v1.0/auth/check-schedule-conflict', [BusinessController::class, "checkScheduleConflict"]);
Route::post('/v1.0/auth/register-with-business', [BusinessController::class, "registerUserWithBusiness"]);
Route::post('/v1.0/businesses', [BusinessController::class, "createBusiness"]);
Route::put('/v1.0/businesses/toggle-active', [BusinessController::class, "toggleActiveBusiness"]);
Route::put('/v1.0/businesses', [BusinessController::class, "updateBusiness"]);

Route::put('/v1.0/businesses-part-1', [BusinessController::class, "updateBusinessPart1"]);
Route::put('/v1.0/businesses-part-2', [BusinessController::class, "updateBusinessPart2"]);
Route::put('/v2.0/businesses-part-2', [BusinessController::class, "updateBusinessPart2V2"]);
Route::put('/v1.0/businesses-part-3', [BusinessController::class, "updateBusinessPart3"]);


Route::put('/v1.0/businesses/separate', [BusinessController::class, "updateBusinessSeparate"]);
Route::get('/v1.0/businesses', [BusinessController::class, "getBusinesses"]);
Route::get('/v1.0/businesses/{id}', [BusinessController::class, "getBusinessById"]);
Route::get('/v2.0/businesses/{id}', [BusinessController::class, "getBusinessByIdV2"]);

Route::get('/v1.0/business-subscriptions/{id}', [BusinessController::class, "getSubscriptionsByBusinessId"]);


Route::delete('/v1.0/businesses/{ids}', [BusinessController::class, "deleteBusinessesByIds"]);






// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// end business management section
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%


// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// business Time Management
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

Route::patch('/v1.0/business-times', [BusinessTimesController::class, "updateBusinessTimes"]);
Route::get('/v1.0/business-times', [BusinessTimesController::class, "getBusinessTimes"]);





// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// template management section
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

// ********************************************
// template management section --wrapper
// ********************************************
Route::put('/v1.0/email-template-wrappers', [EmailTemplateWrapperController::class, "updateEmailTemplateWrapper"]);
Route::get('/v1.0/email-template-wrappers/{perPage}', [EmailTemplateWrapperController::class, "getEmailTemplateWrappers"]);
Route::get('/v1.0/email-template-wrappers/single/{id}', [EmailTemplateWrapperController::class, "getEmailTemplateWrapperById"]);

// ********************************************
// template management section
// ********************************************
Route::post('/v1.0/email-templates', [EmailTemplateController::class, "createEmailTemplate"]);
Route::put('/v1.0/email-templates', [EmailTemplateController::class, "updateEmailTemplate"]);
Route::get('/v1.0/email-templates/{perPage}', [EmailTemplateController::class, "getEmailTemplates"]);
Route::get('/v1.0/email-templates/single/{id}', [EmailTemplateController::class, "getEmailTemplateById"]);
Route::get('/v1.0/email-template-types', [EmailTemplateController::class, "getEmailTemplateTypes"]);
 Route::delete('/v1.0/email-templates/{id}', [EmailTemplateController::class, "deleteEmailTemplateById"]);

// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// template management section
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%


// ********************************************
// notification template management section
// ********************************************

Route::put('/v1.0/notification-templates', [NotificationTemplateController::class, "updateNotificationTemplate"]);
Route::get('/v1.0/notification-templates/{perPage}', [NotificationTemplateController::class, "getNotificationTemplates"]);
Route::get('/v1.0/notification-templates/single/{id}', [NotificationTemplateController::class, "getEmailTemplateById"]);
Route::get('/v1.0/notification-template-types', [NotificationTemplateController::class, "getNotificationTemplateTypes"]);
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// notification template management section
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%











});

// !!!!!!!@@@@@@@@@@@@$$$$$$$$$$$$%%%%%%%%%%%%%%%%^^^^^^^^^^
// end admin routes
// !!!!!!!@@@@@@@@@@@@$$$$$$$$$$$$%%%%%%%%%%%%%%%%^^^^^^^^^^



Route::post('/v1.0/client/auth/register-with-business', [BusinessController::class, "registerUserWithBusinessClient"]);
Route::get('/v1.0/client/service-plans', [ServicePlanController::class, "getServicePlanClient"]);

Route::post('/v1.0/client/check-discount', [ServicePlanController::class, "checkDiscountClient"]);


Route::post('webhooks/stripe', [CustomWebhookController::class, "handleStripeWebhook"])->name("stripe.webhook");





// remove below routes.








































































