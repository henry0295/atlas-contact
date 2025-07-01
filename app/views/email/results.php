<?php require_once APPROOT . '/views/layouts/header.php'; ?>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-12">
                <?php if(isset($data['result']) && !empty($data['result'])): ?>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Resultado del Último Envío</h3>
                        </div>
                        <div class="card-body">
                            <?php if($data['result']['status'] === 'success'): ?>
                                <div class="alert alert-success">
                                    <h4>¡Envío Exitoso!</h4>
                                    <p><?= $data['result']['message'] ?></p>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-danger">
                                    <h4>Error en el Envío</h4>
                                    <p><?= $data['result']['message'] ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Historial de Envíos Recientes</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-vcenter table-bordered">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Destinatario</th>
                                        <th>Asunto</th>
                                        <th>Estado</th>
                                        <th>Detalles</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($data['logs'])): ?>
                                        <?php foreach($data['logs'] as $log): ?>
                                            <tr>
                                                <td><?= date('d/m/Y H:i', strtotime($log->created_at)) ?></td>
                                                <td><?= $log->recipient ?></td>
                                                <td><?= $log->subject ?></td>
                                                <td>
                                                    <?php if($log->status === 'sent'): ?>
                                                        <span class="badge bg-success">Enviado</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Error</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($log->error): ?>
                                                        <span class="text-danger"><?= $log->error ?></span>
                                                    <?php else: ?>
                                                        <span class="text-success">Enviado correctamente</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center">No hay registros para mostrar</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            <a href="<?= BASE_URL ?>email" class="btn btn-primary">
                                Volver
                            </a>
                            <a href="<?= BASE_URL ?>email/logs" class="btn btn-secondary">
                                Ver Historial Completo
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once APPROOT . '/views/layouts/footer.php'; ?>
