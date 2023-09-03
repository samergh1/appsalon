document.addEventListener('DOMContentLoaded', function() {
    runApp();
});

function runApp() {
    loadService();
    deleteWarning();
}

function loadService() {
    const allServices = document.querySelectorAll('.service');
    allServices.forEach(service => {
        service.addEventListener('click', function(e) {
            const serviceId = e.target.closest('div').dataset.id;
            window.location = `/services/update?id=${serviceId}`;
        });
    });
}

function createSwalAlert(id) {
    Swal.fire({
        icon: 'warning',
        title: '¿Estás seguro?',
        text: 'No podrás revertir esta acción',
        showCancelButton: true,
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar'
    }).then((result) => {
        if (result.isConfirmed) {
            deleteService(id);
        }
    })
}

function deleteWarning() {
    const deleteBtn = document.querySelector('.delete-btn');
    if (deleteBtn !== null) {
        deleteBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const id = e.target.dataset.id;
            createSwalAlert(id);
        })
    }
}

async function deleteService(id) {
    const data = new FormData();
    data.append('id', id);
    const url = "/services/delete";
    try {
        const response = await fetch(url, {
            method: 'POST',
            body: data
        })
        const result = await response.json();
        if (result) {
            window.location = '/services';
        }
    } catch (error) {
        console.log(error);
    }
}