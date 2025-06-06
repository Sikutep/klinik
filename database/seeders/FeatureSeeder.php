<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            [
                'name' => 'Dashboard',
                'menu' => 'Dashboard',
                'icon' => 'i-heroicons-chart-bar-20-solid',
                'route' => 'dashboard.index',
                'is_active' => true,
                'description' => 'Halaman utama untuk melihat ringkasan data',
            ],
            [
                'name' => 'Pasien',
                'menu' => 'Pasien',
                'icon' => 'i-heroicons-user-group-20-solid',
                'route' => 'pasien.index',
                'is_active' => true,
                'description' => 'Halaman untuk mengelola data pasien',
            ],

            [
                'name' => 'Registrasi',
                'menu' => 'Registrasi',
                'icon' => 'i-heroicons-user-plus-20-solid',
                'route' => 'registrasi.index',
                'is_active' => true,
                'description' => 'Halaman untuk melakukan registrasi pasien baru',
            ],
            [
                'name' => 'Antrian',
                'menu' => 'Antrian',
                'icon' => 'i-heroicons-queue-list-20-solid',
                'route' => 'antrian.index',
                'is_active' => true,
                'description' => 'Halaman untuk mengelola antrian pasien',
            ],
            [
                'name' => 'Laporan',
                'menu' => 'Laporan',
                'icon' => 'i-heroicons-document-report-20-solid',
                'route' => 'laporan.index',
                'is_active' => true,
                'description' => 'Halaman untuk melihat laporan data pasien dan antrian',
            ],
            [
                'name' => 'Pengaturan',
                'menu' => 'Pengaturan',
                'icon' => 'i-heroicons-cog-20-solid',
                'route' => 'pengaturan.index',
                'is_active' => true,
                'description' => 'Halaman untuk mengelola pengaturan sistem',
            ],
            [
                'name' => 'User Management',
                'menu' => 'User Management',
                'icon' => 'i-heroicons-users-20-solid',
                'route' => 'user-management.index',
                'is_active' => true,
                'description' => 'Halaman untuk mengelola pengguna sistem',
            ],
            [
                'name' => 'Role Management',
                'menu' => 'Role Management',
                'icon' => 'i-heroicons-shield-check-20-solid',
                'route' => 'role-management.index',
                'is_active' => true,
                'description' => 'Halaman untuk mengelola peran dan hak akses pengguna',
            ],
            [
                'name' => 'Feature Management',
                'menu' => 'Feature Management',
                'icon' => 'i-heroicons-cube-20-solid',
                'route' => 'feature-management.index',
                'is_active' => true,
                'description' => 'Halaman untuk mengelola fitur sistem',
            ],
            [
                'name' => 'Audit Log',
                'menu' => 'Audit Log',
                'icon' => 'i-heroicons-clipboard-list-20-solid',
                'route' => 'audit-log.index',
                'is_active' => true,
                'description' => 'Halaman untuk melihat log audit sistem',
            ],
            [
                'name' => 'Backup & Restore',
                'menu' => 'Backup & Restore',
                'icon' => 'i-heroicons-cloud-upload-20-solid',
                'route' => 'backup-restore.index',
                'is_active' => true,
                'description' => 'Halaman untuk melakukan backup dan restore data sistem',
            ],
            [
                'name' => 'Notification',
                'menu' => 'Notification',
                'icon' => 'i-heroicons-bell-20-solid',
                'route' => 'notification.index',
                'is_active' => true,
                'description' => 'Halaman untuk mengelola notifikasi sistem',
            ],
            [
                'name' => 'Help & Support',
                'menu' => 'Help & Support',
                'icon' => 'i-heroicons-question-mark-circle-20-solid',
                'route' => 'help-support.index',
                'is_active' => true,
                'description' => 'Halaman untuk mendapatkan bantuan dan dukungan sistem',
            ],
        ];
        foreach ($features as $feature) {
            DB::table('features')->updateOrInsert(
                ['name' => $feature['name']],
                $feature
            );
        }
    }
}
