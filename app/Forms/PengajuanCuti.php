<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class PengajuanCuti extends Form
{
    public function buildForm()
    {
    	$jenis_cuti = [	'Cuti Tahunan'=>'Cuti Tahunan',
    					'Cuti Sakit'=>'Cuti Sakit',
    					'Cuti Besar'=>'Cuti Besar',
    					'Cuti Hamil'=>'Cuti Hamil',
    					'Cuti Penting'=>'Cuti Penting'
    				];
        $this
    	->add('jenis_cuti', 'select', [
                'rules'=>'required',
                'choices' => $jenis_cuti,
                'attr'=>['id'=>'jenis_cuti'],
                'empty_value' => '- Pilih Jenis Cuti -',
                'label' => 'Jenis Cuti'
            ])
    	->add('tanggal_mulai','date',[
    		'rules'=>'required'
    	])
    	->add('tanggal_selesai','date',[
    		'rules'=>'required'
    	])
    	->add('keterangan','textarea')
        ->add('submit', 'submit', ['label' => 'Save','attr'=>['class'=>'btn-success btn btn-flat btn-block']]);
    }
}
