<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /seu_projeto_codeigniter/

    # Remove index.php da URL
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php/$1 [L]

    # Configuração de tipos MIME para arquivos .doc e .docx
    <IfModule mod_mime.c>
        AddType application/vnd.openxmlformats-officedocument.wordprocessingml.document .docx
        AddType application/msword .doc
    </IfModule>
</IfModule>
