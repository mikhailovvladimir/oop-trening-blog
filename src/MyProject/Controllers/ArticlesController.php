<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\Forbidden;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Models\Articles\Article;

class ArticlesController extends AbstractController
{
    public function view(int $articleId)
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException();
        }

        $this->view->renderHtml('articles/view.php', [
            'article' => $article,
        ]);
    }

    public function edit(int $articleId): void
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException();
        }

        $article->setName('Новое название статьи1');
        $article->setText('Новый текст статьи1');

        $article->save();
    }

    public function add(): void
    {
        if (!$this->user->isAdmin()) {
            throw new Forbidden('У вас нет доступа к этой странице!');
        }

        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if (!empty($_POST)) {
            try {
                $article = Article::createFromArray($_POST, $this->user);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('articles/add.php', ['error' => $e->getMessage()]);
                return;
            }

            header('Location: /articles/' . $article->getId(), true, 302);
            exit;
        }

        $this->view->renderHtml('articles/add.php');
    }

    public function delete(int $id): void
    {
        $article = Article::getById($id);

        if ($article === null) {
            throw new NotFoundException();
        }

        $article->deleteById($id);
    }
}