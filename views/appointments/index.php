<main class="container appointments-section">
    <div class="user-nav">
        <p class="center-text">Bienvenido <b><?php echo $name ?></b></p>
        <a class="center-text logout-link" href="/logout">Cerrar sesión</a>
    </div>

    <h2 class="section-title">Crear nueva cita</h2>
    <div class="tab">
        <button class="active" data-step="1">Servicios</button>
        <button data-step="2">Información cita</button>
        <button data-step="3">Resumen</button>
    </div>

    <section id="step-1" class="appointment-step show">
        <h2>Selecciona los servicios</h2>
        <div class="all-services"></div>
    </section>

    <section id="step-2" class="appointment-step">
        <h2>Ingresa la fecha de la cita</h2>
        <form class="form">
            <div>
                <label for="name" class="label-input">Nombre</label>
                <input type="text" value="<?php echo $name; ?>" id="name" class="form-input" disabled>
            </div>
            <div class="date-input">
                <label for="date" class="label-input">Fecha</label>
                <input type="date" class="form-input" name="date" id="date" min="<?php echo date('Y-m-d', strtotime('+1 day')) ?>">
            </div>
            <div class="time-input">
                <label for="time" class="label-input">Hora</label>
                <input type="time" class="form-input" name="time" id="time">
            </div>
            <input type="hidden" id="id" value="<?php echo $id; ?>">
        </form>
    </section>

    <section id="step-3" class="appointment-step"></section>

    <div class="pagination">
        <button id="previous" class="btn btn-hide">&laquo; Anterior</button>
        <button id="next" class="btn">Siguiente &raquo;</button>
    </div>
</main>

<?php

$script = "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script src='/build/js/app.js'></script>
";

?>