<?php headerAdmin($data); ?>
<style>
.notification-btn {
    background-color: #f8f9fa;
    color: #495057;
    border: 1px solid #dee2e6;
    transition: all 0.3s ease;
    padding: 15px 30px;
}

.notification-btn:hover:not(:disabled) {
    background-color: #e9ecef;
    border-color: #ced4da;
    color: #212529;
}

.notification-btn:disabled {
    background-color: #e9ecef;
    border-color: #dee2e6;
    opacity: 0.7;
}

.notification-btn i {
    margin-right: 8px;
}

.info-section {
    background-color: #fff;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 20px;
    margin-top: 2rem;
}

.info-section h4 {
    color: #495057;
    font-size: 1.1rem;
    margin-bottom: 1rem;
}

.info-section ul {
    color: #6c757d;
}

.notification-status {
    padding: 10px;
    border-radius: 6px;
    margin-top: 1rem;
}

.notification-status.success {
    background-color: #d1e7dd;
    color: #0f5132;
    border: 1px solid #badbcc;
}

.notification-status.warning {
    background-color: #fff3cd;
    color: #856404;
    border: 1px solid #ffeeba;
}

.notification-status.info {
    background-color: #f8f9fa;
    color: #495057;
    border: 1px solid #e9ecef;
}

.notification-status.error {
    background-color: #f8d7da;
    color: #842029;
    border: 1px solid #f5c2c7;
}
</style>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-bell"></i> Notificaciones</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house"></i></li>
            <li class="breadcrumb-item"><a href="<?= base_url(); ?>/notificaciones">Notificaciones</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body text-center">
                    <div class="mb-4">
                        <button id="btnActivarNotificaciones" class="btn notification-btn">
                            <i class="fa fa-bell"></i> Activar Notificaciones del Navegador
                        </button>
                        <div id="estadoNotificaciones" class="mt-3"></div>
                    </div>
                    
                    <div class="info-section">
                        <h4><i class="fa fa-info-circle"></i> ¿Por qué activar las notificaciones?</h4>
                        <p class="text-muted">Al activar las notificaciones del navegador, podrás recibir alertas instantáneas sobre:</p>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fa fa-check me-2"></i> Nuevas tareas asignadas</li>
                            <li class="mb-2"><i class="fa fa-check me-2"></i> Actualizaciones importantes</li>
                            <li class="mb-2"><i class="fa fa-check me-2"></i> Recordatorios y fechas límite</li>
                            <li class="mb-2"><i class="fa fa-check me-2"></i> Y más...</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnActivarNotificaciones = document.getElementById('btnActivarNotificaciones');
    const estadoNotificaciones = document.getElementById('estadoNotificaciones');

    if (!('Notification' in window)) {
        btnActivarNotificaciones.disabled = true;
        mostrarEstado('warning', 'Tu navegador no soporta notificaciones.');
    } else {
        actualizarEstadoNotificaciones();
    }

    btnActivarNotificaciones.addEventListener('click', solicitarPermisoNotificaciones);

    function solicitarPermisoNotificaciones() {
        Notification.requestPermission()
            .then(function(permission) {
                actualizarEstadoNotificaciones();
                if (permission === 'granted') {
                    new Notification('¡Notificaciones activadas!', {
                        body: 'Ahora recibirás notificaciones importantes del sistema.',
                        icon: base_url + '/Assets/images/favicon.ico'
                    });
                }
            });
    }

    function actualizarEstadoNotificaciones() {
        switch(Notification.permission) {
            case 'granted':
                btnActivarNotificaciones.disabled = true;
                mostrarEstado('success', 'Las notificaciones están activadas.');
                break;
            case 'denied':
                btnActivarNotificaciones.disabled = true;
                mostrarEstado('error', 'Has bloqueado las notificaciones. Para activarlas, debes permitirlas en la configuración de tu navegador.');
                break;
            default:
                btnActivarNotificaciones.disabled = false;
                mostrarEstado('info', 'Haz clic en el botón para activar las notificaciones.');
        }
    }

    function mostrarEstado(tipo, mensaje) {
        estadoNotificaciones.innerHTML = `<div class="notification-status ${tipo}">${mensaje}</div>`;
    }
});
</script>

<?php footerAdmin($data); ?> 