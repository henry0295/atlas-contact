<?php require APPROOT . '/views/includes/header.php'; ?>

<div class="page-body">
    <div class="container-xl">
        <!-- Filtros de fecha -->
        <div class="card mb-3">
            <div class="card-body">
                <form method="get" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Fecha Inicio</label>
                        <input type="date" class="form-control" name="start_date" value="<?= $data['startDate'] ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Fecha Fin</label>
                        <input type="date" class="form-control" name="end_date" value="<?= $data['endDate'] ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-primary">Filtrar</button>
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    Exportar
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="<?= URLROOT ?>/reports/export?type=email&format=excel&start_date=<?= $data['startDate'] ?>&end_date=<?= $data['endDate'] ?>">
                                        Excel
                                    </a>
                                    <a class="dropdown-item" href="<?= URLROOT ?>/reports/export?type=email&format=csv&start_date=<?= $data['startDate'] ?>&end_date=<?= $data['endDate'] ?>">
                                        CSV
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="row row-deck row-cards mb-3">
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Total Correos</div>
                        </div>
                        <div class="h1"><?= number_format($data['stats']['total']) ?></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Entregados</div>
                        </div>
                        <div class="h1 text-success"><?= number_format($data['stats']['success']) ?></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Fallidos</div>
                        </div>
                        <div class="h1 text-danger"><?= number_format($data['stats']['failed']) ?></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Tasa de Entrega</div>
                        </div>
                        <div class="h1">
                            <?= number_format(($data['stats']['success'] / max($data['stats']['total'], 1)) * 100, 1) ?>%
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico -->
        <div class="card mb-3">
            <div class="card-body">
                <h3 class="card-title">Actividad Diaria</h3>
                <div id="chart-email-activity" style="height: 300px;"></div>
            </div>
        </div>

        <!-- Tabla de logs -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Registro de Envíos</h3>
            </div>
            <div class="table-responsive">
                <table class="table card-table table-vcenter">
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
                        <?php foreach ($data['logs'] as $log): ?>
                        <tr>
                            <td><?= date('d/m/Y H:i', strtotime($log->created_at)) ?></td>
                            <td><?= $log->email ?></td>
                            <td><?= htmlspecialchars($log->subject) ?></td>
                            <td>
                                <span class="badge bg-<?= $log->status === 'success' ? 'success' : 'danger' ?>">
                                    <?= $log->status ?>
                                </span>
                            </td>
                            <td><?= $log->details ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var data = <?= json_encode($data['stats']['daily']) ?>;
    
    var options = {
        chart: {
            type: 'area',
            height: 300,
            toolbar: {
                show: true
            }
        },
        series: [{
            name: 'Total',
            data: data.map(d => d.total)
        }, {
            name: 'Entregados',
            data: data.map(d => d.success)
        }, {
            name: 'Fallidos',
            data: data.map(d => d.failed)
        }],
        xaxis: {
            categories: data.map(d => d.date),
            type: 'datetime'
        },
        yaxis: {
            title: {
                text: 'Cantidad de Correos'
            }
        },
        colors: ['#206bc4', '#2fb344', '#d63939'],
        stroke: {
            curve: 'smooth'
        },
        fill: {
            type: 'gradient',
            gradient: {
                opacityFrom: 0.6,
                opacityTo: 0.1
            }
        },
        tooltip: {
            y: {
                formatter: function(value) {
                    return value + " correos";
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart-email-activity"), options);
    chart.render();
});
</script>

<?php require APPROOT . '/views/includes/footer.php'; ?>
