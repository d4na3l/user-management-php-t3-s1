<!-- resources/views/layouts/guest.view.php -->
<?php
// Extraer variables de $data para que estén disponibles directamente
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
    <!-- Aquí puedes incluir CSS, meta etiquetas, etc. -->
</head>
<body>
    <!-- Aquí se incluirá la vista específica -->
    <?php require $view;
    ?>

</body>
</html>
