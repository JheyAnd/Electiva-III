// Archivo: products.js

// Función para abrir el modal y cargar los datos del producto
function openModals(id) {
    const modal = document.getElementById('productModals');
    const form = document.getElementById('productForm');
    
    // Configurar la acción del formulario
    form.action = 'actualizar_descripcion.php';
    
    // Realizar una petición AJAX para obtener los datos del producto
    fetch(`obtener_producto.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            // Establecer el ID del producto en un campo oculto
            if (!document.getElementById('producto_id')) {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'producto_id';
                hiddenInput.id = 'producto_id';
                form.appendChild(hiddenInput);
            }
            document.getElementById('producto_id').value = id;
            
            // Establecer la descripción en el editor
            document.getElementById('editor').value = data.descripcion;
        });
    
    modal.style.display = 'block';
}

// Función para cerrar el modal
function closeModals() {
    const modal = document.getElementById('productModals');
    modal.style.display = 'none';
}

// Cerrar el modal si se hace clic fuera de él
window.onclick = function(event) {
    const modal = document.getElementById('productModals');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}