<?php

namespace src\service;
require_once __DIR__ . '/../repository/ArticleRepository.php';
require_once __DIR__ . '/../service/ArticleValidationService.php';

use Core\repository\ArticleRepository;
use DateTime;
use http\Exception\RuntimeException;
use src\entity\Article;
use src\entity\User;

class ArticleService
{
    private ArticleRepository $articleRepository;
    private ArticleValidationService $validationService;


    public function __construct()
    {
        $this->articleRepository = new ArticleRepository();
        $this->validationService = new ArticleValidationService();
    }

    public function getArticleById(int $id): ?Article
    {
        return  $this->articleRepository->findById($id);

    }

    public function getAllArticles(): array
    {
        return $this->articleRepository->findAll();
    }

    public function getArticlesByUser(int $userId): array
    {
        return $this->articleRepository->findAllUserArticles($userId);
    }

    public function getLatestArticles(int $limit = 5): array
    {
        return $this->articleRepository->findLatest($limit);
    }

    public function createArticle(Article $article): bool
    {
        if (!$this->validationService->validate($article)){

            $errors = $this->validationService->getErrors();
            require_once '../app/views/articles/create_article_form.php';
            $this->validationService->setErrors([]);
            exit;
        }

        return $this->articleRepository->save($article);
    }

    public function deleteArticle(int $articleId): bool
    {
        return $this->articleRepository->delete($articleId);
    }

    public function updateArticle($id, $request):bool
    {
        $article = $this->articleRepository->findById($id);


        // Обновляем поля статьи
        $article->setTitle(trim($request['title']));
        $article->setContent(trim($request['content']));
        $article->setCategory($request['category'] ?? null);
        $article->setTags($request['tags'] ?? null);
        $article->setUpdatedAt(new DateTime());

        if (!$this->validationService->validate($article)){

            $errors = $this->validationService->getErrors();
            require_once '../app/views/articles/create_article_form.php';
            $this->validationService->setErrors([]);
            exit;
        }

        // Сохраняем изменения
        return $this->articleRepository->save($article);
    }

}