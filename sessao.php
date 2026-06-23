<!-- app/Models/Sessao.php -->

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sessao extends Model
{
    protected $fillable = [
        'filme_id',
        'data',
        'horario',
        'sala'
    ];

    public function filme()
    {
        return $this->belongsTo(Filme::class);
    }

    public function ingressos()
    {
        return $this->hasMany(Ingresso::class);
    }
}









// app/Models/Ingresso.php

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingresso extends Model
{
    protected $fillable = [
        'sessao_id',
        'nome_cliente',
        'quantidade',
        'valor_total'
    ];

    public function sessao()
    {
        return $this->belongsTo(Sessao::class);
    }
}










// app/Http/Controllers/SessaoController.php

<?php

namespace App\Http\Controllers;

use App\Models\Sessao;
use App\Models\Filme;
use Illuminate\Http\Request;

class SessaoController extends Controller
{
    public function index()
    {
        $sessoes = Sessao::all();

        return view('sessoes.index', compact('sessoes'));
    }

    public function create()
    {
        $filmes = Filme::all();

        return view('sessoes.create', compact('filmes'));
    }

    public function store(Request $request)
    {
        Sessao::create($request->all());

        return redirect()->route('sessoes.index');
    }

    public function show(Sessao $sessao)
    {
        //
    }

    public function edit(Sessao $sessao)
    {
        $filmes = Filme::all();

        return view('sessoes.edit', compact('sessao', 'filmes'));
    }

    public function update(Request $request, Sessao $sessao)
    {
        $sessao->update($request->all());

        return redirect()->route('sessoes.index');
    }

    public function destroy(Sessao $sessao)
    {
        $sessao->delete();

        return redirect()->route('sessoes.index');
    }
}











// app/Http/Controllers/IngressoController.php

<?php

namespace App\Http\Controllers;

use App\Models\Ingresso;
use App\Models\Sessao;
use Illuminate\Http\Request;

class IngressoController extends Controller
{
    public function index()
    {
        $ingressos = Ingresso::all();

        return view('ingressos.index', compact('ingressos'));
    }

    public function create()
    {
        $sessoes = Sessao::all();

        return view('ingressos.create', compact('sessoes'));
    }

    public function store(Request $request)
    {
        Ingresso::create($request->all());

        return redirect()->route('ingressos.index');
    }

    public function show(Ingresso $ingresso)
    {
        //
    }

    public function edit(Ingresso $ingresso)
    {
        $sessoes = Sessao::all();

        return view('ingressos.edit', compact('ingresso', 'sessoes'));
    }

    public function update(Request $request, Ingresso $ingresso)
    {
        $ingresso->update($request->all());

        return redirect()->route('ingressos.index');
    }

    public function destroy(Ingresso $ingresso)
    {
        $ingresso->delete();

        return redirect()->route('ingressos.index');
    }
}








// resources/views/sessoes/index.blade.php

<!DOCTYPE html>
<html>
<head>
    <title>Sessões</title>
</head>
<body>

<h1>Lista de Sessões</h1>

<a href="{{ route('sessoes.create') }}">
    Nova Sessão
</a>

<hr>

@foreach($sessoes as $sessao)

    <p>Filme: {{ $sessao->filme->titulo }}</p>
    <p>Data: {{ $sessao->data }}</p>
    <p>Horário: {{ $sessao->horario }}</p>
    <p>Sala: {{ $sessao->sala }}</p>

    <a href="{{ route('sessoes.edit', $sessao->id) }}">
        Editar
    </a>

    <form action="{{ route('sessoes.destroy', $sessao->id) }}" method="POST">

        @csrf
        @method('DELETE')

        <button type="submit">
            Excluir
        </button>

    </form>

    <hr>

@endforeach

</body>
</html>








// resources/views/sessoes/create.blade.php

<!DOCTYPE html>
<html>
<head>
    <title>Nova Sessão</title>
</head>
<body>

<h1>Cadastrar Sessão</h1>

<form action="{{ route('sessoes.store') }}" method="POST">

    @csrf

    <label>Filme:</label><br>

    <select name="filme_id">

        @foreach($filmes as $filme)

            <option value="{{ $filme->id }}">
                {{ $filme->titulo }}
            </option>

        @endforeach

    </select>

    <br><br>

    <label>Data:</label><br>
    <input type="date" name="data"><br><br>

    <label>Horário:</label><br>
    <input type="time" name="horario"><br><br>

    <label>Sala:</label><br>
    <input type="text" name="sala"><br><br>

    <button type="submit">
        Salvar
    </button>

</form>

</body>
</html>






// resources/views/sessoes/edit.blade.php

<!DOCTYPE html>
<html>
<head>
    <title>Editar Sessão</title>
</head>
<body>

<h1>Editar Sessão</h1>

<form action="{{ route('sessoes.update', $sessao->id) }}" method="POST">

    @csrf
    @method('PUT')

    <label>Filme:</label><br>

    <select name="filme_id">

        @foreach($filmes as $filme)

            <option value="{{ $filme->id }}"
                {{ $filme->id == $sessao->filme_id ? 'selected' : '' }}>
                {{ $filme->titulo }}
            </option>

        @endforeach

    </select>

    <br><br>

    <input type="date" name="data" value="{{ $sessao->data }}"><br><br>

    <input type="time" name="horario" value="{{ $sessao->horario }}"><br><br>

    <input type="text" name="sala" value="{{ $sessao->sala }}"><br><br>

    <button type="submit">
        Atualizar
    </button>

</form>

</body>
</html>







// resources/views/ingressos/index.blade.php

<!DOCTYPE html>
<html>
<head>
    <title>Ingressos</title>
</head>
<body>

<h1>Lista de Ingressos</h1>

<a href="{{ route('ingressos.create') }}">
    Novo Ingresso
</a>

<hr>

@foreach($ingressos as $ingresso)

    <p>Cliente: {{ $ingresso->nome_cliente }}</p>
    <p>Quantidade: {{ $ingresso->quantidade }}</p>
    <p>Valor: R$ {{ $ingresso->valor_total }}</p>

    <a href="{{ route('ingressos.edit', $ingresso->id) }}">
        Editar
    </a>

    <form action="{{ route('ingressos.destroy', $ingresso->id) }}" method="POST">

        @csrf
        @method('DELETE')

        <button type="submit">
            Excluir
        </button>

    </form>

    <hr>

@endforeach

</body>
</html>






// resources/views/ingressos/create.blade.php

<!DOCTYPE html>
<html>
<head>
    <title>Novo Ingresso</title>
</head>
<body>

<h1>Cadastrar Ingresso</h1>

<form action="{{ route('ingressos.store') }}" method="POST">

    @csrf

    <label>Sessão:</label><br>

    <select name="sessao_id">

        @foreach($sessoes as $sessao)

            <option value="{{ $sessao->id }}">
                {{ $sessao->filme->titulo }} - {{ $sessao->data }}
            </option>

        @endforeach

    </select>

    <br><br>

    <input type="text" name="nome_cliente" placeholder="Nome"><br><br>

    <input type="number" name="quantidade"><br><br>

    <input type="number" step="0.01" name="valor_total"><br><br>

    <button type="submit">
        Salvar
    </button>

</form>

</body>
</html>






// resources/views/ingressos/edit.blade.php

<!DOCTYPE html>
<html>
<head>
    <title>Editar Ingresso</title>
</head>
<body>

<form action="{{ route('ingressos.update', $ingresso->id) }}" method="POST">

    @csrf
    @method('PUT')

    <input type="text"
           name="nome_cliente"
           value="{{ $ingresso->nome_cliente }}"><br><br>

    <input type="number"
           name="quantidade"
           value="{{ $ingresso->quantidade }}"><br><br>

    <input type="number"
           step="0.01"
           name="valor_total"
           value="{{ $ingresso->valor_total }}"><br><br>

    <button type="submit">
        Atualizar
    </button>

</form>

</body>
</html>
