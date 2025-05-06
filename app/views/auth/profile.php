<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Профиль пользователя</title>
    <link rel="stylesheet" href="/style/profile.css">

</head>
<body>
<?php require_once '../app/views/partials/nav.php'; ?>
<br>
<br>
<div class="profile-container">
    <?php if ($user): ?>
        <h1>Профиль пользователя</h1>
        <p><strong>Имя:</strong> <?= htmlspecialchars($user->getUsername()) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user->getEmail()) ?></p>
        <p><strong>Роль:</strong> <?= htmlspecialchars($user->getRole()) ?></p>
        <p><strong>Дата регистрации:</strong> <?= $user->getCreatedAt()->format('Y-m-d H:i') ?>
        </p><!-- Button to retrieve articles -->

        <h2>Статьи пользователя</h2>

        <?php
        $articles = $user->getArticles();
        if (!empty($articles)):
            ?>
            <div class="user-article-list">
                <?php foreach ($articles as $article): ?>
                    <div class="user-article-card">
                        <a href="/profile/articles/<?= $article->getId() ?>" class="user-article-title">
                            <?= htmlspecialchars($article->getTitle()) ?>
                        </a>
                        <div class="user-article-meta">
                            <small>Дата публикации: <?= $article->getCreatedAt()->format('Y-m-d H:i') ?></small>
                        </div>
                        <div class="user-article-actions">
                            <a href="/article/edit/<?= $article->getId() ?>" class="btn-edit">Редактировать</a>

                            <form action="/article/delete/<?= $article->getId() ?>" method="POST" class="delete-form" onsubmit="return confirm('Вы уверены, что хотите удалить статью?');">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn-delete">Удалить</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>У пользователя пока нет статей.</p>
        <?php endif; ?>


    <?php else: ?>
        <p>Пользователь не найден или не авторизован.</p>
    <?php endif; ?>
</div>
</body>
</html>





