<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //
    public function test()
    {
        for($i=0;$i<10;$i++){
            $this->data[] = ['name'=>aa123a.rand(10000000,99999999),'time'=>123];
        }


        return json_encode($this->data);
    }
}
