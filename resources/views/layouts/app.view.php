<?php
extract($data);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo isset($title) ? "Programacion - " . ucfirst(htmlspecialchars($title)) : "Programacion"; ?>
    </title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="app-container">
        <div class="navbar">
            <span>Bienvenido, <?= htmlspecialchars($_SESSION['user']['name']) ?></span>
            <a href="/profile?email=<?= htmlspecialchars($_SESSION['user']['email']) ?>"">Editar Perfil</a>
            <form action="/logout" method="POST" style="display:inline;">
                <button class="logout-button" type="submit">Cerrar Sesión</button>
            </form>
        </div>
        <div class="container">
            <?php include $view; ?>
        </div>
    </div>
</body>
</html>
