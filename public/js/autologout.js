let idleMax = 1; // minutes
let idleTime = localStorage.getItem('idleTime') ? parseInt(localStorage.getItem('idleTime')) : 0;

$(document).ready(function () {
    // Check immediately on page load
    if (idleTime >= idleMax) {
        window.location.href = "/logout";
        return;
    }

    setInterval(timerIncrement, 60000);

    $(this).on('mousemove keypress click scroll mousedown touchstart', function () {
        idleTime = 0;
        localStorage.setItem('idleTime', idleTime);
    });
});

function timerIncrement() {
    idleTime++;
    localStorage.setItem('idleTime', idleTime);

    if (idleTime >= idleMax) {
        localStorage.removeItem('idleTime'); // Clear after logout
        window.location.href = "/logout";
    }
}
