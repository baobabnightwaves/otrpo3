require('./bootstrap');

//import * as bootstrap from 'bootstrap';

document.addEventListener('DOMContentLoaded', function() {
    initToast();
    initPopovers();
});


function initToast() {
    const loadButton = document.querySelector('.btn-light');
    if (loadButton) {
        loadButton.addEventListener('click', () => {
            const toastEl = document.getElementById('loadToast');
            if (toastEl) {
                const toast = new bootstrap.Toast(toastEl);
                toast.show();
            }
        });
    }
}

function initPopovers() {
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    const popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
}