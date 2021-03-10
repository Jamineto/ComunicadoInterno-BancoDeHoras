<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use App\Models\Categoria;
use App\Models\Comunicado;
use App\Models\Funcionario;
use App\Models\Setor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use function PHPUnit\Framework\isNull;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.index');
    }

    public function adminComu($tipo,$filtro){
        if($tipo == 'setor')
        {
            $comunicados = Comunicado::where('origem_id',$filtro)->simplePaginate(15);
        }else
            if($tipo == 'usuario')
            {
                $comunicados = Comunicado::where('autor_id',$filtro)->simplePaginate(15);
            }else
                $comunicados = Comunicado::orderByDesc('created_at')->simplePaginate(15);
        return view('comunicados.vistos-comunicado',['comunicados' => $comunicados]);
    }

    public function filtros($filtro){
        if ($filtro == 'setor')
        {
            $setores = Setor::orderBy('nome')->get();
            return view('admin.filtros',['filtros' => $setores]);
        }else
            if($filtro == 'usuario')
            {
                $users = User::orderBy('name')->get();
                return view('admin.filtros',['filtros' => $users]);
            }
    }

    public function adminBanco($filtro){
        if($filtro != 'todos')
        {
            $banco = Banco::where('autor_id',$filtro)->simplePaginate(15);
            $user = User::find($filtro);
            $user->nome = $user->name;
            return view('banco.dashboard',['banco' => $banco,'funcionario' => $user]);
        }else
        {
            $banco = Banco::orderByDesc('created_at')->simplePaginate(15);
            $user = new User();
            $user->nome = 'Ultimas solicitações';
            return view('banco.dashboard',['banco' => $banco,'funcionario' => $user]);
        }
    }

    public function filtrosBanco($filtro){
        if ($filtro == 'setor')
        {
            $setores = Setor::orderBy('nome')->get();
            return view('admin.filtros',['filtros' => $setores]);
        }else
            if($filtro == 'usuario')
            {
                $users = User::orderBy('name')->get();
                return view('admin.filtros',['filtros' => $users]);
            }
    }

    public function trocaStatus($id,$status){
        $banco = Banco::findOrFail($id);
        $func = Funcionario::where('matricula',$banco->funcionario->matricula)->first();
        $total = "00:00";
        $total = explode(":",$total);
        $totalf = explode(':',$func->total_horas);
        $totalr = explode(':',$banco->total);
        $banco->status = $status;
        if($status == 1) {
            if ($banco->tipo == 1) {
                $total[0] = (int)$totalf[0] + (int)$totalr[0];
                if ((int)$totalf[1] + (int)$totalr[1] < 60)
                    $total[1] = (int)$totalf[1] + (int)$totalr[1];
                else {
                    $resto = ((int)$totalf[1] + (int)$totalr[1]) - 60;
                    $total[1] += $resto;
                    $total[0] += 1;
                }
                if ($total[0] < 10 && $total[0] > 0)
                    $total[0] = '0' . $total[0];
                if ($total[1] < 10 && $total[1] > 0)
                    $total[1] = '0' . $total[1];
                $total = $total[0] . ':' . $total[1];
                $func->total_horas = $total;
                if ($banco->save())
                    if ($func->save())
                        return redirect()->to(route('banco_dash', $banco->funcionario_id))->with('success', 'Marcado como aprovado com sucesso!');
                    else
                        return redirect()->to(route('banco_dash', $banco->funcionario_id))->with('error', 'Erro ao adicionar horas para o funcionario!');
                else
                    return redirect()->to(route('banco_dash', $banco->funcionario_id))->with('error', 'Erro ao marcar como aprovado!');
            } else
                if ($banco->tipo == 2) {
                    $total[0] = (int)$totalf[0] - (int)$totalr[0];
                    if ((int)$totalf[1] - (int)$totalr[1] >= 0)
                        $total[1] = (int)$totalf[1] - (int)$totalr[1];
                    else {
                        $resto = 60 - (abs((int)$totalf[1] - (int)$totalr[1]));
                        $total[1] = $resto;
                        $total[0] -= 1;
                    }
                    if ($total[0] < 10 && $total[0] > 0)
                        $total[0] = '0' . $total[0];
                    if ($total[1] < 10 && $total[1] > 0)
                        $total[1] = '0' . $total[1];
                    $total = $total[0] . ':' . $total[1];
                    $func->total_horas = $total;
                    if ($banco->save())
                        if ($func->save())
                            return redirect()->to(route('banco_dash', $banco->funcionario_id))->with('success', 'Marcado como aprovado com sucesso!');
                        else
                            return redirect()->to(route('banco_dash', $banco->funcionario_id))->with('error', 'Erro ao remover horas do funcionario!');
                    else
                        return redirect()->to(route('banco_dash', $banco->funcionario_id))->with('error', 'Erro ao marcar como aprovado!');
                }
        }else{
            if($banco->save())
                return redirect()->to(route('banco_dash',$banco->funcionario_id))->with('success', 'Marcado como recusado com sucesso!');
            else
                return redirect()->to(route('banco_dash',$banco->funcionario_id))->with('error', 'Erro ao marcar como recusado!');
        }
        return redirect()->to(route('banco_dash',$banco->funcionario_id))->with('error', 'Algo deu errado! Tente novamente mais tarde.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create_setores()
    {
        return view('admin.setores.create-setor');
    }

    public function create_funcionarios()
    {
        return view('admin.funcionarios.create-funcionarios');
    }

    public function search_usuarios()
    {
        return view('admin.usuarios.search-usuario');
    }

    public function search_funcionarios()
    {
        return view('admin.funcionarios.search-funcionarios');
    }

    public function search_setores()
    {
        return view('admin.setores.search-setor');
    }

    public function search_usuarios_ajax(Request $request)
    {
        if($request->ajax())
        {
            $output="";
            $products=User::where('name','LIKE','%'.$request->search."%")->get();
            if($products->count() > 0)
            {
                foreach ($products as $key => $product) {
                    $output.='<tr>'.
                        '<td class="align-middle">'.$product->id.'</td>'.
                        '<td class="align-middle">'.$product->name.'</td>'.
                        '<td class="align-middle">'.$product->username.'</td>'.
                        '<td class="align-middle">'.$product->created_at->format('d/m/Y') . ' às '  .$product->created_at->format('h:i').'</td>'.
                        '<td class="align-middle">'.$product->updated_at->format('d/m/Y') . ' às '  .$product->updated_at->format('h:i').'</td>'.
                        '<td class="align-middle"><a type="button" class="btn btn-info" href="'. route('edit_usuario',$product->id) .'">Editar</a><button type="button" class="btn btn-danger ml-3" data-id="'. $product->id.'" data-nome="'. $product->name.'">Deletar</button></td>'.
                        '</tr>';
                }
                return Response($output);
            }
        }
    }

    public function search_funcionarios_ajax(Request $request)
    {
        $output="";
        if($request->ajax())
        {
            $products = Funcionario::where('nome','LIKE','%'.$request->search."%")->get();
            if($products != NULL || $products->count() > 0)
            {
                foreach ($products as $key => $product) {

                    $output.='<tr>'.
                        '<td class="align-middle">'.$product->id.'</td>'.
                        '<td class="align-middle">'.$product->nome.'</td>'.
                        '<td class="align-middle">'.$product->setor->nome .'</td>'.
                        '<td class="align-middle">'. \Illuminate\Support\Carbon::createFromFormat('Y-m-d',$product->data_nasc)->format('d/m/Y') .'</td>'.
                        '<td class="align-middle">'.$product->created_at->format('d/m/Y') . ' às '  .$product->created_at->format('h:i').'</td>'.
                        '<td class="align-middle"><a type="button" class="btn btn-info" href="'. route('edit_funcionarios',$product->matricula) .'">Editar</a><button type="button" class="btn btn-danger ml-3" data-id="'. $product->matricula.'" data-nome="'. $product->nome.'">Deletar</button></td>'.
                        '</tr>';
                }
                return Response($output);
            }else
            {
                $output.=
                    '<tr>'.
                    '<td class="align-middle" colspan="5"> Nenhum funcionário encontrado!</td>'.
                    '</tr>';
                return Response($output);
            }
        }else
        {
            $output.=
                '<tr>'.
                '<td class="align-middle" colspan="5"> Método invalido!</td>'.
                '</tr>';
            return Response($output);
        }
    }

    public function search_setores_ajax(Request $request)
    {
        if($request->ajax())
        {
            $output="";
            $setores = Setor::where('nome','LIKE','%'.$request->search."%")->get();
            if($setores->count() > 0)
            {
                foreach ($setores as $key => $setor) {
                    $output.='<tr>'.
                        '<td class="align-middle">'.$setor->id.'</td>'.
                        '<td class="align-middle">'.$setor->nome.'</td>'.
                        '<td class="align-middle">'.$setor->created_at->format('d/m/Y') . ' às '  .$setor->created_at->format('h:i').'</td>'.
                        '<td class="align-middle">'.$setor->updated_at->format('d/m/Y') . ' às '  .$setor->updated_at->format('h:i').'</td>'.
                        '<td><a type="button" class="btn btn-info mr-3" href="'. route('edit_setores',$setor->id) .'">Editar</a><button type="button" class="btn btn-danger" data-id="'. $setor->id.'" data-nome="'. $setor->nome.'">Deletar</button></td>'.
                        '</tr>';
                }
                return Response($output);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_setor(Request $request)
    {
        $novo = new Setor();
        $encoding = 'UTF-8';
        $novo->nome = mb_convert_case($request->nome, MB_CASE_UPPER, $encoding);
        if(Setor::where('nome',$request->nome)->count() == 0)
        {
            $novo->save();
            return response(['mensagem' => 'O setor <b> '.$request->nome.'</b> foi criado!', 'response' => 200]);
        }
        else
            return response(['mensagem' => 'O setor <b> '.$request->nome.'</b> já existe!', 'response' => 401]);
    }

    public function store_funcionarios(Request $request)
    {
        $funcionario = new Funcionario();
        $funcionario->matricula = $request->cod;
        $funcionario->nome = $request->nome;
        $data = Carbon::createFromFormat('d/m/Y',$request->data_nasc)->format('Y-m-d');
        $funcionario->data_nasc = $data;

        if(Funcionario::where('matricula',$request->cod)->count() == 0)
        {
            $funcionario->save();
            return response(['mensagem' => 'O funcionario <b> '.$request->name.'</b> foi criado!', 'response' => 200]);
        }
        else
            return response(['mensagem' => 'O funcionario <b> '.$request->name.'</b> já existe!', 'response' => 401]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */

    public function edit_usuario($id)
    {
        $user = User::findOrFail($id);
        $set = Setor::orderBy('nome')->get();
        return view('admin.usuarios.show-usuario',['usuario' => $user,'setores' => $set]);
    }

    public function edit_funcionarios($id)
    {
        $fun = Funcionario::where('matricula',$id)->first();
        $set = Setor::OrderBy('nome')->get();
        if($fun)
            return view('admin.funcionarios.show-funcionario',['funcionario' => $fun,'setores' => $set]);
        else
            return back()->with('error','Funcionário não encontrado!');
    }

    public function edit_setores($id)
    {
        $set = Setor::findOrFail($id);
        if($set)
            return view('admin.setores.show-setor',['setor' => $set]);
        else
            return back()->with('error','Setor não encontrado!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */

    public function update_usuario(Request $request, $id)
    {
        $antigo = User::find($id);
        $antigo->fill($request->all());
        if($request->password_new !== null)
            $antigo->password = Hash::make($request->password_new);
        if($antigo->save())
            return back()->with('success','Cadastro atualizado com sucesso!');
        else
            return back()->with('error','Erro ao atualizar cadastro!');

    }

    public function update_funcionario(Request $request, $id)
    {
        $fun = Funcionario::where('matricula',$id)->first();
        $fun->fill($request->all());
        if($fun->save())
            return back()->with('success','Dados do usuário alterados com sucesso!');
        else
            return back()->with('error','Erro ao alterar dados do usuário!');
    }

    public function update_setor(Request $request, $id)
    {
        $antigo = Setor::find($id);
        $encoding = 'UTF-8';
        $nomea = $antigo->nome;
        $antigo->nome = mb_convert_case($request->nome, MB_CASE_UPPER, $encoding);
        if($antigo->save())
            return back()->with('success','Nome do setor '. $nomea .' alterado para '. $antigo->nome .' com sucesso!');
        else
            return back()->with('error','Erro ao alterar nome do setor!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy_funcionario($id)
    {
        $fun = Funcionario::where('matricula',$id)->first();
        if($fun)
            if($fun->delete())
                return back()->with('success','Funcionário '. $fun->nome .' deletado com sucesso!');
            else
                return back()->with('error','Erro ao deletar o funcionário! Tente novamente mais tarde.');
        else
            return back()->with('error','Funcionário não encontrado!');
    }

    public function destroy_setor($id)
    {
        $set = Setor::findOrFail($id);
        if($set)
            if($set->delete())
                return back()->with('success','Setor deletado com sucesso!');
            else
                return back()->with('error','Erro ao deletar setor! Tente novamente mais tarde.');
        else
            return back()->with('error','Setor não encontrado!');
    }

    public function destroy_usuario($id)
    {
        $user = User::findOrFail($id);
        if($user)
            if($user->delete())
                return back()->with('success','Usuário deletado com sucesso!');
            else
                return back()->with('error','Erro ao deletar usuário! Tente novamente mais tarde.');
        else
            return back()->with('error','Usuário não encontrado!');
    }

    public function importaFunc(Request $request){

        $arquivo = $request->file('arquivo');
        $arq = fopen($arquivo,'r');
        $i = 0;
        while($linha = fscanf($arq,"%d;%[^;];%[^;];%[^;]\n")){
            if($linha[0] != NULL) {
                $funcionarios = Funcionario::where('matricula',$linha[0])->get();
                if($funcionarios->count() == 0)
                {
                    $funcionario = new Funcionario();
                    $funcionario->matricula = $linha[0];
                    $funcionario->nome = $linha[1];
                    $data = Carbon::createFromFormat('d/m/Y',$linha[2])->format('Y-m-d');
                    $funcionario->data_nasc = $data;
                    $encoding = 'UTF-8';
                    $setor = mb_convert_case(preg_replace('/[^a-zA-Z]+/', '', $linha[3]), MB_CASE_UPPER, $encoding);
                    $compara = trim($setor);
                    $setores = Setor::where('nome', $setor)->first();
                    if ($setores == NULL || $setores->count() == 0) {
                        if($compara == "")
                            $setor = "INDEFINIDO";
                        $novo = new Setor();
                        $novo->nome = $setor;
                        $novo->save();
                        $funcionario->setor_id = $novo->id;
                    }else
                        $funcionario->setor_id = $setores->id;
                    if($funcionario->save())
                        $i++;
                }
            }
        }
        return redirect()->to(route('admin_index'))->with('success',$i . ' funcionários foram importados!');
    }
}
