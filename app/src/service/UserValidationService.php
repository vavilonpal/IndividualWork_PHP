<?php

namespace src\service;

use src\service\UserService;
use UserRequest;

class UserValidationService
{
    private UserService $userService;


    private array $errors = [];

    /**
     * @param \src\service\UserService $userService
     */
    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function validate(UserRequest $request, bool $requirePassword = true): bool
    {
        $this->errors = []; // очищаем ошибки

        if (empty($request->getUsername()) || strlen($request->getUsername()) < 3) {
            $this->errors['username'] = 'Имя пользователя должно быть не короче 3 символов.';
        }

        if (empty($request->getEmail()) || !filter_var($request->getEmail(), FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Неверный формат email.';
        }

        if ($requirePassword && (empty($request->getPassword()) || strlen($request->getPassword()) < 6)) {
            $this->errors['password'] = 'Пароль должен содержать не менее 6 символов.';
        }
        if ($this->userService->existsByEmail($request->getEmail())){
            $this->errors['email'] = "Email занят";
        }

        return empty($this->errors);
    }




    public function getErrors(): array
    {
        return $this->errors;
    }
}