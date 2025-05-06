<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($article->getTitle()) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f4f4f4;
        }
        .article-container {
            max-width: 800px;
            background: #fff;
            padding: 24px;
            margin: 0 auto;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.1);
        }
        .article-title {
            font-size: 2em;
            margin-bottom: 12px;
        }
        .article-meta {
            color: #888;
            margin-bottom: 20px;
        }
        .article-content {
            line-height: 1.6;
        }
        .article-actions {
            margin-top: 30px;
        }
        .article-actions a,
        .article-actions form button {
            padding: 8px 16px;
            margin-right: 10px;
            border: none;
            background: #007BFF;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
        }
        .article-actions form {
            display: inline;
        }
        .article-actions form button.delete {
            background: #dc3545;
        }
    </style>
</head>
<body>
<?php include '../app/views/partials/nav.php'; ?>
<br>

<div class="article-container">
    <h1 class="article-title"><?= htmlspecialchars($article->getTitle()) ?></h1>
    <div class="article-meta">
        Автор: <?= htmlspecialchars($article->getAuthor()->getUsername()) ?> |
        Дата: <?= $article->getCreatedAt()->format('Y-m-d H:i') ?>
    </div>
    <div class="article-content">
        <?= nl2br(htmlspecialchars($article->getContent())) ?>
    </div>
</div>

</body>
</html
