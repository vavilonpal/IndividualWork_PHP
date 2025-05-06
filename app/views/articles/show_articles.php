<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Список статей</title>
    <link rel="stylesheet" type="text/css" href="/style/articles.css">

</head>
<body>
<?php include '../app/views/partials/nav.php'; ?>
<h1>Статьи</h1>

<?php if (empty($articles)): ?>
    <p>Статей пока нет.</p>
<?php else: ?>
    <?php foreach ($articles as $article): ?>
        <div class="article">
            <h2><?= htmlspecialchars($article->getTitle()) ?></h2>
            <div class="meta">
                Автор: <?= htmlspecialchars($article->getAuthor()->getUsername()) ?> |
                Категория: <?= htmlspecialchars($article->getCategory() ?? 'Без категории') ?> |
                Дата: <?= $article->getCreatedAt()->format('d.m.Y H:i') ?>
            </div>
            <div class="content">
                <?= nl2br(htmlspecialchars($article->getContent())) ?>
            </div>
            <?php if ($article->getTags()): ?>
                <div class="meta">Теги: <?= htmlspecialchars($article->getTags()) ?></div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>
