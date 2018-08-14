<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use App\Models\Divisi;

class Karyawan extends Form
{
    public function buildForm()
    {
        $divisi = (new Divisi);
    	
    	$this
        ->add('profil_pic','file',[ 
            'label'=>'Photo',
        ])
        ->add('id','text',[
            'rules'=>'required',
            'label' => 'No',
            'attr'=>['class'=>'id_karyawan form-control']
    	])
    	->add('nama','text',[
    		'rules'=>'required'
    	])
    	->add('email','email')
    	->add('tempat_lahir', 'text')
    	->add('tanggal_lahir','date')
    	->add('tanggal_masuk','date')
    	->add('no_hp','number')
        ->add('username','text')
        ->add('password','password')
        ->add('divisi_id', 'select', [
                'rules'=>'required',
                'choices' => $divisi->pluck("nama", "id")->toArray(),
                'attr'=>['id'=>'divisi_id'],
                'empty_value' => '- Pilih Divisi -',
                'label' => 'Divisi'
            ])
    	->add('level','select',[
                'rules'=>'required',
                'choices' => ['admin'=>'Admin','karyawan'=>'Karyawan','kepala divisi'=>'Kepala Divisi','hrd'=>'HRD','manager'=>'Manager'],
                'attr'=>['id'=>'level_id'],
                'empty_value' => '- Pilih Level -',
                'label' => 'Level'
        ])
        ->add('submit', 'submit', ['label' => 'Save','attr'=>['class'=>'btn-success btn btn-flat btn-block']]);
    }
}
