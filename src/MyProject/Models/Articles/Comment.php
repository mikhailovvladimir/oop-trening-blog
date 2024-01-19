<?php


namespace MyProject\Models\Articles;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Users\User;

class Comment extends ActiveRecordEntity
{
    protected $articleId;

    protected $authorId;

    protected $text;

    public static function addNewComment(array $infoAboutComment, User $author)
    {
        if (empty($infoAboutComment['commentText'])) {
            throw new InvalidArgumentException('Не указан комментарий');
        }

        if (!filter_var($infoAboutComment['commentText'], FILTER_SANITIZE_STRING)) {
            throw new InvalidArgumentException('Не корректно указан комментарий');
        }

        $comment = new Comment();

        $comment->articleId = $infoAboutComment['articleId'];
        $comment->authorId = $author->getId();
        $comment->text = $infoAboutComment['commentText'];

        $comment->save();

        return $comment;
    }
    public function getText()
    {
        return $this->text;
    }

    public function getAuthor()
    {
        return User::getById($this->authorId)->getNickname();
    }

    public static function add(int $authorId, int $articleId): Comment
    {
        $commentText = filter_input(INPUT_POST, 'commentText', FILTER_SANITIZE_STRING);

        if (empty($commentText)) {
            throw new InvalidArgumentException('Некорректно указан текст комментария');
        }

        $comment = new Comment();

        $comment->authorId = $authorId;
        $comment->articleId = $articleId;
        $comment->text = $commentText;
        $comment->save();

        return $comment;
    }

    protected static function getTableName(): string
    {
        return 'comments';
    }
}