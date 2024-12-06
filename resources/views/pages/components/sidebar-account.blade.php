<div id="sidebar-account">
    <button id="toggleButton">&rarr;</button>
    <div id="sidebarContent">
        @if (Auth::check())
            @if (auth()->user()->role == "admin")

                <a href="{{ route('admin.dashboard') }}"><i class="fa-regular fa-user"></i> {{ auth()->user()->username }}</a> 
            @else
                <a href="{{ route('business.dashboard') }}"><i class="fa-regular fa-user"></i> {{ auth()->user()->username }}</a>

            @endif

            <a href="{{ route('admin.logout') }}"><i class="fa-solid fa-arrow-right-from-bracket"></i> Đăng xuất</a>
        @else
            <a href="{{ route('admin.login') }}"><i class="fa-solid fa-arrow-right-to-bracket"></i> Đăng nhập</a>
        @endif
    </div>
</div>

@push('styles')
@endpush

@push('scripts')
    <script>
        function toggleSidebar() {
            const sidebarContent = document.getElementById('sidebarContent');
            const toggleButton = document.getElementById('toggleButton');

            if (sidebarContent.style.display === 'none' || !sidebarContent.style.display) {
                sidebarContent.style.display = 'block';
                toggleButton.innerHTML = '&larr;';
                toggleButton.style.background = 'linear-gradient(45deg, rgba(173, 216, 230, 0.5), rgba(0, 0, 0, 0.5))'
            } else {
                sidebarContent.style.display = 'none';
                toggleButton.innerHTML = '&rarr;';
                toggleButton.style.background = 'linear-gradient(45deg, orange, yellow)'
            }
        }

        let isDragging = false;
        let startY, startTop;

        document.getElementById('toggleButton').addEventListener('click', function() {
            if (!isDragging) {
                toggleSidebar();
            }
        });

        document.getElementById('toggleButton').addEventListener('touchstart', function(e) {
            if (!isDragging) {
                e.preventDefault(); // Prevent default touch behavior
                toggleSidebar();
            }
        }, {
            passive: false
        });

        // Draggable functionality
        const sidebar = document.getElementById('sidebar-account');

        // Mouse events
        sidebar.addEventListener('mousedown', function(e) {
            isDragging = true;
            startY = e.clientY;
            startTop = sidebar.offsetTop;
            document.body.style.userSelect = 'none'; // Prevent text selection
        });

        document.addEventListener('mousemove', function(e) {
            if (isDragging) {
                const deltaY = e.clientY - startY;
                let newTop = startTop + deltaY;

                // Ensure the sidebar does not go out of the viewport
                const sidebarHeight = sidebar.offsetHeight;
                const viewportHeight = window.innerHeight;

                if (newTop < 0) {
                    newTop = 0;
                } else if (newTop + sidebarHeight > viewportHeight) {
                    newTop = viewportHeight - sidebarHeight;
                }

                sidebar.style.top = `${newTop}px`;
            }
        });

        document.addEventListener('mouseup', function() {
            isDragging = false;
            document.body.style.userSelect = ''; // Re-enable text selection
        });

        // Touch events
        sidebar.addEventListener('touchstart', function(e) {
            isDragging = true;
            startY = e.touches[0].clientY;
            startTop = sidebar.offsetTop;
            document.body.style.userSelect = 'none'; // Prevent text selection
           
        }, {
            passive: false
        });

        document.addEventListener('touchmove', function(e) {
            if (isDragging) {
                const deltaY = e.touches[0].clientY - startY;
                let newTop = startTop + deltaY;

                // Ensure the sidebar does not go out of the viewport
                const sidebarHeight = sidebar.offsetHeight;
                const viewportHeight = window.innerHeight;

                if (newTop < 0) {
                    newTop = 0;
                } else if (newTop + sidebarHeight > viewportHeight) {
                    newTop = viewportHeight - sidebarHeight;
                }

                sidebar.style.top = `${newTop}px`;
                e.preventDefault(); // Prevent default touch behavior
            }
        }, {
            passive: false
        });

        document.addEventListener('touchend', function() {
            isDragging = false;
            document.body.style.userSelect = '';
        });
    </script>
@endpush