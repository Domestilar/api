<?php

namespace App\Http\Requests;

class CrediarioStoreRequest {
    public static function rules(){
        return [
            'nome' => 'required|max:191',
            'cpf_cnpj' => 'required|max:20',
            // 'cpf_cnpj' => 'required|max:20|unique:crediarios',
            'email' => 'email|required|max:50',
            'data_nascimento' => 'required',
            'celular' => 'required|max:16',
            'categoria_profissional' => 'required',
        ];
    }

    public static function messages()
    {
        return [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.max' => 'O campo nome deve conter no máximo 191 caracteres.',
            'cpf_cnpj.required' => 'O campo CPF é obrigatório.',
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.max' => 'O campo e-mail deve conter no máximo 50 caracteres.',
            'data_nascimento.required' => 'O campo data de nascimento é obrigatório.',
            'celular.required' => 'O campo celular é obrigatório.',
            'categoria_profissional.required' => 'O campo categoria profissional é obrigatório.',
            'cpf_cnpj.unique' => 'O CPF informado já possui cadastro.',
        ];
    }
}