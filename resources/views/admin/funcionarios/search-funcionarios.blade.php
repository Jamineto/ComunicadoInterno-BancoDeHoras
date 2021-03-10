<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pesquisa de funcionários') }}
        </h2>
    </x-slot>
    <div class="modal fade" id="myModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Deseja realmente deletar o funcionário <span id="funcionario"></span>?</p>
                </div>
                <div class="modal-footer">
                    <form action="" id="deleta" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-danger" >Deletar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12 pb-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($message = Session::get('success'))

                <div class="alert alert-success alert-block">

                    <strong>{{ $message }}</strong>

                </div>

            @endif


            @if ($message = Session::get('error'))

                <div class="alert alert-danger alert-block">

                    <strong>{{ $message }}</strong>

                </div>

            @endif
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <input class="form-control m-2" type="text" id="search" name="search" placeholder="Pesquisar funcionários...">
            </div>
        </div>
    </div>
    <div class="py-12 p-0">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="table table-responsive table-hover text-center">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nome Completo</th>
                        <th scope="col">Setor</th>
                        <th scope="col">Data de Nascimento</th>
                        <th scope="col">Data da criação</th>
                        <th scope="col">Ações</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
<script type="text/javascript">
    $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>

<script type="text/javascript">
    $('#search').on('keyup',function(){
        $value=$(this).val();
        $.ajax({
            type : 'get',
            url : '{{route('search_funcionarios_ajax')}}',
            data:{'search':$value},
            success:function(data){
                $('tbody').html(data);
            }
        });
    })
</script>

<script type="text/javascript">
    $(document).on("click","td button",function( event ){
        $('#funcionario').text($(this).attr("data-nome"));
        var id = $(this).attr("data-id");
        var url = '{{route('destroy_funcionario',":id")}}';
        url = url.replace(':id',id);
        $('#deleta').attr("action",url);
        var myModal = new bootstrap.Modal(document.getElementById('myModal'), {
            keyboard: true
        });
        myModal.show()
    });
</script>
