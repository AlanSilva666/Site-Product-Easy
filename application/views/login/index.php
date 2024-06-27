<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product Easy</title>
    <link rel="shortcut icon" href="<?= base_url("assets/images/si_icon.png")?>">
    <link href="<?= base_url("assets/css/bulma.min.css")?>" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url("assets/css/login.css")?>" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <style>
        p.success {
            font-size: 11pt;
            font-weight: bold;
            font-family: arial;
        }
		.eye-icon {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
        .eye-icon img {
            width: 40px; /* Ajuste o tamanho do ícone do olho */
            height: auto;
            padding: 5px; /* Espaçamento interno para maior clique */
            /* background-color: #fff; Fundo branco para o ícone */
            border-radius: 3px; /* Borda arredondada */
        }
        .tooltip {
            visibility: hidden;
            width: 120px;
            background-color: black;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;
            position: absolute;
            z-index: 1;
            top: 50%;
            left: 110%; /* Adjust this value to control the distance from the icon */
            transform: translateY(-50%);
            opacity: 0;
            transition: opacity 0.3s;
        }
        .eye-icon:hover .tooltip {
            visibility: visible;
            opacity: 1;
        }
        .input-container {
            position: relative;
        }

    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            var senha = $('#senha');
            var olho = $("#olho");

            // Mostrar senha ao clicar no ícone do olho
            olho.mousedown(function() {
                senha.attr("type", "text");
            });

            // Ocultar senha ao soltar o clique do ícone do olho
            olho.mouseup(function() {
                senha.attr("type", "password");
            });

            // Garantir que a senha seja ocultada se o mouse sair do ícone do olho
            olho.mouseout(function() {
                senha.attr("type", "password");
            });
        });

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
				alert("Digite apenas números");
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
    </script>
</head>
<body>
<section class="hero is-success is-fullheight">
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="column is-4 is-offset-4">
                <h3 class="title has-text-grey">Login</h3>
                <img width="60%" height="60%" class="img-responsive" src="<?= base_url("assets/images/logo_1.png")?>" alt="KPI Mobile" />
                
                <?php if ($this->session->flashdata('criado')): ?>
                    <div class="notification is-success">
                        <p class="success">SUCESSO: LOGIN CADASTRADO. <br> PODE ACESSAR O SISTEMA!</p>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('senha_alterada')): ?>
                    <div class="notification is-success">
                        <p>SUCESSO: SENHA ALTERADA! <br> ACESSE O SISTEMA.</p>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('nao_autenticado')): ?>
                    <div class="notification is-danger">
                        <p>ERRO: LOGIN OU SENHA ESTÃO INVÁLIDOS.</p>
                    </div>
                <?php endif; ?>

                <div class="box">
                    <form action="<?= base_url("index.php/login/process_login")?>" method="post">
                        <div class="field">
                            <div class="control">
                                <input name="cpf" id="cpf" 
                                type="text" size="16" maxlength="14" class="input is-large" placeholder="LOGIN (CPF)" autofocus="" onkeypress="mascaraCPF(this,'###.###.###-##')">
                                <!-- value="<?= $this->session->flashdata('cpf') ?>" -->
                            </div>
                        </div>

                        <div class="field input-container">
                            <div class="control has-icons-right">
                                <input name="senha" id="senha" class="input is-large" minlength="8" maxlength="40" size="40"
                                type="password" placeholder="SENHA">
                                <span id="olho" class="eye-icon">
                                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABDUlEQVQ4jd2SvW3DMBBGbwQVKlyo4BGC4FKFS4+TATKCNxAggkeoSpHSRQbwAB7AA7hQoUKFLH6E2qQQHfgHdpo0yQHX8T3exyPR/ytlQ8kOhgV7FvSx9+xglA3lM3DBgh0LPn/onbJhcQ0bv2SHlgVgQa/suFHVkCg7bm5gzB2OyvjlDFdDcoa19etZMN8Qp7oUDPEM2KFV1ZAQO2zPMBERO7Ra4JQNpRa4K4FDS0R0IdneCbQLb4/zh/c7QdH4NL40tPXrovFpjHQr6PJ6yr5hQV80PiUiIm1OKxZ0LICS8TWvpyyOf2DBQQtcXk8Zi3+JcKfNafVsjZ0WfGgJlZZQxZjdwzX+ykf6u/UF0Fwo5Apfcq8AAAAASUVORK5CYII=" alt="Mostrar Senha">
                                    <span class="tooltip">
                                        CLIQUE AQUI 
                                        <BR>
                                        MOSTRE A SENHA
                                    </span>
                                </span>

                            </div>
                        </div>
						
                        <button type="submit" class="button is-block is-link is-large is-fullwidth">Entrar</button>
						<br>
						<div class="field">
							<div class="control">
								<button type="link" class="button is-warning is-link is-large is-fullwidth">
								<a href="<?= site_url('login/show_register'); ?>">CRIAR CONTA</a></buton>                                    
							</div>
						</div>
						<div class="field">
							<div class="control">
							<button type="link" class="button is-info is-link is-large is-fullwidth">
							<a href="<?= site_url('login/show_new_password'); ?>">ESQUECEU A SENHA?</a></buton>      
						</div>    
                    </form>
                </div>
                <!-- <p><a href="<?= site_url('login/show_new_password') ?>">Esqueci a senha</a> | <a href="<?= site_url('login/show_register') ?>">Criar Login</a></p> -->
            </div>
        </div>
    </div>
</section>
</body>
</html>
