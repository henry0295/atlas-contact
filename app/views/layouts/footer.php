    </div>

    <!-- jQuery (opcional, pero ayuda con compatibilidad) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap Bundle JS (incluye Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Tabler JS -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>
    
    <!-- Scripts personalizados para dropdowns -->
    <script>
        // Asegurar que los dropdowns funcionen
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM cargado, inicializando dropdowns...');
            
            // Verificar que Bootstrap esté disponible
            if (typeof bootstrap !== 'undefined') {
                console.log('Bootstrap detectado, inicializando dropdowns...');
                
                // Inicializar todos los dropdowns
                var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
                console.log('Encontrados ' + dropdownElementList.length + ' dropdowns');
                
                var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                    return new bootstrap.Dropdown(dropdownToggleEl, {
                        boundary: 'viewport'
                    });
                });
                
                console.log('Dropdowns inicializados:', dropdownList.length);
            } else {
                console.error('Bootstrap no está disponible!');
            }
            
            // Fallback: agregar event listeners manuales
            document.querySelectorAll('.dropdown-toggle').forEach(function(dropdown) {
                dropdown.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Click en dropdown:', this.id);
                    
                    var menu = this.nextElementSibling;
                    if (menu && menu.classList.contains('dropdown-menu')) {
                        // Toggle la visibilidad del menú
                        if (menu.style.display === 'block') {
                            menu.style.display = 'none';
                        } else {
                            // Cerrar otros menús abiertos
                            document.querySelectorAll('.dropdown-menu').forEach(function(m) {
                                m.style.display = 'none';
                            });
                            menu.style.display = 'block';
                        }
                    }
                });
            });
            
            // Cerrar menús al hacer click fuera
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.dropdown')) {
                    document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                        menu.style.display = 'none';
                    });
                }
            });
        });
    </script>
</body>
</html>
