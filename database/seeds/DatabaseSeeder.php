<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $datadivisi = new \App\Models\Divisi;
        $datadivisi->insert(['nama'=>'IT']);
        $datadivisi->insert(['nama'=>'HRD']);

        $divisi = \App\Models\Divisi::where('nama','IT')->first();

        $karyawan = new \App\Models\Karyawan;
        $karyawan->insert([
        		'id'=>1,
        		'nama'=>'admin',
        		'email'=>'admin@mail.com',
        		'tempat_lahir'=>'terminal',
        		'tanggal_lahir'=>date('Y-m-d'),
        		'tanggal_masuk'=>date('Y-m-d'),
        		'no_hp'=>'1234567890',
        		'level'=>'admin',
        		'username'=>'admin',
        		'password'=>bcrypt('admin'),
        		'divisi_id'=>$divisi->id,
                'photo'=>asset('img/default-user.png'),
	        ]);
        $karyawan->insert([
        		'id'=>2,
        		'nama'=>'kepala divisi',
        		'email'=>'kepaladivisi@mail.com',
        		'tempat_lahir'=>'terminal',
        		'tanggal_lahir'=>date('Y-m-d'),
        		'tanggal_masuk'=>date('Y-m-d'),
        		'no_hp'=>'1234567890',
        		'level'=>'kepala divisi',
        		'username'=>'kepaladivisi',
        		'password'=>bcrypt('kepaladivisi'),
        		'divisi_id'=>$divisi->id,
                'photo'=>asset('img/default-user.png'),
	        ]);
        $karyawan->insert([
        		'id'=>3,
        		'nama'=>'karyawan',
        		'email'=>'karyawan@mail.com',
        		'tempat_lahir'=>'terminal',
        		'tanggal_lahir'=>date('Y-m-d'),
        		'tanggal_masuk'=>date('Y-m-d'),
        		'no_hp'=>'1234567890',
        		'level'=>'karyawan',
        		'username'=>'karyawan',
        		'password'=>bcrypt('karyawan'),
        		'divisi_id'=>$divisi->id,
                'photo'=>asset('img/default-user.png'),
	        ]);
    }
}
