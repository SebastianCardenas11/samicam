        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-blue-300">Sistema SAMICAM</h3>
                    <p class="text-gray-300 text-sm">
                        Sistema de Administración Municipal Integrado de Control y Administración Municipal.
                        Plataforma diseñada para optimizar los procesos administrativos municipales.
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-blue-300">Soporte Técnico</h3>
                    <ul class="text-gray-300 text-sm space-y-2">
                        <li><i class="fas fa-envelope mr-2"></i> soporte@samicam.gov.co</li>
                        <li><i class="fas fa-phone mr-2"></i> +57 (1) 123-4567</li>
                        <li><i class="fas fa-clock mr-2"></i> Lunes a Viernes 8:00 AM - 5:00 PM</li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-blue-300">Enlaces Útiles</h3>
                    <ul class="text-gray-300 text-sm space-y-2">
                        <li><a href="#" class="hover:text-blue-300 transition">Portal Municipal</a></li>
                        <li><a href="#" class="hover:text-blue-300 transition">Políticas de Uso</a></li>
                        <li><a href="#" class="hover:text-blue-300 transition">Manual de Procedimientos</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-400 text-sm">
                    © 2023 Sistema SAMICAM. Todos los derechos reservados. 
                    Desarrollado para la administración municipal.
                </p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Smooth scrolling para los enlaces del menú
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Resaltar sección activa en el menú
        window.addEventListener('scroll', () => {
            const sections = document.querySelectorAll('section[id]');
            const navLinks = document.querySelectorAll('aside a[href^="#"]');
            
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (scrollY >= (sectionTop - 200)) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('bg-blue-600');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('bg-blue-600');
                }
            });
        });
    </script>
</body>
</html>
