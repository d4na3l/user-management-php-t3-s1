<div class="container">
    <form id="forgotPasswordForm" action="/forgot-password" method="POST">
        <input type="hidden" name="_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
        <input type="email" name="email" placeholder="Ingresa tu correo electrónico" required>
        <button type="submit">Enviar enlace de restablecimiento</button>
        <?php if (isset($data['error'])): ?>
            <p><?php echo htmlspecialchars($data['error']); ?></p>
        <?php endif; ?>
    </form>
</div>
