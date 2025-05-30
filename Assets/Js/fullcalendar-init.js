document.addEventListener('DOMContentLoaded', function() {
    // Inicializar calendario cuando se hace clic en la pestaña
    $('#calendario-tab').on('shown.bs.tab', function (e) {
        setTimeout(function() {
            initCalendar();
        }, 100);
    });
});

function initCalendar() {
    const calendarEl = document.getElementById('calendar');
    
    // Verificar si el elemento existe
    if (!calendarEl) {
        console.error('No se encontró el elemento calendar');
        return;
    }
    
    // Verificar si FullCalendar está disponible
    if (typeof FullCalendar === 'undefined') {
        console.error('FullCalendar no está cargado. Asegúrate de incluir la biblioteca.');
        calendarEl.innerHTML = '<div class="alert alert-danger">Error: La biblioteca FullCalendar no está disponible.</div>';
        return;
    }
    
    // Destruir instancia previa si existe
    if (window.calendar) {
        window.calendar.destroy();
    }
    
    // Crear nueva instancia
    window.calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        height: 'auto',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        events: {
            url: base_url+'/Tareas/getTareasCalendario',
            method: 'GET',
            failure: function() {
                swal("Error", "No se pudieron cargar las tareas en el calendario", "error");
            }
        },
        eventClick: function(info) {
            let idTarea = info.event.id;
            fntViewTarea(idTarea);
        },
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        },
        // Mejorar la visualización de eventos
        eventDidMount: function(info) {
            $(info.el).tooltip({
                title: info.event.title,
                placement: 'top',
                trigger: 'hover',
                container: 'body'
            });
        }
    });
    
    window.calendar.render();
}