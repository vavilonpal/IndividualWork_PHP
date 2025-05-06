
<nav style="
    background: #333;
    color: #fff;
    padding: 10px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
">
    <div>
        <a href="/" style="color: #fff; text-decoration: none; margin-right: 15px;">Главная</a>
        <a href="/articles" style="color: #fff; text-decoration: none; margin-right: 15px;">Статьи</a>
        <a href="/article" style="color: #fff; text-decoration: none; margin-right: 15px;">Создать статью</a>
        <?php  if($_SESSION['role'] == "admin"): ?>
             <a href="/admin/dashboard" style="color: #fff; text-decoration: none; margin-right: 15px;">Админ панель</a>
        <?php endif; ?>
    </div>
    <div>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/profile" style="color: #fff; text-decoration: none; margin-right: 15px;">Профиль</a>
        <?php else: ?>
            <a href="/login" style="color: #fff; text-decoration: none; margin-right: 15px;">Вход</a>
            <a href="/register" style="color: #fff; text-decoration: none;">Регистрация</a>
        <?php endif; ?>
    </div>
</nav>

