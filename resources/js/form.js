document.addEventListener('DOMContentLoaded', function () {
    const lendingSubmit = document.querySelector("button[id=lending_btn]");
    const reservationSubmit = document.querySelector("button[id=reservation_btn]");

    lendingSubmit.addEventListener("click", function () {
        const form = document.getElementById('form');

        form.action = lendingSubmit.formAction;
        form.submit();
    });

    reservationSubmit.addEventListener("click", function () {
        const form = document.getElementById('form');
        form.action = reservationSubmit.formAction;
        form.submit();
    });
}, false);

