<?php require_once APPROOT . '/views/layouts/header.php'; ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Envío Masivo de Mensajes de Voz</h3>
    </div>
    <div class="card-body">
        <?php if(isset($data['errors'])): ?>
            <?php foreach($data['errors'] as $error): ?>
                <div class="alert alert-danger">
                    <?= $error ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>        <form action="<?= BASE_URL ?>audio/bulk" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Archivo CSV con Números de Teléfono</label>
                <input type="file" name="csv_file" class="form-control" accept=".csv" required>
                <div class="form-text">
                    El archivo CSV debe contener una columna con los números telefónicos.
                    <a href="<?= BASE_URL ?>assets/templates/phones_template.csv" download>Descargar plantilla</a>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Mensaje</label>
                <textarea name="message" class="form-control" rows="4" 
                          placeholder="Escribe el mensaje que será convertido a voz..." required><?= $data['data']['message'] ?? '' ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Género de la voz</label>
                        <select name="gender" class="form-select">
                            <option value="F" <?= (($data['data']['gender'] ?? 'F') === 'F') ? 'selected' : '' ?>>Femenino</option>
                            <option value="M" <?= (($data['data']['gender'] ?? '') === 'M') ? 'selected' : '' ?>>Masculino</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Idioma</label>
                        <select name="language" class="form-select">
                            <option value="es_ES" <?= (($data['data']['language'] ?? 'es_ES') === 'es_ES') ? 'selected' : '' ?>>Español (España)</option>
                            <option value="es_CO" <?= (($data['data']['language'] ?? '') === 'es_CO') ? 'selected' : '' ?>>Español (Colombia)</option>
                            <option value="en_US" <?= (($data['data']['language'] ?? '') === 'en_US') ? 'selected' : '' ?>>Inglés (USA)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Enviar Mensajes de Voz</button>
                <a href="<?= BASE_URL ?>audio/send" class="btn btn-secondary">Envío Individual</a>
            </div>
        </form>
    </div>
</div>

<?php require_once APPROOT . '/views/layouts/footer.php'; ?>
