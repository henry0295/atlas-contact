<?php 
$title = 'Envío Masivo de SMS';
require_once APPROOT . '/views/layouts/header.php'; 
?>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Envío Masivo de SMS</h3>
                    </div>
                    <div class="card-body">
                        <?php if(isset($data['errors']) && !empty($data['errors'])): ?>
                            <div class="alert alert-danger">
                                <?php foreach($data['errors'] as $error): ?>
                                    <div><?= $error ?></div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if(isset($data['success'])): ?>
                            <div class="alert alert-success">
                                <?= $data['success'] ?>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" action="<?= BASE_URL ?>sms/bulk" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Nombre de la campaña</label>
                                <input type="text" class="form-control" name="campaign" placeholder="Ej: Promoción_Masiva_Enero_2025" value="<?= $data['post']['campaign'] ?? '' ?>">
                                <div class="form-text">Opcional. Si no se especifica, se generará automáticamente.</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Archivo CSV con números de teléfono</label>
                                <input type="file" class="form-control" name="contacts" accept=".csv" required>
                                <div class="form-text">
                                    El archivo debe contener una columna 'phone' con los números de teléfono.
                                    <a href="<?= BASE_URL ?>public/assets/templates/phones_template.csv" download class="ms-2">
                                        <i class="fas fa-download"></i> Descargar plantilla
                                    </a>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mensaje</label>
                                <textarea class="form-control" name="message" rows="4" placeholder="Escriba su mensaje aquí" required><?= $data['post']['message'] ?? '' ?></textarea>
                                <div class="form-text">
                                    <span id="charCount">0</span>/160 caracteres
                                    <span id="partsInfo"></span>
                                </div>
                            </div>
                            <div class="form-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-upload me-1"></i>
                                    Enviar SMS Masivos
                                </button>
                                <a href="<?= BASE_URL ?>sms" class="btn btn-link">
                                    <i class="fas fa-arrow-left me-1"></i>
                                    Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const messageTextarea = document.querySelector('textarea[name="message"]');
    const charCount = document.getElementById('charCount');
    const partsInfo = document.getElementById('partsInfo');
    
    function updateCharCount() {
        const message = messageTextarea.value;
        const length = message.length;
        charCount.textContent = length;
        
        // Calcular número de partes
        let parts = 1;
        const containsSpecialChars = message.length !== new Blob([message]).size;
        
        if (containsSpecialChars) {
            // UTF-16: 67 caracteres por parte
            parts = Math.ceil(length / 67);
        } else {
            // GSM: 160 caracteres para 1 parte, 153 para múltiples partes
            if (length > 160) {
                parts = Math.ceil(length / 153);
            }
        }
        
        parts = Math.min(parts, 15); // Máximo 15 partes
        
        if (parts > 1) {
            partsInfo.textContent = ` (${parts} partes)`;
            partsInfo.className = 'text-warning ms-2';
        } else {
            partsInfo.textContent = '';
        }
        
        // Cambiar color según límite
        if (length > 160) {
            charCount.className = 'text-warning';
        } else if (length > 140) {
            charCount.className = 'text-warning';
        } else {
            charCount.className = 'text-muted';
        }
    }
    
    messageTextarea.addEventListener('input', updateCharCount);
    updateCharCount(); // Inicializar
});
</script>

<?php require_once APPROOT . '/views/layouts/footer.php'; ?>
