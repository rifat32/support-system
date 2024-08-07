<?php

namespace App\Http\Controllers;

use App\Http\Utils\ErrorUtil;
use App\Http\Utils\SetupUtil;
use App\Http\Utils\UserActivityUtil;
use App\Models\ActivityLog;
use App\Models\Bank;
use App\Models\Business;
use App\Models\Designation;
use App\Models\EmploymentStatus;
use App\Models\ErrorLog;
use App\Models\JobPlatform;
use App\Models\JobType;
use App\Models\RecruitmentProcess;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use App\Models\Role;
use App\Models\ServicePlan;
use App\Models\SettingAttendance;
use App\Models\SettingLeave;
use App\Models\SettingLeaveType;
use App\Models\SettingPaymentDate;
use App\Models\SettingPayrun;
use App\Models\SocialSite;
use App\Models\TaskCategory;
use App\Models\TerminationReason;
use App\Models\TerminationType;
use App\Models\WorkLocation;
use App\Models\WorkShift;
use App\Models\WorkShiftHistory;
use Illuminate\Support\Facades\Log;

class SetUpController extends Controller
{
    use ErrorUtil, UserActivityUtil, SetupUtil;

    public function getFrontEndErrorLogs(Request $request)
    {
        $this->storeActivity($request, "DUMMY activity", "DUMMY description");
        $error_logs = ErrorLog::whereIn("status_code", [422, 403, 400, 404, 409])
            ->when(!empty($request->status), function ($query) use ($request) {
                $query->where("status_code", $request->status);
            })
            ->orderbyDesc("id")->paginate(10);
        return view("error-log", compact("error_logs"));
    }

    public function getErrorLogs(Request $request)
    {
        $this->storeActivity($request, "DUMMY activity", "DUMMY description");
        $error_logs = ErrorLog::when(!empty($request->status_code), function ($query) use ($request) {
                $query->where("status_code", $request->status);
            })
            ->when(!empty($request->ip_address), function ($query) use ($request) {
                $query->where("ip_address", $request->ip_address);
            })
            ->when(!empty($request->request_method), function ($query) use ($request) {
                $query->where("request_method", $request->request_method);
            })
            ->when(!empty($request->id), function ($query) use ($request) {
                $query->where("id", $request->id);
            })
            ->orderbyDesc("id")->paginate(10);
        return view("error-log", compact("error_logs"));
    }

    public function testError($id, Request $request)
    {
        $this->storeActivity($request, "DUMMY activity", "DUMMY description");
        $error_log = ErrorLog::where("id", $request->id)

            ->first();
        return view("test-error", compact("error_log"));
    }

    public function testApi($id, Request $request)
    {
        $this->storeActivity($request, "DUMMY activity", "DUMMY description");
        $error_log = ActivityLog::where("id", $request->id)

            ->first();
        return view("test-api", compact("error_log"));
    }



    public function getActivityLogs(Request $request)
    {
        $this->storeActivity($request, "DUMMY activity", "DUMMY description");
        $activity_logs = ActivityLog::when(!empty($request->status_code), function ($query) use ($request) {
                $query->where("status_code", $request->status);
            })
            ->when(!empty($request->api_url), function ($query) use ($request) {
                $query->where("api_url", $request->api_url);
            })
            ->when(!empty($request->ip_address), function ($query) use ($request) {
                $query->where("ip_address", $request->ip_address);
            })
            ->when(!empty($request->request_method), function ($query) use ($request) {
                $query->where("request_method", $request->request_method);
            })
            ->when(!empty($request->id), function ($query) use ($request) {
                $query->where("id", $request->id);
            })

            ->orderbyDesc("id")
            ->paginate(100);
        return view("user-activity-log", compact("activity_logs"));
    }

    public function migrate(Request $request)
    {
        $this->storeActivity($request, "DUMMY activity", "DUMMY description");
        Artisan::call('check:migrate');
        return "migrated";
    }

    public function swaggerRefresh(Request $request)
    {
        $this->storeActivity($request, "DUMMY activity", "DUMMY description");
        Artisan::call('optimize:clear');
        Artisan::call('l5-swagger:generate');
        return "swagger generated";
    }

    public function setUp(Request $request)
    {
        $this->storeActivity($request, "DUMMY activity", "DUMMY description");
        // @@@@@@@@@@@@@@@@@@@
        // clear everything
        // @@@@@@@@@@@@@@@@@@@

        Artisan::call('optimize:clear');
        Artisan::call('migrate:fresh');
        Artisan::call('migrate', ['--path' => 'vendor/laravel/passport/database/migrations']);
        Artisan::call('passport:install');
        Artisan::call('l5-swagger:generate');



        // ##########################################
        // user
        // #########################################
        $superadmin =  User::create([
            'first_Name' => "super",
            'last_Name' => "admin",
            'phone' => "01771034383",
            'address_line_1',
            'address_line_2',
            'country' => "Bangladesh",
            'city' => "Dhaka",
            'postcode' => "1207",
            'email' => "asjadtariq@gmail.com",
            'password' => Hash::make("12345678@We"),
            "email_verified_at" => now(),
            'is_active' => 1
        ]);
        $superadmin->email_verified_at = now();
        $superadmin->save();

        $admin =  User::create([
            'first_Name' => "Shahbaz",
            'last_Name' => "Khan",
            'phone' => "01771034383",
            'address_line_1',
            'address_line_2',
            'country' => "Bangladesh",
            'city' => "Dhaka",
            'postcode' => "1207",
            'email' => "shahbaz.scm@gmail.com",
            'password' => Hash::make("12345678@We"),
            "email_verified_at" => now(),
            'is_active' => 1
        ]);
        $admin->email_verified_at = now();
        $admin->save();






        // ###############################
        // permissions
        // ###############################
        $permissions =  config("setup-config.permissions");
        // setup permissions
        foreach ($permissions as $permission) {
            if (!Permission::where([
                'name' => $permission,
                'guard_name' => 'api'
            ])
                ->exists()) {
                Permission::create(['guard_name' => 'api', 'name' => $permission]);
            }
        }
        // setup roles
        $roles = config("setup-config.roles");
        foreach ($roles as $role) {
            if (!Role::where([
                'name' => $role,
                'guard_name' => 'api',
                "is_system_default" => 1,
                "business_id" => NULL,
                "is_default" => 1,
            ])
                ->exists()) {
                Role::create([
                    'guard_name' => 'api', 'name' => $role, "is_system_default" => 1, "business_id" => NULL,
                    "is_default" => 1,
                    "is_default_for_business" => (in_array($role, [
                        "client",
                        "support_team_member",

                    ]) ? 1 : 0)


                ]);
            }
        }

        // setup roles and permissions
        $role_permissions = config("setup-config.roles_permission");
        foreach ($role_permissions as $role_permission) {
            $role = Role::where(["name" => $role_permission["role"]])->first();
            // error_log($role_permission["role"]);
            $permissions = $role_permission["permissions"];
            $role->syncPermissions($permissions);

        }



        $admin->assignRole("admin");
        $superadmin->assignRole("superadmin");

        $this->storeEmailTemplates();



        return "You are done with setup";
    }


    public function roleRefresh(Request $request)
    {

        $this->storeActivity($request, "DUMMY activity", "DUMMY description");




        // ###############################
        // permissions
        // ###############################
        $permissions =  config("setup-config.permissions");

        // setup permissions
        foreach ($permissions as $permission) {
            if (!Permission::where([
                'name' => $permission,
                'guard_name' => 'api'
            ])
                ->exists()) {
                Permission::create(['guard_name' => 'api', 'name' => $permission]);
            }
        }
        // setup roles
        $roles = config("setup-config.roles");
        foreach ($roles as $role) {
            if (!Role::where([
                'name' => $role,
                'guard_name' => 'api',
                "is_system_default" => 1,
                "business_id" => NULL,
                "is_default" => 1,
            ])
                ->exists()) {
                Role::create([
                    'guard_name' => 'api', 'name' => $role, "is_system_default" => 1, "business_id" => NULL,
                    "is_default" => 1,
                    "is_default_for_business" => (in_array($role, [
                        "client",
                        "support_team_member",
                    ]) ? 1 : 0)


                ]);
            }
        }

        // setup roles and permissions
        // setup roles and permissions
        $role_permissions = config("setup-config.roles_permission");
        foreach ($role_permissions as $role_permission) {
            $role = Role::where(["name" => $role_permission["role"]])->first();

            $permissions = $role_permission["permissions"];

            // Get current permissions associated with the role
            $currentPermissions = $role->permissions()->pluck('name')->toArray();

            // Determine permissions to remove
            $permissionsToRemove = array_diff($currentPermissions, $permissions);

            // Deassign permissions not included in the configuration
            if (!empty($permissionsToRemove)) {
                foreach ($permissionsToRemove as $permission) {
                    $role->revokePermissionTo($permission);
                }
            }

            // Assign permissions from the configuration
            $role->syncPermissions($permissions);
        }

        // $business_ids = Business::get()->pluck("id");


        // foreach ($role_permissions as $role_permission) {

        //     if($role_permission["role"] == "business_employee"){
        //         foreach($business_ids as $business_id){

        //             $role = Role::where(["name" => $role_permission["role"] . "#" . $business_id])->first();

        //            if(empty($role)){

        //             continue;
        //            }

        //                 $permissions = $role_permission["permissions"];

        //                 // Assign permissions from the configuration
        //     $role->syncPermissions($permissions);



        //         }

        //     }

        //     if($role_permission["role"] == "business_manager"){
        //         foreach($business_ids as $business_id){

        //             $role = Role::where(["name" => $role_permission["role"] . "#" . $business_id])->first();

        //            if(empty($role)){

        //             continue;
        //            }

        //                 $permissions = $role_permission["permissions"];

        //                 // Assign permissions from the configuration
        //     $role->syncPermissions($permissions);



        //         }

        //     }



        // }


        return "You are done with setup";
    }


    public function backup(Request $request)
    {
        $this->storeActivity($request, "DUMMY activity", "DUMMY description");
        foreach (DB::connection('backup_database')->table('users')->get() as $backup_data) {

            $data_exists = DB::connection('mysql')->table('users')->where([
                "id" => $backup_data->id
            ])->first();
            if (!$data_exists) {
                DB::connection('mysql')->table('users')->insert(get_object_vars($backup_data));
            }
        }


        // foreach(DB::connection('backup_database')->table('automobile_categories')->get() as $backup_data){
        //     $data_exists = DB::connection('mysql')->table('automobile_categories')->where([
        //         "id" => $backup_data->id
        //        ])->first();
        //        if(!$data_exists) {
        //         DB::connection('mysql')->table('automobile_categories')->insert(get_object_vars($backup_data));
        //        }
        //     }

        //     foreach(DB::connection('backup_database')->table('automobile_makes')->get() as $backup_data){
        //         $data_exists = DB::connection('mysql')->table('automobile_makes')->where([
        //             "id" => $backup_data->id
        //            ])->first();
        //            if(!$data_exists) {
        //             DB::connection('mysql')->table('automobile_makes')->insert(get_object_vars($backup_data));
        //            }
        //         }

        //         foreach(DB::connection('backup_database')->table('automobile_models')->get() as $backup_data){
        //             $data_exists = DB::connection('mysql')->table('automobile_models')->where([
        //                 "id" => $backup_data->id
        //                ])->first();
        //                if(!$data_exists) {
        //                 DB::connection('mysql')->table('automobile_models')->insert(get_object_vars($backup_data));
        //                }
        //             }

        //             foreach(DB::connection('backup_database')->table('services')->get() as $backup_data){
        //                 $data_exists = DB::connection('mysql')->table('services')->where([
        //                     "id" => $backup_data->id
        //                    ])->first();
        //                    if(!$data_exists) {
        //                     DB::connection('mysql')->table('services')->insert(get_object_vars($backup_data));
        //                    }
        //                 }


        //                 foreach(DB::connection('backup_database')->table('sub_services')->get() as $backup_data){
        //                     $data_exists = DB::connection('mysql')->table('sub_services')->where([
        //                         "id" => $backup_data->id
        //                        ])->first();
        //                        if(!$data_exists) {
        //                         DB::connection('mysql')->table('sub_services')->insert(get_object_vars($backup_data));
        //                        }
        //                     }



        foreach (DB::connection('backup_database')->table('businesses')->get() as $backup_data) {
            $data_exists = DB::connection('mysql')->table('businesses')->where([
                "id" => $backup_data->id
            ])->first();
            if (!$data_exists) {
                DB::connection('mysql')->table('businesses')->insert(get_object_vars($backup_data));
            }
        }

        foreach (DB::connection('backup_database')->table('business_automobile_makes')->get() as $backup_data) {
            $data_exists = DB::connection('mysql')->table('business_automobile_makes')->where([
                "id" => $backup_data->id
            ])->first();
            if (!$data_exists) {
                DB::connection('mysql')->table('business_automobile_makes')->insert(get_object_vars($backup_data));
            }
        }

        foreach (DB::connection('backup_database')->table('business_automobile_models')->get() as $backup_data) {
            $data_exists = DB::connection('mysql')->table('business_automobile_models')->where([
                "id" => $backup_data->id
            ])->first();
            if (!$data_exists) {
                DB::connection('mysql')->table('business_automobile_models')->insert(get_object_vars($backup_data));
            }
        }

        foreach (DB::connection('backup_database')->table('business_services')->get() as $backup_data) {
            $data_exists = DB::connection('mysql')->table('business_services')->where([
                "id" => $backup_data->id
            ])->first();
            if (!$data_exists) {
                DB::connection('mysql')->table('business_services')->insert(get_object_vars($backup_data));
            }
        }

        foreach (DB::connection('backup_database')->table('business_sub_services')->get() as $backup_data) {
            $data_exists = DB::connection('mysql')->table('business_sub_services')->where([
                "id" => $backup_data->id
            ])->first();
            if (!$data_exists) {
                DB::connection('mysql')->table('business_sub_services')->insert(get_object_vars($backup_data));
            }
        }
        foreach (DB::connection('backup_database')->table('fuel_stations')->get() as $backup_data) {
            $data_exists = DB::connection('mysql')->table('fuel_stations')->where([
                "id" => $backup_data->id
            ])->first();
            if (!$data_exists) {
                DB::connection('mysql')->table('fuel_stations')->insert(get_object_vars($backup_data));
            }
        }

        return response()->json("done", 200);
    }
}
