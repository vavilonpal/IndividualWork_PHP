<link rel="stylesheet" href="/style/create-article.css">


<div>
    <?php include '../app/views/partials/nav.php'; ?>
</div>

<div class="form-container">
    <?php if (isset($errors) && !empty($errors)): ?>
        <div class="form-errors">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="/article/create" method="POST" class="article-form">
        <h2>Создать статью</h2>

        <label for="title">Заголовок:</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>">

        <label for="content">Содержание:</label>
        <textarea id="content" name="content" rows="6"><?= htmlspecialchars($_POST['content'] ?? '') ?></textarea>

        <label for="category">Категория:</label>
        <input type="text" id="category" name="category" value="<?= htmlspecialchars($_POST['category'] ?? '') ?>">

        <label for="tags">Теги:</label>
        <input type="text" id="tags" name="tags" value="<?= htmlspecialchars($_POST['tags'] ?? '') ?>">

        <button type="submit">Создать</button>
    </form>
</div>
