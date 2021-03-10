<?php

namespace App\Http\Controllers;

use App\Mail\NovoComunicado;
use App\Models\Categoria;
use App\Models\Comunicado;
use App\Models\Setor;
use App\Models\User;
use App\Models\Visualizado;
use Hamcrest\Core\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ComunicadoController extends Controller
{

    public function index()
    {
        $visualizados = Auth::user()->visualizados()->latest()->get();
        $todos = Comunicado::where('destino_id',Auth::user()->setor_id)->latest()->get();
        $i = 0;
        $comunicados[] = null;
        if($visualizados->count() > 0)
        {
            if($todos->count() > 0)
            foreach ($todos as $comunicado)
            {
                $encontrado = false;
                foreach ($visualizados as $comunicado_visto)
                {
                    if($comunicado->id == $comunicado_visto->id)
                    {
                        $encontrado = true;
                    }
                }
                if($encontrado == false)
                {
                    $novo = json_decode($comunicado,true);
                    $comunicados[$i] = new Comunicado($novo);
                    $i++;
                }
            }
            if($comunicados[0] == null)
                $comunicados = null;
            return view('comunicados.todos-comunicado',['comunicados' => $comunicados]);
        }else
            return view('comunicados.todos-comunicado',['comunicados' => $todos]);
    }

    public function viewed()
    {
        $comunicados = Auth::user()->visualizados()->latest()->simplePaginate(15);
        return view('comunicados.vistos-comunicado',['comunicados' => $comunicados]);
    }

    public function markAsViewed($id)
    {
        $user_id = Auth::user()->id;
        $comunicado_id = $id;
        $visto =  new Visualizado();
        $visto->user_id = $user_id;
        $visto->comunicado_id = $comunicado_id;
        if(Visualizado::where('user_id',$user_id)->where('comunicado_id',$comunicado_id)->count() == 0)
        {
            $visto->save();
            return response(['mensagem' => 'O comunicado foi marcado como lido com sucesso!', 'response' => 200]);
        }
        else
            return response(['mensagem' => 'Você já marcou este comunicado como lido!', 'response' => 401]);
    }

    public function markAsNotViewed($id)
    {
        $visto = Visualizado::where('user_id',Auth::user()->id)->where('comunicado_id',$id)->first();
        if( Auth::user()->visualizados()->detach($visto->comunicado_id))
        {
            return response(['mensagem' => 'O comunicado foi marcado como não lido com sucesso!', 'response' => 200]);
        }
        else
            return response(['mensagem' => 'Você ainda não marcou este comunicado como lido!', 'response' => 401]);
    }

    public function sent()
    {
        $comunicados = Auth::user()->comunicados()->latest()->simplePaginate(15);
        return view('comunicados.enviados-comunicado',['comunicados' => $comunicados]);
    }

    public function create()
    {
        if(Auth::user()->setor_id != null)
        {
            $setores = Setor::orderBy('nome')->get();
            return view('comunicados.create-comunicado',['setores' => $setores]);
        }else
            return redirect(route('all_comunicados'));
    }

    public function store(Request $request)
    {
        $novo = new Comunicado();
        $novo->autor_id = Auth::user()->id;
        $novo->fill($request->all());
        $novo->origem_id = Auth::user()->setor_id;

        if($novo->save())
        {
            $users = User::where('setor_id',$request->destino_id)->get();
            foreach ($users as $user)
                if(isset($user->email)) {
                    Mail::to($user)->send(new NovoComunicado($novo)); //? $email = 'enviado' : $email = 'não enviado';
                    sleep(1);
                }
            return redirect(route('sent_comunicados'))->with('success','O comunicado foi enviado com sucesso!') ; //$email);
        }

        else
            return redirect(route('sent_comunicados'))->with('error','Houve um erro ao enviar o comunicado!');
    }

    public function show($id)
    {
        $comunicado = Comunicado::findOrFail($id);
        return view('comunicados.show-comunicado',['comunicado' => $comunicado]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
