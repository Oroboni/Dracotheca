// habilitar/desabilitar o input de suspensão
document.addEventListener('DOMContentLoaded', function() {
    var selectPenalidade = document.getElementById('penalidade');
    var diasInput = document.getElementById('dias');

    selectPenalidade.addEventListener('change', function() {
        if (this.value === 's') {
            diasInput.disabled = false;
        } else {
            diasInput.disabled = true;
        }
    });
});