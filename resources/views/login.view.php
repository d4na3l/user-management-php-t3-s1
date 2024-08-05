<div class="login-form">
    <h2>Iniciar Sesión</h2>
    <?php if (!empty($error)): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST" action="/login">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Iniciar Sesión</button>
    </form>
    <div class="links">
        <a href="/register">Registrarse</a>
        <a href="/forgot-password">Olvidé mi contraseña</a>
    </div>
</div>
