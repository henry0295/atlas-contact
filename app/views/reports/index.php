<?php include APPROOT . '/views/layouts/header.php'; ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-line me-2"></i>Reportes Generales
                </h3>
            </div>
            <div class="card-body">
                <!-- Estadísticas Generales -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-sms fa-2x me-3"></i>
                                    <div>
                                        <h5 class="card-title mb-1">SMS</h5>
                                        <div class="text-white-75">
                                            <div>Total: <?= $data['sms_stats']['total'] ?? 0 ?></div>
                                            <div>Exitosos: <?= $data['sms_stats']['success'] ?? 0 ?></div>
                                            <div>Hoy: <?= $data['sms_stats']['today'] ?? 0 ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-envelope fa-2x me-3"></i>
                                    <div>
                                        <h5 class="card-title mb-1">Email</h5>
                                        <div class="text-white-75">
                                            <div>Total: <?= $data['email_stats']['total'] ?? 0 ?></div>
                                            <div>Exitosos: <?= $data['email_stats']['success'] ?? 0 ?></div>
                                            <div>Hoy: <?= $data['email_stats']['today'] ?? 0 ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-volume-up fa-2x me-3"></i>
                                    <div>
                                        <h5 class="card-title mb-1">Audio</h5>
                                        <div class="text-white-75">
                                            <div>Total: <?= $data['audio_stats']['total'] ?? 0 ?></div>
                                            <div>Exitosos: <?= $data['audio_stats']['success'] ?? 0 ?></div>
                                            <div>Hoy: <?= $data['audio_stats']['today'] ?? 0 ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enlaces Rápidos -->
                <div class="row">
                    <div class="col-12">
                        <h5 class="mb-3">Acceso Rápido a Reportes Detallados</h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <i class="fas fa-sms fa-3x text-primary mb-3"></i>
                                <h6 class="card-title">Reportes SMS</h6>
                                <p class="card-text">Ver historial completo de mensajes SMS enviados</p>
                                <a href="<?= BASE_URL ?>sms/logs" class="btn btn-primary">Ver Logs SMS</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <i class="fas fa-envelope fa-3x text-success mb-3"></i>
                                <h6 class="card-title">Reportes Email</h6>
                                <p class="card-text">Ver historial completo de correos electrónicos</p>
                                <a href="<?= BASE_URL ?>email/logs" class="btn btn-success">Ver Logs Email</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <i class="fas fa-volume-up fa-3x text-info mb-3"></i>
                                <h6 class="card-title">Reportes Audio</h6>
                                <p class="card-text">Ver historial completo de mensajes de voz</p>
                                <a href="<?= BASE_URL ?>audio/logs" class="btn btn-info">Ver Logs Audio</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filtros de Fecha para Análisis Rápido -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">Análisis por Período</h6>
                            </div>
                            <div class="card-body">
                                <form method="GET">
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Fecha desde</label>
                                            <input type="date" class="form-control" name="date_from" value="<?= $_GET['date_from'] ?? '' ?>">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Fecha hasta</label>
                                            <input type="date" class="form-control" name="date_to" value="<?= $_GET['date_to'] ?? '' ?>">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Módulo</label>
                                            <select class="form-select" name="module">
                                                <option value="">Todos</option>
                                                <option value="sms" <?= ($_GET['module'] ?? '') == 'sms' ? 'selected' : '' ?>>SMS</option>
                                                <option value="email" <?= ($_GET['module'] ?? '') == 'email' ? 'selected' : '' ?>>Email</option>
                                                <option value="audio" <?= ($_GET['module'] ?? '') == 'audio' ? 'selected' : '' ?>>Audio</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">&nbsp;</label>
                                            <div>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-search me-1"></i>Generar Reporte
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include APPROOT . '/views/layouts/footer.php'; ?>
