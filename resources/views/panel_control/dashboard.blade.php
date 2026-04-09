
@extends('panel_control.components.main')

@section('content')
        <section class="section">
          <div class="section-header">
            <h1>Movies</h1>
          </div>
          <div class="section-body">
            <div class="row mt-4">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>All Movies</h4>
                  </div>
                  <div class="card-body">
                    <div class="float-right">
                      <div class="search-element">
                        <div class="input-group-append">
                          <input type="text" name="q" id="search-input" class="form-control" placeholder="Cari Movies">
                            <div class="input-group-append">
                              <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                              </button>
                            </div>
                          </div>
                        </div>
                    <div class="cleartix mb-3">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="movie-table">
                      <thead>
                        <tr>
                          <th>Poster</th>
                          <th>Title</th>
                          <th>Year</th>
                          <th>Type</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody id="Movie-container">
                        <tr id="empty-row">
                          <td colspan="5" class="text-center py-5">
                            <i class="fas fa-search fa-3x text-muted mb-3 d-block"></i>
                            <span class="text-muted">"masukan kata kunci untuk mencari movies"</span>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
              </div>
            </div>
          </div>
        </section>
@endsection
    