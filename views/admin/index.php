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
    <h2 class="section-title">Consultar citas</h2>

    <form class="form">
        <div class="date-input">
            <label for="date" class="label-input">Fecha</label>
            <input type="date" value="<?php echo $date; ?>" class="form-input" name="date" id="date">
        </div>
    </form>

    <?php if (!empty($appointments)) { ?>
        <?php foreach ($appointments as $appointment) { ?>
            <div class="appointment">
                <h3>Id: <?php echo $appointment['id']; ?></h3>
                <p><span>Hora:</span> <?php echo $appointment['hora']; ?></p>
                <p><span>Cliente:</span> <?php echo $appointment['cliente']; ?></p>
                <p><span>Email:</span> <?php echo $appointment['email']; ?></p>
                <p><span>Teléfono:</span> <?php echo $appointment['telefono']; ?></p>
                <div class="services">
                    <h3>Servicios</h3>
                    <?php foreach ($appointment['servicios'] as $service) { ?>
                        <p><?php echo $service['servicio'] ?> - $<?php echo $service['precio'] ?></p>
                    <?php } ?>
                    <p><span>Total: </span> $<?php echo $appointment['total'] ?></p>
                    <form action="/api/delete" method="POST">
                        <input type="hidden" name="id" value="<?php echo $appointment['id']; ?>">
                        <input type="submit" class="btn-delete" value="Eliminar cita">
                    </form>
                </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <h3 class="not-found">No hay citas agendadas en esta fecha</h3>
    <?php } ?>
</main>

<?php

$script = "<script src='/build/js/filter.js'></script>";

?>