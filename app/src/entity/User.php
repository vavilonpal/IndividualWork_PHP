<?php

namespace src\entity;

use DateTime;

class User
{
    private int $id;
    private string $username;
    private string $email;
    private string $password;
    private string $role;
    private array $articles;
    private DateTime $createdAt;
    private DateTime $updatedAt;

    /**
     * @param int $id
     * @param string $username
     * @param string $email
     * @param string $password
     * @param string $role
     * @param array $articles
     * @param DateTime $createdAt
     * @param DateTime $updatedAt
     */
    public function __construct()
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function getArticles(): array
    {
        return $this->articles;
    }

    public function setArticles(array $articles): void{
        $this->articles = $articles;
    }
    public function addArticle(Article $article): void
    {
        $this->articles[] = $article;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }



}