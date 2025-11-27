require('./bootstrap');

import * as bootstrap from 'bootstrap';

document.addEventListener('DOMContentLoaded', function() {
    const modals = Array.from(document.querySelectorAll('.modal'));
    const modalByIndex = {};
    modals.forEach(el => {
        const idx = parseInt(el.getAttribute('data-index'), 10);
        if (!Number.isNaN(idx)) 
            modalByIndex[idx] = el;
    });

    const indices = Object.keys(modalByIndex)
        .map(Number)
        .sort((a, b) => a - b);

    let currentIndex = null;
    let switching = false;
    const backdrop = document.createElement('div');
    backdrop.className = 'modal-backdrop show';
    backdrop.style.display = 'none';
    document.body.appendChild(backdrop);
    const modalInstances = {};
    modals.forEach(el => {
        modalInstances[el.id] = new bootstrap.Modal(el, { backdrop: false });
    });
    modals.forEach(modal => {
        modal.addEventListener('shown.bs.modal', () => {
            backdrop.style.display = 'block';
            currentIndex = parseInt(modal.getAttribute('data-index'), 10);
            switching = false;
        });

        modal.addEventListener('hidden.bs.modal', () => {
            if (!switching) {
                currentIndex = null;
                backdrop.style.display = 'none';
            }
        });
    });
    document.addEventListener('keydown', e => {
        if (currentIndex === null || switching) return;
        if (e.key !== 'ArrowLeft' && e.key !== 'ArrowRight') return;

        const pos = indices.indexOf(currentIndex);
        if (pos === -1) return;

        const nextPos = (e.key === 'ArrowRight')
            ? (pos + 1) % indices.length
            : (pos - 1 + indices.length) % indices.length;

        const nextIndex = indices[nextPos];
        const currentEl = modalByIndex[currentIndex];
        const nextEl = modalByIndex[nextIndex];
        if (!currentEl || !nextEl) return;

        switching = true;

        const currentModal = modalInstances[currentEl.id];
        const nextModal = modalInstances[nextEl.id];

        currentEl.addEventListener('hidden.bs.modal', function handler() {
            currentEl.removeEventListener('hidden.bs.modal', handler);
            nextModal.show();
        });

        currentModal.hide();
    });

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

    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
});