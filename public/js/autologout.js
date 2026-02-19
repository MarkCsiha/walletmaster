//https://forum.scriptcase.net/t/how-to-auto-logout-after-10-min-idle-time-help/12453/5
//https://stackoverflow.com/questions/23023916/how-to-implement-auto-logout-in-javascript
let idleMax = 15;
let idleTime = localStorage.getItem('idleTime') ? parseInt(localStorage.getItem('idleTime')) : 0;

$(document).ready(function () {
    if (idleTime >= idleMax) {
        window.location.href = "/logout";
        return;
    }

    setInterval(timerIncrement, 60000);

    $(this).on('mousemove keydown click scroll mousedown touchstart', function () {
        idleTime = 0;
        localStorage.setItem('idleTime', idleTime);
    });
});

function timerIncrement() {
    idleTime++;
    localStorage.setItem('idleTime', idleTime);

    if (idleTime >= idleMax) {
        localStorage.removeItem('idleTime');
        window.location.href = "/logout";
    }
}
