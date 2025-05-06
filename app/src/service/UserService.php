<?php

namespace src\service;
require_once __DIR__ . '/../repository/UserRepository.php';

use Core\repository\UserRepository;
use http\Exception\RuntimeException;
use UserRequest;
use src\entity\User;


class UserService
{

    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }


    public function getAuthenticatedUser(): ?User
    {
        if (!isset($_SESSION['user_id'])) {
            return null;
        }

        $user = $this->getUserById($_SESSION['user_id']);

        echo $user->getId();
        return $user;
    }


    public function authorizeUser(UserRequest $userRequest): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        try {
            $user = $this->userRepository->findUserByUsername($userRequest->getUsername());
        } catch (\Throwable $e) {
            header('Location: /login?error=Ошибка авторизации');
            exit;
        }

        if (!$user || !password_verify($userRequest->getPassword(), $user->getPassword())) {
            header('Location: /login?error=Неверные учетные данные');
            exit;
        }

        $_SESSION['user_id'] = $user->getId();
        $_SESSION['role'] = $user->getRole();

        header('Location: /profile');
    }


    public function getUserById(int $id): ?User
    {
        $user = $this->userRepository->findById($id);
        if (!$user) {
            throw new RuntimeException("User not found");
        }
        return $user;
    }

    public function getAllUsers(): array
    {
        return $this->userRepository->findAll();
    }

    public function createUser(UserRequest $userRequest): void
    {
        $user = new User();
        $user->setUsername($userRequest->getUsername());
        $user->setEmail($userRequest->getEmail());

        $hashedPassword = password_hash($userRequest->getPassword(), PASSWORD_DEFAULT);
        $user->setPassword($hashedPassword);
        $user->setCreatedAt(new \DateTime());

        $this->userRepository->save($user);
    }

    public function updateUser(int $id, UserRequest $userRequest): bool
    {
        $user = $this->userRepository->findById($id);
        if (!$user) {
            throw new \RuntimeException("Пользователь не найден");
        }

        // Обновляем поля
        $user->setUsername($userRequest->getUsername());
        $user->setEmail($userRequest->getEmail());

        if ($userRequest->getPassword()) {
            $hashedPassword = password_hash($userRequest->getPassword(), PASSWORD_DEFAULT);
            $user->setPassword($hashedPassword);
        }
        $user->setUpdatedAt(new \DateTime());

        return $this->userRepository->save($user);
    }


    public function existsByEmail(string $email): bool
    {
        return $this->userRepository->existsByEmail($email);
    }


    public function deleteById(int $id)
    {
        if($_SESSION['user_id'] == $id){
            echo "Нельзя удалить себя же";
            exit;
        }
        $this->userRepository->deleteById($id);
    }

}