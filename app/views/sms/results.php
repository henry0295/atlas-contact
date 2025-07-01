<?php 
$title = 'Resultados del Envío';
require_once APPROOT . '/views/layouts/header.php'; 
?>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Resultados del Envío de SMS</h3>
                            <a href="<?= BASE_URL ?>sms" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M9 13l-4 -4l4 -4m-4 4h11a4 4 0 0 1 0 8h-1" />
                                </svg>
                                Volver
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if(isset($data['results']) && !empty($data['results'])): ?>
                            <div class="table-responsive">
                                <table class="table table-vcenter">                                    <thead>
                                        <tr>
                                            <th>Número</th>
                                            <th>Campaña</th>
                                            <th>Estado</th>
                                            <th>Fecha de Envío</th>
                                            <th>Mensaje</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($data['results'] as $result): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($result['phone']) ?></td>
                                                <td>
                                                    <span class="badge bg-<?= $result['status'] === 'success' ? 'success' : 'danger' ?>">
                                                        <?= $result['status'] === 'success' ? 'Enviado' : 'Error' ?>
                                                    </span>
                                                </td>
                                                <td><?= htmlspecialchars($result['sent_at']) ?></td>
                                                <td><?= htmlspecialchars($result['message']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="empty">
                                <div class="empty-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M3 12h1m8 -9v1m8 8h1m-15.4 -6.4l.7 .7m12.1 -.7l-.7 .7" />
                                        <path d="M9 16h6" />
                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                    </svg>
                                </div>
                                <p class="empty-title">No hay resultados disponibles</p>
                                <p class="empty-subtitle text-muted">
                                    Intente enviar algunos mensajes primero.
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once APPROOT . '/views/layouts/footer.php'; ?>
