<?php require APPROOT . '/views/includes/header.php'; ?>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <!-- Resumen de SMS -->
            <div class="col-sm-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">SMS</div>
                        </div>
                        <div class="h1 mb-3"><?= number_format($data['stats']['sms']['total']) ?></div>
                        <div class="d-flex mb-2">
                            <div>Tasa de entrega</div>
                            <div class="ms-auto">
                                <span class="text-success d-inline-flex align-items-center lh-1">
                                    <?= number_format(($data['stats']['sms']['success'] / max($data['stats']['sms']['total'], 1)) * 100, 1) ?>%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Resumen de Email -->
            <div class="col-sm-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Correos</div>
                        </div>
                        <div class="h1 mb-3"><?= number_format($data['stats']['email']['total']) ?></div>
                        <div class="d-flex mb-2">
                            <div>Tasa de entrega</div>
                            <div class="ms-auto">
                                <span class="text-success d-inline-flex align-items-center lh-1">
                                    <?= number_format(($data['stats']['email']['success'] / max($data['stats']['email']['total'], 1)) * 100, 1) ?>%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Resumen de Audio -->
            <div class="col-sm-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Llamadas</div>
                        </div>
                        <div class="h1 mb-3"><?= number_format($data['stats']['audio']['total']) ?></div>
                        <div class="d-flex mb-2">
                            <div>Tasa de éxito</div>
                            <div class="ms-auto">
                                <span class="text-success d-inline-flex align-items-center lh-1">
                                    <?= number_format(($data['stats']['audio']['success'] / max($data['stats']['audio']['total'], 1)) * 100, 1) ?>%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráfico de actividad -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Actividad General</h3>
                        <div id="chart-activity" style="height: 300px;"></div>
                    </div>
                </div>
            </div>

            <!-- Actividad Reciente -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Actividad Reciente</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table card-table table-vcenter">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Tipo</th>
                                    <th>Destinatario</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['recentActivity'] as $activity): ?>
                                <tr>
                                    <td><?= date('d/m/Y H:i', strtotime($activity['created_at'])) ?></td>
                                    <td><?= ucfirst($activity['type']) ?></td>
                                    <td><?= $activity['recipient'] ?></td>
                                    <td>
                                        <span class="badge bg-<?= $activity['status'] === 'success' ? 'success' : 'danger' ?>">
                                            <?= $activity['status'] ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Datos para el gráfico
    var data = <?= json_encode($data['stats']['daily']) ?>;
    
    // Configuración del gráfico
    var options = {
        chart: {
            type: 'line',
            height: 300
        },
        series: [{
            name: 'SMS',
            data: data.map(d => d.sms)
        }, {
            name: 'Correos',
            data: data.map(d => d.email)
        }, {
            name: 'Llamadas',
            data: data.map(d => d.audio)
        }],
        xaxis: {
            categories: data.map(d => d.date),
            type: 'datetime'
        },
        yaxis: {
            title: {
                text: 'Cantidad de envíos'
            }
        },
        stroke: {
            curve: 'smooth'
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart-activity"), options);
    chart.render();
});
</script>

<?php require APPROOT . '/views/includes/footer.php'; ?>
