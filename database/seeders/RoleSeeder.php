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
            'name' => 'dr. Diyanti',
            'username' => 'drdiyanti',
            'password' => bcrypt('drdiyanti123'),
            'unit' => 'Direktur'
        ]);
        $superAdmin->assignRole('Super Admin');

        $perawat = User::firstOrCreate([
            'name' => 'dr. Andi',
            'username' => 'drandi',
            'password' => bcrypt('drandi123'),
            'unit' => 'Ruang Rawat Inap'
        ]);
        $perawat->assignRole('Perawat');

        $menajemen = User::firstOrCreate([
            'name' => 'dr. Prayogi',
            'username' => 'drprayogi',
            'password' => bcrypt('drprayogi123'),
            'unit' => 'Dokter Spesialis'
        ]);
        $menajemen->assignRole('Menajemen');

        $kepalaRuang = User::firstOrCreate([
            'name' => 'dr. Fachrul',
            'username' => 'drfachrul',
            'password' => bcrypt('drfachrul123'),
            'unit' => 'Manajer Keperawatan'
        ]);
        $kepalaRuang->assignRole('Kepala Ruang');
    }
}
