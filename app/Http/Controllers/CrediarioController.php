<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Crediario;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CrediarioStoreRequest;
use App\Mail\CompletarCadastroMail;
use App\Mail\CrediarioAprovadoMail;
use App\Mail\CrediarioCadastroMail;
use App\Mail\CrediarioValidacaoEmail;
use App\Mail\RejeitarCrediarioMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class CrediarioController extends BaseController
{
    public function __construct(Crediario $model)
    {
        parent::__construct($model);
    }

    public function index()
    {
        $limit = request()->limit ?? 10;
        $query = $this->model->query();

        $query
            ->when(request()->has('nome'), function ($q) {
                return $q->where('nome', 'ILIKE', "%" . request()->nome . "%");
            })
            ->when(request()->has('cpf_cnpj'), function ($q) {
                return $q->where('cpf_cnpj', 'ILIKE', "%" . request()->cpf_cnpj . "%");
            })
            ->when(request()->has('status'), function ($q) {
                return $q->where('status', request()->status);
            })
            ->when(request()->has('created_at'), function ($q) {
                return $q->whereDate('created_at', request()->created_at);
            });


        return $query->orderBy('created_at', 'desc')->paginate($limit);
    }

    public function visualizar($uuid)
    {
        return $this->model->with('anexos', 'rejeicoes')->where('uuid', $uuid)->first();
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['data_nascimento'] = Carbon::createFromFormat('d/m/Y', $request->data_nascimento)->format('Y-m-d');
        $validator = Validator::make($data, CrediarioStoreRequest::rules(), CrediarioStoreRequest::messages());

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        if ($request->foto_selfie) {
            $img = substr($request->foto_selfie, strpos($request->foto_selfie, ',') + 1);
            $img = base64_decode($img);
            $nameFile =  uniqid(date('HisYmd')) . ".png";
            $path = storage_path() . '/app/public/anexos/' . $nameFile;
            \Image::make(file_get_contents($request->foto_selfie))->save($path);
            $data['foto_selfie_url'] = env('API_URL') . "/storage/anexos/{$nameFile}";
        }

        $crediario = $this->model->create($data);

        if ($request->file('comprovante_residencia_arquivo')) {
            $upload = $this->uploadArquivo($request->comprovante_residencia_arquivo, 'anexos');
            $crediario->anexos()->create(['tipo' => 'COMPROVANTE DE RESIDENCIA', 'url' => $upload['url_arquivo']]);
        }

        if ($request->file('documento_foto_arquivo')) {
            $upload = $this->uploadArquivo($request->documento_foto_arquivo, 'anexos');
            $crediario->anexos()->create(['tipo' => 'DOCUMENTO COM FOTO', 'url' => $upload['url_arquivo']]);
        }

        if ($request->file('cpf_cnpj_arquivo')) {
            $upload = $this->uploadArquivo($request->cpf_cnpj_arquivo, 'anexos');
            $crediario->anexos()->create(['tipo' => 'CPF', 'url' => $upload['url_arquivo']]);
        }

        Mail::to($crediario->email)->send(new CrediarioCadastroMail($crediario));
        return $crediario;
    }

    public function show($id)
    {
        return $this->model->with('referenciasPessoais', 'anexos')->find($id);
    }

    public function validar($id)
    {
        $crediario = Crediario::find($id);
        $data = ['status' => 'VALIDADO', 'validado' => true];
        $crediario->update($data);

        Mail::to($crediario)->send(new CrediarioValidacaoEmail($crediario));
        return $data;
    }

    public function completar(Request $request, $uuid)
    {
        $data = $request->all();
        $crediario = Crediario::where('uuid', $uuid)->first();
        if ($request->referencia_nome1) {
            $crediario->referenciasPessoais()->create([
                'nome' => $request->referencia_nome1,
                'telefone' => $request->referencia_telefone1,
                'ramal' => $request->referencia_ramal1,
            ]);
        }

        if ($request->referencia_nome2) {
            $crediario->referenciasPessoais()->create([
                'nome' => $request->referencia_nome2,
                'telefone' => $request->referencia_telefone2,
                'ramal' => $request->referencia_ramal2,
            ]);
        }

        if ($request->file('contra_cheque_arquivo')) {
            if (count($request->allFiles()['contra_cheque_arquivo']) > 0) {
                foreach ($request->allFiles()['contra_cheque_arquivo'] as $c) {
                    $upload = $this->uploadArquivo($c, 'anexos');
                    $crediario->anexos()->create(['tipo' => 'CONTRA CHEQUE', 'url' => $upload['url_arquivo']]);
                }
            }
        }
        if ($request->file('cartao_beneficio_arquivo')) {
            $upload = $this->uploadArquivo($request->cartao_beneficio_arquivo, 'anexos');
            $crediario->anexos()->create(['tipo' => 'CARTÃO BENEFICIÁRIO', 'url' => $upload['url_arquivo']]);
        }
        if ($request->file('demonstrativo_pagamento_arquivo')) {
            $upload = $this->uploadArquivo($request->demonstrativo_pagamento_arquivo, 'anexos');
            $crediario->anexos()->create(['tipo' => 'DEMONSTRATIVO DE PAGAMENTO', 'url' => $upload['url_arquivo']]);
        }
        if ($request->file('decore_arquivo')) {
            $upload = $this->uploadArquivo($request->decore_arquivo, 'anexos');
            $crediario->anexos()->create(['tipo' => 'DECORE', 'url' => $upload['url_arquivo']]);
        }
        if ($request->file('carteira_conselho_arquivo')) {
            $upload = $this->uploadArquivo($request->carteira_conselho_arquivo, 'anexos');
            $crediario->anexos()->create(['tipo' => 'CARTEIRA CONSELHO', 'url' => $upload['url_arquivo']]);
        }
        if ($request->file('declaracao_irpf_arquivo')) {
            $upload = $this->uploadArquivo($request->declaracao_irpf_arquivo, 'anexos');
            $crediario->anexos()->create(['tipo' => 'DECLARACAO IRPF', 'url' => $upload['url_arquivo']]);
        }
        if ($request->file('contrato_trabalho_arquivo')) {
            $upload = $this->uploadArquivo($request->contrato_trabalho_arquivo, 'anexos');
            $crediario->anexos()->create(['tipo' => 'CONTRATO DE TRABALHO', 'url' => $upload['url_arquivo']]);
        }
        if ($request->file('carne_quitado_arquivo')) {
            if (count($request->allFiles()['carne_quitado_arquivo']) > 0) {
                foreach ($request->allFiles()['carne_quitado_arquivo'] as $c) {
                    $upload = $this->uploadArquivo($c, 'anexos');
                    $crediario->anexos()->create(['tipo' => 'CARNÊ QUITADO', 'url' => $upload['url_arquivo']]);
                }
            }
        }
        if ($request->file('boleto_quitado_arquivo')) {
            if (count($request->allFiles()['boleto_quitado_arquivo']) > 0) {
                foreach ($request->allFiles()['boleto_quitado_arquivo'] as $c) {
                    $upload = $this->uploadArquivo($c, 'anexos');
                    $crediario->anexos()->create(['tipo' => 'BOLETO QUITADO', 'url' => $upload['url_arquivo']]);
                }
            }
        }
        if ($request->file('carteira_trabalho_arquivo')) {
            $upload = $this->uploadArquivo($request->carteira_trabalho_arquivo, 'anexos');
            $crediario->anexos()->create(['tipo' => 'CARTEIRA DE TRABALHO', 'url' => $upload['url_arquivo']]);
        }
        if ($request->file('carteira_cooperativa_arquivo')) {
            $upload = $this->uploadArquivo($request->carteira_cooperativa_arquivo, 'anexos');
            $crediario->anexos()->create(['tipo' => 'CARTEIRA DE COOPERATIVA', 'url' => $upload['url_arquivo']]);
        }
        if ($request->file('comprovante_rendimento_arquivo')) {
            $upload = $this->uploadArquivo($request->comprovante_rendimento_arquivo, 'anexos');
            $crediario->anexos()->create(['tipo' => 'COMPROVANTE DE RENDIMENTO', 'url' => $upload['url_arquivo']]);
        }
        if ($request->file('cartao_cnpj_arquivo')) {
            $upload = $this->uploadArquivo($request->cartao_cnpj_arquivo, 'anexos');
            $crediario->anexos()->create(['tipo' => 'CARTÃO CNPJ', 'url' => $upload['url_arquivo']]);
        }
        if ($request->file('pro_labore_arquivo')) {
            $upload = $this->uploadArquivo($request->pro_labore_arquivo, 'anexos');
            $crediario->anexos()->create(['tipo' => 'PRÓ-LABORE', 'url' => $upload['url_arquivo']]);
        }
        if ($request->file('certidao_casamento_uniao_estavel_arquivo')) {
            $upload = $this->uploadArquivo($request->certidao_casamento_uniao_estavel_arquivo, 'anexos');
            $crediario->anexos()->create(['tipo' => 'CERTIDÃO CASAMENTO/UNIÃO ESTÁVEL', 'url' => $upload['url_arquivo']]);
        }

        if ($request->file('comprovante_residencia_arquivo')) {
            $upload = $this->uploadArquivo($request->comprovante_residencia_arquivo, 'anexos');
            $crediario->anexos()->create(['tipo' => 'COMPROVANTE DE RESIDENCIA', 'url' => $upload['url_arquivo']]);
        }

        if ($request->file('documento_foto_arquivo')) {
            $upload = $this->uploadArquivo($request->documento_foto_arquivo, 'anexos');
            $crediario->anexos()->create(['tipo' => 'DOCUMENTO COM FOTO', 'url' => $upload['url_arquivo']]);
        }

        if ($request->file('cpf_cnpj_arquivo')) {
            $upload = $this->uploadArquivo($request->cpf_cnpj_arquivo, 'anexos');
            $crediario->anexos()->create(['tipo' => 'CPF', 'url' => $upload['url_arquivo']]);
        }

        $crediario->rejeicoes()->delete();
        $crediario->anexos()->where('status', 'REJEITADO')->delete();

        if($crediario->validado == false){
            $crediario->update([$data, 'status' => 'AGUARDANDO VALIDAÇÃO']);
        }else{
            $crediario->update([$data, 'status' => 'AGUARDANDO APROVAÇÃO']);
        }
        Mail::to($crediario->email)->send(new CompletarCadastroMail($crediario));
    }

    public function aprovar($id)
    {
        $crediario = Crediario::find($id);
        $data = ['status' => 'APROVADO'];
        $crediario->update($data);
        Mail::to($crediario->email)->send(new CrediarioAprovadoMail($crediario));
        return $data;
    }

    public function rejeitar(Request $request, $id)
    {
        $crediario = Crediario::find($id);
     
        $data = ['status' => 'REJEITADO', 'motivo_rejeicao' => $request->motivo_rejeicao];
        $crediario->update($data);

        if (count($request->motivos_rejeicao) > 0) {
            foreach ($request->motivos_rejeicao as $m) {
                $crediario->rejeicoes()->create(['motivo' => $m]);
            }
        }

        Mail::to($crediario->email)->send(new RejeitarCrediarioMail($crediario));
        return $data;
    }

    public function uploadArquivo($arquivo, $diretorio)
    {
        $name =  uniqid(date('HisYmd'));
        $extension = $arquivo->extension();
        $nameFile = "{$name}.{$extension}";
        $upload = $arquivo->storeAs('public/' . $diretorio, $nameFile);
        return [
            'url_arquivo' => env('API_URL') . "/storage/{$diretorio}/{$nameFile}"
        ];
    }

    public function consultaCPF()
    {
        $cpf = request()->query('cpf');

        // dd($cpf);
        
        $cpf = $this->model->where('cpf_cnpj', $cpf)->first();
        
        if(!empty($cpf->id) && $cpf->status != 'REJEITADO'){
            return [
                'cadastrado' => true,
                'message' => "O CPF informado já possuí cadastro com o status $cpf->status"
            ];
        }else {
            return ['cadastrado' => false];
        }
    }
}
