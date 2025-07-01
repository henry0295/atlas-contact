<?php 
$data['title'] = 'Iniciar Sesión';
require_once APPROOT . '/views/layouts/header.php'; 
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Iniciar Sesión</h3>
                </div>
                <div class="card-body">                    <?php if(isset($data['errors'])): ?>
                        <?php if(isset($data['errors']['system'])): ?>
                            <div class="alert alert-danger">
                                <?= $data['errors']['system'] ?>
                            </div>
                        <?php endif; ?>
                        <?php if(isset($data['errors']['login'])): ?>
                            <div class="alert alert-danger">
                                <?= $data['errors']['login'] ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <form action="<?= BASE_URL ?>auth/login" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Usuario</label>
                            <input type="text" name="username" class="form-control <?= isset($data['errors']['username']) ? 'is-invalid' : '' ?>" 
                                value="<?= htmlspecialchars($data['username'] ?? '') ?>" required>
                            <?php if(isset($data['errors']['username'])): ?>
                                <div class="invalid-feedback">
                                    <?= $data['errors']['username'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Contraseña</label>
                            <input type="password" name="password" class="form-control <?= isset($data['errors']['password']) ? 'is-invalid' : '' ?>" required>
                            <?php if(isset($data['errors']['password'])): ?>
                                <div class="invalid-feedback">
                                    <?= $data['errors']['password'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">
                                Iniciar Sesión
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once APPROOT . '/views/layouts/footer.php'; ?>
