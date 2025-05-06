<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="/style/register.css">
</head>
<body>

<form action="/register" method="POST" onsubmit="return validateForm();">
    <label>Имя пользователя:</label><br>
    <input type="text" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required><br>
    <?php if (!empty($errors['username'])): ?>
        <br>
        <div class="error"><?= $errors['username'] ?></div>
    <?php endif; ?>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required><br>
    <?php if (!empty($errors['email'])): ?>
        <br>
        <div class="error"><?= $errors['email'] ?></div>
    <?php endif; ?>

    <label>Пароль:</label><br>
    <input type="password" name="password" required><br>
    <?php if (!empty($errors['password'])): ?>
        <br>
        <div class="error"><?= $errors['password'] ?></div>
    <?php endif; ?>

    <label>Подтвердите пароль:</label><br>
    <input type="password" name="confirm_password" required><br>
    <?php if (!empty($errors['confirm_password'])): ?>
        <div class="error"><?= $errors['confirm_password'] ?></div>
    <?php endif; ?>

    <br><button type="submit">Зарегистрироваться</button>
</form>

<script>
    function validateForm() {
        const pass = document.querySelector('input[name="password"]').value;
        const confirm = document.querySelector('input[name="confirm_password"]').value;
        if (pass !== confirm) {
            alert('Пароли не совпадают');
            return false;
        }
        return true;
    }
</script>
</body>
</html>

