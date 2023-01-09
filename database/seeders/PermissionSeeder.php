<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'Admin',
            'Dev',
            'Sales',
            'Finance',
            'Editor'
        ];


        foreach ($roles as $key => $value) {
            if(!Role::where('guard_name', 'jwt-staff')->where('name',$value)->exists())
                Role::create(['guard_name' => 'jwt-staff', 'name' => $value]);
        }

        if (!Staff::where('name', 'Admin')->exists()) {
            $staff = Staff::create([
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin@123'),
            ])->assignRole('Admin');
        }
        

    }
}
