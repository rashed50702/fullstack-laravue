<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        
        Role::create([
            'roleName' => 'Admin',
            'permission' => '[{"resourceName":"Home","iconType":"ios-home-outline","read":true,"write":true,"update":true,"delete":true,"name":"/"},{"resourceName":"Tags","iconType":"ios-pricetags","read":true,"write":true,"update":true,"delete":true,"name":"tags"},{"resourceName":"Categories","iconType":"ios-list-box","read":true,"write":true,"update":true,"delete":true,"name":"categories"},{"resourceName":"Admin Users","iconType":"ios-contacts","read":true,"write":true,"update":true,"delete":true,"name":"admin-users"},{"resourceName":"Roles","iconType":"ios-grid","read":true,"write":true,"update":true,"delete":true,"name":"roles"},{"resourceName":"Role Permissions","iconType":"ios-paper","read":true,"write":true,"update":true,"delete":true,"name":"role-permissions"}]',
        ]);
        Role::create([
            'roleName' => 'Editor'
        ]);
        Role::create([
            'roleName' => 'User'
        ]);
        User::create([
            'fullName' => 'Rashedul Hasan',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456'),
            'role_id' => 1
        ]);
    }
}
