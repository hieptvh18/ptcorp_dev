<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Auth Model
    |--------------------------------------------------------------------------
    |
    | This is the Auth model used by Teamwork.
    |
    */
    'user_model' => config('auth.providers.users.model', App\Models\User::class),

    /*
    |--------------------------------------------------------------------------
    | Teamwork users Table
    |--------------------------------------------------------------------------
    |
    | This is the users table name used by Teamwork.
    |
    */
    'users_table' => 'auth_users',

    /*
    |--------------------------------------------------------------------------
    | Teamwork Team Model
    |--------------------------------------------------------------------------
    |
    | This is the Team model used by Teamwork to create correct relations.  Update
    | the team if it is in a different namespace.
    |
    */
    // 'team_model' => Mpociot\Teamwork\TeamworkTeam::class,
    'team_model' => Modules\Auth\Models\Teamwork::class,

    /*
    |--------------------------------------------------------------------------
    | Teamwork teams Table
    |--------------------------------------------------------------------------
    |
    | This is the teams table name used by Teamwork to save teams to the database.
    |
    */
    'teams_table' => 'auth_teams',

    /*
    |--------------------------------------------------------------------------
    | Teamwork team_user Table
    |--------------------------------------------------------------------------
    |
    | This is the team_user table used by Teamwork to save assigned teams to the
    | database.
    |
    */
    'team_user_table' => 'auth_team_user',

    /*
    |--------------------------------------------------------------------------
    | User Foreign key on Teamwork's team_user Table (Pivot)
    |--------------------------------------------------------------------------
    */
    'user_foreign_key' => 'id',

    /*
    |--------------------------------------------------------------------------
    | Teamwork Team Invite Model
    |--------------------------------------------------------------------------
    |
    | This is the Team Invite model used by Teamwork to create correct relations.
    | Update the team if it is in a different namespace.
    |
    */
    'invite_model' => Mpociot\Teamwork\TeamInvite::class,

    /*
    |--------------------------------------------------------------------------
    | Teamwork team invites Table
    |--------------------------------------------------------------------------
    |
    | This is the team invites table name used by Teamwork to save sent/pending
    | invitation into teams to the database.
    |
    */
    'team_invites_table' => 'auth_team_invites',
];
