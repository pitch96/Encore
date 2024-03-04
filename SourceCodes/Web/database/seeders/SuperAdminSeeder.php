<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'Chyna',
            'last_name' => 'Hobbs',
            'user_type' => config('constants.ADMIN_TYPE'),
            'email' => 'admin@encoreevents.live',
            'password' => Hash::make('encore@event'),
        ]);
    }
}
