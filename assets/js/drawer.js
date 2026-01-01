document.addEventListener('DOMContentLoaded', () => {

    const drawer = document.getElementById('sidebar');
    if (!drawer) return;

    const dialog = drawer.querySelector('.modal-dialog');
    const ANIMATION_TIME = 300;

    // estado inicial
    dialog.style.transform = 'translateX(-100%)';

    // antes de abrir
    drawer.addEventListener('show.bs.modal', () => {
        dialog.style.transform = 'translateX(-100%)';
    });

    // abriu → anima para dentro
    drawer.addEventListener('shown.bs.modal', () => {
        dialog.getBoundingClientRect(); // força repaint
        dialog.style.transform = 'translateX(0)';
    });

    // começou a fechar → anima para fora
    drawer.addEventListener('hide.bs.modal', () => {
        dialog.style.transform = 'translateX(-100%)';
    });

    // terminou de fechar → LIMPA TUDO
    drawer.addEventListener('hidden.bs.modal', () => {
        // garante estado limpo
        dialog.style.transform = 'translateX(-100%)';
    });

});
