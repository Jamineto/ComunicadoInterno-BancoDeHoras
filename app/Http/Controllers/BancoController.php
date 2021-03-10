<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use App\Models\Funcionario;
use App\Models\Setor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class BancoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $funcionarios = Auth::user()->funcionarios;
        return view('banco.index',['funcionarios' => $funcionarios]);
    }

    public function dashboard($id){
        $funcionario = Funcionario::where('matricula',$id)->select('nome')->first();
        $banco = Banco::where('funcionario_id',$id)->orderByDesc('created_at')->paginate(15);
        return view('banco.dashboard',['banco' => $banco,'funcionario' => $funcionario]);
    }

    public function warning()
    {
        return view('banco.warning');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create_banco()
    {
        if(Auth::user()->setor_id != null) {
            $func_setor = Auth::user()->funcionarios;
            return view('banco.create',['funcionarios' => $func_setor]);
        }
        else
            return redirect(route('index_horas'));
    }

    public function create_compensada(){
        if(Auth::user()->setor_id != null) {
            $func_setor = Auth::user()->funcionarios;
            return view('banco.create_compensada',['funcionarios' => $func_setor]);
        }
        else
            return redirect(route('index_horas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store_banco(Request $request)
    {
        $modelo = new Banco();
        $modelo->fill($request->all());
        $modelo->autor_id = Auth::user()->id;
        $modelo->total = $request->total;
        if($modelo->save())
            return redirect(route('index_horas'))->with('success','Comunicado de horas criado com sucesso!');
        else
            return redirect(route('index_horas'))->with('error','Erro ao criar o comunicado de horas!');

    }

    public function store_compensada(Request $request)
    {
        $modelo = new Banco();
        $modelo->fill($request->all());
        $modelo->autor_id = Auth::user()->id;
        $modelo->total = $request->total;
        if($modelo->save())
            return redirect(route('index_horas'))->with('success','Comunicado de compensada criado com sucesso!');
        else
            return redirect(route('index_horas'))->with('error','Erro ao criar o comunicado de compensada!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $dados = Banco::findOrFail($id);
        $sep = explode(':',$dados->total);
        $horas = $sep[0];
        $min = $sep[1];
        return view('banco.visualiza',['dados' => $dados, 'horas' => $horas, 'min' => $min]);
    }

    public function show_horas($mat)
    {
        $fun = Funcionario::where('matricula', $mat)->select('total_horas')->first();
        if ($fun != NULL) {
            return response(['total_horas' => $fun->total_horas, 'response' => 200]);
        }
    }

    public function solicitacoes(){
        $solicitacoes = Banco::where('status',0)->paginate(15);
        $fun = new Funcionario();
        $fun->nome = "Todos";
        return view('banco.dashboard',['banco' => $solicitacoes,'funcionario' => $fun]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
