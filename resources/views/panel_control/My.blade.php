@include("panel_control.components.header")

<!-- Main Content -->
<div class="main-content" style="min-height: 896px">
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.My Favorites') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('movies.search') }}">Movies</a></div>
                <div class="breadcrumb-item">My Favorites</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ __('messages.Favorite Movies') }}</h4>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ __('messages.Poster') }}</th>
                                            <th>{{ __('messages.Title') }}</th>
                                            <th>{{ __('messages.Year') }}</th>
                                            <th>{{ __('messages.Type') }}</th>
                                            <th>{{ __('messages.Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="favorites-tbody">
                                        @forelse($favorites as $favorite)
                                            <tr id="row-{{ $favorite->imdb_id }}">
                                                <td class="align-middle">
                                                    <img
                                                        src="{{ $favorite->poster && $favorite->poster !== 'N/A' ? $favorite->poster : 'https://via.placeholder.com/50x70?text=No+Image' }}"
                                                        width="50"
                                                        height="70"
                                                        style="object-fit: cover; border-radius: 4px;"
                                                        alt="{{ $favorite->title }}">
                                                </td>
                                                <td class="align-middle">{{ $favorite->title }}</td>
                                                <td class="align-middle">{{ $favorite->year }}</td>
                                                <td class="align-middle">
                                                    <span class="badge badge-primary">
                                                        {{ ucfirst($favorite->type) }}
                                                    </span>
                                                </td>
                                                <td class="align-middle">
                                                    <a href="{{ route('movies.detail', $favorite->imdb_id) }}"
                                                       class="btn btn-sm btn-info mr-1">
                                                        <i class="fas fa-eye"></i> Detail
                                                    </a>
                                                    <button class="btn btn-sm btn-danger remove-favorite"
                                                            data-imdb="{{ $favorite->imdb_id }}">
                                                        <i class="fas fa-trash"></i> Remove
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr id="empty-state">
                                                <td colspan="5">
                                                    <div class="text-center py-5">
                                                        <i class="fas fa-heart-broken fa-3x text-muted mb-3 d-block"></i>
                                                        <h5 class="text-muted">{{ __('messages.No favorites yet') }}</h5>
                                                        <p class="text-muted">{{ __('messages.Start adding movies to your favorites list!') }}</p>
                                                        <a href="{{ route('movies.search') }}" class="btn btn-primary mt-2">
                                                            <i class="fas fa-search"></i> {{ __('messages.find your favorite movie') }}
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- SweetAlert Notifications --}}
@if(session()->has('success'))
  <script>
    Swal.fire({
        text: "{{ session()->get('success') }}",
        icon: 'success',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    })
  </script>
@endif

@if(session()->has('error'))
  <script>
    Swal.fire({
        text: "{{ session()->get('error') }}",
        icon: 'error',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    })
  </script>
@endif

{{-- Script Remove Favorite --}}
<script>
document.querySelectorAll('.remove-favorite').forEach(function (btn) {
    btn.addEventListener('click', function () {
        const imdbId = this.dataset.imdb;
        const row    = document.getElementById(`row-${imdbId}`);
        const tbody  = document.getElementById('favorites-tbody');

        Swal.fire({
            title: 'Hapus dari Favorites?',
            text: 'Film ini akan dihapus dari daftar favorites kamu.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/panel_control/favorites/${imdbId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        row.remove();

                        // Cek kalau sudah tidak ada row, tampilkan empty state
                        if (tbody.querySelectorAll('tr').length === 0) {
                            tbody.innerHTML = `
                                <tr id="empty-state">
                                    <td colspan="5">
                                        <div class="text-center py-5">
                                            <i class="fas fa-heart-broken fa-3x text-muted mb-3 d-block"></i>
                                            <h5 class="text-muted">No favorites yet</h5>
                                            <p class="text-muted">Start adding movies to your favorites list!</p>
                                            <a href="{{ route('movies.search') }}" class="btn btn-primary mt-2">
                                                <i class="fas fa-search"></i> Find your favorite movie
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            `;
                        }

                        Swal.fire({
                            text: data.message,
                            icon: 'success',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    } else {
                        Swal.fire({
                            text: data.message,
                            icon: 'error',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                })
                .catch(() => {
                    Swal.fire({
                        text: 'Terjadi kesalahan.',
                        icon: 'error',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                });
            }
        });
    });
});
</script>

@include("panel_control.components.footer")