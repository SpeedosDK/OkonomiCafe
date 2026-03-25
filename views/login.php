<main class="login-side">
    <h1>Login</h1>

    <?php if (!empty($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST" action="/login">
        <label for="username">Brugernavn</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Kodeord</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Log ind</button>
    </form>
</main>
