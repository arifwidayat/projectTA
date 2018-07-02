<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class Jabatan extends Form
{
    public function buildForm()
    {
        $this
    	->add('nama','text',[
    		'rules'=>'required'
    	])
        ->add('submit', 'submit', ['label' => 'Save','attr'=>['class'=>'btn-success btn btn-flat btn-block']]);
    }
}
