<div class="container">
    <h2>Registrarse</h2>
    <?php if (!empty($error)): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST" action="/register">
        <input type="text" name="name" placeholder="Nombre" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <input type="password" name="confirm_password" placeholder="Confirmar Contraseña" required>
        <button type="submit">Registrarse</button>
    </form>
    <div class="links">
        <a href="/login">Ya tengo una cuenta</a>
    </div>
</div>
