<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            'super_admin',
            'admin',
            'tim_penilai',
            'koordinator',
        ];
        $permissions = [
            // Kriteria
            'kriteria.view',
            'kriteria.create',
            'kriteria.edit',
            'kriteria.delete',
            'kriteria.input_bobot',
            // Sub Kriteria
            'sub_kriteria.view',
            'sub_kriteria.create',
            'sub_kriteria.edit',
            'sub_kriteria.delete',
            'sub_kriteria.input_bobot',
            // Permission lain (tambahkan sesuai kebutuhan)
            'dashboard',
            'kelola_role',
            'data_proyek',
            'data_manajer_proyek',
            'data_jenis_proyek',
            'penilaian',
            'laporan',
        ];
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }
        foreach ($roles as $role) {
            $roleObj = Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
            if ($role === 'super_admin') {
                $roleObj->syncPermissions(Permission::all());
            } elseif ($role === 'admin') {
                $roleObj->syncPermissions([
                    'kriteria.view', 'kriteria.create', 'kriteria.edit', 'kriteria.delete', 'kriteria.input_bobot',
                    'sub_kriteria.view', 'sub_kriteria.create', 'sub_kriteria.edit', 'sub_kriteria.delete', 'sub_kriteria.input_bobot',
                    'dashboard', 'kelola_role', 'data_proyek', 'data_manajer_proyek', 'data_jenis_proyek', 'penilaian', 'laporan',
                ]);
            } elseif ($role === 'tim_penilai') {
                $roleObj->syncPermissions([
                    'kriteria.view', 'kriteria.input_bobot',
                    'sub_kriteria.view', 'sub_kriteria.input_bobot',
                ]);
            }
        }
        // Assign super_admin ke semua user
        $superAdminRole = Role::where('name', 'super_admin')->first();
        foreach (User::all() as $user) {
            if (!$user->hasRole('super_admin')) {
                $user->assignRole('super_admin');
            }
        }
        // Tambah permission kelola_periode
        $kelolaPeriode = Permission::firstOrCreate(['name' => 'kelola_periode']);
        // Assign ke role superadmin
        $superadmin = Role::where('name', 'super_admin')->first();
        if ($superadmin) {
            $superadmin->givePermissionTo($kelolaPeriode);
        }
    }
} 