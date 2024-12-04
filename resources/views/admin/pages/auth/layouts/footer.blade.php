<footer class="footer py-5">
    <div class="container">
        <div class="row">
            <div class="col-8 mx-auto text-center mt-1">
                <p class="mb-0 text-secondary">
                    Copyright ©
                    <script>
                        document.write(new Date().getFullYear())
                    </script>
                    <a style="color: #252f40;" href="" class="font-weight-bold ml-1" target="_blank">TECHSERV</a>.
                </p>
            </div>
        </div>
    </div>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" ></script>
<script>
    $(document).ready(function() {
        @if (session('success'))
            showToast('{{ session('success') }}', 'success');
        @elseif (session('error'))
            showToast('{{ session('error') }}', 'error');
        @endif
    });
</script>
