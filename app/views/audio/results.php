<?php require_once APPROOT . '/views/layouts/header.php'; ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Resultados del Envío de Mensajes de Voz</h3>
    </div>
    <div class="card-body">
        <?php if(isset($data['result'])): ?>
            <div class="alert alert-info">
                <h4>Resumen</h4>
                <p>Mensajes enviados exitosamente: <?= $data['result']['success'] ?? 0 ?></p>
                <p>Mensajes fallidos: <?= $data['result']['failed'] ?? 0 ?></p>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Número</th>
                            <th>Estado</th>
                            <th>Mensaje de Error</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($data['result']['results'])): ?>
                            <?php foreach($data['result']['results'] as $result): ?>
                                <tr>
                                    <td><?= $result['number'] ?? '' ?></td>
                                    <td>
                                        <?php if(($result['status'] ?? '') === 'success'): ?>
                                            <span class="badge bg-success">Exitoso</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Fallido</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $result['message'] ?? '' ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">
                No hay resultados disponibles.
            </div>
        <?php endif; ?>

        <div class="mt-3">
            <a href="<?= BASE_URL ?>audio/bulk" class="btn btn-primary">Nuevo Envío Masivo</a>
            <a href="<?= BASE_URL ?>audio/logs" class="btn btn-secondary">Ver Registros</a>
        </div>
    </div>
</div>

<?php require_once APPROOT . '/views/layouts/footer.php'; ?>
