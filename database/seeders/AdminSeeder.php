<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء الأدوار إذا لم تكن موجودة
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // إنشاء الصلاحيات
        $permissions = [
            'manage-users',
            'manage-content',
            'manage-services',
            'view-dashboard',
            'manage-settings'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // إعطاء جميع الصلاحيات للأدمن
        $adminRole->syncPermissions($permissions);

        // إنشاء مستخدم أدمن إذا لم يكن موجوداً
        $admin = User::firstOrCreate(
            ['email' => 'admin@soliman.com'],
            [
                'name' => 'Soliman Admin',
                'password' => Hash::make('Admin@2025'),
                'email_verified_at' => now(),
            ]
        );

        // إعطاء دور الأدمن للمستخدم
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }
    }
}
