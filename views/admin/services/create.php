<main class="container admin-section">
    <div class="user-nav">
        <p class="center-text">Bienvenido <b><?php echo $name ?></b></p>
        <a class="center-text logout-link" href="/logout">Cerrar sesión</a>
    </div>

    <div class="admin-navbar">
        <a href="/admin" class="btn">Ver citas</a>
        <a href="/services" class="btn">Ver servicios</a>
        <a href="/services/create" class="btn">Crear servicio</a>
    </div>
    <h2 class="section-title">Crear servicio</h2>

    <?php if (!empty($alerts['success'])) { ?>
        <span class="alert success"><?php echo $alerts['success']['confirmation'] ?? ''; ?></span>
    <?php } ?>

    <form class="form" method="POST">
        <div>
            <label for="nombre" class="label-input">Nombre</label>
            <input type="text" value="<?php echo $service->nombre; ?>" name="nombre" class="form-input" autocomplete="off">
            <span class="input-error"><?php echo $alerts['error']['nombre'] ?? ''; ?></span>
        </div>
        <div>
            <label for="precio" class="label-input">Precio</label>
            <input type="number" value="<?php echo $service->precio; ?>" name="precio" class="form-input" min="0">
            <span class="input-error"><?php echo $alerts['error']['precio'] ?? ''; ?></span>
        </div>
        <input type="submit" class="submit-btn" value="Crear">
    </form>
</main>