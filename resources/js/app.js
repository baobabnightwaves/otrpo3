require('./bootstrap');

import * as bootstrap from 'bootstrap';

document.addEventListener('DOMContentLoaded', function() {
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));
    
    // Инициализация всех модальных окон
    const modalList = document.querySelectorAll('.modal');
    modalList.forEach(modalElement => {
        new bootstrap.Modal(modalElement);
    });
});