// Funciones auxiliares para las gráficas del módulo de seguimiento de contratos

// Configuraciones globales de Chart.js
Chart.defaults.font.family = "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif";
Chart.defaults.font.size = 12;
Chart.defaults.color = '#495057';

// Paleta de colores profesional
const chartColors = {
    primary: '#6f42c1',
    secondary: '#6c757d',
    success: '#198754',
    info: '#0dcaf0',
    warning: '#ffc107',
    danger: '#dc3545',
    light: '#f8f9fa',
    dark: '#212529'
};

// Función para generar colores con transparencia
function getColorWithAlpha(color, alpha = 0.8) {
    const hex = color.replace('#', '');
    const r = parseInt(hex.substr(0, 2), 16);
    const g = parseInt(hex.substr(2, 2), 16);
    const b = parseInt(hex.substr(4, 2), 16);
    return `rgba(${r}, ${g}, ${b}, ${alpha})`;
}

// Función para formatear números como moneda
function formatCurrency(value) {
    return new Intl.NumberFormat('es-CO', {
        style: 'currency',
        currency: 'COP',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(value);
}

// Función para formatear números grandes
function formatLargeNumber(value) {
    if (value >= 1000000000) {
        return (value / 1000000000).toFixed(1) + 'B';
    } else if (value >= 1000000) {
        return (value / 1000000).toFixed(1) + 'M';
    } else if (value >= 1000) {
        return (value / 1000).toFixed(1) + 'K';
    }
    return value.toString();
}

// Configuración base para tooltips personalizados
const customTooltipConfig = {
    backgroundColor: 'rgba(0, 0, 0, 0.8)',
    titleColor: '#fff',
    bodyColor: '#fff',
    borderColor: 'rgba(255, 255, 255, 0.1)',
    borderWidth: 1,
    cornerRadius: 8,
    displayColors: true,
    padding: 12,
    titleFont: {
        size: 14,
        weight: 'bold'
    },
    bodyFont: {
        size: 13
    }
};

// Configuración base para leyendas
const customLegendConfig = {
    position: 'top',
    align: 'center',
    labels: {
        usePointStyle: true,
        pointStyle: 'circle',
        padding: 20,
        font: {
            size: 12,
            weight: '500'
        }
    }
};

// Configuración base para escalas
const customScaleConfig = {
    grid: {
        color: 'rgba(0, 0, 0, 0.05)',
        lineWidth: 1
    },
    ticks: {
        font: {
            size: 11
        },
        color: '#6c757d'
    }
};

// Función para mostrar loading en gráficas
function showChartLoading(canvasId) {
    const canvas = document.getElementById(canvasId);
    if (canvas) {
        const container = canvas.parentElement;
        const loadingDiv = document.createElement('div');
        loadingDiv.className = 'chart-loading';
        loadingDiv.innerHTML = `
            <div class="spinner"></div>
            <p>Cargando gráfica...</p>
        `;
        loadingDiv.id = `loading-${canvasId}`;
        
        canvas.style.display = 'none';
        container.appendChild(loadingDiv);
    }
}

// Función para ocultar loading en gráficas
function hideChartLoading(canvasId) {
    const canvas = document.getElementById(canvasId);
    const loading = document.getElementById(`loading-${canvasId}`);
    
    if (canvas) canvas.style.display = 'block';
    if (loading) loading.remove();
}

// Función para crear gradientes
function createGradient(ctx, color1, color2, direction = 'vertical') {
    const gradient = direction === 'vertical' 
        ? ctx.createLinearGradient(0, 0, 0, 400)
        : ctx.createLinearGradient(0, 0, 400, 0);
    
    gradient.addColorStop(0, color1);
    gradient.addColorStop(1, color2);
    return gradient;
}

// Configuraciones predefinidas para diferentes tipos de gráficas

// Configuración para gráficas de línea
const lineChartConfig = {
    responsive: true,
    maintainAspectRatio: false,
    interaction: {
        intersect: false,
        mode: 'index'
    },
    plugins: {
        legend: customLegendConfig,
        tooltip: customTooltipConfig
    },
    scales: {
        x: {
            ...customScaleConfig,
            title: {
                display: true,
                font: {
                    size: 12,
                    weight: 'bold'
                }
            }
        },
        y: {
            ...customScaleConfig,
            beginAtZero: true,
            title: {
                display: true,
                font: {
                    size: 12,
                    weight: 'bold'
                }
            }
        }
    },
    elements: {
        line: {
            tension: 0.4
        },
        point: {
            radius: 4,
            hoverRadius: 6
        }
    }
};

// Configuración para gráficas de barras
const barChartConfig = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: customLegendConfig,
        tooltip: customTooltipConfig
    },
    scales: {
        x: {
            ...customScaleConfig,
            title: {
                display: true,
                font: {
                    size: 12,
                    weight: 'bold'
                }
            }
        },
        y: {
            ...customScaleConfig,
            beginAtZero: true,
            title: {
                display: true,
                font: {
                    size: 12,
                    weight: 'bold'
                }
            }
        }
    }
};

// Configuración para gráficas circulares
const pieChartConfig = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            ...customLegendConfig,
            position: 'bottom'
        },
        tooltip: {
            ...customTooltipConfig,
            callbacks: {
                label: function(context) {
                    const label = context.label || '';
                    const value = context.parsed;
                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                    const percentage = ((value / total) * 100).toFixed(1);
                    return `${label}: ${value} (${percentage}%)`;
                }
            }
        }
    }
};

// Función para animar contadores
function animateCounter(elementId, finalValue, duration = 2000, prefix = '', suffix = '') {
    const element = document.getElementById(elementId);
    if (!element) return;
    
    const startValue = 0;
    const increment = finalValue / (duration / 16);
    let currentValue = startValue;
    
    const timer = setInterval(() => {
        currentValue += increment;
        if (currentValue >= finalValue) {
            currentValue = finalValue;
            clearInterval(timer);
        }
        
        const displayValue = Math.floor(currentValue);
        element.textContent = prefix + displayValue.toLocaleString() + suffix;
    }, 16);
}

// Función para crear efectos de hover en tarjetas
function addCardHoverEffects() {
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
}

// Función para crear partículas de fondo (opcional)
function createParticleBackground(containerId) {
    const container = document.getElementById(containerId);
    if (!container) return;
    
    for (let i = 0; i < 20; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        particle.style.cssText = `
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(111, 66, 193, 0.3);
            border-radius: 50%;
            pointer-events: none;
            animation: float ${3 + Math.random() * 4}s ease-in-out infinite;
            left: ${Math.random() * 100}%;
            top: ${Math.random() * 100}%;
            animation-delay: ${Math.random() * 2}s;
        `;
        container.appendChild(particle);
    }
}

// CSS para las partículas
const particleCSS = `
@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.7; }
    50% { transform: translateY(-20px) rotate(180deg); opacity: 1; }
}
`;

// Agregar CSS de partículas al documento
if (!document.getElementById('particle-styles')) {
    const style = document.createElement('style');
    style.id = 'particle-styles';
    style.textContent = particleCSS;
    document.head.appendChild(style);
}

// Función para exportar gráficas como imagen
function exportChartAsImage(chartInstance, filename = 'grafica') {
    const canvas = chartInstance.canvas;
    const url = canvas.toDataURL('image/png');
    const link = document.createElement('a');
    link.download = `${filename}.png`;
    link.href = url;
    link.click();
}

// Función para imprimir gráficas
function printChart(chartInstance) {
    const canvas = chartInstance.canvas;
    const dataURL = canvas.toDataURL();
    const windowContent = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Gráfica - Seguimiento de Contratos</title>
            <style>
                body { margin: 0; padding: 20px; text-align: center; }
                img { max-width: 100%; height: auto; }
                h1 { color: #333; margin-bottom: 20px; }
            </style>
        </head>
        <body>
            <h1>Gráfica - Seguimiento de Contratos</h1>
            <img src="${dataURL}" alt="Gráfica">
            <p>Generado el: ${new Date().toLocaleDateString('es-CO')}</p>
        </body>
        </html>
    `;
    
    const printWindow = window.open('', '_blank');
    printWindow.document.write(windowContent);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    printWindow.close();
}

// Inicialización cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    // Agregar efectos de hover a las tarjetas
    setTimeout(addCardHoverEffects, 500);
    
    // Configurar Chart.js globalmente
    Chart.defaults.plugins.legend.labels.usePointStyle = true;
    Chart.defaults.plugins.tooltip.cornerRadius = 8;
    Chart.defaults.elements.bar.borderRadius = 4;
    Chart.defaults.elements.bar.borderSkipped = false;
});

// Exportar funciones para uso global
window.chartHelpers = {
    formatCurrency,
    formatLargeNumber,
    showChartLoading,
    hideChartLoading,
    createGradient,
    animateCounter,
    exportChartAsImage,
    printChart,
    chartColors,
    lineChartConfig,
    barChartConfig,
    pieChartConfig,
    getColorWithAlpha
};