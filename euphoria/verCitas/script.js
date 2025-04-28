function toggleCita(clienteDiv) {
    const detalles = clienteDiv.querySelector('.detalles');
    const isVisible = detalles.style.display === 'block';
    detalles.style.display = isVisible ? 'none' : 'block';
}
