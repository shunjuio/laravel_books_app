document.addEventListener('DOMContentLoaded', function () {
    const submitReservation = document.querySelector("input[type=submit][id=submit_reservation]");
    const lendingSubmit = document.querySelector("input[type=submit][id=submit_lending]");

    const startAtInput = document.querySelector("input[id='input_start_at']");
    const endAtInput = document.querySelector("input[id='input_end_at']");

    submitReservation.addEventListener("click", function () {
        const startAtHiddenInput = document.querySelector("input[id='reservation_start_at']");
        const endAtHiddenInput = document.querySelector("input[id='reservation_end_at']");

        startAtHiddenInput.value = startAtInput.value;
        endAtHiddenInput.value = endAtInput.value;
    });
    lendingSubmit.addEventListener("click", function () {
        const startAtHiddenInput = document.querySelector("input[id='lending_start_at']");
        const endAtHiddenInput = document.querySelector("input[id='lending_end_at']");

        startAtHiddenInput.value = startAtInput.value;
        endAtHiddenInput.value = endAtInput.value;
    });
}, false);
