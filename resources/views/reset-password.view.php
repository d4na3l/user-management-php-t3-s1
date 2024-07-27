<!-- resources/views/reset-password.view.php -->

<form action="/reset-password" method="POST">
    <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token'] ?? ''); ?>">
    <input type="password" name="password" placeholder="Nueva contraseña" required>
    <input type="password" name="confirm_password" placeholder="Confirmar nueva contraseña" required>
    <button type="submit">Restablecer contraseña</button>
    <?php if (isset($data['error'])): ?>
        <p><?php echo htmlspecialchars($data['error']); ?></p>
    <?php endif; ?>

</form>
