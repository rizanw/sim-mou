<?php

return [
    'activated'        => true, // active/inactive all logging
    'middleware'       => ['web', 'auth'],
    'route_path'       => 'app/control/user-activity',
    'admin_panel_path' => 'app/dashboard',
    'delete_limit'     => 360, // default 7 days

    'model' => [
        'user' => "App\Models\User"
    ],

    'log_events' => [
        'on_create'     => true,
        'on_edit'       => true,
        'on_delete'     => true,
        'on_login'      => true,
        'on_lockout'    => true
    ]
];
