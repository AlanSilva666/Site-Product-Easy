<!-- application/views/errors/upload_error.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Error</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }
        .error-box {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
        }
        h2 {
            color: #d9534f;
        }
        p {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="error-box">
        <h2>Erro de Upload</h2>
        <?php echo $error; ?>
        <p>Por favor, <a href="<?php echo base_url('home/converter_arquivo'); ?>">tente novamente</a>.</p>
    </div>
</body>
</html>
