<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use App\Models\Karyawan;

class JatahCuti extends Form
{
    public function buildForm()
    {
    	$karyawan = (new Karyawan);
        $this
    	->add('tahun','number',[
    		'rules'=>'required',
    		'default_value'=>date('Y')
    	])
    	->add('jumlah_cuti','number',[
    		'rules'=>'required'
    	])
    	->add('karyawan_id', 'select', [
                'rules'=>'required',
                'choices' => $karyawan->pluck("nama", "id")->toArray(),
                'attr'=>['id'=>'karyawan_id'],
                'empty_value' => '- Pilih Karyawan -',
                'label' => 'Karyawan'
            ])
        ->add('submit', 'submit', ['label' => 'Save','attr'=>['class'=>'btn-success btn btn-flat btn-block']]);
    }
}
