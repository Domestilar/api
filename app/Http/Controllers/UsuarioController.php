<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\User;
class UsuarioController extends BaseController
{
    protected $model;

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        if($request->password){
            $data['password'] = bcrypt($request->password);
        }

        $res = $this->model->find($id)->update($data);

        return response($res);
    }
}
