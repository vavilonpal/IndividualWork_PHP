<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Панель администратора - Пользователи</title>
    <link rel="stylesheet" type="text/css" href="/style/users.css">
</head>
<body>
<?php include '../app/views/partials/admin_nav.php'; ?>

<h1>Список пользователей</h1>


<table class="admin-table">
    <thead>
    <tr>
        <th>ID</th>
        <th>Имя пользователя</th>
        <th>Email</th>
        <th>Роль</th>
        <th>Дата регистрации</th>
        <th>Действия</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user->getId()) ?></td>
            <td><?= htmlspecialchars($user->getUsername()) ?></td>
            <td><?= htmlspecialchars($user->getEmail()) ?></td>
            <td><?= htmlspecialchars($user->getRole()) ?></td>
            <td><?= $user->getCreatedAt()?->format('Y-m-d H:i') ?? '—' ?></td>
            <td>
                <a href="/admin/users/edit/<?= $user->getId() ?>" class="btn btn-edit">Изменить</a>
                <form action="/admin/users/delete" method="post" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $user->getId() ?>">
                    <button type="submit" class="btn btn-delete"
                            onclick="return confirm('Удалить пользователя?')">Удалить
                    </button>
                </form>
                <a href="/admin/users/articles/<?= $user->getId() ?>" class="btn btn-articles">Статьи</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>

