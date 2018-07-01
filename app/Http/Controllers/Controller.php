<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public function cekjatahcuti(){
    	$jatahcuti = new \App\Models\JatahCuti;
    	$jatah = $jatahcuti->where('karyawan_id',auth()->id())->first();
    	if(!is_null($jatah)){
    		if($jatah->tahun!=date('Y')){
    			$jatah->tahun=date('Y');
    			$jatah->jumlah_cuti=12;
                $jatah->save();
    		}
    	}else{
    		$jatahcuti->insert(['karyawan_id'=>auth()->id(),'tahun'=>date('Y'),'jumlah_cuti'=>12]);
    	}
    }
}
