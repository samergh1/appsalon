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
    <h2 class="section-title">Servicios</h2>
    <p class="center-text">Haz click en cualquier servicio para editarlo</p>

    <div class="all-services">
        <?php foreach ($services as $service) { ?>
            <div class="service" data-id="<?php echo $service->id; ?>">
                <p class="service-name no-margin center-text"><?php echo $service->nombre; ?></p>
                <p class="service-price no-margin center-text">$<?php echo $service->precio; ?></p>
            </div>
        <?php } ?>
    </div>
</main>

<?php

$script = "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script src='/build/js/services.js'></script>
";

?>