function redirecionar(local) {
    var local;
	window.location.href = local
}
//Botões de adicionar 1 e remover 1 do carrinho
function carrinhoRemoverProduto(idPedido, idProduto, item){
    $('#form-remover-produto input[name="pedidos_id"]').val(idPedido);
    $('#form-remover-produto input[name="produto_id"]').val(idProduto);
    $('#form-remover-produto input[name="item"]').val(item);
    $('#form-remover-produto').submit();
}

function carrinhoAdicionarProduto(idProduto){
    $('#form-adicionar-produto input[name="id"]').val(idProduto);
    $('#form-adicionar-produto').submit();
}
//ViaCEP API
function limpa_formulário_cep() {
    //Limpa valores do formulário de cep.
    document.getElementById('rua').value=("");
    document.getElementById('bairro').value=("");
    document.getElementById('cidade').value=("");
    document.getElementById('uf').value=("");
}

function meu_callback(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('rua').value=(conteudo.logradouro);
        document.getElementById('bairro').value=(conteudo.bairro);
        document.getElementById('cidade').value=(conteudo.localidade);
        document.getElementById('uf').value=(conteudo.uf);
    } //end if.
    else {
        //CEP não Encontrado.
        limpa_formulário_cep();
        alert("CEP não encontrado.");
    }
}

function pesquisacep(valor) {

    //Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if(validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('rua').value="...";
            document.getElementById('bairro').value="...";
            document.getElementById('cidade').value="...";
            document.getElementById('uf').value="...";

            //Cria um elemento javascript.
            var script = document.createElement('script');

            //Sincroniza com o callback.
            script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);

        } //end if.
        else {
            //cep é inválido.
            limpa_formulário_cep();
            alert("Formato de CEP inválido.");
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep();
    }
};

function carregar() {
    PagSeguroDirectPayment.setSessionId('{{$sessionID}}');
}
$(function() {
    carregar();
    $(".numerocartao").on('blur', function(){
        PagSeguroDirectPayment.onSenderHashReady(function(response){
            if (response.status=="error") {
                console.log(response.message)
                return false
            }
            var hash = response.senderHash
            $(".hashseller").val(hash)
        })
    })
})
