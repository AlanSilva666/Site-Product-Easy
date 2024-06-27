<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Product Easy - Multimídia</title>
    <link rel="shortcut icon" href="<?= base_url("assets/images/si_icon.png")?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/estilo.css') ?>"/>
    <link rel="stylesheet" href="<?= base_url('assets/css/fotos.css') ?>"/>
    <script language="javascript" src="<?= base_url('assets/js/funcoes.js') ?>"></script>
    <style>
        div#tv-radio{
            width: 900px;
            height: 580px;
            margin: auto;
            background: url("<?= base_url('assets/images/radio-tv.png') ?>") no-repeat;
        }
        audio#musica{
            display: block;
            position: relative;
            left: 575px;
            top: 490px;
            width: 300px;
        }
        video#filme{
            display: block;
            position: relative;
            left: 90px;
            top: 65px;
            width: 440px;
        }
    </style>
</head>
<body>
    <div id="interface">
        <br>
        <header id="cabecalho">
            <hgroup>
                <h1>Google Glass</h1>
                <h2>A revolução do Google está chegando</h2>
            </hgroup>
            <img id="icone" src="<?= base_url('assets/images/multimidia.png') ?>"/>
            <nav id="menu">
                <h1>Menu Principal</h1>
                <ul type="disc" >
                    <li onmouseover="mudaFoto('<?= base_url('assets/images/home.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/multimidia.png') ?>')">
                        <a href="<?= base_url('index.php') ?>">Home</a></li>
                    <li onmouseover="mudaFoto('<?= base_url('assets/images/especificacoes.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/multimidia.png') ?>')">
                        <a href="<?= base_url('index.php/home/specs/' . $usuario_id) ?>">Especificações</a></li>
                    <li onmouseover="mudaFoto('<?= base_url('assets/images/fotos.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/multimidia.png') ?>')">
                        <a href="<?= base_url('index.php/home/fotos/' . $usuario_id) ?>">Fotos</a></li>
                    <li onmouseover="mudaFoto('<?= base_url('assets/images/multimidia.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/multimidia.png') ?>')">
                        <a href="<?= base_url('index.php/home/multimidia/' . $usuario_id) ?>">Multimídia</a></li>
                    <li onmouseover="mudaFoto('<?= base_url('assets/images/contato.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/multimidia.png') ?>')">
                        <a href="<?= base_url('index.php/home/fale_conosco/' . $usuario_id) ?>">Faça seu pedido</a></li>
                    <li onmouseover="mudaFoto('<?= base_url('assets/images/contato.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/multimidia.png') ?>')">
                        <a href="<?= base_url('index.php/home/listar_pedidos/' . $usuario_id) ?>">Lista de Pedidos</a></li>
                    <li onmouseover="mudaFoto('<?= base_url('assets/images/logout-peq.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/multimidia.png') ?>')">
                        <a href="<?= site_url('login/logout'); ?>">Sair</a></li> 
                </ul>
            </nav>
        </header>

        <section id="corpo-full">
            <article id="noticia-principal">
                <header id="cabecalho-artigo">
                    <hgroup>
                        <h3>Glass > Multimídia</h3>
                        <h1>Sons e Vídeos</h1>
                        <h2>por Alan Silva</h2>
                        <h3 class="direita">Atualizado em Junho/2024</h3>
                    </hgroup>
                </header>
                <div id="tv-radio">
                    <audio id="musica" controls="controls">
                        <source src="<?= base_url('assets/_media/2009-lovers-carvings-bibio.mp3') ?>" type="audio/mpeg"/>
                        <source src="<?= base_url('assets/_media/2009-lovers-carvings-bibio.m4a') ?>" type="audio/mpeg"/>
                        <source src="<?= base_url('assets/_media/2009-lovers-carvings-bibio.ogg') ?>" type="audio/mpeg"/>
                        Desculpe, mas não foi possível carregar o áudio.
                    </audio>
                    <video id="filme" controls="controls" poster="<?= base_url('assets/images/video-mini03.jpg') ?>">
                        <source src="<?= base_url('assets/_media/getting-started.mp4') ?>" type="video/mp4">
                        <source src="<?= base_url('assets/_media/getting-started.webm') ?>" type="video/webm">
                        <source src="<?= base_url('assets/_media/getting-started.ogg') ?>" type="video/ogg">
                        Desculpe, mas não foi possível carregar o vídeo.
                    </video>
                </div>
            </article>
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
