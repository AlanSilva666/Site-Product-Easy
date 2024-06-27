<?php
    $dados_form = $this->session->flashdata('dados_form');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product Easy - Faça seu Pedido</title>
    <link rel="shortcut icon" href="<?= base_url("assets/images/si_icon.png")?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/estilo.css') ?>"/>
    <link rel="stylesheet" href="<?= base_url('assets/css/form.css') ?>"/>
    <!-- <link rel="stylesheet" href="<?= base_url('assets/css/estilo.css?v=' . time()) ?>"/> -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <style>
        input.enviar{
            /* background: blue;
            font-size: 12pt;
            font-family: Arial, Helvetica, sans-serif;
            color: #FFFFFF;
            padding: 10px;  */
            margin-left: 20px; 
        }
        p.sucesso{
            text-align: center;
            font-family: Arial;
            font-size: 16pt;
            font-weight: 700;
            background: #00FF7F;
            border: 2px solid black;     
            /* position:fixed;
            right: auto;
            bottom: auto; */

            /* border-width: 0px;
            border-right: 0px; */

        }
        p.erro{
            text-align: center;
            font-family: Arial;
            font-size: 16pt;
            font-weight: 700;
            background: #FF0000;
            border: 2px solid black;     
        }
        h1.h2_aviso{
            font-family: Arial;
            font-size: 12pt;
            color: red;
            text-align: center;
        }

        form{
            width: 500px;
            margin: auto;
        }

        div.cep{
            color: black;
            font-weight: bold;
            font-size: 13pt;
            text-align: center;

        }
        p{
            color: black;
            font-weight: bold;
            font-size: 13pt;
        }
        a.correios_site{
            color: blue;
            font-weight: bold;
            font-size: 13pt;
            text-decoration: underline;
        }
        /* p.p_rodape{
            color:black;
            font-weight: normal;
            font-size: 12pt;
        } */
        input, textarea{
            font-family: sans-serif;
            font-weight: normal;
            font-size: 13pt;
            background-color: rgba(255,255,255,.8);
        }
        input:hover, textarea:hover{
            background-color: #dddddd;
        }
        button.buscar_cep{
            background-color: blue;
            color: #ffffff;
            /*margin: 0px;*/
        }
        /*input.botao{
            width: 50px;
            height: 45px;
            position: relative;
        }*/
        legend{
            color: #888888;
            font-weight: bold;
            font-size: 13pt;
            font-family: sans-serif;
        }
        fieldset{
            border-color: #cecece;
            margin: 20px;
        }
        fieldset#sexo{
            width: 150px;
        }
        fieldset#usuario{
            background: url('_imagens/icone-contato.png') no-repeat 95% 95%;
            /*95% 95% para colocar na parte inferior direita da tela*/
        }
        fieldset#endereco{
            background: url("_imagens/icone-endereco.png") no-repeat 95% 95%;
            /*95% 95% para colocar na parte inferior direita da tela*/
        }
        fieldset#mensagem{
            background: url("_imagens/icone-mensagem.png") no-repeat 95% 95%;
            /*95% 95% para colocar na parte inferior direita da tela*/
        }
        fieldset#pedido{
            background: url("_imagens/icone-pagamento.png") no-repeat 95% 95%;
            /*95% 95% para colocar na parte inferior direita da tela*/
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<script language="javascript" src="<?= base_url('assets/js/funcoes.js') ?>"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script language="javascript">
   // $( function() {
    //    $( ".datepicker" ).datepicker();
    // class="datepicker" 
    // });
    
    function calc_total(){
        var qtd = parseInt(document.getElementById('cQtd').value);/*parseInt converter para número inteiro*/
        var campoTotal = document.getElementById('cTot');
        tot = qtd * 1500;  
        campoTotal.value = tot;
    }

    function mascara(campo,mascara)
    {
        if(event.keyCode<48 || event.keyCode>57)
        {
            event.returnValue=false;
            // alert("Digite apenas números");
            return false;
        }
        var tam = campo.value.length;
        var saída = mascara.substring(1,0);
        var txt = mascara.substring(tam);
        if(txt.substring(0,1) != saída)
        {
            campo.value += txt.substring(0,1);
        }
    }
    
    function mascaraCPF(campo,mascara)
    {
        if(event.keyCode<48 || event.keyCode>57)
        {
            event.returnValue=false;
            // alert("Digite apenas números");
            // return false;
        }
        var tam = campo.value.length;
        var saída = mascara.substring(1,0);
        var txt = mascara.substring(tam);
        if(txt.substring(0,1) != saída)
        {
            campo.value += txt.substring(0,1);
        }
    }

    const handlePhone = (event) => {
      let input = event.target
      input.value = phoneMask(input.value)
    }

    const phoneMask = (value) => {
      if (!value) return ""
      value = value.replace(/\D/g,'')
      value = value.replace(/(\d{2})(\d)/,"($1) $2")
      value = value.replace(/(\d)(\d{4})$/,"$1-$2")
      return value
    }

    $(function(){
        $("#buscar_cep").click(function(){
      
        //Nova variável "cep" somente com dígitos.
        var cep = $("#cep").val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

             //Consulta o webservice viacep.com.br/
            $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#rua").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        $("#cidade").val(dados.localidade);
                        $("#uf").val(dados.uf);
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        console.log("CEP não encontrado.");
                    }
                    });
                } //end if.
                else {
                    console.log("Formato de CEP inválido.");
                }
            } //end if.
        });

        let value_cpf = document.querySelector('#campo_cpf');

        value_cpf.addEventListener("keydown", function(e) {
        if (e.key > "a" && e.key < "z") {
            e.preventDefault();
        }
        });

        value_cpf.addEventListener("blur", function(e) {

             //Remove tudo o que não é dígito
             let validar_cpf = this.value.replace( /\D/g , "");

             //verificação da quantidade números
             if (validar_cpf.length==11){

             // verificação de CPF valido
              var Soma;
              var Resto;

              Soma = 0;
              for (i=1; i<=9; i++) Soma = Soma + parseInt(validar_cpf.substring(i-1, i)) * (11 - i);
                 Resto = (Soma * 10) % 11;

              if ((Resto == 10) || (Resto == 11))  Resto = 0;
              if (Resto != parseInt(validar_cpf.substring(9, 10)) ) return alert("CPF Inválido!");;

              Soma = 0;
              for (i = 1; i <= 10; i++) Soma = Soma + parseInt(validar_cpf.substring(i-1, i)) * (12 - i);
              Resto = (Soma * 10) % 11;

              if ((Resto == 10) || (Resto == 11))  Resto = 0;
              if (Resto != parseInt(validar_cpf.substring(10, 11) ) ) return alert("CPF Inválido!");;

              //formatação final
              cpf_final = validar_cpf.replace( /(\d{3})(\d)/ , "$1.$2");
              cpf_final = cpf_final.replace( /(\d{3})(\d)/ , "$1.$2");
              cpf_final = cpf_final.replace(/(\d{3})(\d{1,2})$/ , "$1-$2");
              document.getElementById('campo_cpf').value = cpf_final;

             } else {
                alert("CPF Inválido! É esperado 11 dígitos numéricos.");
             }   

        })

        let inputNome = document.querySelector("#nameClient");
        inputNome.addEventListener("keydown", function(e) {  
          if (e.key > "0" && e.key < "9") {
            e.preventDefault();
            // alert("Digite apenas letras");
            return false;
          }
        });
    });
</script>
<body>
    <div id="interface">
        <header id="cabecalho">
            <br>
            <hgroup>
                <h1>Google Glass</h1>
                <h2>A revolução do Google está chegando</h2>
            </hgroup>
            <img id="icone" src="<?= base_url('assets/images/fale.png') ?>"/>
            <!-- <img id="icone" src="_imagens/contato.png"/> -->

            <nav id="menu">
            <h1>Menu Principal</h1>
            <ul type="disc">
                <li onmouseover="mudaFoto('<?= base_url('assets/images/home.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/fale.png') ?>')">
                    <a href="<?= base_url('index.php') ?>">Home</a></li>
                <li onmouseover="mudaFoto('<?= base_url('assets/images/especificacoes.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/fale.png') ?>')">
                    <a href="<?= base_url('index.php/home/specs/' . $usuario_id) ?>">Especificações</a></li>
                <li onmouseover="mudaFoto('<?= base_url('assets/images/fotos.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/fale.png') ?>')">
                    <a href="<?= base_url('index.php/home/fotos/' . $usuario_id) ?>">Fotos</a></li>
                <li onmouseover="mudaFoto('<?= base_url('assets/images/multimidia.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/fale.png') ?>')">
                    <a href="<?= base_url('index.php/home/multimidia/' . $usuario_id) ?>">Multimídia</a></li>
                <li onmouseover="mudaFoto('<?= base_url('assets/images/contato.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/fale.png') ?>')">
                    <a href="<?= base_url('index.php/home/fale_conosco/' . $usuario_id) ?>">Faça seu pedido</a></li>
                <li onmouseover="mudaFoto('<?= base_url('assets/images/contato.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/fale.png') ?>')">
                    <a href="<?= base_url('index.php/home/listar_pedidos/' . $usuario_id) ?>">Lista de Pedidos</a></li>
                <li onmouseover="mudaFoto('<?= base_url('assets/images/logout-peq.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/fale.png') ?>')">
                    <a href="<?= site_url('login/logout'); ?>">Sair</a></li>
            </ul>
            </nav>
        </header>
        <section id="corpo-full">
            <article id="noticia-principal">
                <header id="cabecalho-artigo">
                    <hgroup>
                        <h3 style="font-size: 12pt;">Fale Conosco > FAÇA SEU PEDIDO</h3>
                        <h1>Formulário de Contato</h1>
                        <h2>por Alan Silva</h2>
                        <h3 class="direita">Atualizado em Junho/2024</h3>
                    </hgroup>
                    <?php
                    if(isset($_SESSION['pedido_realizado'])):
                    ?>
                    <div class="notification is-success">
                        <p class="sucesso">SUCESSO: Pedido Realizado!
                    </div>
                    <?php
                    endif;
                    unset($_SESSION['pedido_realizado']);
                    ?>
                    <?php
                        if(isset($_SESSION['pedido_nao_realizado'])):
                    ?>
                    <div class="notification is-danger">
                        <p class="erro">ERRO: Não foi possível completar o pedido. <br> Tente Novamente!</p>
                    </div>
                    <?php
                    endif;
                    unset($_SESSION['pedido_nao_realizado']);
                    ?>

                    <!-- <div class="columns is-centered"> -->
                    <div class="column is-half">
                        <?php if ($this->session->flashdata('campos_em_branco')): ?>
                            <div class="notification is-danger has-text-centered">
                                <p class="erro"><?php echo $this->session->flashdata('campos_em_branco'); ?></p>
                            </div>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('cpf_invalido')): ?>
                            <div class="notification is-danger has-text-centered">
                                <p class="erro"><?php echo $this->session->flashdata('cpf_invalido'); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- </div> -->
                    
                </header>
                
                <form action="<?= site_url('home/request_c') ?>" oninput="calc_total();" method="POST">                    
                    <fieldset id="usuario"><legend>Identificação do Usuário</legend>
                        <br>
                        <p><label for="nameClient">Nome Completo:</label>
                        <input type="text" id="nameClient" name="tNome" size="20" minlength="3" maxlength="80" value="<?= $this->session->flashdata('dados_form')['nome'] ?? '' ?>" 
                        placeholder="Digite apenas letras" required/></p>

                        <p><label for="cMail">E-mail:</label>
                        <input type="email" name="tMail" id="cMail" size="25" value="<?= $this->session->flashdata('dados_form')['email'] ?? '' ?>" 
                        minlength="5" maxlength="40" placeholder="examplo@examplo.com" required/></p><br>

                        <p><label class="label_input">Gênero:</label><br>
                        <p><input type="radio" name="tSexo" id="cMasc" value="Masculino" <?= isset($this->session->flashdata('dados_form')['sexo']) && $this->session->flashdata('dados_form')['sexo'] === 'Masculino' ? 'checked' : ''; ?>/>
                        <label class="cMasc" for="cMasc"> Masculino</label><br/></p>
                        <p><input type="radio" name="tSexo" id="cFem" value="Feminino" <?= isset($this->session->flashdata('dados_form')['sexo']) && $this->session->flashdata('dados_form')['sexo'] === 'Feminino' ? 'checked' : ''; ?>/>
                        <label class="cMasc" for="cFem"> Feminino</label><br/></p>
                        <p><input type="radio" name="tSexo" id="cOut" value="Outro" <?= isset($this->session->flashdata('dados_form')['sexo']) && $this->session->flashdata('dados_form')['sexo'] === 'Outro' ? 'checked' : ''; ?>/>
                        <label class="cMasc" for="cOut"> Outro</label><br/><br/></p>
                        </p>

                        <p><label for="cNasc">Data de Nascimento:</label>
                        <input type="date" name="tNasc" id="cNasc"
                        class="form-control"
                        placeholder="Digite a data" 
                        value="<?= $this->session->flashdata('dados_form')['data_nascimento'] ?? '' ?>" 
                        required />
                        <!-- <input type="text" name="tNasc" id="cNasc" 
                        size="10" maxlength="10" minlength="0" placeholder="Digite a data" value="<?= $this->session->flashdata('dados_form')['data_nascimento'] ?? '' ?>" 
                        size="10" class="form-control date-mask" onkeypress="mascara(this,'##/##/####')" required/></p> -->

                        <p><label for="cpf">CPF:</label>
                        <input type="text" name="tCpf" id="cpf" size="16" maxlength="14" 
                        value="<?= $this->session->flashdata('dados_form')['cpf'] ?? '' ?>"
                        placeholder="Digite apenas números" onkeypress="mascaraCPF(this,'###.###.###-##')" required/></p>

                        <p><label for="cRg">RG:</label>
                        <input type="text" name="tRg" id="cRg" onkeypress="mascara(this,'##.###.###-##')" value="<?= $this->session->flashdata('dados_form')['rg'] ?? '' ?>" 
                        maxlength="13" size="17" placeholder="Digite apenas números"/></p>

                        <p><label for="cTel1">Celular 1:</label>
                        <input type="text" name="tTel1" id="cTel1" type="tel" value="<?= $this->session->flashdata('dados_form')['telefone_1'] ?? '' ?>" 
                        maxlength="15" onkeyup="handlePhone(event)" placeholder="(XX)XXXXX-XXXX" required/></p>

                        <p><label for="cTel2">Celular 2:</label>
                        <input type="text" name="tTel2" id="cTel2" type="tel" value="<?= $this->session->flashdata('dados_form')['telefone_2'] ?? '' ?>" 
                        maxlength="15" required onkeyup="handlePhone(event)" placeholder=" (XX)XXXXX-XXXX"/></p><br>
                    </fieldset>

                    <h1 class="h2_aviso">UTILIZE O CAMPO CEP, PARA BUSCAR SEU ENDEREÇO!</h1>
                    <fieldset id="endereco"><legend>Endereço do Usuário</legend><br>
                        <div class="cep">
                            <div class="col-6 col-md-4">
                            <p><label for="cep">CEP:</label>                            
                            <input type="text" id="cep" name="cep" onkeypress="mascara(this,'#####-###')" value="<?= $this->session->flashdata('dados_form')['cep'] ?? '' ?>" 
                            maxlength="9" placeholder="Digite apenas números" required/>
                            <button type="button" class="buscar_cep" id="buscar_cep">
                                BUSCAR
                            <i class="fa fa-search" action="" ></i>
                            </button> 
                            </div>
                            <div class="col-6 col-md-4">
                                <p><a class="correios_site" href="https://buscacepinter.correios.com.br/app/endereco/index.php" target="_blank">Buscar Cep</a></p>
                            </div>
                            <div class="col-6 col-md-4">
                                <p><label for="rua">Rua:</label>
                                <input type="text" id="rua" name="endereco" size="30" value="<?= $this->session->flashdata('dados_form')['endereco'] ?? '' ?>" required/>
                            </div>
                            <div class="col-6 col-md-4">
                                <p><label for="cNum"/>Número:<input type="text" name="tNum" id="cNum" size="7" value="<?= $this->session->flashdata('dados_form')['numero'] ?? '' ?>" 
                                minlength="0" maxlength="7"  onkeypress="mascara(this,'#######')" required/></p>
                                <p><label for="bairro">Bairro:</label>
                                <input type="text" id="bairro" name="bairro" value="<?= $this->session->flashdata('dados_form')['bairro'] ?? '' ?>" size="26" required/>
                            </div>
                            <div class="col-6 col-md-4">
                                <p><label for="uf">UF:</label>
                                <input type="text" id="uf" name="uf" size="2" value="<?= $this->session->flashdata('dados_form')['uf'] ?? '' ?>" required/>
                            </div>
                            <div class="col-6 col-md-4">
                                <p><label for="cidade">Cidade:</label>
                                <input type="text" id="cidade" name="cidade" value="<?= $this->session->flashdata('dados_form')['cidade'] ?? '' ?>" required/>
                            </div>
                        </div>
                        <br>
                    </fieldset>

                    <fieldset id="mensagem"><legend>Mensagem do Usuário</legend><br>
                        <p><label class="men" for="cMsg">Mensagem:</label>
                        <textarea name="tMsg" id="cMsg" cols="28" rows="5" placeholder="Deixe aqui sua mensagem"><?= $this->session->flashdata('dados_form')['mensagem'] ?? '' ?></textarea></p>
                        <br>
                    </fieldset>

                    <fieldset id="pedido"><legend>Quero um Google Glass</legend>
                        <br>
                        <p><label for="cQtd">Quantidade:</label>
                        <input type="number" name="tQtd" id="cQtd" max="5" min="0" value="<?= $this->session->flashdata('dados_form')['quantidade'] ?? '0' ?>" required/></p>                         
                        <p><label for="cTot">Preço Total: R$</label>
                        <input type="text" name="tTot" id="cTot" placeholder="Total a pagar" readonly/></p>
                        <br>
                    </fieldset>
                    <input type="image" class="enviar" name="Enviar" src="<?= base_url('assets/images/botao-enviar.png') ?>">
                    <!-- <input type="submit" value="ENVIAR PEDIDO" class="enviar"> -->
                </form>
            </article><br>
        </section>
    
        <footer id="rodape">
            <p>Copyright 2024 - by Product Easy 
            <br></br>
            <a style="color: #120A8F" href= https://www.linkedin.com/in/alan-martins-b83639316/ target="_blank">LINKEDIN | 
            <a style="color: #000080" href= https://www.facebook.com/alan.martins.50746/ target="_blank">FACEBOOK | 
            <a style="color: #DD2A7B" href= https://www.instagram.com/alan_martins0/ target="_blank">INSTAGRAM 
            </p>
        </footer>
        
    </div>
</body>
</html>


