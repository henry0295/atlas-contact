<?php require_once APPROOT . '/views/layouts/header.php'; ?>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Envío Masivo de Correos</h3>
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
                        
                        <form method="POST" action="<?= BASE_URL ?>email/bulk" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Archivo CSV con Destinatarios</label>
                                <input type="file" class="form-control" name="csv_file" accept=".csv" required>
                                <div class="form-text">
                                    El archivo CSV debe contener una columna con los correos electrónicos.
                                    <a href="<?= BASE_URL ?>assets/templates/emails_template.csv" download>Descargar plantilla</a>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Asunto</label>
                                <input type="text" class="form-control" name="subject" placeholder="Asunto del correo" value="<?= $data['post']['subject'] ?? '' ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Mensaje</label>
                                <textarea id="email-content" class="form-control" name="message" rows="10" required><?= $data['post']['message'] ?? '' ?></textarea>
                            </div>

                            <div class="form-footer">
                                <button type="submit" class="btn btn-primary">Enviar Correos</button>
                                <a href="<?= BASE_URL ?>email" class="btn btn-link">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Editor TinyMCE -->
<script src="https://cdn.tiny.cloud/1/m9e1oozk2qrnk83wa0hbwp9w9l4u6gck7d5zllcn8bslzwok/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
    selector: '#email-content',
    language: 'es',
    height: 400,
    menubar: true,
    plugins: [
        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
        'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
        'insertdatetime', 'media', 'table', 'help', 'wordcount'
    ],
    toolbar: 'undo redo | styles | bold italic forecolor backcolor | ' +
            'alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist outdent indent | removeformat | help',
    content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; }',
    branding: false,
    promotion: false,
    setup: function (editor) {
        editor.on('change', function () {
            editor.save();
        });
    }
});
</script>

<?php require_once APPROOT . '/views/layouts/footer.php'; ?>
