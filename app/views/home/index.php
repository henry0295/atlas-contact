<?php 
$title = 'Dashboard - Contact Center';
require_once APPROOT . '/views/layouts/header.php'; 
?>

<div class="container-fluid py-4">
    <!-- Header del Dashboard -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-0">Panel de Control</h2>
                            <p class="mb-0 opacity-75">Bienvenido al sistema de gestión de comunicaciones</p>
                        </div>
                        <div class="text-end">
                            <h4 class="mb-0"><?= date('d/m/Y') ?></h4>
                            <small><?= date('H:i') ?></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas Generales -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Mensajes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($data['stats']['totals']['total_messages']) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Exitosos</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($data['stats']['totals']['total_success']) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Fallidos</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($data['stats']['totals']['total_failed']) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasa de Éxito</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php 
                                $successRate = $data['stats']['totals']['total_messages'] > 0 
                                    ? round(($data['stats']['totals']['total_success'] / $data['stats']['totals']['total_messages']) * 100, 1) 
                                    : 0;
                                echo $successRate . '%';
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-percentage fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Módulos de Comunicación -->
    <div class="row">
        <!-- SMS Module -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex align-items-center">
                    <i class="fas fa-sms me-2"></i>
                    <h5 class="mb-0">SMS</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="mb-2">
                                <strong><?= number_format($data['stats']['sms']['total']) ?></strong>
                            </div>
                            <small class="text-muted">Total</small>
                        </div>
                        <div class="col-4">
                            <div class="mb-2 text-success">
                                <strong><?= number_format($data['stats']['sms']['success']) ?></strong>
                            </div>
                            <small class="text-muted">Exitosos</small>
                        </div>
                        <div class="col-4">
                            <div class="mb-2 text-danger">
                                <strong><?= number_format($data['stats']['sms']['failed']) ?></strong>
                            </div>
                            <small class="text-muted">Fallidos</small>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center">
                        <small class="text-muted">Hoy: <strong><?= number_format($data['stats']['sms']['today']) ?></strong></small>
                    </div>
                    <div class="d-grid gap-2 mt-3">
                        <a href="<?= URLROOT ?>/sms/send" class="btn btn-primary btn-sm">Enviar SMS</a>
                        <a href="<?= URLROOT ?>/sms/bulk" class="btn btn-outline-primary btn-sm">Envío Masivo</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Email Module -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-header bg-success text-white d-flex align-items-center">
                    <i class="fas fa-envelope me-2"></i>
                    <h5 class="mb-0">Email</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="mb-2">
                                <strong><?= number_format($data['stats']['email']['total']) ?></strong>
                            </div>
                            <small class="text-muted">Total</small>
                        </div>
                        <div class="col-4">
                            <div class="mb-2 text-success">
                                <strong><?= number_format($data['stats']['email']['success']) ?></strong>
                            </div>
                            <small class="text-muted">Enviados</small>
                        </div>
                        <div class="col-4">
                            <div class="mb-2 text-danger">
                                <strong><?= number_format($data['stats']['email']['failed']) ?></strong>
                            </div>
                            <small class="text-muted">Fallidos</small>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center">
                        <small class="text-muted">Hoy: <strong><?= number_format($data['stats']['email']['today']) ?></strong></small>
                    </div>
                    <div class="d-grid gap-2 mt-3">
                        <a href="<?= URLROOT ?>/email/send" class="btn btn-success btn-sm">Enviar Email</a>
                        <a href="<?= URLROOT ?>/email/bulk" class="btn btn-outline-success btn-sm">Envío Masivo</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Audio Module -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-header bg-info text-white d-flex align-items-center">
                    <i class="fas fa-volume-up me-2"></i>
                    <h5 class="mb-0">Audio</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="mb-2">
                                <strong><?= number_format($data['stats']['audio']['total']) ?></strong>
                            </div>
                            <small class="text-muted">Total</small>
                        </div>
                        <div class="col-4">
                            <div class="mb-2 text-success">
                                <strong><?= number_format($data['stats']['audio']['success']) ?></strong>
                            </div>
                            <small class="text-muted">Exitosos</small>
                        </div>
                        <div class="col-4">
                            <div class="mb-2 text-danger">
                                <strong><?= number_format($data['stats']['audio']['failed']) ?></strong>
                            </div>
                            <small class="text-muted">Fallidos</small>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center">
                        <small class="text-muted">Hoy: <strong><?= number_format($data['stats']['audio']['today']) ?></strong></small>
                    </div>
                    <div class="d-grid gap-2 mt-3">
                        <a href="<?= URLROOT ?>/audio/send" class="btn btn-info btn-sm">Enviar Audio</a>
                        <a href="<?= URLROOT ?>/audio/bulk" class="btn btn-outline-info btn-sm">Envío Masivo</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accesos Rápidos -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">Accesos Rápidos</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="<?= URLROOT ?>/sms/results" class="btn btn-outline-primary w-100">
                                <i class="fas fa-chart-line me-2"></i>
                                Reportes SMS
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?= URLROOT ?>/email/logs" class="btn btn-outline-success w-100">
                                <i class="fas fa-file-alt me-2"></i>
                                Logs Email
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?= URLROOT ?>/audio/logs" class="btn btn-outline-info w-100">
                                <i class="fas fa-history me-2"></i>
                                Historial Audio
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?= URLROOT ?>/auth/logout" class="btn btn-outline-danger w-100">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                Cerrar Sesión
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-danger {
    border-left: 0.25rem solid #e74a3b !important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}
.text-xs {
    font-size: 0.7rem;
}
.shadow {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}
</style>

<?php require_once APPROOT . '/views/layouts/footer.php'; ?>
