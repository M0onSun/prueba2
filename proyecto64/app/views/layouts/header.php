<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Usuarios</title>
    <link href="/proyecto64/public/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/proyecto64/public/assets/css/styles.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 shadow-lg">
        <div class="container">
            <a class="navbar-brand" href="">Sistema Usuarios</a>
            <?php if(isset($_SESSION['user'])): ?>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    Bienvenido: <?= $_SESSION['user']['nombre'] ?> (<?= $_SESSION['user']['rol'] ?>)
                </span>
                <a href="/proyecto64/public/auth/logout" class="btn btn-outline-light">Salir</a>
            </div>
            <?php endif; ?>
        </div>
    </nav>
    <div class="container">