<main class="container auth-section">
    <div>
        <h1>Inicio de sesión</h1>
    </div>
    <form class="form" action="/" method="POST">
        <div>
            <label class="label-input" for="email">Email</label>
            <input class="form-input" value="<?php echo s($user->email); ?>" type="email" name="email" id="email">
            <span class="input-error"><?php echo $alerts['error']['email'] ?? ''; ?></span>
        </div>
        <div>
            <label class="label-input" for="password">Password</label>
            <input class="form-input" type="password" name="password" id="password">
            <span class="input-error"><?php echo $alerts['error']['password'] ?? ''; ?></span>
            <p class="no-margin forgot-password"><a href="/password/reset">Olvidaste tu password?</a></p>
        </div>
        <input type="submit" class="submit-btn" value="Iniciar sesión">
        <p class="no-margin auth-helper"><a href="/signup">Crear nueva cuenta</a></p>
    </form>
</main>