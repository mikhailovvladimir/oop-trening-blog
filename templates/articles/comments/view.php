<?php include __DIR__ . '/../../header.php'; ?>

<label for="content">Текст комментария:</label>
<form action="/articles/<?= $articleId ?>/add-comment" method="post">
    <textarea name="commentText" id="commentText" rows="10" cols="50"></textarea><br>
    <button type="submit">Отправить</button>
</form>

<?php include __DIR__ . '/../../footer.php'; ?>