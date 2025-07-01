<?php require_once APPROOT . '/views/layouts/header.php'; ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Enviar Mensaje de Voz</h3>
    </div>
    <div class="card-body">
        <?php if(isset($data['errors'])): ?>
            <?php foreach($data['errors'] as $error): ?>
                <div class="alert alert-danger">
                    <?= $error ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if(isset($data['success'])): ?>
            <div class="alert alert-success">
                <?= $data['success'] ?>
            </div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>audio/send" method="POST">
            <div class="mb-3">
                <label class="form-label">Nombre de la campaña</label>
                <input type="text" name="campaign" class="form-control" 
                       placeholder="Ej: Recordatorio_Citas_Enero" 
                       value="<?= $data['data']['campaign'] ?? '' ?>">
                <div class="form-text">Opcional. Si no se especifica, se generará automáticamente.</div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Número de teléfono</label>
                <input type="text" name="recipient" class="form-control" 
                       placeholder="Ejemplo: +573101234567" required
                       value="<?= $data['data']['recipient'] ?? '' ?>">
                <div class="form-text">Formato: +57 seguido del número (ej: +573001234567)</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Mensaje</label>
                <textarea name="message" class="form-control" rows="4" 
                          placeholder="Escribe el mensaje que será convertido a voz..." required><?= $data['data']['message'] ?? '' ?></textarea>
                <div class="form-text">El mensaje será convertido a audio y enviado al número especificado.</div>
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
                <button type="submit" class="btn btn-primary">Enviar Mensaje de Voz</button>
                <a href="<?= BASE_URL ?>audio/bulk" class="btn btn-secondary">Envío Masivo</a>
            </div>
        </form>
    </div>
</div>

<?php require_once APPROOT . '/views/layouts/footer.php'; ?>
