// Loader Manager - Maneja los loaders del sistema
class LoaderManager {
    constructor() {
        this.globalLoader = document.getElementById('globalLoader');
        this.init();
    }

    init() {
        // Ocultar el loader global cuando la página esté completamente cargada
        window.addEventListener('load', () => {
            this.hideGlobalLoader();
        });

        // También ocultar después de un tiempo mínimo para evitar parpadeos
        setTimeout(() => {
            this.hideGlobalLoader();
        }, 1000);

        // Actualizar los divLoading existentes
        this.updateExistingLoaders();
    }

    hideGlobalLoader() {
        if (this.globalLoader) {
            this.globalLoader.classList.add('hidden');
            setTimeout(() => {
                this.globalLoader.style.display = 'none';
            }, 300);
        }
    }

    showGlobalLoader(message = 'Cargando sistema...') {
        if (this.globalLoader) {
            const loaderText = this.globalLoader.querySelector('.loader-text');
            if (loaderText) {
                loaderText.textContent = message;
            }
            this.globalLoader.style.display = 'flex';
            this.globalLoader.classList.remove('hidden');
        }
    }

    updateExistingLoaders() {
        // Buscar todos los divLoading existentes y actualizarlos
        const existingLoaders = document.querySelectorAll('#divLoading');
        existingLoaders.forEach(loader => {
            this.updateLoaderContent(loader);
        });

        // Observar cambios en el DOM para nuevos divLoading
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                mutation.addedNodes.forEach((node) => {
                    if (node.nodeType === 1 && node.id === 'divLoading') {
                        this.updateLoaderContent(node);
                    }
                });
            });
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }

    updateLoaderContent(loaderElement) {
        // Limpiar contenido existente
        loaderElement.innerHTML = '';
        
        // Agregar el nuevo loader jelly
        const jellyLoader = document.createElement('l-jelly');
        jellyLoader.setAttribute('size', '40');
        jellyLoader.setAttribute('speed', '0.9');
        jellyLoader.setAttribute('color', '#5e72e4');
        
        const loaderText = document.createElement('p');
        loaderText.className = 'loader-text';
        loaderText.textContent = 'Cargando...';
        
        loaderElement.appendChild(jellyLoader);
        loaderElement.appendChild(loaderText);
    }

    // Función para mostrar loader en cualquier elemento
    showLoader(elementId, message = 'Cargando...') {
        let loader = document.getElementById(elementId);
        
        if (!loader) {
            loader = document.createElement('div');
            loader.id = elementId;
            loader.className = 'custom-loader';
            document.body.appendChild(loader);
        }

        this.updateLoaderContent(loader);
        const loaderText = loader.querySelector('.loader-text');
        if (loaderText) {
            loaderText.textContent = message;
        }
        
        loader.style.display = 'flex';
    }

    // Función para ocultar loader
    hideLoader(elementId) {
        const loader = document.getElementById(elementId);
        if (loader) {
            loader.style.display = 'none';
        }
    }
}

// Inicializar el LoaderManager cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    window.loaderManager = new LoaderManager();
});

// Función global para mostrar/ocultar loaders (compatibilidad con código existente)
function showLoading(elementId = 'divLoading', message = 'Cargando...') {
    if (window.loaderManager) {
        window.loaderManager.showLoader(elementId, message);
    }
}

function hideLoading(elementId = 'divLoading') {
    if (window.loaderManager) {
        window.loaderManager.hideLoader(elementId);
    }
} 