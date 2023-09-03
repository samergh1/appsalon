<main class="container auth-section">
    <div>
        <h1>Reestablecer password</h1>
    </div>

    <?php if (!empty($alerts['success'])) { ?>
        <span class="alert success"><?php echo $alerts['success']['confirmation'] ?? ''; ?></span>
    <?php } ?>

    <form class="form" action="/password/reset" method="POST">
        <div>
            <label class="label-input" for="email">Email</label>
            <input class="form-input" type="email" name="email" id="email">
            <span class="input-error"><?php echo $alerts['error']['email'] ?? ''; ?></span>
        </div>
        <input type="submit" class="submit-btn" value="Reestablecer password">
        <p class="no-margin auth-helper"><a href="/signup">Crear nueva cuenta</a></p>
    </form>
</main>