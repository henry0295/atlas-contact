<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $data['title'] ?? 'Contact Center' ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Tabler CSS para algunos estilos adicionales -->
    <link href="https://cdn.jsdelivr.net/npm/tabler@latest/dist/css/tabler.min.css" rel="stylesheet">
    <style>
        /* Asegurar que el contenido se vea correctamente en cualquier zoom */
        html, body {
            font-size: 16px;
            min-width: 320px;
        }
        
        /* Estilos para dropdowns */
        .dropdown-menu {
            border: 1px solid #dee2e6;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border-radius: 0.375rem;
            min-width: 200px;
        }
        .dropdown-item {
            padding: 0.5rem 1rem;
            transition: background-color 0.15s ease-in-out;
            font-size: 0.875rem;
        }
        .dropdown-item:hover, .dropdown-item:focus {
            background-color: #e9ecef;
            color: #212529;
        }
        .dropdown-divider {
            margin: 0.5rem 0;
            border-color: #dee2e6;
        }
        .navbar-nav .dropdown-toggle::after {
            margin-left: 0.5rem;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container-fluid {
                padding-left: 15px;
                padding-right: 15px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= BASE_URL ?>">
                <i class="fas fa-headset me-2"></i>Contact Center
            </a>
            
            <?php if(isset($_SESSION['user_id'])): ?>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>home">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>
                    
                    <!-- Dropdown SMS -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="smsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-sms me-1"></i>SMS
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="smsDropdown">
                            <li>
                                <a class="dropdown-item" href="<?= BASE_URL ?>sms">
                                    <i class="fas fa-home me-2"></i>Panel SMS
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="<?= BASE_URL ?>sms/send">
                                    <i class="fas fa-paper-plane me-2"></i>Enviar SMS
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= BASE_URL ?>sms/bulk">
                                    <i class="fas fa-upload me-2"></i>Envío Masivo
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="<?= BASE_URL ?>sms/logs">
                                    <i class="fas fa-history me-2"></i>Historial
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= BASE_URL ?>sms/results">
                                    <i class="fas fa-chart-bar me-2"></i>Resultados
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Dropdown Email -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="emailDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-envelope me-1"></i>Email
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="emailDropdown">
                            <li>
                                <a class="dropdown-item" href="<?= BASE_URL ?>email">
                                    <i class="fas fa-home me-2"></i>Panel Email
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="<?= BASE_URL ?>email/send">
                                    <i class="fas fa-paper-plane me-2"></i>Enviar Email
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= BASE_URL ?>email/bulk">
                                    <i class="fas fa-upload me-2"></i>Envío Masivo
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="<?= BASE_URL ?>email/logs">
                                    <i class="fas fa-file-alt me-2"></i>Logs
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= BASE_URL ?>email/results">
                                    <i class="fas fa-chart-bar me-2"></i>Resultados
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Dropdown Audio -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="audioDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-volume-up me-1"></i>Audio
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="audioDropdown">
                            <li>
                                <a class="dropdown-item" href="<?= BASE_URL ?>audio">
                                    <i class="fas fa-home me-2"></i>Panel Audio
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="<?= BASE_URL ?>audio/send">
                                    <i class="fas fa-phone me-2"></i>Enviar Audio
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= BASE_URL ?>audio/bulk">
                                    <i class="fas fa-upload me-2"></i>Envío Masivo
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="<?= BASE_URL ?>audio/logs">
                                    <i class="fas fa-history me-2"></i>Historial
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= BASE_URL ?>audio/results">
                                    <i class="fas fa-chart-bar me-2"></i>Resultados
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>reports">
                            <i class="fas fa-chart-line me-1"></i>Reportes
                        </a>
                    </li>
                </ul>
                
                <!-- Usuario y cerrar sesión -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="navbar-text">
                            <i class="fas fa-user me-1"></i>Bienvenido, <?= $_SESSION['username'] ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>auth/logout">
                            <i class="fas fa-sign-out-alt me-1"></i>Cerrar Sesión
                        </a>
                    </li>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    </nav>

    <div class="container-fluid py-4">

