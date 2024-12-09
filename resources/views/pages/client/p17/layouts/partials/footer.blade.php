    <section id="footer" class="main-footer">
        <footer class="footer">
            <div class="container">
                <div class="row ">
                    <div class="col-lg-12">
                        <div class="footer-bottom">
                            <p class="mb-2">© 2024 Copyright STech</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" ></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" ></script>
    <script src="{{ asset('js/script.js') }}?v={{ filemtime(public_path('js/script.js')) }}"></script>
    <script src="{{ asset('js/app.js') }}?v={{ filemtime(public_path('js/app.js')) }}"></script>

    <script type="text/javascript" src="{{ asset('ckeditor/ckeditor.js')}}?v={{ filemtime(public_path('ckeditor/ckeditor.js')) }}"></script>
    <script src="{{ asset('ckeditor/config.js')}}?v={{ filemtime(public_path('ckeditor/config.js')) }}"></script>
    <script>
        $(document).ready(function() {
            @if (session('success'))
                showToast('{{ session('success') }}', 'success');
            @elseif (session('error'))
                showToast('{{ session('error') }}', 'error');
            @endif
        });
    </script>
    
    @stack('scripts')
</body>
</html>
