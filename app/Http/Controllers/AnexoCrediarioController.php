<?php

namespace App\Http\Controllers;

use App\Models\AnexoCrediario;
use Illuminate\Http\Request;

class AnexoCrediarioController extends BaseController
{
    protected $model;

    public function __construct(AnexoCrediario $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        return $this->model->where('crediario_id', request()->query('crediario_id'))->get();
    }

    public function aprovar($id)
    {
        $this->model->where('id', $id)->update(['status' => 'APROVADO']);
        return $this->show($id);
    }
    
    public function rejeitar(Request $request, $id)
    {
        $this->model->where('id', $id)->update(['status' => 'REJEITADO', 'motivo_rejeicao' => $request->motivo_rejeicao]);
        return $this->show($id);
    }
}
