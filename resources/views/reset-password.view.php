<div class="container">
    <form id="resetPasswordForm" action="/reset-password" method="POST">
        <input type="hidden" name="_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
        <label for="password">Nueva Contraseña:</label>
        <input type="password" name="password" required>
        <label for="confirm_password">Confirmar Contraseña:</label>
        <input type="password" name="confirm_password" required>
        <button type="submit">Restablecer Contraseña</button>
        <?php if (isset($data['error'])): ?>
            <p><?php echo htmlspecialchars($data['error']); ?></p>
        <?php endif; ?>
    </form>
</div>
