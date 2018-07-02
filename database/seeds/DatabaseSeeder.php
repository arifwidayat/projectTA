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

        $datajabatan = new \App\Models\Jabatan;
        $datajabatan->insert(['nama'=>'programmer']);
        $datajabatan->insert(['nama'=>'keuangan']);
        
        $divisi = \App\Models\Divisi::where('nama','IT')->first();
        $jabatan = \App\Models\Jabatan::where('nama','programmer')->first();

        $karyawan = new \App\Models\Karyawan;
        $karyawan->insert([
        		'no'=>1,
        		'nama'=>'admin',
        		'email'=>'admin@mail.com',
        		'tempat_lahir'=>'terminal',
        		'tanggal_lahir'=>date('Y-m-d'),
        		'tanggal_masuk'=>date('Y-m-d'),
        		'no_hp'=>'1234567890',
                'jabatan_id'=>$jabatan->id,
        		'level'=>'admin',
        		'username'=>'admin',
        		'password'=>bcrypt('admin'),
        		'divisi_id'=>$divisi->id,
	        ]);
        $karyawan->insert([
        		'no'=>2,
        		'nama'=>'kepala divisi',
        		'email'=>'kepaladivisi@mail.com',
        		'tempat_lahir'=>'terminal',
        		'tanggal_lahir'=>date('Y-m-d'),
        		'tanggal_masuk'=>date('Y-m-d'),
        		'no_hp'=>'1234567890',
                'jabatan_id'=>$jabatan->id,
        		'level'=>'kepala divisi',
        		'username'=>'kepaladivisi',
        		'password'=>bcrypt('kepaladivisi'),
        		'divisi_id'=>$divisi->id,
	        ]);
        $karyawan->insert([
        		'no'=>3,
        		'nama'=>'karyawan',
        		'email'=>'karyawan@mail.com',
        		'tempat_lahir'=>'terminal',
        		'tanggal_lahir'=>date('Y-m-d'),
        		'tanggal_masuk'=>date('Y-m-d'),
        		'no_hp'=>'1234567890',
                'jabatan_id'=>$jabatan->id,
        		'level'=>'karyawan',
        		'username'=>'karyawan',
        		'password'=>bcrypt('karyawan'),
        		'divisi_id'=>$divisi->id,
	        ]);
    }
}
