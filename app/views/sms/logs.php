<?php include APPROOT . '/views/layouts/header.php'; ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-history me-2"></i>Historial de SMS
                </h3>
            </div>
            <div class="card-body">
                <!-- Filtros -->
                <form method="GET" class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label">Fecha desde</label>
                        <input type="date" class="form-control" name="date_from" value="<?= $_GET['date_from'] ?? '' ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Fecha hasta</label>
                        <input type="date" class="form-control" name="date_to" value="<?= $_GET['date_to'] ?? '' ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Estado</label>
                        <select class="form-select" name="status">
                            <option value="">Todos</option>
                            <option value="success" <?= ($_GET['status'] ?? '') == 'success' ? 'selected' : '' ?>>Enviado</option>
                            <option value="failed" <?= ($_GET['status'] ?? '') == 'failed' ? 'selected' : '' ?>>Fallido</option>
                            <option value="pending" <?= ($_GET['status'] ?? '') == 'pending' ? 'selected' : '' ?>>Pendiente</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Campaña</label>
                        <input type="text" class="form-control" name="campaign" value="<?= $_GET['campaign'] ?? '' ?>" placeholder="Nombre de campaña">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i>Filtrar
                        </button>
                        <a href="<?= BASE_URL ?>sms/logs" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i>Limpiar
                        </a>
                    </div>
                </form>

                <?php if (!empty($data['logs'])): ?>
                    <!-- Tabla de logs -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Teléfono</th>
                                    <th>Mensaje</th>
                                    <th>Campaña</th>
                                    <th>Estado</th>
                                    <th>Respuesta API</th>
                                    <th>Enviado en</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['logs'] as $log): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($log['id']) ?></td>
                                        <td><?= htmlspecialchars($log['phone']) ?></td>
                                        <td>
                                            <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?= htmlspecialchars($log['message']) ?>">
                                                <?= htmlspecialchars($log['message']) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if (!empty($log['campaign'])): ?>
                                                <span class="badge bg-info"><?= htmlspecialchars($log['campaign']) ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($log['status'] == 'success'): ?>
                                                <span class="badge bg-success">Enviado</span>
                                            <?php elseif ($log['status'] == 'failed'): ?>
                                                <span class="badge bg-danger">Fallido</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning">Pendiente</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($log['api_response'])): ?>
                                                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#responseModal<?= $log['id'] ?>">
                                                    Ver respuesta
                                                </button>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= date('d/m/Y H:i:s', strtotime($log['created_at'])) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <?php if ($data['total_pages'] > 1): ?>
                        <nav>
                            <ul class="pagination justify-content-center">
                                <?php for ($i = 1; $i <= $data['total_pages']; $i++): ?>
                                    <li class="page-item <?= $i == $data['current_page'] ? 'active' : '' ?>">
                                        <a class="page-link" href="?page=<?= $i ?><?= !empty($_GET) ? '&' . http_build_query(array_filter(array_diff_key($_GET, ['page' => '']))) : '' ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>

                    <!-- Modales para respuestas de API -->
                    <?php foreach ($data['logs'] as $log): ?>
                        <?php if (!empty($log['api_response'])): ?>
                            <div class="modal fade" id="responseModal<?= $log['id'] ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Respuesta API - Log <?= $log['id'] ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <pre><?= htmlspecialchars($log['api_response']) ?></pre>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>

                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        No se encontraron logs de SMS con los filtros aplicados.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include APPROOT . '/views/layouts/footer.php'; ?>
