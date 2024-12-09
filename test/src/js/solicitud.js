function validarFechas() {
    const inicio = new Date(document.getElementById('fecha-inicio').value);
    const fin = new Date(document.getElementById('fecha-fin').value);
    if (inicio > fin) {
        alert('La fecha de inicio no puede ser posterior a la fecha de fin.');
        return false;
    }
    return true;
}