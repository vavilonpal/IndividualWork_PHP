<?php

session_start();
require_once __DIR__ . "/../app/src/request/UserRequest.php";
require_once "../app/src/service/UserService.php";
require_once "../app/src/service/AdminService.php";
require_once "../app/src/service/UserValidationService.php";
require_once "../app/src/entity/Auth.php";
require_once "../app/src/entity/Article.php";
require_once '../app/src/Router.php';
require_once "../app/src/service/ArticleService.php";

use Core\entity\Auth;
use Core\Router;
use src\entity\Article;
use src\entity\User;
use src\service\AdminService;
use src\service\ArticleService;
use src\service\UserService;
use src\service\UserValidationService;

$adminService = new AdminService();
$userService = new UserService();
$articleService = new ArticleService();
$userValidator = new UserValidationService();
$router = new Router();


Router::get('/', function () {
    global $articleService;
    $articles = $articleService->getLatestArticles();
    require_once '../app/views/articles/show_articles.php';
});
Router::get('/articles', function () {
    global $articleService;
    $articles = $articleService->getAllArticles();
    require_once '../app/views/articles/show_articles.php';
});

Router::get('/register', function () {
    require_once '../app/views/auth/registration_form.php';
});
Router::post('/register', function () {
    global $userService, $userValidator;

    $userRequest = new UserRequest();
    $userRequest->setUsername($_POST['username']);
    $userRequest->setPassword($_POST['password']);
    $userRequest->setEmail($_POST['email']);

    if (!$userValidator->validate($userRequest)) {
        $errors = $userValidator->getErrors();
        require_once '../app/views/auth/registration_form.php';
        exit;
    }
    $userService->createUser($userRequest);
    header('Location: /');
    exit;
});
Router::get('/login', function () {
    if (isset($_GET['error'])) {
        $errorMessage = urldecode($_GET['error']);
    } else {
        $errorMessage = '';
    }
    require_once '../app/views/auth/login_form.php';

});

Router::post('/login', function () {
    global $userService;
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $userRequest = new UserRequest();
    $userRequest->setUsername($username);
    $userRequest->setPassword($password);

    $userService->authorizeUser($userRequest);
});

Router::get('/profile', function () {
    Auth::requireAuth();

    global $userService;
    $user = $userService->getAuthenticatedUser();
    require_once '../app/views/auth/profile.php';

    exit;
});


//todo use article repo for returning articles
Router::get('/profile/articles', function () {
    Auth::requireAuth();

    global $articleService;

    $articles = $articleService->getArticlesByUser($_SESSION['user_id']);

    echo json_encode(['articles' => $articles]);
});
Router::get('/profile/articles/{id}', function ($id) {
    Auth::requireAuth();

    global $articleService;
    $article = $articleService->getArticleById($id);
    require_once '../app/views/articles/show_profile_article.php';
});

// Форма для создания статьи
Router::get("/article", function () {
    Auth::requireAuth();

    require_once '../app/views/articles/create_article_form.php';

});
Router::get("/article/{id}", function () {
    Auth::requireAuth();

    require_once '../app/views/articles/create_article_form.php';

});
// Отправка созданной статьи
Router::post("/article/create", function () {
    Auth::requireAuth();
    global $articleService;
    global $userService;

    $data = [
        'title' => $_POST['title'] ?? '',
        'content' => $_POST['content'] ?? '',
        'category' => $_POST['category'] ?? '',
        'tags' => $_POST['tags'] ?? ''
    ];
    $author = $userService->getUserById($_SESSION['user_id']);

    $article = new Article();
    $article->setAuthor($author);
    $article->setTitle($data['title']);
    $article->setContent($data['content']);
    $article->setCategory($data['category']);
    $article->setTags($data['tags']);
    $article->setCreatedAt(new DateTime());
    $article->setUpdatedAt(new DateTime());
    $articleService->createArticle($article);

    header('Location: /article');
    exit;
});
Router::get("/article/edit/{id}", function ($id){
    Auth::requireAuth();

    global $articleService;
    $article = $articleService->getArticleById($id);
    require_once '../app/views/articles/edit_article_form.php';
});
Router::post("/article/edit/{id}", function ($id){
    global $articleService;
    parse_str(file_get_contents("php://input"), $data);

    $updateIsSuccessful = $articleService->updateArticle($id, $data);
    if ($updateIsSuccessful) {
        header("Location: /profile/articles/$id");
        exit;
    } else {
        echo "Ошибка при обновлении статьи";
    }


});
Router::get("/password/reset", function () {
    require '../app/views/auth/password/reset_form.php';
});

Router::get('/admin/dashboard', function () {
    Auth::requireAdmin();
    require_once '../app/views/admin/admin_panel.php';
});
Router::get('/admin/users', function () {
    Auth::requireAdmin();
    global $userService;
    $users = $userService->getAllUsers();
    require_once '../app/views/admin/users.php';
});
Router::get('/admin/users/articles/{id}', function ($id) {
    Auth::requireAdmin();
    global $articleService;
    $articles =$articleService->getArticlesByUser($id);
    require_once '../app/views/articles/show_articles.php';
});
Router::get('/admin/user/create', function (){
    Auth::requireAdmin();
    require_once '../app/views/admin/user_create.php';
});

Router::post("/admin/create-user", function () use ($userService, $userValidator, $adminService) {
    Auth::requireAdmin();
    $role = $_POST['role'] ?? 'user';
    $userRequest = new UserRequest();
    $userRequest->setUsername($_POST['username']);
    $userRequest->setPassword($_POST['password']);
    $userRequest->setEmail($_POST['email']);
    if (!$userValidator->validate($userRequest)) {
        $errors = $userValidator->getErrors();
        require_once '../app/views/admin/create_user_form.php';
        exit;
    }
    $user = new User();
    $user->setUsername($userRequest->getUsername());
    $user->setPassword($userRequest->getPassword());
    $user->setEmail($userRequest->getEmail());
    $user->setRole($role);
    $adminService->createUser($user);
    header('Location: /admin/dashboard');
});

Router::post("/admin/users/delete", function (){
    Auth::requireAdmin();
    global $userService;
    $userService->deleteById($_POST['id']);
    header('Location: /admin/users');
});

Router::get("/admin/users/edit/{id}", function ($id){
    Auth::requireAdmin();
    global $userService;
    $user = $userService->getUserById($id);
    require_once '../app/views/admin/edit_user.php';

});
Router::post('/admin/users/edit/{id}', function ($id) use ($userService, $userValidator) {
    $data = $_POST;
    $userRequest = new UserRequest();
    $userRequest->setUsername($_POST['username']);
    $userRequest->setUsername($_POST['password']);
    $userRequest->setUsername($_POST['email']);
    $userRequest->setUsername($_POST['role']);

    if(!$userValidator->validate($userRequest)){
        $errors = $userValidator->getErrors();
        $user = $userService->getUserById($id);
        require_once '../app/views/admin/edit_user.php';
    }

    $isUpdated = $userService->updateUser($id, $data);

    if ($isUpdated) {
        header("Location: /admin/users");
        exit;
    } else {
        $user = $userService->getById($id);
        require_once '../app/views/admin/edit_user.php';
    }
});



Router::route();