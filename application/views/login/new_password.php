<?php
	// session_start();
?>
<!DOCTYPE html>
<html>
    
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product Easy</title>
    <link rel="shortcut icon" href="<?= base_url("assets/images/si_mini.png")?>">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link href="<?= base_url("assets/css/bulma.min.css")?>" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url("assets/css/login.css")?>" rel="stylesheet" type="text/css"/>
    <style type="text/css">
        label.label_input{
            color: black;
            font-weight: bold;
            font-family: Arial;
        }
        .strength-meter {
            display: none;
            width: 100%;
            height: 10px;
            margin-top: 5px;
            border-radius: 5px;
        }
        .strength-meter div {
            height: 100%;
            border-radius: 5px;
        }
        .strength-weak {
            background-color: red;
        }      
        .strength-medium {
            background-color: yellow;
        }       
        .strength-strong {
            background-color: green;
        }       
        #strength-text {
            display: block;
            margin-top: 5px;
            font-weight: bold;
        }
        .eye-icon {
            position: absolute;
            right: 5px; /* Ajuste a posição horizontal conforme necessário */
            top: 50%; /* Centraliza verticalmente */
            transform: translateY(-50%);
            cursor: pointer;
        }

        .eye-icon img {
            width: 35px; /* Ajuste o tamanho do ícone do olho conforme necessário */
            height: auto;
            padding: 5px; /* Espaçamento interno para maior clique */
            border-radius: 3px; /* Borda arredondada */
            background-color: #fff; /* Fundo branco para o ícone */
        }

        .input-container {
            position: relative;
        }
    </style>
</head>
<script src="<?= base_url("assets/js/funcoes.js")?>"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script language="javascript">
    $(document).ready(function() {
        // Mostrar senha ao clicar no ícone do olho da senha
        $("#olho").mousedown(function() {
            $('#senha').attr("type", "text");
        });

        // Ocultar senha ao soltar o clique do ícone do olho da senha
        $("#olho").mouseup(function() {
            $('#senha').attr("type", "password");
        });

        // Garantir que a senha seja ocultada se o mouse sair do ícone do olho da senha
        $("#olho").mouseout(function() {
            $('#senha').attr("type", "password");
        });

        // Mostrar senha ao clicar no ícone do olho de confirmação
        $("#olho-confirm").mousedown(function() {
            $('#confirm_password').attr("type", "text");
        });

        // Ocultar senha de confirmação ao soltar o clique do ícone do olho de confirmação
        $("#olho-confirm").mouseup(function() {
            $('#confirm_password').attr("type", "password");
        });

        // Garantir que a senha de confirmação seja ocultada se o mouse sair do ícone do olho de confirmação
        $("#olho-confirm").mouseout(function() {
            $('#confirm_password').attr("type", "password");
        });

        // Impedir que o clique no ícone do olho confirme a ação do formulário
        $("#olho-confirm").click(function(e) {
            e.preventDefault();
        });
    });

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

    document.addEventListener('DOMContentLoaded', (event) => {
        var password = document.getElementById('senha');
        var confirm_password = document.getElementById('confirm_password');
        var strengthMeter = document.getElementById('strength-meter');
        var strengthMeterBar = strengthMeter.querySelector('div');
        var strengthText = document.getElementById('strength-text');

    password.addEventListener('input', checkPasswordStrength);
    confirm_password.addEventListener('input', checkPasswordMatch);

        password.addEventListener('input', checkPasswordStrength);

        function checkPasswordStrength() {
            var val = password.value;
            var strength = 0;

            if (val.length > 7) strength++;
            if (val.match(/[a-z]+/)) strength++;
            if (val.match(/[A-Z]+/)) strength++;
            if (val.match(/[0-9]+/)) strength++;
            if (val.match(/[$@#&!]+/)) strength++;

            switch (strength) {
                case 1:
                case 2:
                    strengthMeterBar.style.width = "33%";
                    strengthMeterBar.className = "strength-weak";
                    strengthText.style.color = "red";
                    strengthMeter.style.display = "block";
                    strengthText.textContent = "Senha fraca";
                    break;
                case 3:
                case 4:
                    strengthMeterBar.style.width = "66%";
                    strengthMeterBar.className = "strength-medium";
                    strengthText.style.color = "orange";
                    strengthMeter.style.display = "block";
                    strengthText.textContent = "Senha média";
                    break;
                case 5:
                    strengthMeterBar.style.width = "100%";
                    strengthMeterBar.className = "strength-strong";
                    strengthText.style.color = "green";
                    strengthMeter.style.display = "block";
                    strengthText.textContent = "Senha forte";
                    break;
                default:
                    strengthMeter.style.display = "none";
            }
        }
        function checkPasswordMatch() {
            if (password.value !== confirm_password.value) {
                confirm_password.setCustomValidity("As senhas não coincidem.");
                submitButton.disabled = true; // Desabilita o botão de submit
            } else {
                confirm_password.setCustomValidity('');
                submitButton.disabled = false; // Habilita o botão de submit
            }
        }
    });
</script>
<body>
    <section class="hero is-success is-fullheight">
        <div class="hero-body">
            <div class="container has-text-centered">
                <div class="column is-4 is-offset-4">
                    <h3 class="title has-text-grey">Atualização de Senha</h3>
                    <img width="60%" height="60%" class="img-responsive" src="<?= base_url("assets/images/logo_1.png")?>" alt="KPI Mobile" />
                    
                    <?php if ($this->session->flashdata('erro_senha')): ?>
                        <div class="notification is-danger">
                            <p>ERRO: CPF NÃO ENCONTRADO!</p>
                        </div>
                    <?php endif; ?>

                    <?php if ($this->session->flashdata('senha_forte')): ?>
                        <div class="notification is-danger">
                            <p>ERRO: CRIE UMA SENHA FORTE! <BR> LETRAS MAIÚSCULAS, MINÚSCULAS, <BR> NÚMEROS E CARACTERES ESPECIAIS.</p>
                        </div>
                    <?php endif; ?>


                    <div class="box">
                        <form action="<?= base_url("index.php/login/new_password")?>" method="POST">
                            <div class="field">
                                <div class="control">
                                    <label class="label_input">Digite seu CPF (Campo Obrigatório)</label>
                                    <input name="cpf" type="text" id="cpf" value="<?= $this->session->flashdata('cpf') ?>" size="16" maxlength="14" class="input is-large" placeholder="CPF" autofocus="" onkeypress="mascara(this,'###.###.###-##')" required>
                                </div>
                                <br/>
                                <div class="field input-container">
                                    <div class="control has-icons-right">
                                        <label class="label_input">Crie uma nova senha (Campo Obrigatório)</label>
                                        <div style="position:relative;">
                                            <input name="senha" id="senha" class="input is-large" type="password" placeholder="Senha" minlength="8" maxlength="40" required>
                                            <span id="olho" class="eye-icon" style="position:absolute; right:5px; top:50%; transform:translateY(-50%);">
                                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABDUlEQVQ4jd2SvW3DMBBGbwQVKlyo4BGC4FKFS4+TATKCNxAggkeoSpHSRQbwAB7AA7hQoUKFLH6E2qQQHfgHdpo0yQHX8T3exyPR/ytlQ8kOhgV7FvSx9+xglA3lM3DBgh0LPn/onbJhcQ0bv2SHlgVgQa/suFHVkCg7bm5gzB2OyvjlDFdDcoa19etZMN8Qp7oUDPEM2KFV1ZAQO2zPMBERO7Ra4JQNpRa4K4FDS0R0IdneCbQLb4/zh/c7QdH4NL40tPXrovFpjHQr6PJ6yr5hQV80PiUiIm1OKxZ0LICS8TWvpyyOf2DBQQtcXk8Zi3+JcKfNafVsjZ0WfGgJlZZQxZjdwzX+ykf6u/UF0Fwo5Apfcq8AAAAASUVORK5CYII=" alt="Mostrar Senha">
                                            </span>
                                        </div>
                                        <div class="strength-meter" id="strength-meter">
                                            <div></div>
                                        </div>
                                        <span id="strength-text"></span>
                                    </div>
                                </div>

                                <div class="field input-container">
                                    <div class="control has-icons-right">
                                        <label class="label_input">Digite a senha novamente (Campo Obrigatório)</label>
                                        <div style="position:relative;">
                                            <input name="confirm_password" id="confirm_password" class="input is-large" type="password" placeholder="Confirmar senha" minlength="8" maxlength="40" required>
                                            <span id="olho-confirm" class="eye-icon" style="position:absolute; right:5px; top:50%; transform:translateY(-50%);">
                                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABDUlEQVQ4jd2SvW3DMBBGbwQVKlyo4BGC4FKFS4+TATKCNxAggkeoSpHSRQbwAB7AA7hQoUKFLH6E2qQQHfgHdpo0yQHX8T3exyPR/ytlQ8kOhgV7FvSx9+xglA3lM3DBgh0LPn/onbJhcQ0bv2SHlgVgQa/suFHVkCg7bm5gzB2OyvjlDFdDcoa19etZMN8Qp7oUDPEM2KFV1ZAQO2zPMBERO7Ra4JQNpRa4K4FDS0R0IdneCbQLb4/zh/c7QdH4NL40tPXrovFpjHQr6PJ6yr5hQV80PiUiIm1OKxZ0LICS8TWvpyyOf2DBQQtcXk8Zi3+JcKfNafVsjZ0WfGgJlZZQxZjdwzX+ykf6u/UF0Fwo5Apfcq8AAAAASUVORK5CYII=" alt="Mostrar Senha">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="control">
                                    <label class="label_input">CRIE UMA NOVA SENHA (CAMPO OBRIGATÓRIO):</label>
                                    <input name="senha" class="input is-large" type="password" id="password" placeholder="Senha" minlength="8" maxlength="40" required>
                                    <div class="strength-meter" id="strength-meter">
                                        <div></div>
                                    </div>
                                    <span id="strength-text"></span>
                                </div><br/> -->

                                <!-- <div class="control">
                                    <label class="label_input" >DIGITE A SENHA NOVAMENTE (CAMPO OBRIGATÓRIO):</label>
                                    <input name="senha" class="input is-large" type="password" id="confirm_password" placeholder="Confirmar senha" minlength="8" maxlength="40" required>
                                </div> -->
                            </div>
                            <button id="submit-button" type="submit" class="button is-block is-link is-large is-fullwidth">ATUALIZAR</button><br>
							<a href="<?= base_url("index.php/login/index")?>">VOLTAR</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>

