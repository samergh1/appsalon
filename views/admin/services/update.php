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
    <h2 class="section-title">Editar servicio</h2>

    <form class="form" action="/services/update?id=<?php echo $service->id; ?>" method="POST">
        <div>
            <label for="nombre" class="label-input">Nombre</label>
            <input type="text" value="<?php echo $service->nombre; ?>" name="nombre" class="form-input" autocomplete="off">
            <span class="input-error"><?php echo $alerts['error']['nombre'] ?? ''; ?></span>
        </div>
        <div>
            <label for="precio" class="label-input">Precio</label>
            <input type="number" value="<?php echo intval($service->precio) === 0 ? '' : intval($service->precio); ?>" name="precio" class="form-input" min="0">
            <span class="input-error"><?php echo $alerts['error']['precio'] ?? ''; ?></span>
        </div>
        <div class="actions">
            <input type="submit" class="submit-btn" value="Actualizar">
            <button class="delete-btn" data-id="<?php echo $service->id; ?>">Eliminar</button>
        </div>
    </form>
</main>

<?php

$script = "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script src='/build/js/services.js'></script>
";

?>