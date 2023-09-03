let step = 1;
const initialStep = 1;
const finalStep = 3;

const appointment = {
    usuarioId: '',
    name: '',
    date: '',
    time: '',
    selectedServices: []
};

document.addEventListener('DOMContentLoaded', function() {
    runApp();
});

function runApp() {
    // Funciones para la paginacion
    showSection();
    tab();
    pagination();
    previousStep();
    nextStep();
    changeSelectedTab();
    // Consumir servicios con fetch y mostrarlos
    showServices();
    // Guardar los datos de la cita en el objeto appointment
    getId();
    getName();
    getDate();
    getTime();
}

function tab() {
    const tab = document.querySelectorAll('.tab');
    tab.forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (step !== parseInt(e.target.dataset.step)) {
                step = parseInt(e.target.dataset.step);
                showSection();
                pagination();
            }
        });
    });
}

function changeSelectedTab() {
    const previousTab = document.querySelector('.active');
    previousTab.classList.remove('active');

    const actualTab = document.querySelector(`[data-step="${step}"]`);
    actualTab.classList.add('active');
}

function showSection() {
    // Ocultar seccion anterior
    const prevSection = document.querySelector('.show');
    prevSection.classList.remove('show');
    // Mostrar nueva seccion
    const section = document.querySelector(`#step-${step}`);
    section.classList.add('show'); 
    changeSelectedTab();
}

function pagination() {
    const previousBtn = document.querySelector('#previous');
    const nextBtn = document.querySelector('#next');

    if (step === initialStep) {
        previousBtn.classList.add('btn-hide');
        nextBtn.classList.remove('btn-hide');
    } else if (step > initialStep && step < finalStep) {
        previousBtn.classList.remove('btn-hide');
        nextBtn.classList.remove('btn-hide');
    } else if (step === finalStep) {
        previousBtn.classList.remove('btn-hide');
        nextBtn.classList.add('btn-hide');
        showSummary();
    }

    showSection();
}

function previousStep() {
    const previousBtn = document.querySelector('#previous');
    previousBtn.addEventListener('click', function() {
        if (step > initialStep) {
            step--;
            pagination();
        }
    })
}

function nextStep() {
    const nextBtn = document.querySelector('#next');
    nextBtn.addEventListener('click', function() {
        if (step < finalStep) {
            step++;
            pagination();
        }
    })
}

async function fetchServices() {
    try {
        const url = "/api/services";
        const services = await fetch(url);
        const allServices = await services.json();
        return allServices;
    } catch (error) {
        console.log(error);
    }
}

async function showServices() {
    const services = await fetchServices();
    const allServicesContainer = document.querySelector('.all-services');
    services.forEach(service => {
        const {id, nombre, precio} = service;
        // Crear contenedor del servicio
        const serviceContainer = document.createElement("div");
        serviceContainer.classList.add('service');
        serviceContainer.dataset.id = id;
        serviceContainer.addEventListener('click', () => {
            selectService(service);
        });
        serviceContainer.innerHTML = `
            <p class="service-name no-margin center-text">${nombre}</p>
            <p class="service-price no-margin center-text">$${precio}</p>
        `;
        // Agregarlo al documento HTML
        allServicesContainer.appendChild(serviceContainer);
    })
}

function selectService(service) {
    const {id} = service;
    const {selectedServices} = appointment;
    if (selectedServices.some(checkService => checkService.id === id)) {
        appointment.selectedServices = selectedServices.filter(newService => newService.id !== id);
    } else {
        appointment.selectedServices = [...selectedServices, service];
    }
    document.querySelector(`[data-id="${service.id}"]`).classList.toggle('selected');
}

function getId() {
    appointment.usuarioId = document.querySelector('#id').value;
}

function getName() {
    appointment.name = document.querySelector('#name').value;
}

function getDate() {
    const dateInput = document.querySelector('#date');
    dateInput.addEventListener('input', function(e) {
        const date = e.target.value;
        const day = new Date(date).getDay();
        validateDate(dateInput, date, day);
    });
}

function getTime() {
    const timeInput = document.querySelector('#time');
    timeInput.addEventListener('input', function(e) {
        const time = e.target.value;
        const hour = time.split(":")[0];
        const minutes = time.split(":")[1];
        validateHour(timeInput, time, hour, minutes);
    });
}

function createInputError(message) {
    const error = document.createElement('span');
    error.classList.add('input-error');
    error.textContent = `${message}`;
    return error;
}

function createAlert(type, message) {
    const alert = document.createElement('span');
    alert.classList.add('alert');
    alert.classList.add(type);
    alert.textContent = message;
    return alert;
}

function validateDate(dateInput, date, day) {
    if ([5, 6].includes(day)) {
        if (document.querySelector('.date-input .input-error') !== null) return;
        dateInput.value = '';
        // Crear elemento de error y agregar al HTML
        const error = createInputError('No se puede agendar en fines de semana');
        const dateContainer = document.querySelector('.date-input');
        dateContainer.appendChild(error);

        setTimeout(() => {
            error.remove();
        }, 3000);
    } else {
        appointment.date = date;
    }
}

function validateHour(timeInput, time, hour) {
    const timeContainer = document.querySelector('.time-input');
    if (hour < 9 || hour > 17) {
        timeInput.value = '';
        if (document.querySelector('.time-input .input-error') !== null) return;

        error = createInputError('Ingrese un horario válido (9:00 AM - 5:00 PM)');
        timeContainer.appendChild(error);

        setTimeout(() => {
            error.remove();
        }, 3000);
    } else {
        appointment.time = time;
    }
}

function showSummary() {
    const summarySection = document.querySelector('#step-3');
    summarySection.textContent = '';
    if (Object.values(appointment).includes('') || appointment.selectedServices.length === 0) {
        if (document.querySelector('.alert.error')) return;
        const error = createAlert('error', 'Debes completar todos los campos y seleccionar algún servicio para continuar');
        summarySection.appendChild(error);
        return;
    } else {
        const error = document.querySelector('.alert.error');
        if (error) {
            error.remove();
        }
    }

    // Resumen de servicios
    const servicesSummary = document.createElement('div');
    servicesSummary.classList.add('services-summary');
    // Contenido del resumen de servicios
    const titleService = document.createElement('h2');
    titleService.textContent = 'Resumen de servicios';
    servicesSummary.appendChild(titleService);

    const {name, date, time, selectedServices} = appointment;

    let totalPrice = 0;
    selectedServices.forEach(service => {
        const {nombre, precio} = service;
        const serviceBox = document.createElement('div');
        serviceBox.classList.add('service-summary');
        serviceBox.innerHTML = `
            <p><span>Nombre:</span> ${nombre}</p>
            <p><span>Precio:</span> $${precio}</p>
        `;
        servicesSummary.appendChild(serviceBox);
        // Calcular el precio total
        totalPrice += parseInt(precio);
    });

    const totalPriceContainer = document.createElement('p');
    totalPriceContainer.classList.add('total-services');
    totalPriceContainer.innerHTML = `Total: <span>$${totalPrice}</span>`;
    servicesSummary.appendChild(totalPriceContainer);

    // Resumen de cita
    const appointmentSummary = document.createElement('div');
    appointmentSummary.classList.add('appointment-summary');
    // Contenido del resumen de cita
    const titleAppointment = document.createElement('h2');
    titleAppointment.textContent = 'Resumen de cita';

    const nameContainer = document.createElement('p');
    nameContainer.innerHTML = `<span>Nombre: </span> ${name}`;
    // Formatear fecha
    const dateObj = new Date(date + ' 00:00');
    const options = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'};
    const formattedDate = dateObj.toLocaleDateString('es-MX', options); 

    const dateContainer = document.createElement('p');
    dateContainer.innerHTML = `<span>Fecha: </span> ${formattedDate}`;

    const timeContainer = document.createElement('p');
    timeContainer.innerHTML = `<span>Hora: </span> ${time}`;

    const sendBtn = document.createElement('button');
    sendBtn.textContent = 'Crear cita';
    sendBtn.classList.add('send-btn');
    sendBtn.addEventListener('click', createAppointment);

    appointmentSummary.appendChild(titleAppointment);
    appointmentSummary.appendChild(nameContainer);
    appointmentSummary.appendChild(dateContainer);
    appointmentSummary.appendChild(timeContainer);
    appointmentSummary.appendChild(sendBtn);

    // Se agregan los resumenes al contenido padre de la seccion
    summarySection.appendChild(servicesSummary);
    summarySection.appendChild(appointmentSummary);
}

function createSwalAlert(icon, title, text) {
    Swal.fire({
        icon: icon,
        title: title,
        text: text,
    }).then(() => {
        window.location.reload();
    })
}

async function createAppointment() {
    const {selectedServices} = appointment;
    const servicesId = selectedServices.map(service => service.id);

    const data = new FormData();
    const keys = Object.keys(appointment);
    keys.forEach(key => {
        key === 'selectedServices' ? data.append(key, servicesId) : data.append(key, appointment[key]);
    });
    const url = "/api/appointments";
    try {
        // Se debe pasar un segundo parametro al fetch con la data a enviar debido a que es un metodo POST
        const response = await fetch(url, {
            method: 'POST',
            body: data
        });
        const result = await response.json();
        console.log(result);
        if (result) {
            createSwalAlert('success', 'Cita creada', 'Su cita fue creada exitosamente');
        }
    } catch (error) {
        console.log(error);
        createSwalAlert('error', 'Error', 'Ha ocurrido un error al tratar de crear su cita');
    }
}