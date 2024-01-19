<?php include __DIR__ . '/../header.php';?>
    <h1><?= $article->getName() ?></h1>
    <p><?= $article->getParseText() ?></p>
    <p>Автор: <?= $article->getAuthor()->getNickname(); ?></p>
    <?php if (!empty($user)) : ?>
    <p style="font-size: 15px; color: red; margin: 0;"><?= $error ?? '' ;?></p>
    <b>Оставить комментарий:</b>
    <form action="" method="post">
        <textarea name="commentText" style="width: 70%;"></textarea><br>
        <input type="submit" style="width: 30%; padding: 2px;">
    </form>

    <a href="/articles/<?= $article->getId()?>/comments">Оставить комментарий</a>
    <?php else: ?>
        <h3><a href="/users/register">Зарегестрируйтесь и оставляйте комментарии!</a></h3>
    <?php endif ?>

    <?php if (!empty($comments)): ?>
        <?php foreach ($comments as $comment): ?>
        <h4><?= $comment->getAuthor() ?> </h4>
        <p><?= $comment->getText(); ?> </p>
        <hr>
        <?php endforeach; ?>
    <?php endif; ?>
<?php
if ($admin) : ?>
    <p><a href="/articles/<?= $article->getId() ?>/edit">Редактировать статью</a></p>
<?php endif; ?>

<?php include __DIR__ . '/../footer.php'; ?>