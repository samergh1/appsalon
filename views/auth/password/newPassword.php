<main class="container auth-section">
    <div>
        <h1>Nueva password</h1>
    </div>

    <?php if (!empty($alerts['success'])) { ?>
        <span class="alert success"><?php echo $alerts['success']['confirmation'] ?? ''; ?></span>
    <?php } ?>

    <form class="form" method="POST">
        <div>
            <label class="label-input" for="password">Password</label>
            <input class="form-input" type="password" name="password" id="password">
            <span class="input-error"><?php echo $alerts['error']['password'] ?? ''; ?></span>
        </div>
        <input type="submit" class="submit-btn" value="Crear nueva password">
        <p class="no-margin auth-helper"><a href="/">Iniciar sesión</a></p>
    </form>
</main>