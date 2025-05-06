
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Создать пользователя</title>
    <link rel="stylesheet" href="/style/user-create.css">
</head>
<body>
<?php include '../app/views/partials/admin_nav.php'; ?>

<div class="form-container">
    <h2>Создание пользователя</h2>

    <?php if (!empty($errors)): ?>
        <div class="form-errors">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="/admin/create-user" method="POST">
        <label for="username">Имя пользователя</label>
        <input type="text" name="username" id="username" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Пароль</label>
        <input type="password" name="password" id="password" required>

        <label for="role">Роль</label>
        <select name="role" id="role" required>
            <option value="user">Пользователь</option>
            <option value="admin">Администратор</option>
        </select>

        <button type="submit">Создать</button>
    </form>
</div>

</body>
</html>
