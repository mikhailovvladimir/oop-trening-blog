<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\Forbidden;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Articles\Comment;

class ArticlesController extends AbstractController
{
    public function view(int $articleId)
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException();
        }

        $allComments = Comment::findRecordsByColumn('article_id', $articleId);
        if (!empty($allComments)) {
            $allComments = array_reverse($allComments);
        }

        if (!empty($_POST)) {
            try {
                $_POST['articleId'] = $articleId;
                Comment::addNewComment($_POST, $this->user);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('articles/view.php', [
                    'article' => $article,
                    'comments' => $allComments,
                    'error' => $e->getMessage()
                ]);
                exit;
            }
        }

        $this->view->renderHtml('articles/view.php', [
            'article' => $article,
            'comments' => $allComments
        ]);
    }

    public function edit(int $articleId): void
    {
        if (!$this->admin) {
            throw new Forbidden('У вас нет доступа к этой странице!');
        }

        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException();
        }

        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if (!empty($_POST)) {
            try {
                $article->updateFromArray($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('articles/edit.php', ['error' => $e->getMessage()]);
                return;
            }

            header('Location: /articles/' . $article->getId(), true, 302);
            exit;
        }

        $this->view->renderHtml('articles/edit.php', ['article' => $article]);

    }

    public function add(): void
    {
        if (!$this->admin) {
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