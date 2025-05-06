<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактировать пользователя</title>
    <link rel="stylesheet" href="/style/edit-user.css">
</head>
<body>

<?php include '../app/views/partials/admin_nav.php'; ?>

<div class="admin-form-container">
    <h2>Редактировать пользователя</h2>

    <?php if (!empty($errors)): ?>
        <div class="form-errors">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="/admin/users/edit/<?= $user->getId() ?>" method="POST">
        <input type="hidden" name="_method" value="POST">

        <label for="username">Имя пользователя:</label>
        <input type="text" id="username" name="username" value="<?= htmlspecialchars($user->getUsername()) ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user->getEmail()) ?>" required>

        <label for="role">Роль:</label>
        <select name="role" id="role" required>
            <option value="user" <?= $user->getRole() === 'user' ? 'selected' : '' ?>>Пользователь</option>
            <option value="admin" <?= $user->getRole() === 'admin' ? 'selected' : '' ?>>Администратор</option>
        </select>

        <button type="submit" class="btn-save">Сохранить изменения</button>
    </form>
</div>

</body>
</html>
