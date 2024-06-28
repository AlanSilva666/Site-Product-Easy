Site feito com Framework Codelgnither(version 3.1.13) + PHP(version 8.2.12).
Linguagens: PHP, HTML, CSS3 e JavaScript.
Banco de dados: MySql.
Padrão MVC.

Configurações referentes à banco de dados, estão localizadas no diretório application/config.
Utilizei o XAMPP para configurar o ambiente necessário para rodar o Projeto em uma máquina local.
Com o XAMPP instalado e configurado, basta criar o Projeto no diretório xampp/htdocs, abrir o xampp-control e Startar o Apache e o MySQL.
Geralmente a url necessária para visualização em navegador é: http://localhost/seu_projeto/index.php/diretorio/index.
Está url também já é padrão Codelgnither, que é o Framework que utilizei para o Desenvolvimento deste Projeto.
Mas o Projeto pode ser configurado em outros pacotes, além do xampp.

O site contém incialmente uma Tela Login. 
Nela pede um CPF e uma Senha para entrar, também tem a opção de CRIAR CONTA / ESQUECEU A SENHA.
Só será possível, acessar a página home do Site, passando pela Tela Login inicial.
Há envio de emails configurados, tanto para Cadastro de Conta, quanto o esquecimento da senha.
Ou seja, no momento que for realizar o cadastro, terá que preencher algumas informações, uma delas é o email.
Assim que preencher todas as informações, e realizar o cadastro, será enviado um email de boas vindas ao Site.
Este email é enviado para o email preenchido no formulário em questão.
O mesmo se repete para Esqueceu Senha, caso o usuário esqueça a senha, é possível altera-lá.
Alterando, será enviado um email para o email preenchido no formulário de Cadastro.

Com um Login(CPF) e Senha criados.
Basta acessar o site.

Construi o site com base no Curso de HTML+CSS+JavaScript que realizei na Plataforma Curso em Vídeo.
E também com base e Experência que tive na área de Desenvolvimento Full Stack.
Então o conteúdo(escritas) do site é o mesmo que aprendi no Curso citado, porém coloquei minhas ideias e estilo.
Se trata da divulgação do produto Óculos Google Glass.

Analisando o contéudo sobre o produto, o usuário tem a opção de fazer uma compra do produto pela guia Faça Seu Pedido.
Nela consta um formulário de compra, onde o usuário terá que preencher informações referentes, uma delas é o email.
A compra sendo realizada, é enviado um email para o email que foi preenchido no formulário em questão.
Atulamente, não realizei a funcionalidade de gerar boletos.
Então, consta apenas um email informando os detalhes da compra e o valor à pagar.

Assim que que a compra é realizada e o email é enviado, o usuário é redirecionado para a página Listar Pedidos.
No qual é página onde ficará listada os pedidos realizados.

Nela o usuário tem a opção de Editar o Pedido, ou até mesmo Deletar o Pedido.
Qualquer uma destas ações, será enviado um email, informando a ação.

Utilizei também funcionalidades de API, para buscar CEP.
Você pode encontrar está funcionalidade, no momento de fazer um pedido.

Por fim, o projeto é voltado a um Site de Compras.
Aonde se pode analisar um produto e realizar a compra do mesmo, tudo que envolve INSERT, UPDATE e DELETE é enviado para o Banco de Dados Mysql, com toda segurança necessária.
E também qualquer uma dessas três ações realizadas no geral dentro do projeto, é enviado uma email, que sempre será preenchido em formulários referentes.
E uma observação importante, é que no momento que se cria um usuário para acessar o site, é necessário criar uma senha, a mesma é criptografada, quando se conclui o cadastro.
Outro ponto é importante, é que pode ser realizadas inúmeras ações de compra dentro do site.
Porém, ficará vinculada somente ao usuário logado em questão.

A identificação do usuário é mostrada por um id, na url em questão.
Exemplo: http://localhost/seu_projeto/index.php/home/index/1
O mesmo se repete quando um pedido é realizado. Um novo id é criado, referente ao pedido, e consequentemente é adicionado também a url, quando a mesma é acessada.
Exemplo: http://localhost/seu_projeto/index.php/home/editar_pedido/1/62

