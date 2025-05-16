<!-- FOOTER ORDENADO Y SIN DUPLICADOS -->
<script>
    const base_url = "<?= base_url(); ?>";
</script>

<!-- CORE JS Files (Bootstrap, Popper, jQuery) -->
<script src="<?= media(); ?>/js/jquery-3.7.0.min.js"></script>
<script src="<?= media(); ?>/js/core/popper.min.js"></script>
<script src="<?= media(); ?>/js/core/bootstrap.min.js"></script>

<!-- PLUGINS PRINCIPALES -->
<script src="<?= media(); ?>/js/plugins/perfect-scrollbar.min.js"></script>
<script src="<?= media(); ?>/js/plugins/smooth-scrollbar.min.js"></script>
<script src="<?= media(); ?>/js/plugins/chartjs.min.js"></script>
<script src="<?= media(); ?>/js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?=media();?>/js/selectpicker/picker.js"></script>

<!-- LIBRERÍAS EXTERNAS CDN (solo una vez cada una) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script async defer src="https://buttons.github.io/buttons.js"></script>

<!-- DATATABLES BUTTONS Y EXPORTACIÓN -->
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>

<!-- SCRIPTS PROPIOS Y DE LA PLANTILLA -->
<script src="<?= media(); ?>/js/soft-ui-dashboard.min.js?v=1.1.0"></script>
<script src="<?= media(); ?>/js/main.js"></script>
<script src="<?= media(); ?>/js/functions_usuarios.js"></script>
<script type="text/javascript" src="<?=media();?>/js/functions_admin.js"></script>
<script src="<?=media();?>/js/<?=$data['page_functions_js'];?>"></script>












<!-- INICIALIZACIÓN DE PLUGINS Y GRÁFICAS -->
<script>
    // Chart.js barras
    var ctx = document.getElementById("chart-bars")?.getContext("2d");
    if (ctx) {
        new Chart(ctx, {
            type: "bar",
            data: {
                labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Sales",
                    tension: 0.4,
                    borderWidth: 0,
                    borderRadius: 4,
                    borderSkipped: false,
                    backgroundColor: "#fff",
                    data: [450, 200, 100, 220, 500, 100, 400, 230, 500],
                    maxBarThickness: 6
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                interaction: { intersect: false, mode: 'index' },
                scales: {
                    y: {
                        grid: { drawBorder: false, display: false, drawOnChartArea: false, drawTicks: false },
                        ticks: {
                            suggestedMin: 0,
                            suggestedMax: 500,
                            beginAtZero: true,
                            padding: 15,
                            font: { size: 14, family: "Inter", style: 'normal', lineHeight: 2 },
                            color: "#fff"
                        },
                    },
                    x: {
                        grid: { drawBorder: false, display: false, drawOnChartArea: false, drawTicks: false },
                        ticks: { display: false },
                    },
                },
            },
        });
    }
    // Chart.js líneas
    var ctx2 = document.getElementById("chart-line")?.getContext("2d");
    if (ctx2) {
        var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);
        gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
        gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
        gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)');
        var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);
        gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
        gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
        gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)');
        new Chart(ctx2, {
            type: "line",
            data: {
                labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [
                    {
                        label: "Mobile apps",
                        tension: 0.4,
                        borderWidth: 0,
                        pointRadius: 0,
                        borderColor: "#cb0c9f",
                        borderWidth: 3,
                        backgroundColor: gradientStroke1,
                        fill: true,
                        data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
                        maxBarThickness: 6
                    },
                    {
                        label: "Websites",
                        tension: 0.4,
                        borderWidth: 0,
                        pointRadius: 0,
                        borderColor: "#3A416F",
                        borderWidth: 3,
                        backgroundColor: gradientStroke2,
                        fill: true,
                        data: [30, 90, 40, 140, 290, 290, 340, 230, 400],
                        maxBarThickness: 6
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                interaction: { intersect: false, mode: 'index' },
                scales: {
                    y: {
                        grid: { drawBorder: false, display: true, drawOnChartArea: true, drawTicks: false, borderDash: [5, 5] },
                        ticks: {
                            display: true,
                            padding: 10,
                            color: '#b2b9bf',
                            font: { size: 11, family: "Inter", style: 'normal', lineHeight: 2 },
                        }
                    },
                    x: {
                        grid: { drawBorder: false, display: false, drawOnChartArea: false, drawTicks: false, borderDash: [5, 5] },
                        ticks: {
                            display: true,
                            color: '#b2b9bf',
                            padding: 20,
                            font: { size: 11, family: "Inter", style: 'normal', lineHeight: 2 },
                        }
                    },
                },
            },
        });
    }
    // DataTable inicialización
    if (typeof $ !== 'undefined' && $('#sampleTable').length) {
        $('#sampleTable').DataTable();
    }
    // Scrollbar para Windows
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = { damping: '0.5' }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>

</body>
</html>
<!-- FIN FOOTER ORDENADO -->