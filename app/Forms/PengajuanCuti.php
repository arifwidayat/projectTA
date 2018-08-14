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

        foreach($jenis_cuti as $value){
            $cuti = \App\Models\Cuti::whereYear('tanggal_mulai','=',date('Y'))->where('status','verified')->where('jenis_cuti',$value)->first();
            if(!empty($cuti)){
                unset($jenis_cuti[$value]);
            }
        }

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
