<div class="container">
    <h2><?= htmlspecialchars($title) ?></h2>
    <ul>
        <?php foreach ($users as $user): ?>
            <li>
                <a href="/profile?email=<?= htmlspecialchars($user['email']) ?>">
                    <?= htmlspecialchars($user['name']) ?> (<?= htmlspecialchars($user['email']) ?>)
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
