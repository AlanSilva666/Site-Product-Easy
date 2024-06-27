<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Converter Arquivo</title>
    <link rel="shortcut icon" href="<?= base_url("assets/images/si_icon.png")?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/estilo.css') ?>"/>
    <link rel="stylesheet" href="<?= base_url('assets/css/form.css') ?>"/>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="<?= base_url('assets/js/funcoes.js') ?>"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
    <div id="interface">
        <header id="cabecalho">
            <hgroup>
                <h1>Google Glass</h1>
                <h2>A revolução do Google está chegando</h2>
            </hgroup>
            <img id="icone" src="<?= base_url('assets/images/contato.png') ?>"/>
            <nav id="menu">
                <h1>Menu Principal</h1>
                <ul type="disc">
                    <li onmouseover="mudaFoto('<?= base_url('assets/images/home.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/glass-oculos-preto-peq.png') ?>')">
                        <a href="<?= base_url('index.php') ?>">Home</a></li>
                    <li onmouseover="mudaFoto('<?= base_url('assets/images/especificacoes.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/glass-oculos-preto-peq.png') ?>')">
                        <a href="<?= base_url('index.php/home/specs/' . $usuario_id) ?>">Especificações</a></li>
                    <li onmouseover="mudaFoto('<?= base_url('assets/images/fotos.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/glass-oculos-preto-peq.png') ?>')">
                        <a href="<?= base_url('index.php/home/fotos/' . $usuario_id) ?>">Fotos</a></li>
                    <li onmouseover="mudaFoto('<?= base_url('assets/images/multimidia.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/glass-oculos-preto-peq.png') ?>')">
                        <a href="<?= base_url('index.php/home/multimidia/' . $usuario_id) ?>">Multimídia</a></li>
                    <li onmouseover="mudaFoto('<?= base_url('assets/images/contato.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/glass-oculos-preto-peq.png') ?>')">
                        <a href="<?= base_url('index.php/home/fale_conosco/' . $usuario_id) ?>">Faça seu pedido</a></li>
                    <li onmouseover="mudaFoto('<?= base_url('assets/images/contato.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/especificacoes.png') ?>')">
                        <a href="<?= base_url('index.php/home/listar_pedidos/' . $usuario_id) ?>">Lista de Pedidos</a></li>
                    <li onmouseover="mudaFoto('<?= base_url('assets/images/especificacoes.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/glass-oculos-preto-peq.png') ?>')">
                        <a href="<?= base_url('index.php/home/converter_arquivo/' . $usuario_id) ?>">Converter arquivo</a></li>
                    <li onmouseover="mudaFoto('<?= base_url('assets/images/logout-peq.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/glass-oculos-preto-peq.png') ?>')">
                        <a href="<?= site_url('login/logout'); ?>">Sair</a></li>
                </ul>
            </nav>
        </header>
        
        <div id="content">
            <h2>Converter Arquivo para PDF</h2>

            <?php if (isset($pdf_link)): ?>
                <p><a href="<?= $pdf_link ?>">Download do PDF</a></p>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <p style="color: red;"><?= $error ?></p>
            <?php endif; ?>

            <?= form_open_multipart('home/converter_arquivo/' . $usuario_id); ?>
                <input type="file" name="arquivo" accept=".doc,.docx" required>
                <br><br>
                <input type="submit" value="Converter Arquivo para PDF">
            <?= form_close(); ?>
        </div>
    </div>
</body>
</html>
