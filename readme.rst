Projeto de Site utilizando CodeIgniter (v3.1.13) e PHP (v8.2.12)
Linguagens de Programação: PHP, HTML, CSS3, JavaScript.
Banco de Dados: MySQL.
Padrão: MVC (Model-View-Controller).

O projeto foi desenvolvido utilizando o XAMPP para criar o ambiente local necessário. 
As configurações de banco de dados estão localizadas no diretório application/config.

Instale e configure o XAMPP.
Crie o projeto no diretório xampp/htdocs.
Abra o XAMPP Control Panel e inicie o Apache e o MySQL.
Acesse o projeto pelo navegador com a URL padrão do CodeIgniter: http://localhost/seu_projeto/index.php/diretorio/index.
O projeto pode ser configurado em outros pacotes além do XAMPP.

A tela inicial exige CPF e senha para acesso.
Opções de "Criar Conta" e "Esqueceu a Senha" estão disponíveis.
O acesso à página principal só é permitido após a autenticação.


Envio de emails configurado para cadastro e recuperação de senha.
No cadastro, o usuário preenche um formulário, incluindo o email.
Um email de boas-vindas é enviado após o cadastro.
Para recuperação de senha, um email é enviado para redefinição.
Após a atualização da senha, um email é enviado confirmando a atualização.

O site divulga o produto Óculos Google Glass.
Opção de compra disponível na guia "Faça Seu Pedido".
Após preencher o formulário de compra, um email de confirmação é enviado.
Redirecionamento para a página "Listar Pedidos" após a compra.

O usuário pode editar ou deletar pedidos.
Ações de edição ou deleção de pedidos também enviam notificações por email.
Funcionalidade de API:
Busca de CEP configurada no momento da realização do pedido.

Senhas de usuários são criptografadas ao serem criadas.

Todas as operações de INSERT, UPDATE e DELETE são realizadas com segurança no banco de dados MySQL.
Emails são enviados para cada ação relevante no site.

A identificação do usuário é mostrada na URL, ex: http://localhost/seu_projeto/index.php/home/index/1.
Pedidos realizados também recebem um ID na URL, ex: http://localhost/seu_projeto/index.php/home/editar_pedido/1/62.

Este projeto foi baseado no curso de HTML, CSS e JavaScript realizado na plataforma Curso em Vídeo, complementado com minha experiência prática em Desenvolvimento Full Stack. O conteúdo e o design do site refletem o que aprendi, juntamente com minhas ideias e estilo pessoal.


