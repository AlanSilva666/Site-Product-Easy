<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Product Easy - Pedidos</title>
    <link rel="shortcut icon" href="<?= base_url("assets/images/si_icon.png")?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/estilo.css') ?>"/>
    <!-- <link rel="stylesheet" href="<?= base_url('assets/css/specs.css') ?>"/> -->
    <link rel="stylesheet" href="<?= base_url('assets/css/estilo.css?v=' . time()) ?>"/>
    <style>
        table#datatable {
            background-color: #FFFFFF;
            text-align: center;
            font-size: 12pt;
            font-family: Arial, Helvetica, sans-serif;
            width: 100%;
            border-collapse: collapse;
        }
        .form-container {
            display: flex;
            align-items: center;
            gap: 10px; /* Espaço entre os botões */
        }
        .gerar_excel {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        .gerar_excel:hover {
            background-color: #45a049;
        }
        /* button.gerar_excel {
            background-color: #00FF7F;
            color: black;
            text-align: center;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12pt;
        } */
        th.edit, td.td {
            text-align: center;
            color: black;
            border: 1px solid #ddd;
            padding: 8px;
        }
        a.button {
            display: block;
            text-align: center;
        }
        a.pagina_atual {
            background-color: whitesmoke;
            color: black;
            padding: 1%;
            text-decoration: none;
        }
        a.primeira, a.segunda, a.antes, a.depois {
            font-family: Arial, Helvetica, sans-serif;
            color: black;
            font-weight: bold;
            background-color: #00FF7F;
            text-decoration: underline;
            padding: 0.5%;
        }
        img.icone-editar, img.icon_delete {
            width: 25px;
            vertical-align: middle;
        }
        a.button-delete {
            background-color: #FFFFFF;
            color: darkred;
            font-size: 12pt;
            font-family: Arial, Helvetica, sans-serif;
        }
        p.sucesso {
            text-align: center;
            font-family: Arial;
            font-size: 16pt;
            font-weight: 700;
            background: #00FF7F;
            border: 2px solid black;
            padding: 10px;
        }
        p.erro {
            text-align: center;
            font-family: Arial;
            font-size: 16pt;
            font-weight: 700;
            background: #FF0000;
            border: 2px solid black;
            padding: 10px;
        }
        form {
            margin-top: 20px;
        }
        label {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12pt;
            font-weight: bold;
        }
        select, button[type="submit"] {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12pt;
            padding: 8px;
        }
        
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .form-container {
            margin: 20px 0;
        }

        .form-container form {
            display: flex;
            align-items: center;
        }

        .form-container label {
            margin-right: 10px;
            font-weight: bold;
        }

        .form-container select,
        .form-container button {
            padding: 5px 10px;
            margin-right: 10px;
            border: 1px solid #28a745;
            border-radius: 5px;
        }

        .form-container select {
            background-color: #f8f9fa;
        }

        .form-container button {
            background-color: #28a745;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-container button:hover {
            background-color: #218838;
        }

        .pedido {
            border: 1px solid #28a745;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #e9f5ee;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a,
        .pagination strong {
            border: 1px solid #28a745;
            padding: 5px 10px;
            margin: 0 5px;
            border-radius: 5px;
            text-decoration: none;
            color: #28a745;
            transition: background-color 0.3s;
        }

        .pagination a:hover {
            background-color: #28a745;
            color: white;
        }

        .pagination strong {
            background-color: #28a745;
            color: white;
        }
        .result-count {
            text-align: center;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12pt;
            margin-bottom: 20px;
        }
        
    </style>
    <script language="javascript" src="<?= base_url('assets/js/funcoes.js') ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var sucesso = document.querySelector('.sucesso');
            if (sucesso) {
                sucesso.style.display = 'block'; // Mostra a mensagem
                setTimeout(function() {
                    sucesso.style.display = 'none'; // Esconde a mensagem após 10 segundos
                }, 10000); // 10 segundos
            }
        });
    </script>
</head>
<body>
    <div id="interface">
        <header id="cabecalho">
            <hgroup>
            <br>
                <h1>Google Glass</h1>
                <h2>A revolução do Google está chegando</h2>
            </hgroup>
            <img id="icone" src="<?= base_url('assets/images/especificacoes.png') ?>"/>
            <nav id="menu">
                <h1>Menu Principal</h1>
                <ul>
                    <li onmouseover="mudaFoto('<?= base_url('assets/images/home.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/especificacoes.png') ?>')">
                        <a href="<?= base_url('index.php') ?>">Home</a></li>
                    <li onmouseover="mudaFoto('<?= base_url('assets/images/especificacoes.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/especificacoes.png') ?>')">
                        <a href="<?= base_url('index.php/home/specs/' . $usuario_id) ?>">Especificações</a></li>
                    <li onmouseover="mudaFoto('<?= base_url('assets/images/fotos.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/especificacoes.png') ?>')">
                        <a href="<?= base_url('index.php/home/fotos/' . $usuario_id) ?>">Fotos</a></li>
                    <li onmouseover="mudaFoto('<?= base_url('assets/images/multimidia.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/especificacoes.png') ?>')">
                        <a href="<?= base_url('index.php/home/multimidia/' . $usuario_id) ?>">Multimídia</a></li>
                    <li onmouseover="mudaFoto('<?= base_url('assets/images/contato.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/especificacoes.png') ?>')">
                        <a href="<?= base_url('index.php/home/fale_conosco/' . $usuario_id) ?>">Faça seu pedido</a></li>
                    <li onmouseover="mudaFoto('<?= base_url('assets/images/contato.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/especificacoes.png') ?>')">
                        <a href="<?= base_url('index.php/home/listar_pedidos/' . $usuario_id) ?>">Lista de Pedidos</a></li>
                    <li onmouseover="mudaFoto('<?= base_url('assets/images/logout-peq.png') ?>')" onmouseout="mudaFoto('<?= base_url('assets/images/especificacoes.png') ?>')">
                        <a href="<?= site_url('login/logout'); ?>">Sair</a></li>
                </ul>
            </nav>
        </header>
        <section id="corpo-full">
            <article id="noticia-principal">
                <header id="cabecalho-artigo">
                    <hgroup>
                        <h3 style="font-size: 12pt;">Glass > LISTA DE PEDIDOS</h3>
                        <h1>Raio-X no Google Glass</h1>
                        <h2>por Alan Silva</h2>
                        <h3 class="direita">Atualizado em Junho/2024</h3>
                    </hgroup>

                    <?php if($this->session->flashdata('pedido_realizado')): ?>
                        <div class="notification is-success">
                            <p class="sucesso">SUCESSO: PEDIDO REALIZADO!</p>
                        </div>
                    <?php endif; ?>

                    <?php if($this->session->flashdata('dados_atualizados')): ?>
                        <div class="notification is-success">
                            <p class="sucesso">SUCESSO: PEDIDO ATUALIZADO!</p>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($this->session->flashdata('pedido_nao_realizado')): ?>
                        <div class="notification is-danger">
                            <p class="erro">ERRO: Não foi possível completar o pedido. <br> Tente Novamente!</p>
                        </div>
                    <?php endif; ?>

                    <!-- Exibição da mensagem de sucesso -->
                    <?php if($this->session->flashdata('success_message')): ?>
                        <div class="notification is-success">
                            <p class="sucesso"><?php echo $this->session->flashdata('success_message'); ?></p>
                        </div>
                    <?php endif; ?>

                    <!-- Exibição da mensagem de erro -->
                    <?php if($this->session->flashdata('error_message')): ?>
                        <div class="notification is-danger">
                            <p class="erro"><?php echo $this->session->flashdata('error_message'); ?></p>
                        </div>
                    <?php endif; ?>

                </header>
                <h1 style="text-align: center; color: black; font-family: Arial, Helvetica, sans-serif; text-decoration: underline; font-size: 18pt; font-weight: bold;">
                    LISTA DE PEDIDOS
                </h1><br/>

                <?php if (empty($pedidos)): ?>
                        <div class="form-container">  
                        </div>                                   
                <?php else: ?>
                    <div class="form-container">
                        <form action="<?= base_url('index.php/home/exportar_pedidos_all/excel/' . $usuario_id) ?>" method="get">
                            <button class="gerar_excel" type="submit">EXPORTAR TODOS OS PEDIDOS EM EXCEL</button>
                        </form>
                        <form action="<?= base_url('index.php/home/exportar_pedidos/excel/' . $usuario_id) ?>" method="get">
                            <input type="hidden" name="per_page" value="<?= $this->input->get('per_page') ? $this->input->get('per_page') : 5 ?>">
                            <input type="hidden" name="page" value="<?= $this->uri->segment(4) ? $this->uri->segment(4) : 0 ?>">
                            <button class="gerar_excel" type="submit">EXPORTAR POR FILTRO EM EXCEL</button>
                        </form>
                    </div>
                <?php endif; ?>

                <?php if (empty($pedidos)): ?>
                        <div class="form-container">  
                        </div>                                   
                <?php else: ?>
                    <div class="form-container">
                    <!-- Seleção de quantidade de dados -->
                        <form action="<?= base_url('index.php/home/listar_pedidos/' . $usuario_id) ?>" method="get">
                            <label for="per_page">MOSTRAR POR PÁGINA:</label>
                            <select name="per_page" id="per_page">
                                <option value="5" <?= $this->input->get('per_page') == 5 ? 'selected' : '' ?>>5</option>
                                <option value="10" <?= $this->input->get('per_page') == 10 ? 'selected' : '' ?>>10</option>
                                <option value="15" <?= $this->input->get('per_page') == 15 ? 'selected' : '' ?>>15</option>
                            </select>
                            <button type="submit">FILTRAR</button>
                        </form>
                    </div>
                <?php endif; ?>
            
                 <!-- Contador de resultados -->
                 <p class="result-count">
                    <?= $result_count ?>
                </p>

                <table id="datatable">
                    <thead>
                        <tr>
                            <th class="edit">NÚEMRO DO PEDIDO</th>
                            <th class="edit">NOME</th>
                            <th class="edit">EMAIL</th>
                            <th class="edit">STATUS DO PEDIDO</th>
                            <th class="edit">EDITAR PEDIDO</th>
                            <th class="edit">CANCELAR PEDIDO</th>
                        </tr>
                    </thead>
                    <br>
                    <tbody>
                    <tr>
                        <?php if (empty($pedidos)): ?>
                            <td style="color:red" colspan="6">NENHUM PEDIDO ENCONTRADO</td>
                        <?php else: ?>
                            <?php foreach ($pedidos as $pedido): ?>
                                <tr>
                                    <td class="td"><?= $pedido->contato_id ?></td>
                                    <td class="td"><?= $pedido->nome ?></td>
                                    <td class="td"><?= $pedido->email ?></td>
                                    <td class="td"><?= $pedido->flag_status == "TRUE" ? "EM ANDAMENTO" : "FINALIZADO" ?></td>
                                    <td class="td">
                                        <a href="<?= base_url('index.php/home/edit_request/' . $usuario_id . '/' . $pedido->contato_id) ?>">
                                            <img class="icone-editar" title="EDITAR PEDIDO" src="<?= base_url('assets/images/edicao.png') ?>" alt="Editar">
                                        </a>
                                    </td>
                                    <td class="td">
                                        <a href="<?= base_url('index.php/home/cancel_request/' . $usuario_id . '/' . $pedido->contato_id) ?>">
                                            <img class="icone-editar" title="CANCELAR PEDIDO" src="<?= base_url('assets/images/remocao.png') ?>" alt="Editar">
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tr>
                    </tbody>
                </table>
            
            <div class="pagination">
                <?php echo $this->pagination->create_links(); ?>
            </div>
        </article> 
        </section>
        <br/>
        <footer id="rodape">
            <p>Copyright 2024 - by Product Easy 
            <br></br>
            <a style="color: #120A8F" href= https://www.linkedin.com/in/alan-martins-b83639316/ target="_blank">LINKEDIN | 
            <a style="color: #000080" href= https://www.facebook.com/alan.martins.50746/ target="_blank">FACEBOOK | 
            <a style="color: #DD2A7B" href= https://www.instagram.com/alan_martins0/ target="_blank">INSTAGRAM 
            </p>
        </footer>
    </body>
</html>