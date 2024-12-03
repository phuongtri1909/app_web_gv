    <section id="footer" class="main-footer">
        <footer class="footer">
            <div class="container">
                <div class="row ">
                    <div class="col-lg-12">
                        <div class="footer-bottom">
                            <p class="mb-2">© 2024 Copyright HỘI DOANH NGHIỆP QUẬN GÒ VẤP</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" ></script>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" ></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bxslider@4.2.17/dist/jquery.bxslider.min.js" ></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="{{ asset('js/script.js') }}" ></script>
    <script src="{{ asset('js/app.js') }}" ></script>
    <script src="{{ asset('js/animation.js') }}" ></script>

    
    <script>
        
        $(document).ready(function() {
            @if (session('success'))
                showToast('{{ session('success') }}', 'success');
            @elseif (session('error'))
                showToast('{{ session('error') }}', 'error');
            @endif
        });

        document.addEventListener('click', function (event) {
            const target = event.target;
            if (target.tagName === 'INPUT' || target.tagName === 'TEXTAREA') {
                setTimeout(() => {
                    target.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 300);
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
