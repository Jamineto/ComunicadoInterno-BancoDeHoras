<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="container">
        <div class="row mt-5">
            <div class="col-md-4">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <table class="table table-responsive table-hover text-center">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Usuários</th>
                        </tr>
                        </thead>
                    </table>
                    <nav class="nav flex-column">
                        <a class="nav-link" href="{{ route('register') }}">Criar</a>
                        <a class="nav-link" href="{{ route('search_usuarios') }}">Pesquisar / Editar / Deletar</a>
                    </nav>
                </div>
            </div>
            <div class="col-md-4">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <table class="table table-responsive table-hover text-center">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Setores</th>
                        </tr>
                        </thead>
                    </table>
                    <nav class="nav flex-column">
                        <a class="nav-link" href="{{ route('create_setores') }}">Criar</a>
                        <a class="nav-link" href="{{ route('search_setores')  }}">Pesquisar / Editar / Deletar</a>
                    </nav>
                </div>
            </div>
            <div class="col-md-4">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <table class="table table-responsive table-hover text-center">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Funcionarios</th>
                        </tr>
                        </thead>
                    </table>
                    <nav class="nav flex-column">
                        <a class="nav-link" href="{{ route('create_funcionarios') }}">Criar</a>
                        <a class="nav-link" href="{{ route('importar') }}">Importar</a>
                        <a class="nav-link" href="{{ route('search_funcionarios') }}">Pesquisar / Editar / Deletar</a>
                    </nav>
                </div>
            </div>
            <div class="col-md-4">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <table class="table table-responsive table-hover text-center">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Comunicados</th>
                        </tr>
                        </thead>
                    </table>
                    <nav class="nav flex-column">
                        <a class="nav-link" href="{{ route('admin_comunicados',['todos',"todos"]) }}">Todos</a>
                        <a class="nav-link" href="{{ route('admin_filtros','setor') }}">Criados por setor</a>
                        <a class="nav-link" href="{{ route('admin_filtros','usuario') }}">Criados por usuário</a>
                    </nav>
                </div>
            </div>
            <div class="col-md-4">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <table class="table table-responsive table-hover text-center">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Banco de Horas</th>
                        </tr>
                        </thead>
                    </table>
                    <nav class="nav flex-column">
                        <a class="nav-link" href="{{ route('admin_banco','todos') }}">Ver todos</a>
                        <a class="nav-link" href="{{ route('admin_filtros_banco','usuario') }}">Criados por usuário</a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
