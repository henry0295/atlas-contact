<?php
$title = 'Gestión de SMS';
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
                    <i class="fas fa-sms me-2"></i>
                    Gestión de SMS
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
                                    Enviar SMS
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
                            <!-- Pestaña Enviar SMS -->
                            <div class="tab-pane active show" id="tabs-send" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h3 class="mb-3">Enviar SMS Individual</h3>
                                        <p class="text-muted">Envía mensajes de texto a un número específico.</p>
                                        
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h4>Características:</h4>
                                                        <ul class="list-unstyled">
                                                            <li><i class="fas fa-check text-success me-2"></i>Envío inmediato</li>
                                                            <li><i class="fas fa-check text-success me-2"></i>Formato automático de números</li>
                                                            <li><i class="fas fa-check text-success me-2"></i>Validación de contenido</li>
                                                            <li><i class="fas fa-check text-success me-2"></i>Seguimiento de estado</li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h4>Especificaciones:</h4>
                                                        <ul class="list-unstyled">
                                                            <li><strong>Longitud máxima:</strong> 160 caracteres</li>
                                                            <li><strong>Codificación:</strong> UTF-8</li>
                                                            <li><strong>Formato número:</strong> 57XXXXXXXXXX</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <a href="<?= URLROOT ?>/sms/send" class="btn btn-primary btn-lg">
                                                <i class="fas fa-paper-plane me-2"></i>
                                                Comenzar Envío
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border-primary">
                                            <div class="card-status-top bg-primary"></div>
                                            <div class="card-body text-center">
                                                <div class="avatar avatar-xl bg-primary-lt mb-3 mx-auto">
                                                    <i class="fas fa-mobile-alt fa-2x"></i>
                                                </div>
                                                <h3>Envío Rápido</h3>
                                                <p class="text-muted">Perfecto para notificaciones urgentes o mensajes personalizados.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pestaña Envío Masivo -->
                            <div class="tab-pane" id="tabs-bulk" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h3 class="mb-3">Envío Masivo de SMS</h3>
                                        <p class="text-muted">Envía el mismo mensaje a múltiples destinatarios usando un archivo CSV.</p>
                                        
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h4>Proceso:</h4>
                                                        <ol class="list-unstyled">
                                                            <li><i class="fas fa-download text-info me-2"></i>1. Descargar plantilla CSV</li>
                                                            <li><i class="fas fa-edit text-warning me-2"></i>2. Completar con números</li>
                                                            <li><i class="fas fa-upload text-primary me-2"></i>3. Subir archivo</li>
                                                            <li><i class="fas fa-paper-plane text-success me-2"></i>4. Enviar mensajes</li>
                                                        </ol>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h4>Requisitos:</h4>
                                                        <ul class="list-unstyled">
                                                            <li><strong>Formato:</strong> .CSV</li>
                                                            <li><strong>Encoding:</strong> UTF-8</li>
                                                            <li><strong>Columna:</strong> phone</li>
                                                            <li><strong>Máximo:</strong> 1000 números</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                
                                                <div class="mt-3">
                                                    <a href="<?= URLROOT ?>/public/assets/templates/phones_template.csv" class="btn btn-outline-info" download>
                                                        <i class="fas fa-download me-2"></i>
                                                        Descargar Plantilla CSV
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <a href="<?= URLROOT ?>/sms/bulk" class="btn btn-success btn-lg">
                                                <i class="fas fa-upload me-2"></i>
                                                Iniciar Envío Masivo
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border-success">
                                            <div class="card-status-top bg-success"></div>
                                            <div class="card-body text-center">
                                                <div class="avatar avatar-xl bg-success-lt mb-3 mx-auto">
                                                    <i class="fas fa-users fa-2x"></i>
                                                </div>
                                                <h3>Alcance Masivo</h3>
                                                <p class="text-muted">Ideal para campañas publicitarias, alertas masivas o comunicados.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pestaña Resultados -->
                            <div class="tab-pane" id="tabs-results" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h3 class="mb-3">Historial y Resultados</h3>
                                        <p class="text-muted">Consulta el historial de envíos, estados de entrega y estadísticas.</p>
                                        
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar bg-primary-lt me-3">
                                                                <i class="fas fa-list"></i>
                                                            </div>
                                                            <div>
                                                                <h4 class="mb-1">Historial Completo</h4>
                                                                <p class="text-muted mb-0">Ver todos los envíos realizados</p>
                                                            </div>
                                                        </div>
                                                        <div class="mt-3">
                                                            <a href="<?= URLROOT ?>/sms/results" class="btn btn-outline-primary">
                                                                Ver Historial
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
                                                                <i class="fas fa-chart-line"></i>
                                                            </div>
                                                            <div>
                                                                <h4 class="mb-1">Estadísticas</h4>
                                                                <p class="text-muted mb-0">Métricas de rendimiento</p>
                                                            </div>
                                                        </div>
                                                        <div class="mt-3">
                                                            <a href="<?= URLROOT ?>/sms/stats" class="btn btn-outline-info">
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
                                                    <i class="fas fa-analytics fa-2x"></i>
                                                </div>
                                                <h3>Seguimiento</h3>
                                                <p class="text-muted">Monitorea el rendimiento de tus campañas SMS.</p>
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
