<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'Super Admin',
            'Menajemen',
            'Kepala Ruang',
            'Perawat'
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate([
                'name' => $role
            ]);
        }

        $superAdmin = User::firstOrCreate([
            'name' => 'Pak Admin',
            'username' => 'superadmin',
            'password' => bcrypt('superadmin123')
        ]);
        $superAdmin->assignRole('Super Admin');

        $perawat = User::firstOrCreate([
            'name' => 'Pak Perawat',
            'username' => 'perawat',
            'password' => bcrypt('perawat123')
        ]);
        $perawat->assignRole('Perawat');

        $menajemen = User::firstOrCreate([
            'name' => 'Pak Menajemen',
            'username' => 'menajemen',
            'password' => bcrypt('menajemen123')
        ]);
        $menajemen->assignRole('Menajemen');

        $kepalaRuang = User::firstOrCreate([
            'name' => 'Pak Kepala Ruang',
            'username' => 'kepalaruang',
            'password' => bcrypt('kepalaruang123')
        ]);
        $kepalaRuang->assignRole('Kepala Ruang');
    }
}
