document.addEventListener('DOMContentLoaded', function() {
    runApp();
});

function runApp() {
    filterByDate();
}

function filterByDate() {
    const dateInput = document.querySelector('#date');
    dateInput.addEventListener('input', function(e) {
        const date = e.target.value;
        window.location = `?date=${date}`;
    });
}