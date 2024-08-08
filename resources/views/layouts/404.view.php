<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programacion - 404</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>404 - Página no encontrada</h1>
        <?php if (isset($data['message'])): ?>
            <p><?= htmlspecialchars($data['message']) ?></p>
        <?php endif; ?>
        <a href="/home">Volver al inicio</a>
    </div>
</body>
</html>
