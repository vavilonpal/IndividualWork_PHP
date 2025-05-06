<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактировать статью</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 40px;
        }
        .form-container {
            max-width: 700px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }
        button {
            padding: 10px 20px;
            background: #007BFF;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Редактировать статью</h2>
    <form action="/article/edit/<?= $article->getId() ?>" method="post">
        <input type="hidden" name="id" value="<?= $article->getId() ?>">

        <label for="title">Заголовок</label>
        <input type="text" id="title" name="title" required value="<?= htmlspecialchars($article->getTitle()) ?>">

        <label for="content">Содержимое</label>
        <textarea id="content" name="content" rows="10" required><?= htmlspecialchars($article->getContent()) ?></textarea>

<label for="category">Категория</label>
<input type="text" id="category" name="category" value="<?= htmlspecialchars($article->getCategory()) ?>">

<label for="tags">Теги (через запятую)</label>
<input type="text" id="tags" name="tags" value="<?= htmlspecialchars($article->getTags()) ?>">

<button type="submit">Сохранить изменения</button>
</form>
</div>

</body>
</html>