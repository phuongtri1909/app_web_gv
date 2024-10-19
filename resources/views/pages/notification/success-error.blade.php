@if (session('success'))
    <div class="m-3  alert alert-success alert-dismissible fade show" id="alert-success" role="alert">
        <span class="alert-text text-dark">
            {{ session('success') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            
        </button>
    </div>
@elseif(session('error'))
    <div class="m-3  alert alert-danger alert-dismissible fade show" id="alert-success" role="alert">
        <span class="alert-text text-dark">{{ session('error') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
