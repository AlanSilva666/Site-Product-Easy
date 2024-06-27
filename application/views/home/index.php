<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Product Easy - Óculos Google Glass</title>
    <link rel="shortcut icon" href="<?= base_url("assets/images/si_icon.png")?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/estilo.css') ?>"/>,
    <!-- <link rel="stylesheet" href="<?= base_url('assets/css/estilo.css?v=' . time()) ?>"/> -->

    <style>
        .welcome-message {
            background-color: #8bc34a;
            color: white;
            font-weight: bold;
            padding: 10px;
            margin: 10px auto;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5); /* Sombra suave */
            width: 25%; /* Ajuste conforme necessário */
            font-size: 10px; /* Ajuste o tamanho da fonte conforme necessário */
            text-align: left;
            margin-left: 10px; /* Ajuste a margem esquerda conforme necessário */
        }
        h2.open_sistem {
            background: #00FF7F;
            border: 2px black solid;
            color: black;
            font-size: 15pt;
            font-weight: bold;
            font-family: Arial sans-serif;
            position: absolute;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var welcomeMessage = document.querySelector('.welcome-message');
            if (welcomeMessage) {
                welcomeMessage.style.display = 'block'; // Mostra a mensagem
                setTimeout(function() {
                    welcomeMessage.style.display = 'none'; // Esconde a mensagem após 10 segundos
                }, 10000); // 10 segundos
            }
        });
    </script>
</head>
<script language="javascript" src="<?= base_url('assets/js/funcoes.js') ?>"></script>
<!-- <script language="javascript" src="assets/js/funcoes.js"></script> -->
<body>
<!-- Verifica se há mensagem de boas-vindas e exibe -->
<div id="interface">
    <header id="cabecalho">
        <hgroup>
            <br>
            <h1>Google Glass</h1>
            <h2>A revolução do Google está chegando</h2>
        </hgroup>
        <img id="icone" src="<?= base_url('assets/images/glass-oculos-preto-peq.png') ?>"/>
        <nav id="menu">
            <h1>Menu Principal</h1>
            <ul type="disc"><br>
                    <li onmouseover="mudaFoto('<?= base_url('assets/images/home.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/glass-oculos-preto-peq.png') ?>')">
                        <a href="<?= base_url('index.php/home') ?>">Home</a>
                    </li>
                    <li onmouseover="mudaFoto('<?= base_url('assets/images/especificacoes.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/glass-oculos-preto-peq.png') ?>')">
                        <a href="<?= base_url('index.php/home/specs/' . $usuario_id) ?>">Especificações</a>
                    </li>
                    <li onmouseover="mudaFoto('<?= base_url('assets/images/fotos.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/glass-oculos-preto-peq.png') ?>')">
                        <a href="<?= base_url('index.php/home/fotos/' . $usuario_id) ?>">Fotos</a>
                    </li>
                    <li onmouseover="mudaFoto('<?= base_url('assets/images/multimidia.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/glass-oculos-preto-peq.png') ?>')">
                        <a href="<?= base_url('index.php/home/multimidia/' . $usuario_id) ?>">Multimídia</a>
                    </li>
                    <li onmouseover="mudaFoto('<?= base_url('assets/images/contato.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/glass-oculos-preto-peq.png') ?>')">
                        <a href="<?= base_url('index.php/home/fale_conosco/' . $usuario_id) ?>">Faça seu pedido</a>
                    </li>
                    <li onmouseover="mudaFoto('<?= base_url('assets/images/contato.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/especificacoes.png') ?>')">
                        <a href="<?= base_url('index.php/home/listar_pedidos/' . $usuario_id) ?>">Lista de Pedidos</a>
                    </li>
                    <li onmouseover="mudaFoto('<?= base_url('assets/images/logout-peq.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/glass-oculos-preto-peq.png') ?>')">
                        <a href="<?= site_url('login/logout'); ?>">Sair</a>
                    </li>
            </ul>
        </nav>
    </header>
    <?php if (!empty($welcome_message)): ?>
        <div class="welcome-message">
            <?= $welcome_message ?>
        </div>
    <?php endif; ?>
    <section id="corpo">
        <article id="noticia-principal">
            <header id="cabecalho-artigo">
                <hgroup>
                    <h3>Tecnologia > &nbsp; &nbsp; &nbsp; Inovações</h3>
                    <h1>Saiba tudo sobre o Google Glass</h1>
                    <h2>por Alan Silva</h2>
                    <h3 class="direita">Atualizado em Junho/2024</h3>
                </hgroup>
            </header>

            <h2>O que é</h2>
            <p>O <span style="font-weight: 900;">Google Glass</span> é um acessório em forma de óculos que possibilita a interação dos usuários com diversos conteúdos em realidade aumentada. Também chamado de <a href="https://glass.google.com" target="_blank">Project Glass</a>, o eletrônico é capaz de tirar fotos a partir de comandos de voz, enviar mensagens instantâneas e realizar vídeo&shy;con&shy;ferên&shy;cias. Seu lançamento está previsto para 2025, e seu preço deve ser de US$ 1,5 mil. Atualmente o <em>Google Glass</em> encontra-se em fase de testes e já possui um vídeo totalmente gravado com o dispositivo. Além disso, a companhia de buscas registrou novas patentes anti-furto e de desbloqueio de tela para o acessório.
            </p>

            <figure class="foto-legenda">
                <img src="<?= base_url('assets/images/glass-quadro-homem-mulher.jpg') ?>"/>
                <figcaption>
                    <h3>Google Glass</h3>
                    <p>Uma nova maneira de ver o mundo.</p>
                </figcaption>
            </figure>


            <h2>Data de lançamento</h2>
            <p>Não há uma data específica e oficial para o dispositivo ser lançado, ainda. Pode ser que ele esteja disponível em demonstrações a partir de 2024, mas seu lançamento para as lojas fica para, pelo menos, 2025.</p>

            <h2>Especificações Técnicas</h2>
            <table id="tabelaspec">
                <caption>Tabela Técnica do Google Glass <span>Mar/2013</span></caption>
                <tr><td class="ce">Tela</td><td class="cd">Resolução equivalente a tela de 25"</td></tr>
                <tr><td rowspan="2" class="ce">Camera</td><td class="cd">5MP para fotos</td></tr>
                <tr><td class="cd">720p para vídeos</td></tr>
                <tr><td rowspan="2" class="ce" >Conectividade</td><td class="cd">Wi-Fi</td></tr>
                <tr><td class="cd">Bluetooth</td></tr>
                <tr><td class="ce">Memória Interna</td><td class="cd"> 12GB</td></tr>
            </table>

            <h2>Como funciona</h2>
            <p>De acordo com fontes próximas do Google, os óculos vão contar com uma pequena tela de LCD ou AMOLED na parte superior e em frente aos olhos do usuário. Com o uso de uma câmera e GPS, você pode se situar, assim como selecionar opções com o movimento da cabeça.</p>

        </article>
    </section>

    <aside id="lateral">
        <h1>Outras Notícias</h1>
        <h2>Novidades no Glass</h2>
        <p>O Google enfim revelou as especificações completas do Google Glass, e com ele uma surpresa ainda inédita no mercado: a gigante das buscas usará um sistema de áudio baseado na transdução por condução. Através das hastes dos óculos, o som será transmitido para o ouvido do usuário por meio de microvibrações em determinados ossos de sua cabeça, sem usar nenhum tipo de alto-falante.</p>

        <p>Além da surpresa do áudio, a tela montada a frente do olho do usuário também chamou atenção. Serão 640 x 360 pixels de resolução que, em proporção, equivaleria a um monitor de 25 polegadas de alta definição colocado a 2,5 metros de distância do espectador.</p>

        
    </aside>

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
