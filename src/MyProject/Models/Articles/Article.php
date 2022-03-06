<?php
namespace MyProject\Models\Articles;

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

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return int
     */
    public function getAuthor(): User
    {
        // lazyload - ленивая загрузка,
        // это когда данные не загружаются пока их не попросят
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


    protected static function getTableName(): string
    {
        return 'articles';
    }
}