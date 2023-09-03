<main class="container auth-section">
    <div>
        <h1>Crear cuenta</h1>
    </div>
    <form class="form" action="/signup" method="POST">
        <div class="name-inputs">
            <div>
                <label class="label-input" for="nombre">Nombre</label>
                <input class="form-input" value="<?php echo s($user->nombre); ?>" type="text" name="nombre" id="nombre" autocomplete="off">
                <span class="input-error"><?php echo $alerts['error']['nombre'] ?? ''; ?></span>
            </div>
            <div>
                <label class="label-input" for="apellido">Apellido</label>
                <input class="form-input" value="<?php echo s($user->apellido); ?>" type="text" name="apellido" id="apellido" autocomplete="off">
                <span class="input-error"><?php echo $alerts['error']['apellido'] ?? ''; ?></span>
            </div>
        </div>
        <div>
            <label class="label-input" for="telefono">Teléfono</label>
            <input class="form-input" value="<?php echo s($user->telefono); ?>" type="number" name="telefono" id="telefono" min="1" autocomplete="off">
            <span class="input-error"><?php echo $alerts['error']['telefono'] ?? ''; ?></span>
        </div>
        <div>
            <label class="label-input" for="email">Email</label>
            <input class="form-input" value="<?php echo s($user->email); ?>" type="email" name="email" id="email">
            <span class="input-error"><?php echo $alerts['error']['email'] ?? ''; ?></span>
        </div>
        <div>
            <label class="label-input" for="password">Password</label>
            <input class="form-input" type="password" name="password" id="password">
            <span class="input-error"><?php echo $alerts['error']['password'] ?? ''; ?></span>
        </div>
        <input type="submit" class="submit-btn" value="Registrarse">
        <p class="no-margin auth-helper"><a href="/">Ya tienes cuenta? Iniciar sesión</a></p>
    </form>
</main>