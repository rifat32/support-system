<?php



return [
    "roles_permission" => [
        [
            "role" => "superadmin",
            "permissions" =>  config("super_admin_permissions")
        ],
        [
            "role" => "admin",
            "permissions" =>  config("admin_permissions")
        ],
        [
            "role" => "support_team_member",
            "permissions" =>  config("support_team_member_permissions")
        ],
        [
            "role" => "client",
            "permissions" =>  config("client_permissions")
        ],

    ],
    "roles" => config("roles"),
    "permissions" => config("permissions"),


    "beautified_permissions" => [

        [
            "header" => "user",
            "permissions" => [

                [
                    "name" => "user_create",
                    "title" => "create"
                ],
                [
                    "name" => "user_update",
                    "title" => "update"
                ],
                [
                    "name" => "user_view",
                    "title" => "view"
                ],
                [
                    "name" => "user_delete",
                    "title" => "delete"
                ],

            ],
        ],
        [
            "header" => "role",
            "permissions" => [

                [
                    "name" => "role_create",
                    "title" => "create"
                ],
                [
                    "name" => "role_update",
                    "title" => "update"
                ],
                [
                    "name" => "role_view",
                    "title" => "view"
                ],
                [
                    "name" => "role_delete",
                    "title" => "delete"
                ],

            ],
        ],

    ],





    "folder_locations" => ["pension_scheme_letters", "recruitment_processes", "candidate_files", "leave_attachments", "assets", "documents", "education_docs", "right_to_work_docs", "visa_docs", "payment_record_file", "pension_letters", "payslip_logo", "business_images", "user_images"],



    "temporary_files_location" => "temporary_files",









];
