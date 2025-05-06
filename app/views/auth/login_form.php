<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <style>
        body { font-family: sans-serif; margin: 50px; }
        form { max-width: 300px; margin: auto; }
        label, input { display: block; width: 100%; margin-bottom: 10px; }
        input[type="submit"] { width: auto; }
        .error { color: red; }
    </style>
</head>
<body>
<h2>Вход в систему</h2>
<?php if (!empty($error)): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>
<form method="post" action="/login">
    <label for="username">Имя пользователя или email:</label>
    <input type="text" name="username" id="username" required>

    <label for="password">Пароль:</label>
    <input type="password" name="password" id="password" required>

    <input type="submit" value="Войти">
</form>
</body>
</html>

