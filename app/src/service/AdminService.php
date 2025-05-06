<?php

namespace src\service;

use Core\repository\UserRepository;
use src\entity\User;

class AdminService
{
    private UserRepository $userRepository;


    /**
     * @param UserRepository $userRepository
     * @param UserService $userService
     * @param UserValidationService $userValidationService
     */
    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

        public function createUser(User $user): void
    {
        $hashedPassword = password_hash($user->getPassword(), PASSWORD_DEFAULT);
        $user->setPassword($hashedPassword);
        $user->setCreatedAt(new \DateTime());

        $this->userRepository->save($user);
    }
}