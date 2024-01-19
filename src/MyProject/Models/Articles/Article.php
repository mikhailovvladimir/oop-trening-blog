<?php
namespace MyProject\Models\Articles;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Users\User;

class Article extends ActiveRecordEntity
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $text;

    /** @var int */
    protected $authorId;

    /** @var string */
    protected $createdAt;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    public function getParseText()
    {
        $parseDown = new \Parsedown();
        return $parseDown->text($this->getText());
    }

    /**
     * @return int
     */
    public function getAuthor(): User
    {
         return User::getById($this->authorId);
    }

    public function setAuthor(User $author): void
    {
        $this->authorId = $author->getId();
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setText(string $text)
    {
        $this->text = $text;
    }

    public static function createFromArray(array $fields, User $author): Article
    {
        if (empty($fields['name'])) {
            throw new InvalidArgumentException('Не передано название статьи');
        }

        if (empty($fields['text'])) {
            throw new InvalidArgumentException('Не передан текст статьи');
        }

        $article = new Article();

        $article->setAuthor($author);
        $article->setName($fields['name']);
        $article->setText($fields['text']);

        $article->save();

        return $article;
    }

    public function updateFromArray(array $fields): Article
    {
        if (empty($fields['name'])) {
            throw new InvalidArgumentException('Не передано название статьи');
        }

        if (empty($fields['text'])) {
            throw new InvalidArgumentException('Не передан текст статьи');
        }

        $this->setName($fields['name']);
        $this->setText($fields['text']);

        $this->save();

        return $this;
    }

    public function addComment(): Comment
    {
        return Comment::add($this->getAuthor()->getId(), $this->getId());
    }

    protected static function getTableName(): string
    {
        return 'articles';
    }
}