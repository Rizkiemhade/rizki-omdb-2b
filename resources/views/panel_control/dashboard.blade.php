@include("panel_control.components.header")

      <!-- Main Content -->
      <div class="main-content" style="min-height: 896px">
        <section class="section">
          <div class="section-header">
            <h1>{{__('messages.Movies') }}</h1>
          </div>
          <div class="section-body">
            <div class="row mt-4">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>{{__('messages.All Movies') }}</h4>
                  </div>
                  <div class="card-body">
                    <div class="float-right">
                      <div class="search-element">
                        <div class="input-group-append">
                          <input type="text" name="q" id="search-input" class="form-control" placeholder="{{__('messages.search for movies') }}">
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
                          <th>{{__('messages.Poster') }}</th>
                          <th>{{__('messages.Title') }}</th>
                          <th>{{__('messages.Year') }}</th>
                          <th>{{__('messages.Type') }}</th>
                          <th>{{__('messages.Action') }}</th>
                        </tr>
                      </thead>
                      <tbody id="Movie-container">
                        <tr id="empty-row">
                          <td colspan="5" class="text-center py-5">
                            <i class="fas fa-search fa-3x text-muted mb-3 d-block"></i>
                            <span class="text-muted">{{__('messages.enter keywords to search for movies') }}</span>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
              </div>
            </div>
          </div>
        </section>
      </div>
@include("panel_control.components.footer")