<div class="container">
    <h2>Register</h2>
    <form id="registerForm" action="/register" method="POST">
        <input type="hidden" name="_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        <button type="submit">Register</button>
        <?php if (isset($data['error']) && !empty($data['error'])): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($data['error']); ?>
            </div>
        <?php endif; ?>
    </form>
</div>
