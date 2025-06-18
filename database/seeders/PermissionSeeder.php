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
            'refleksi.export',
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
            'aktivitas_keperawatan.export',
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
            'supervisi_kepru.export',
        ];

        foreach ($supervisiKepalaRuangPermissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $insidenPermissions = [
            'insiden.list',
            'insiden.buat',
            'insiden.hapus',
            'insiden.export',
        ];

        foreach ($insidenPermissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $kuesionerPermissions = [
            'kuesioner.list',
            'kuesioner.buat',
            'kuesioner.hapus',
        ];

        foreach ($kuesionerPermissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $materiPermissions = [
            'materi.list',
            'materi.buat',
        ];

        foreach ($materiPermissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $kuisPermissions = [
            'kuis.list',
            'kuis.buat',
            'kuis.detail',
            'kuis.edit',
            'kuis.hapus',
            'kuis.mengerjakan',
        ];

        foreach ($kuisPermissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $limaRPermissions = [
            'lima_r.list',
            'lima_r.buat',
            'lima_r.edit',
            'lima_r.hapus',
            'lima_r.lihat.sendiri',
            'lima_r.lihat.semua',
            'lima_r.export',
        ];

        foreach ($limaRPermissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $cuciTanganPermissions = [
            'cuci_tangan.list',
            'cuci_tangan.buat',
            'cuci_tangan.edit',
            'cuci_tangan.hapus',
            'cuci_tangan.lihat.sendiri',
            'cuci_tangan.lihat.semua',
        ];

        foreach ($cuciTanganPermissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $unduhSertifikatPermissions = [
            'unduh_sertifikat.list',
            'unduh_sertifikat.buat',
            'unduh_sertifikat.edit',
            'unduh_sertifikat.hapus',
            'unduh_sertifikat.download',
        ];

        foreach ($unduhSertifikatPermissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
