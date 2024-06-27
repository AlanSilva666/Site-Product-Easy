<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<title>Product Easy - Fotos</title>
	<!-- <link rel="stylesheet" type="text/css" href="_css/estilo.css"/> -->
	<link rel="shortcut icon" href="<?= base_url("assets/images/si_icon.png")?>">
	<link rel="stylesheet" href="<?= base_url('assets/css/estilo.css') ?>"/>
	<link rel="stylesheet" href="<?= base_url('assets/css/fotos.css') ?>"/>
</head>
<script language="javascript" src="<?= base_url('assets/js/funcoes.js') ?>"></script>
<!-- <script language="javascript" src="assets/js/funcoes.js"></script> -->
<body>
	<div id="interface">
		<header id="cabecalho">
			
			<br>
			<hgroup>
				<h1>Google Glass</h1>
				<h2>A revolução do Google está chegando</h2>
			</hgroup>
			<img id="icone" src="<?= base_url('assets/images/fotos.png') ?>"/>
			<nav id="menu">
				<h1>Menu Principal</h1>
				<ul type="disc">
					<li onmouseover="mudaFoto('<?= base_url('assets/images/home.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/fotos.png') ?>')">
						<a href="<?= base_url('index.php') ?>">Home</a>
					</li>
					<li onmouseover="mudaFoto('<?= base_url('assets/images/especificacoes.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/fotos.png') ?>')">
						<a href="<?= base_url('index.php/home/specs/' . $usuario_id) ?>">Especificações</a>
					</li>
					<li onmouseover="mudaFoto('<?= base_url('assets/images/fotos.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/fotos.png') ?>')">
						<a href="<?= base_url('index.php/home/fotos/' . $usuario_id) ?>">Fotos</a>
					</li>
					<li onmouseover="mudaFoto('<?= base_url('assets/images/multimidia.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/fotos.png') ?>')">
						<a href="<?= base_url('index.php/home/multimidia/' . $usuario_id) ?>">Multimídia</a>
					</li>
					<li onmouseover="mudaFoto('<?= base_url('assets/images/contato.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/fotos.png') ?>')">
						<a href="<?= base_url('index.php/home/fale_conosco/' . $usuario_id) ?>">Faça seu pedido</a>
					</li>
					<li onmouseover="mudaFoto('<?= base_url('assets/images/contato.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/fotos.png') ?>')">
						<a href="<?= base_url('index.php/home/listar_pedidos/' . $usuario_id) ?>">Lista de Pedidos</a>
					</li>
					<li onmouseover="mudaFoto('<?= base_url('assets/images/logout-peq.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/fotos.png') ?>')">
						<a href="<?= site_url('login/logout'); ?>">Sair</a>
					</li>
				</ul>
			</nav>
		</header>

		<section id="corpo-full">
			<article id="noticia-principal">
				<header id="cabecalho-artigo">
					<hgroup>
						<h3>Glass > Fotos</h3>
						<h1>Galeria de Imagens do Google Glass</h1>
						<h2>por Alan Silva</h2>
						<h3 class="direita">Atualizado em Junho/2024</h3>
					</hgroup>
				</header>

			<p>Veja na nossa galeria de fotos várias belas imagens que mostram algumas das principais características do Google Glass, como recursos e propriedades que estão impressionando o mundo inteiro. Basta passar o mouse sobre uma das fotos para ver uma versão ampliada e com uma breve descrição.</p>
			<ul id="album-fotos">
				<li id="foto01"><span>Agenda e lembretes</span></li>
				<li id="foto02"><span>Sergey Brin usando o Glass</span></li>
				<li id="foto03"><span>Leve e compacto</span></li>
				<li id="foto04"><span>Sensação de uma tela de 50"</span></li>
				<li id="foto05"><span>Vários tipos de lente</span></li>
				<li id="foto06"><span>Informações importantes</span></li>
			</ul>
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