<?php
$title = 'Gestión de Email';
require_once APPROOT . '/views/layouts/header.php';
?>

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    Módulo de Comunicaciones
                </div>
                <h2 class="page-title">
                    <i class="fas fa-envelope me-2"></i>
                    Gestión de Email
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="<?= URLROOT ?>/home" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Volver al Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="#tabs-send" class="nav-link active" data-bs-toggle="tab" aria-selected="true" role="tab">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Enviar Email
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="#tabs-bulk" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab">
                                    <i class="fas fa-upload me-2"></i>
                                    Envío Masivo
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="#tabs-results" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab">
                                    <i class="fas fa-chart-bar me-2"></i>
                                    Resultados
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- Pestaña Enviar Email -->
                            <div class="tab-pane active show" id="tabs-send" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h3 class="mb-3">Enviar Email Individual</h3>
                                        <p class="text-muted">Envía correos electrónicos personalizados con editor HTML avanzado.</p>
                                        
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h4>Características:</h4>
                                                        <ul class="list-unstyled">
                                                            <li><i class="fas fa-check text-success me-2"></i>Editor HTML (TinyMCE)</li>
                                                            <li><i class="fas fa-check text-success me-2"></i>Formato rico de texto</li>
                                                            <li><i class="fas fa-check text-success me-2"></i>Validación de email</li>
                                                            <li><i class="fas fa-check text-success me-2"></i>Confirmación de entrega</li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h4>Especificaciones:</h4>
                                                        <ul class="list-unstyled">
                                                            <li><strong>Formato:</strong> HTML/Texto plano</li>
                                                            <li><strong>Codificación:</strong> UTF-8</li>
                                                            <li><strong>Tamaño máximo:</strong> 10MB</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <a href="<?= URLROOT ?>/email/send" class="btn btn-success btn-lg">
                                                <i class="fas fa-paper-plane me-2"></i>
                                                Comenzar Envío
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border-success">
                                            <div class="card-status-top bg-success"></div>
                                            <div class="card-body text-center">
                                                <div class="avatar avatar-xl bg-success-lt mb-3 mx-auto">
                                                    <i class="fas fa-at fa-2x"></i>
                                                </div>
                                                <h3>Email Profesional</h3>
                                                <p class="text-muted">Ideal para comunicaciones formales y contenido detallado.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pestaña Envío Masivo -->
                            <div class="tab-pane" id="tabs-bulk" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h3 class="mb-3">Envío Masivo de Emails</h3>
                                        <p class="text-muted">Envía el mismo mensaje a múltiples destinatarios usando un archivo CSV.</p>
                                        
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h4>Proceso:</h4>
                                                        <ol class="list-unstyled">
                                                            <li><i class="fas fa-download text-info me-2"></i>1. Descargar plantilla CSV</li>
                                                            <li><i class="fas fa-edit text-warning me-2"></i>2. Completar con emails</li>
                                                            <li><i class="fas fa-upload text-primary me-2"></i>3. Subir archivo</li>
                                                            <li><i class="fas fa-paper-plane text-success me-2"></i>4. Enviar emails</li>
                                                        </ol>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h4>Requisitos:</h4>
                                                        <ul class="list-unstyled">
                                                            <li><strong>Formato:</strong> .CSV</li>
                                                            <li><strong>Encoding:</strong> UTF-8</li>
                                                            <li><strong>Columna:</strong> email</li>
                                                            <li><strong>Máximo:</strong> 500 emails</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                
                                                <div class="mt-3">
                                                    <a href="<?= URLROOT ?>/public/assets/templates/emails_template.csv" class="btn btn-outline-info" download>
                                                        <i class="fas fa-download me-2"></i>
                                                        Descargar Plantilla CSV
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <a href="<?= URLROOT ?>/email/bulk" class="btn btn-primary btn-lg">
                                                <i class="fas fa-upload me-2"></i>
                                                Iniciar Envío Masivo
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border-primary">
                                            <div class="card-status-top bg-primary"></div>
                                            <div class="card-body text-center">
                                                <div class="avatar avatar-xl bg-primary-lt mb-3 mx-auto">
                                                    <i class="fas fa-mail-bulk fa-2x"></i>
                                                </div>
                                                <h3>Newsletter</h3>
                                                <p class="text-muted">Perfecto para boletines, promociones y comunicados masivos.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pestaña Resultados -->
                            <div class="tab-pane" id="tabs-results" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h3 class="mb-3">Historial y Logs</h3>
                                        <p class="text-muted">Consulta el historial de envíos, estados de entrega y logs detallados.</p>
                                        
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar bg-success-lt me-3">
                                                                <i class="fas fa-file-alt"></i>
                                                            </div>
                                                            <div>
                                                                <h4 class="mb-1">Logs Detallados</h4>
                                                                <p class="text-muted mb-0">Historial completo de envíos</p>
                                                            </div>
                                                        </div>
                                                        <div class="mt-3">
                                                            <a href="<?= URLROOT ?>/email/logs" class="btn btn-outline-success">
                                                                Ver Logs
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar bg-info-lt me-3">
                                                                <i class="fas fa-chart-pie"></i>
                                                            </div>
                                                            <div>
                                                                <h4 class="mb-1">Estadísticas</h4>
                                                                <p class="text-muted mb-0">Métricas de entrega</p>
                                                            </div>
                                                        </div>
                                                        <div class="mt-3">
                                                            <a href="<?= URLROOT ?>/email/results" class="btn btn-outline-info">
                                                                Ver Estadísticas
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border-info">
                                            <div class="card-status-top bg-info"></div>
                                            <div class="card-body text-center">
                                                <div class="avatar avatar-xl bg-info-lt mb-3 mx-auto">
                                                    <i class="fas fa-envelope-open-text fa-2x"></i>
                                                </div>
                                                <h3>Seguimiento</h3>
                                                <p class="text-muted">Monitorea la entrega y apertura de tus emails.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once APPROOT . '/views/layouts/footer.php'; ?>
