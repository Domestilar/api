<?php

namespace App\Http\Controllers;

use App\Models\ReferenciaPessoal;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class ReferenciaPessoalController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->model->where('crediario_id', request()->crediario_id)->get();
    }
   
}
