<div class="container">
    <h2><?= htmlspecialchars($title) ?></h2>

    <!-- Update Name -->
    <form action="/profile/updateName" method="POST">
        <input type="hidden" name="email" value="<?= htmlspecialchars($profileUser['email']) ?>">
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($profileUser['name']) ?>">
        </div>
        <button type="submit">Update Name</button>
    </form>

    <?php if ($_SESSION['user']['email'] === $profileUser['email']): ?>

    <!-- Update Email -->
    <form action="/profile/updateEmail" method="POST">
        <input type="hidden" name="email" value="<?= htmlspecialchars($profileUser['email']) ?>">
        <div>
            <label for="new_email">New Email:</label>
            <input type="email" id="new_email" name="email" value="<?= htmlspecialchars($profileUser['email']) ?>">
        </div>
        <button type="submit">Update Email</button>
    </form>

    <!-- Update Password -->
    <form action="/profile/updatePassword" method="POST">
        <input type="hidden" name="email" value="<?= htmlspecialchars($profileUser['email']) ?>">
        <div>
            <label for="password">New Password:</label>
            <input type="password" id="password" name="password">
        </div>
        <div>
            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" id="confirm_password" name="confirm_password">
        </div>
        <button type="submit">Update Password</button>
    </form>

    <!-- Delete User -->
    <form action="/profile/delete" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($profileUser['id']) ?>">
        <button type="submit" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
    </form>
    <?php endif; ?>

    <div class="links">
        <a href="/home">Back to Home</a>
    </div>
</div>
