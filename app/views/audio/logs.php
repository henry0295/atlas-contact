<?php 
$title = 'Registros de Mensajes de Voz';
require_once APPROOT . '/views/layouts/header.php'; 
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Registros de Mensajes de Voz</h3>
    </div>
    <div class="card-body">
        <?php if(!empty($data['logs'])): ?>
            <div class="table-responsive">
                <table class="table table-hover" id="logsTable">
                    <thead>
                        <tr>                            <th>Fecha</th>
                            <th>Número</th>
                            <th>Campaña</th>
                            <th>Mensaje</th>
                            <th>Estado</th>
                            <th>Respuesta</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['logs'] as $log): ?>
                            <tr>                                <td><?= date('Y-m-d H:i:s', strtotime($log->created_at)) ?></td>
                                <td><?= $log->recipient ?></td>
                                <td><?= htmlspecialchars($log->campaign) ?></td>
                                <td><?= htmlspecialchars($log->audio_file) ?></td>
                                <td>
                                    <?php if($log->status === 'success'): ?>
                                        <span class="badge bg-success">Exitoso</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Fallido</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info" 
                                            data-bs-toggle="modal" data-bs-target="#responseModal"
                                            data-response='<?= htmlspecialchars($log->response, ENT_QUOTES) ?>'>
                                        Ver Respuesta
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Modal para ver la respuesta -->
            <div class="modal fade" id="responseModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detalles de la Respuesta</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <pre><code id="responseDetails"></code></pre>
                        </div>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <div class="alert alert-info">
                No hay registros disponibles.
            </div>
        <?php endif; ?>

        <div class="mt-3">
            <a href="<?= BASE_URL ?>audio/send" class="btn btn-primary">Nuevo Mensaje de Voz</a>
            <a href="<?= BASE_URL ?>audio/bulk" class="btn btn-secondary">Envío Masivo</a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar DataTables
    $('#logsTable').DataTable({
        order: [[0, 'desc']],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        }
    });

    // Manejar el modal de respuesta
    const responseModal = document.getElementById('responseModal');
    responseModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const response = button.getAttribute('data-response');
        try {
            const formattedResponse = JSON.stringify(JSON.parse(response), null, 2);
            document.getElementById('responseDetails').textContent = formattedResponse;
        } catch (e) {
            document.getElementById('responseDetails').textContent = response;
        }
    });
});
</script>

<?php require_once APPROOT . '/views/layouts/footer.php'; ?>
