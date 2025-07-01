<?php
$title = 'Gestión de Audio';
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
                    <i class="fas fa-volume-up me-2"></i>
                    Gestión de Audio
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
                                    <i class="fas fa-phone me-2"></i>
                                    Enviar Audio
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
                            <!-- Pestaña Enviar Audio -->
                            <div class="tab-pane active show" id="tabs-send" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h3 class="mb-3">Enviar Mensaje de Voz</h3>
                                        <p class="text-muted">Convierte texto a voz y envía mensajes de audio personalizados.</p>
                                        
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h4>Características:</h4>
                                                        <ul class="list-unstyled">
                                                            <li><i class="fas fa-check text-success me-2"></i>Conversión texto a voz</li>
                                                            <li><i class="fas fa-check text-success me-2"></i>Voces masculina/femenina</li>
                                                            <li><i class="fas fa-check text-success me-2"></i>Múltiples idiomas</li>
                                                            <li><i class="fas fa-check text-success me-2"></i>Llamada automática</li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h4>Opciones de Voz:</h4>
                                                        <ul class="list-unstyled">
                                                            <li><strong>Género:</strong> Masculino/Femenino</li>
                                                            <li><strong>Idiomas:</strong> ES, EN</li>
                                                            <li><strong>Duración:</strong> Máx. 5 minutos</li>
                                                            <li><strong>Formato:</strong> 57XXXXXXXXXX</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <a href="<?= URLROOT ?>/audio/send" class="btn btn-info btn-lg">
                                                <i class="fas fa-microphone me-2"></i>
                                                Crear Mensaje de Voz
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border-info">
                                            <div class="card-status-top bg-info"></div>
                                            <div class="card-body text-center">
                                                <div class="avatar avatar-xl bg-info-lt mb-3 mx-auto">
                                                    <i class="fas fa-phone-volume fa-2x"></i>
                                                </div>
                                                <h3>Voz Personalizada</h3>
                                                <p class="text-muted">Ideal para alertas importantes y comunicación directa.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pestaña Envío Masivo -->
                            <div class="tab-pane" id="tabs-bulk" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h3 class="mb-3">Campaña de Voz Masiva</h3>
                                        <p class="text-muted">Envía el mismo mensaje de voz a múltiples números telefónicos.</p>
                                        
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h4>Proceso:</h4>
                                                        <ol class="list-unstyled">
                                                            <li><i class="fas fa-download text-info me-2"></i>1. Descargar plantilla CSV</li>
                                                            <li><i class="fas fa-edit text-warning me-2"></i>2. Completar con teléfonos</li>
                                                            <li><i class="fas fa-upload text-primary me-2"></i>3. Subir archivo</li>
                                                            <li><i class="fas fa-phone text-success me-2"></i>4. Iniciar llamadas</li>
                                                        </ol>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h4>Requisitos:</h4>
                                                        <ul class="list-unstyled">
                                                            <li><strong>Formato:</strong> .CSV</li>
                                                            <li><strong>Encoding:</strong> UTF-8</li>
                                                            <li><strong>Columna:</strong> phone</li>
                                                            <li><strong>Máximo:</strong> 200 números</li>
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
                                            <a href="<?= URLROOT ?>/audio/bulk" class="btn btn-warning btn-lg">
                                                <i class="fas fa-broadcast-tower me-2"></i>
                                                Iniciar Campaña de Voz
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border-warning">
                                            <div class="card-status-top bg-warning"></div>
                                            <div class="card-body text-center">
                                                <div class="avatar avatar-xl bg-warning-lt mb-3 mx-auto">
                                                    <i class="fas fa-bullhorn fa-2x"></i>
                                                </div>
                                                <h3>Alcance Masivo</h3>
                                                <p class="text-muted">Perfecto para alertas de emergencia y comunicados urgentes.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pestaña Resultados -->
                            <div class="tab-pane" id="tabs-results" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h3 class="mb-3">Historial de Llamadas</h3>
                                        <p class="text-muted">Consulta el historial de llamadas, estados y logs detallados.</p>
                                        
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar bg-info-lt me-3">
                                                                <i class="fas fa-history"></i>
                                                            </div>
                                                            <div>
                                                                <h4 class="mb-1">Historial Completo</h4>
                                                                <p class="text-muted mb-0">Todas las llamadas realizadas</p>
                                                            </div>
                                                        </div>
                                                        <div class="mt-3">
                                                            <a href="<?= URLROOT ?>/audio/logs" class="btn btn-outline-info">
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
                                                            <div class="avatar bg-success-lt me-3">
                                                                <i class="fas fa-chart-area"></i>
                                                            </div>
                                                            <div>
                                                                <h4 class="mb-1">Estadísticas</h4>
                                                                <p class="text-muted mb-0">Métricas de conectividad</p>
                                                            </div>
                                                        </div>
                                                        <div class="mt-3">
                                                            <a href="<?= URLROOT ?>/audio/results" class="btn btn-outline-success">
                                                                Ver Estadísticas
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border-success">
                                            <div class="card-status-top bg-success"></div>
                                            <div class="card-body text-center">
                                                <div class="avatar avatar-xl bg-success-lt mb-3 mx-auto">
                                                    <i class="fas fa-phone-alt fa-2x"></i>
                                                </div>
                                                <h3>Seguimiento</h3>
                                                <p class="text-muted">Monitorea la efectividad de tus campañas de voz.</p>
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
