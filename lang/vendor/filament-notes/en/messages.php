<?php

return [
    "title" => "Standart ESD",
    "single" => "Standart",
    "group" => "Work instruction",
    "pages" => [
        "groups" => "Manage Standart Groups",
        "status" => "Manage Standart Status"
    ],
    "columns" => [
        "title" => "Title",
        "body" => "Body",
        "date" => "Date",
        "time" => "Time",
        "is_pined" => "Is Pined",
        "is_public" => "Is Public",
        "icon" => "Icon",
        "background" => "Background",
        "border" => "Border",
        "color" => "Color",
        "font_size" => "Font Size",
        "font" => "Font",
        "group" => "Group",
        "status" => "Status",
        "user_id" => "User ID",
        "user_type" => "User Type",
        "model_id" => "Model ID",
        "model_type" => "Model Type",
        "created_at" => "Created At",
        "updated_at" => "Updated At"
    ],
    "tabs" => [
        "general" => "General",
        "style" => "Style"
    ],
    "actions" => [
        "view" => "View",
        "edit" => "Edit",
        "delete" => "Delete",
        "notify" => [
            "label" => "Notify User",
            "notification" => [
                "title" => "Notification Sent",
                "body" => "The notification has been sent."
            ]
        ],
        "share" => [
            "label" => "Share Standart",
            "notification" => [
                "title" => "Standart Shared Link Created",
                "body" => "The Standart shared link has been created and copied to clipboard."
            ]
        ],
        "user_access" => [
            "label" => "User Access",
            "form" => [
                "model_id" => "Users",
                "model_type" => "User Type",
            ],
            "notification" => [
                "title" => "User Access Updated",
                "body" => "The user access has been updated."
            ]
        ],
        "checklist"=> [
            "label" => "Add Checklist",
            "form" => [
                "checklist"=> "Checklist"
            ],
            "state" => [
                "done" => "Done",
                "pending" => "Pending"
            ],
            "notification" => [
                "title" => "Checklist Updated",
                "body" => "The checklist has been updated.",
                "updated" => [
                    "title" => "Checklist Item Updated",
                    "body" => "The checklist item has been updated."
                ],
            ]
        ]
    ],
    "notifications" => [
        "edit" => [
            "title" => "Standart Updated",
            "body" => "The Standart has been updated."
        ],
        "delete" => [
            "title" => "Standart Deleted",
            "body" => "The Standart has been deleted."
        ]
    ]
];
