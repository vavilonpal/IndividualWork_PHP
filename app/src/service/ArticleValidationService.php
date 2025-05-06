<?php

namespace src\service;

use src\entity\Article;

class ArticleValidationService
{
    private array $errors = [];


    public function validate(Article $article): bool
    {
        if (empty($article->getTitle())) {
            $errors['title'] = 'Заголовок обязателен';
        }

        if (empty($article->getContent())) {
            $errors['content'] = 'Содержание обязательно';
        }
        if (!empty($errors)) {

            require_once '../app/views/articles/create_article_form.php';
            return empty($errors);
        }
        return true;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function setErrors(array $array)
    {
        $this->errors = $array;
    }
}