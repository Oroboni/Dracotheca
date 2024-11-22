// /*
// *   @author Camila Inocencio
// *   @version 1.0    
// *   @file devolucao.js
// *   @description Javascript da tela devolucao.php.
// *   Habilitar/desabilitar o campo de input de dias (diasInput) com base na seleção feita em um dropdown (selectPenalidade).
// */

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