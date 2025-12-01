require('./bootstrap');

import * as bootstrap from 'bootstrap';

document.addEventListener('DOMContentLoaded', function() {
    // Инициализируем все модальные окна с отключенным backdrop
    initModals();
    initModalNavigation();
    initToast();
    initPopovers();
});

function initModals() {
    // Инициализируем все модальные окна с отключенным backdrop
    document.querySelectorAll('.modal').forEach(modal => {
        new bootstrap.Modal(modal, {
            backdrop: false, // Полностью отключаем backdrop
            keyboard: true   // Но оставляем закрытие по ESC
        });
    });
}

function initModalNavigation() {
    const modals = Array.from(document.querySelectorAll('.modal'));
    
    if (modals.length === 0) return;

    const modalByIndex = {};
    modals.forEach(el => {
        const idx = parseInt(el.getAttribute('data-index'), 10);
        if (!Number.isNaN(idx)) {
            modalByIndex[idx] = el;
        }
    });

    const indices = Object.keys(modalByIndex)
        .map(Number)
        .sort((a, b) => a - b);

    document.addEventListener('keydown', e => {
        if (e.key !== 'ArrowLeft' && e.key !== 'ArrowRight') return;

        const openModal = document.querySelector('.modal.show');
        if (!openModal) return;

        e.preventDefault();

        const currentIndex = parseInt(openModal.getAttribute('data-index'), 10);
        if (isNaN(currentIndex)) return;

        const pos = indices.indexOf(currentIndex);
        if (pos === -1) return;

        const nextPos = (e.key === 'ArrowRight')
            ? (pos + 1) % indices.length
            : (pos - 1 + indices.length) % indices.length;

        const nextIndex = indices[nextPos];
        const nextEl = modalByIndex[nextIndex];

        if (!nextEl) return;

        const currentModalInstance = bootstrap.Modal.getInstance(openModal);
        if (currentModalInstance) {
            currentModalInstance.hide();

            openModal.addEventListener('hidden.bs.modal', function handler() {
                openModal.removeEventListener('hidden.bs.modal', handler);
                const nextModalInstance = new bootstrap.Modal(nextEl, { 
                    backdrop: false
                });
                nextModalInstance.show();
            });
        }
    });
}

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