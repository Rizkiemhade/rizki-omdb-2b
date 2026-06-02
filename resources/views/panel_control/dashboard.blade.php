@include("panel_control.components.header")

<!-- Main Content -->
<div class="main-content" style="min-height: 896px">
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.Movies') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Movies</a></div>
                <div class="breadcrumb-item">All Movies</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ __('messages.All Movies') }}</h4>
                        </div>
                        <div class="card-body">

                            {{-- Search Form --}}
                            <form action="{{ route('movies.search') }}" method="GET" id="search-form">
                                <div class="float-right mb-3">
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            name="keyword"
                                            id="search-input"
                                            class="form-control"
                                            placeholder="{{ __('messages.search for movies') }}"
                                            value="{{ request('keyword') }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="clearfix mb-3"></div>

                            {{-- Session Error --}}
                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="close" data-dismiss="alert">
                                        <span>&times;</span>
                                    </button>
                                </div>
                            @endif

                            {{-- API Error --}}
                            @if(isset($error) && $error)
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    {{ $error }}
                                    <button type="button" class="close" data-dismiss="alert">
                                        <span>&times;</span>
                                    </button>
                                </div>
                            @endif

                            {{-- Info hasil pencarian --}}
                            @if(request('keyword'))
                                <p class="text-muted mb-3">
                                    Hasil pencarian untuk: <strong>{{ request('keyword') }}</strong>
                                    @isset($total)
                                        &mdash; <strong>{{ $total }}</strong> film ditemukan
                                    @endisset
                                </p>
                            @endif

                            {{-- Table --}}
                            <div class="table-responsive">
                                <table class="table table-striped" id="movie-table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('messages.Poster') }}</th>
                                            <th>{{ __('messages.Title') }}</th>
                                            <th>{{ __('messages.Year') }}</th>
                                            <th>{{ __('messages.Type') }}</th>
                                            <th>{{ __('messages.Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="Movie-container">
                                        @isset($movies)
                                            @forelse($movies as $movie)
                                                <tr>
                                                    <td class="align-middle">
                                                        <img
                                                            src="{{ isset($movie['Poster']) && $movie['Poster'] !== 'N/A' ? $movie['Poster'] : 'https://via.placeholder.com/50x70?text=No+Image' }}"
                                                            width="50"
                                                            height="70"
                                                            style="object-fit: cover; border-radius: 4px;"
                                                            alt="{{ $movie['Title'] ?? '' }}">
                                                    </td>
                                                    <td class="align-middle">{{ $movie['Title'] ?? '-' }}</td>
                                                    <td class="align-middle">{{ $movie['Year'] ?? '-' }}</td>
                                                    <td class="align-middle">
                                                        <span class="badge badge-primary">
                                                            {{ ucfirst($movie['Type'] ?? 'movie') }}
                                                        </span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <button
                                                            class="btn btn-sm btn-outline-danger mr-1 favorite-btn"
                                                            data-imdb="{{ $movie['imdbID'] ?? '' }}"
                                                            data-title="{{ $movie['Title'] ?? '' }}"
                                                            data-year="{{ $movie['Year'] ?? '' }}"
                                                            data-poster="{{ isset($movie['Poster']) && $movie['Poster'] !== 'N/A' ? $movie['Poster'] : '' }}"
                                                            data-type="{{ $movie['Type'] ?? '' }}"
                                                            type="button"
                                                        >
                                                            <i class="fas fa-heart"></i>
                                                        </button>
                                                        <a href="{{ route('movies.detail', $movie['imdbID']) }}" class="btn btn-sm btn-info">
                                                            <i class="fas fa-eye"></i> Detail
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center py-5">
                                                        <i class="fas fa-film fa-3x text-muted mb-3 d-block"></i>
                                                        <span class="text-muted">
                                                            Film tidak ditemukan untuk "<strong>{{ request('keyword') }}</strong>"
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        @else
                                            <tr id="empty-row">
                                                <td colspan="5" class="text-center py-5">
                                                    <i class="fas fa-search fa-3x text-muted mb-3 d-block"></i>
                                                    <span class="text-muted">{{ __('messages.enter keywords to search for movies') }}</span>
                                                </td>
                                            </tr>
                                        @endisset
                                    </tbody>
                                </table>
                            </div>

                            {{-- Pagination --}}
                            @isset($total)
                                @if($total > 10)
                                    @php
                                        $currentPage = (int) request('page', 1);
                                        $totalPages  = (int) ceil($total / 10);
                                    @endphp
                                    <div class="d-flex justify-content-center mt-4">
                                        <nav>
                                            <ul class="pagination">
                                                <li class="page-item {{ $currentPage <= 1 ? 'disabled' : '' }}">
                                                    <a class="page-link" href="{{ route('movies.search', ['keyword' => request('keyword'), 'page' => $currentPage - 1]) }}">
                                                        &laquo;
                                                    </a>
                                                </li>
                                                @for($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++)
                                                    <li class="page-item {{ $currentPage == $i ? 'active' : '' }}">
                                                        <a class="page-link" href="{{ route('movies.search', ['keyword' => request('keyword'), 'page' => $i]) }}">
                                                            {{ $i }}
                                                        </a>
                                                    </li>
                                                @endfor
                                                <li class="page-item {{ $currentPage >= $totalPages ? 'disabled' : '' }}">
                                                    <a class="page-link" href="{{ route('movies.search', ['keyword' => request('keyword'), 'page' => $currentPage + 1]) }}">
                                                        &raquo;
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                @endif
                            @endisset

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@include("panel_control.components.footer")