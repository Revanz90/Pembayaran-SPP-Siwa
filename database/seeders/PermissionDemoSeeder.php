<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // reset cahced roles and permission
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'view data_siswa']);
        Permission::create(['name' => 'create data_siswa']);
        Permission::create(['name' => 'view data_pembayaran_spp']);
        Permission::create(['name' => 'create data_pembayaran_spp']);
        // Permission::create(['name' => 'view data_angsuran']);
        // Permission::create(['name' => 'create data_angsuran']);

        //create roles and assign existing permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo('view data_siswa');
        $adminRole->givePermissionTo('create data_siswa');
        $adminRole->givePermissionTo('view data_pembayaran_spp');
        $adminRole->givePermissionTo('create data_pembayaran_spp');
        // $adminRole->givePermissionTo('view data_angsuran');
        // $adminRole->givePermissionTo('create data_angsuran');

        $kepalaSekolahRole = Role::create(['name' => 'kepalaSekolah']);
        $kepalaSekolahRole->givePermissionTo('view data_siswa');
        $kepalaSekolahRole->givePermissionTo('create data_siswa');
        $kepalaSekolahRole->givePermissionTo('view data_pembayaran_spp');
        $kepalaSekolahRole->givePermissionTo('create data_pembayaran_spp');
        // $kepalaRole->givePermissionTo('view data_angsuran');
        // $kepalaRole->givePermissionTo('create data_angsuran');

        $bendahara1Role = Role::create(['name' => 'bendahara1']);
        $bendahara1Role->givePermissionTo('view data_siswa');
        $bendahara1Role->givePermissionTo('create data_siswa');
        $bendahara1Role->givePermissionTo('view data_pembayaran_spp');
        $bendahara1Role->givePermissionTo('create data_pembayaran_spp');
        // $bendaharaRole->givePermissionTo('view data_angsuran');
        // $bendaharaRole->givePermissionTo('create data_angsuran');

        $bendahara2Role = Role::create(['name' => 'bendahara2']);
        $bendahara2Role->givePermissionTo('view data_siswa');
        $bendahara2Role->givePermissionTo('create data_siswa');
        $bendahara2Role->givePermissionTo('view data_pembayaran_spp');
        $bendahara2Role->givePermissionTo('create data_pembayaran_spp');
        // $bendaharaRole->givePermissionTo('view data_angsuran');
        // $bendaharaRole->givePermissionTo('create data_angsuran');

        $siswaRole = Role::create(['name' => 'siswa']);
        $siswaRole->givePermissionTo('view data_siswa');
        $siswaRole->givePermissionTo('create data_siswa');
        $siswaRole->givePermissionTo('view data_pembayaran_spp');
        $siswaRole->givePermissionTo('create data_pembayaran_spp');
        // $anggotaRole->givePermissionTo('view data_angsuran');
        // $anggotaRole->givePermissionTo('create data_angsuran');

        // create superadmin
        $user = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
        $user->assignRole($adminRole);

        // create kepala sekolah
        $user = User::factory()->create([
            'name' => 'kepala sekolah',
            'email' => 'kepalasekolah@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
        $user->assignRole($kepalaSekolahRole);

        // create bendahara 1
        $user = User::factory()->create([
            'name' => 'bendahara 1',
            'email' => 'bendahara1@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
        $user->assignRole($bendahara1Role);

        // create bendahara 2
        $user = User::factory()->create([
            'name' => 'bendahara 2',
            'email' => 'bendahara2@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
        $user->assignRole($bendahara2Role);

        // create 
        $user = User::factory()->create([
            'name' => 'siswa',
            'email' => 'siswa@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
        $user->assignRole($siswaRole);

    }
}
