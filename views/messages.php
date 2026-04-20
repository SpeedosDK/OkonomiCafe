<main>

    <?php if (isset($_GET['sent'])): ?>
        <p id="mail-sent" class="mail-sent">
            ✔ Mail sendt!
        </p>
    <?php endif; ?>

    <h1>Beskeder</h1>

    <?php foreach ($messages as $msg): ?>
        <article class="message-box <?= $msg['is_read'] ? 'read' : 'unread' ?>">
            <h3>
                <?= htmlspecialchars($msg['name']) ?>
                (<?= htmlspecialchars($msg['email']) ?>)

                <?php if (!$msg['is_read']): ?>
                    <span class="badge">Ulæst</span>
                <?php endif; ?>
            </h3>

            <p><?= nl2br(htmlspecialchars($msg['message'])) ?></p>
            <small>Sendt: <?= $msg['created_at'] ?></small>

            <?php if ($msg['reply']): ?>
                <section class="reply-box">
                    <strong>Svar:</strong>
                    <p><?= nl2br(htmlspecialchars($msg['reply'])) ?></p>
                </section>
            <?php endif; ?>

            <form method="POST" action="/messages/read">
                <input type="hidden" name="id" value="<?= $msg['id'] ?>">
                <button type="submit">Markér som læst</button>
            </form>

            <form method="POST" action="/messages/reply">
                <input type="hidden" name="id" value="<?= $msg['id'] ?>">
                <textarea name="reply" placeholder="Skriv svar her..." required></textarea>
                <button type="submit">Send svar</button>
            </form>
        </article>
    <?php endforeach; ?>

</main>

<script>
    setTimeout(() => {
        const box = document.getElementById('mail-sent');
        if (box) box.remove();
    }, 4000);
</script>
