<?php
extract($data);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo isset($data['name']) ? "Programacion - " . ucfirst(htmlspecialchars($data['name'])) : "Programacion"; ?>
    </title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="guest-container">
        <?php include $view; ?>
    </div>
</body>
</html>

