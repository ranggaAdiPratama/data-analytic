<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class indexSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $admin = Role::create([
            'name' => 'Admin'
        ]);

        $data   = [
            'email'     => $faker->unique()->safeEmail,
            'name'      => $faker->name,
            'password'  => Hash::make('12345678'),
            'username'  => 'admin',
        ];

        $user   = User::create($data);

        $user->syncRoles($admin);

        Artisan::call('passport:install');
    }
}
