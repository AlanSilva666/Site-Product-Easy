<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<title>Product Easy - Especificações</title>
	<link rel="shortcut icon" href="<?= base_url("assets/images/si_icon.png")?>">
	<link rel="stylesheet" href="<?= base_url('assets/css/estilo.css') ?>"/>
	<link rel="stylesheet" href="<?= base_url('assets/css/specs.css') ?>">
	<!-- <link rel="stylesheet" href="<?= base_url('assets/css/estilo.css?v=' . time()) ?>"/> -->
</head>
<script language="javascript" src="<?= base_url('assets/js/funcoes.js') ?>"></script>
<body>
	<div id="interface">
		<br>
		<header id="cabecalho">
			<hgroup>
				<h1>Google Glass</h1>
				<h2>A revolução do Google está chegando</h2>
			</hgroup>
			<img id="icone" src="<?= base_url('assets/images/especificacoes.png') ?>"/>

			<nav id="menu">
			<h1>Menu Principal</h1>
			<ul type="disc">
				<li onmouseover="mudaFoto('<?= base_url('assets/images/home.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/especificacoes.png') ?>')"><a href="<?= base_url('index.php') ?>">Home</a></li>
				<li onmouseover="mudaFoto('<?= base_url('assets/images/especificacoes.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/especificacoes.png') ?>')"><a href="<?= base_url('index.php/home/specs/' . $usuario_id) ?>">Especificações</a></li>
				<li onmouseover="mudaFoto('<?= base_url('assets/images/fotos.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/especificacoes.png') ?>')"><a href="<?= base_url('index.php/home/fotos/' . $usuario_id) ?>">Fotos</a></li>
				<li onmouseover="mudaFoto('<?= base_url('assets/images/multimidia.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/especificacoes.png') ?>')"><a href="<?= base_url('index.php/home/multimidia/' . $usuario_id) ?>">Multimídia</a></li>
				<li onmouseover="mudaFoto('<?= base_url('assets/images/contato.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/especificacoes.png') ?>')"><a href="<?= base_url('index.php/home/fale_conosco/' . $usuario_id) ?>">Faça seu pedido</a></li>
				<li onmouseover="mudaFoto('<?= base_url('assets/images/contato.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/especificacoes.png') ?>')"><a href="<?= base_url('index.php/home/listar_pedidos/' . $usuario_id) ?>">Lista de Pedidos</a></li>
				<li onmouseover="mudaFoto('<?= base_url('assets/images/logout-peq.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/especificacoes.png') ?>')"><a href="<?= site_url('login/logout'); ?>">Sair</a></li>
			</ul>
			</nav>
		</header>

		<section id="corpo-full">
			<article id="noticia-principal">
				<header id="cabecalho-artigo">
					<hgroup>
						<h3>Glass > Especificações</h3>
						<h1>Raio-X no Google Glass</h1>
						<h2>por Alan Silva</h2>
						<h3 class="direita">Atualizado em Junho/2024</h3>
					</hgroup>
				</header>
			<p>Clique em qualquer área destacada da imagem para ter mais informações sobre os recursos do Google Glass. Qualquer ponto vermelho vai te levar a um lugar cheio de novas informações.</p>
			<section id="conteudo">
				<img src="<?= base_url('assets/images/glass-esquema-marcado.jpg') ?>" usemap="#meumapa">
				<map name="meumapa">
					<area shape="rect" coords="179,202,270,260" href="<?= base_url('index.php/home/google_glass/' . $usuario_id) ?>#tela" target="janela"/>
					<area shape="circle" coords="158,243,12" href="<?= base_url('index.php/home/google_glass/' . $usuario_id) ?>#camera" target="janela"/>
					<area shape="circle" coords="73,52,12" href="<?= base_url('index.php/home/google_glass/' . $usuario_id) ?>#gadgets" target="janela"/>
					<area shape="poly" coords="28,43,83,216,84,249,27,249" href="<?= base_url('index.php/home/google_glass/' . $usuario_id) ?>#sensores" target="janela"/>
				</map>

				<?php if (isset($usuario_id)): ?>
					<iframe src="<?= base_url('index.php/home/google_glass/' . $usuario_id) ?>" name="janela" id="frame-spec"></iframe>
				<?php else: ?>
					<p>ID do usuário não definido.</p>
				<?php endif; ?>
			</section>
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
