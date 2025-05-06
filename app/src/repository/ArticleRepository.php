<?php

namespace Core\repository;

require_once __DIR__ . '/../database/DBConnection.php';
require_once __DIR__ . '/../entity/User.php';
require_once __DIR__ . '/../entity/Article.php';

use ArticleRequest;
use src\entity\User;
use src\entity\Article;
use DBConnection;
use PDO;
use \DateTime;


class ArticleRepository
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = DBConnection::getInstance();
    }

    public function findById(int $id): ?Article
    {
        $findQuery = "
        SELECT 
            articles.id AS article_id,
            articles.title,
            articles.content,
            articles.category,
            articles.tags,
            articles.author_id,
            articles.created_at AS article_created_at,
            articles.updated_at AS article_updated_at,
            u.id AS user_id,
            u.username,
            u.email
        FROM articles
        LEFT JOIN users u ON u.id = articles.author_id
        WHERE articles.id = :id
        LIMIT 1
        ";
        $stmt = $this->connection->prepare($findQuery);
        $stmt->execute(['id' => $id]);
        $article = $stmt->fetch(PDO::FETCH_ASSOC);
        return $article ? $this->mapRowToArticle($article) : null;
    }

    public function findAll(): array
    {
        $findQuery = "
        SELECT 
            articles.id AS article_id,
            articles.title,
            articles.content,
            articles.category,
            articles.tags,
            articles.author_id,
            articles.created_at AS article_created_at,
            articles.updated_at AS article_updated_at,
            u.id AS user_id,
            u.username,
            u.email
        FROM articles
        LEFT JOIN users u ON u.id = articles.author_id
        ";
        $stmt = $this->connection->prepare($findQuery);
        $stmt->execute();
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([$this, 'mapRowToArticle'], $articles);
    }

    public function findAllUserArticles(int $userId): array
    {
        $findQuery = "
        SELECT 
            articles.id AS article_id,
            articles.title,
            articles.content,
            articles.category,
            articles.tags,
            articles.author_id,
            articles.created_at AS article_created_at,
            articles.updated_at AS article_updated_at,
            u.id AS user_id,
            u.username,
            u.email
        FROM articles
        LEFT JOIN users u ON u.id = articles.author_id
        WHERE articles.author_id = :user_id
        ";
        $stmt = $this->connection->prepare($findQuery);
        $stmt->execute(['user_id' => $userId]);
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([$this, 'mapRowToArticle'], $articles);
    }

    public function save(Article $article): bool
    {

        if (empty($article->getId())) {
            // Создание новой статьи
            $query = "
            INSERT INTO articles (title, content, category, tags, author_id, created_at, updated_at)
            VALUES (:title, :content, :category, :tags, :author_id, :created_at, :updated_at)
        ";

            $stmt = $this->connection->prepare($query);
            return $stmt->execute([
                'title' => $article->getTitle(),
                'content' => $article->getContent(),
                'category' => $article->getCategory(),
                'tags' => $article->getTags(),
                'author_id' => $article->getAuthor()->getId(),
                'created_at' => $article->getCreatedAt()->format('Y-m-d H:i:s'),
                'updated_at' => $article->getUpdatedAt()?->format('Y-m-d H:i:s'),
            ]);
        } else {
            // Обновление существующей статьи
            $query = "
            UPDATE articles
            SET title = :title,
                content = :content,
                category = :category,
                tags = :tags,
                updated_at = :updated_at
            WHERE id = :id
        ";

            $stmt = $this->connection->prepare($query);
            return $stmt->execute([
                'title' => $article->getTitle(),
                'content' => $article->getContent(),
                'category' => $article->getCategory(),
                'tags' => $article->getTags(),
                'updated_at' => $article->getUpdatedAt()?->format('Y-m-d H:i:s'),
                'id' => $article->getId()
            ]);
        }
    }



    public function delete(int $id): bool
    {
        $query = "DELETE FROM articles WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        return $stmt->execute(['id' => $id]);
    }

    /**
     * @throws \DateMalformedStringException
     */
    private function mapRowToArticle(array $row): Article
    {
        $article = new Article();
        $article->setId((int)$row['article_id']);
        $article->setTitle($row['title']);
        $article->setContent($row['content']);
        $article->setCategory($row['category'] ?? null);
        $article->setTags($row['tags'] ?? null);

        $author = new User();
        $author->setId((int)$row['user_id']);
        $author->setUsername($row['username']);
        $author->setEmail($row['email']);

        $article->setAuthor($author);
        if (!empty($row['article_created_at'])){
            $article->setCreatedAt(new DateTime($row['article_created_at']));
        }
        if (!empty($row['article_updated_at'])){
            $article->setUpdatedAt(new DateTime($row['article_updated_at']));
        }
        return $article;
    }

    public function findLatest(int $limit = 5): array
    {
        $query = "
        SELECT 
        articles.id AS article_id,
        articles.title,
        articles.content,
        articles.category,
        articles.tags,
        articles.author_id,
        articles.created_at AS article_created_at,
        articles.updated_at AS article_updated_at,
        u.id AS user_id,
        u.username,
        u.email
        FROM articles
        LEFT JOIN users u ON u.id = articles.author_id
        ORDER BY articles.created_at DESC
        LIMIT :limit
    ";

        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([$this, 'mapRowToArticle'], $articles);
    }
}
