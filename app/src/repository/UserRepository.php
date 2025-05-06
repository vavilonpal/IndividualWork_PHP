<?php

namespace Core\repository;

require_once __DIR__ . '/../database/DBConnection.php';
require_once __DIR__ . '/../entity/User.php';
require_once __DIR__ . '/../entity/Article.php';

use src\entity\User;
use src\entity\Article;
use DBConnection;
use PDO;
use \DateTime;


/*todo
 * register method
 * update method
 * get all method
 * */
class UserRepository
{
    private PDO $connection;


    public function __construct()
    {
        $this->connection = DBConnection::getInstance();
    }

    public function findUserByUsername(string $username): ?User
    {
        $findQuery = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $this->connection->prepare($findQuery);
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return null;
        }
        return $this->mapRowToEntity($user);
    }

    //todo add article join
    public function findById(int $id): ?User
    {
        // Получаем пользователя
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return null;
        }

        $stmt = $this->connection->prepare("SELECT * FROM articles WHERE author_id = :id");
        $stmt->execute(['id' => $id]);
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this->mapRowToEntity($user, $articles);
    }

    /**
     * @throws \DateMalformedStringException
     */
    public function findAll(): array
    {
        $query = "SELECT * FROM users";
        $stmt = $this->connection->query($query);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users = [];
        foreach ($results as $row) {
            $user =  $this->mapRowToEntity($row);
            $users[] = $user;
        }

        return $users;
    }


    public function save(User $user): bool
    {
        $checkUserExistsQuery = "SELECT * FROM users WHERE username = :username LIMIT 1";

        $saveQuery = "INSERT INTO users (username, email, password) 
                  VALUES (:username, :email, :password)";

        $updateQuery = "UPDATE users 
                    SET email = :email, password = :password 
                    WHERE username = :username";

        $stmt = $this->connection->prepare($checkUserExistsQuery);
        $stmt->execute(['username' => $user->getUsername()]);
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingUser) {
            // Обновляем существующего пользователя
            $stmt = $this->connection->prepare($updateQuery);
            return $stmt->execute([
                'username' => $user->getUsername(),
                'email'    => $user->getEmail(),
                'password' => $user->getPassword()
            ]);
        } else {
            // Добавляем нового пользователя
            $stmt = $this->connection->prepare($saveQuery);
            return $stmt->execute([
                'username' => $user->getUsername(),
                'email'    => $user->getEmail(),
                'password' => $user->getPassword()
            ]);
        }
    }

    public function deleteById(int $id): bool
    {
        $deleteArticles = "DELETE FROM articles WHERE author_id = :id";
        $stmtArticles = $this->connection->prepare($deleteArticles);
        $stmtArticles->execute(['id' => $id]);

        // Удалить пользователя
        $deleteUser = "DELETE FROM users WHERE id = :id";
        $stmtUser = $this->connection->prepare($deleteUser);
        return $stmtUser->execute(['id' => $id]);
    }
    /**
     * @throws \DateMalformedStringException
     */
    private function mapRowToEntity(array $row, array $articles = []): User
    {
        $userEntity = new User();

        // Используем сеттеры для установки значений
        $userEntity->setId($row['id'] ?? null);
        $userEntity->setUsername($row['username'] ?? null);
        $userEntity->setEmail($row['email'] ?? null);
        $userEntity->setRole($row['role'] ?? null);
        $userEntity->setPassword($row['password'] ?? null);

        if (!empty($row['created_at'])) {
            $userEntity->setCreatedAt(new DateTime($row['created_at']));
        }
        if (!empty($row['updated_at'])) {
            $userEntity->setUpdatedAt(new DateTime($row['updated_at']));
        }

        if (empty($articles)) {
            $userEntity->setArticles([]);
        } else {
            foreach ($articles as $articleRow) {
                $article = new Article();
                $article->setId($articleRow['id'] ?? null);
                $article->setTitle($articleRow['title'] ?? null);
                $article->setContent($articleRow['content'] ?? null);
                $article->setCategory($articleRow['category'] ?? null);

                if (!empty($articleRow['created_at'])){
                    $article->setCreatedAt(new DateTime($articleRow['created_at']));
                }
                if (!empty($articleRow['updated_at'])){
                    $article->setUpdatedAt(new DateTime($articleRow['updated_at']));
                }
                $userEntity->addArticle($article);
            }
        }

        return $userEntity;
    }

    public function existsByEmail(string $email): bool
    {
        $sql = "SELECT 1 FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['email' => $email]);

        return (bool) $stmt->fetchColumn();
    }

}