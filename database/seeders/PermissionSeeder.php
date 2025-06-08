<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
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
        $refleksiPermissions = [
            'refleksi.list',
            'refleksi.buat',
            'refleksi.edit',
            'refleksi.lihat.sendiri',
            'refleksi.lihat.semua',
            'refleksi.beri.approvement',
            'refleksi.beri.nilai',
            'refleksi.hapus',
        ];

        foreach ($refleksiPermissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $aktivitasKeperawatanPermissions = [
            'aktivitas_keperawatan.list',
            'aktivitas_keperawatan.buat',
            'aktivitas_keperawatan.edit',
            'aktivitas_keperawatan.hapus',
            'aktivitas_keperawatan.lihat.sendiri',
            'aktivitas_keperawatan.lihat.semua',
            'aktivitas_keperawatan.beri.nilai',
        ];

        foreach ($aktivitasKeperawatanPermissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $supervisiKepalaRuangPermissions = [
            'supervisi_kepru.list',
            'supervisi_kepru.buat',
            'supervisi_kepru.edit',
            'supervisi_kepru.hapus',
            'supervisi_kepru.lihat.sendiri',
            'supervisi_kepru.lihat.semua',
        ];

        foreach ($supervisiKepalaRuangPermissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
