@extends('layouts.app')

@section('link')
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endsection

@section('content')
  {{-- TABLE --}}
  <div class="container-fluid">
    <section>
      <div class="table-responsive">
        <div class="card">
          <div class="card-body px-4 py-3">
            <div class="mb-4">
              <h3 class="mb-3">Guru Pembimbing</h3>
              <div class="d-grid gap-2 d-md-flex justify-content-md-start mt-2">
                <button class="btn btn-primary me-md-2 mb-2 mb-md-0" data-bs-target="#tambah-modal"
                  data-bs-toggle="modal">Tambah Pembimbing</button>
                <button class="btn btn-success me-md-2 mb-2 mb-md-0">Import Excel</button>
                <button class="btn btn-success me-md-2 mb-2 mb-md-0">Export Excel</button>
                <button class="btn btn-danger me-md-2 mb-2 mb-md-0">Export PDF</button>
                <button class="btn btn-info me-md-2 mb-2 mb-md-0">Export Word</button>
              </div>
            </div>
            <div class="table-responsive m-t-40">
              <table id="pembimbing-table" class="table border display table-bordered table-striped no-wrap">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th>Image</th>
                    <th>Jenis Kelamin</th>
                    <th>Jurusan</th>
                    <th>Tempat Prakerin</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($data as $i)
                    <tr>
                      <td>{{ $i->name }}</td>
                      <td><img src="{{ asset('storage/' . $i->image) }}" alt="{{ $i->name }}"></td>
                      <td>{{ $i->gender }}</td>
                      <td>{{ $i->jurusan }}</td>
                      <td>{{ $i->prakerins->name }}</td>
                      <td>
                        {{-- Edit --}}
                        <button class="btn btn-sm btn-warning text-white font-medium" data-bs-toggle="modal"
                          data-bs-target="#edit-modal-{{ $i->id }}"> <i class="ti ti-edit"></i></button>
                        {{-- Delete --}}
                        <button class="btn btn-sm btn-danger text-white font-medium"
                          onclick="event.preventDefault(); document.getElementById('delete-data').submit();"> <i
                            class="ti ti-trash"></i></button>
                        <form id="delete-data" action="{{ route('pembimbing.destroy') }}" action="POST"
                          style="display: none">
                          {{ csrf_field() }}
                        </form>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  {{-- Modal tambah --}}
  <div class="modal fade" id="tambah-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg" style="display: none;"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header d-flex align-items-center">
          <h4 class="modal-title" id="myLargeModalLabel"></h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form class="POST" action="{{ Route('pembimbing.store') }}" enctype="multipart/form-data">
          @csrf
          <div class="modal-body">
            <div class="row">
              <div class="col-12 col-md-6">
                <div class="form-floating mb-3">
                  <input type="text" name="name" class="form-control border border-danger" placeholder="Nama" />
                  <label><i class="ti ti-user me-2 fs-4 text-danger"></i><span
                      class="border-start border-danger ps-3">Nama</span></label>
                </div>
                <div class="form-floating mb-3">
                  <input type="text" name="jurusan" class="form-control border border-danger" placeholder="Jurusan" />
                  <label><i class="ti ti-mail me-2 fs-4 text-danger"></i><span
                      class="border-start border-danger ps-3">Jurusan</span></label>
                </div>
                <div class="form-floating mb-3">
                  <input type="text" name="jabatan" class="form-control border border-danger" placeholder="Jabatan" />
                  <label><i class="ti ti-lock me-2 fs-4 text-danger"></i><span
                      class="border-start border-danger ps-3">Jabatan</span></label>
                </div>
                <div class="mb-3">
                  <select class="form-select  border border-danger" name="gender" aria-label="Jenis Kelamin">
                    <option selected>Bimbingan Di</option>
                    @foreach ($lokasi as $i)
                      <option value="{{ $i->id }}">{{ $prakerins->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="mb-3">
                  <select class="form-select  border border-danger" name="gender" aria-label="Jenis Kelamin">
                    <option selected>Jenis Kelamin</option>
                    <option value="L">Laki - Laki</option>
                    <option value="P">Perempuan</option>
                  </select>
                </div>
              </div>
              <div class="col-12 col-md-6 align-items-center d-flex">
                <div>
                  <div class="mb-3">
                    <img id="imagePreview" name="image" style="width: 100%; max-height: 400px; object-fit: cover"
                      src="{{ asset('assets/default-image/user.jpg') }}"
                      data-default-src="{{ asset('assets/default-image/user.jpg') }}" alt="">
                  </div>
                  <input id="imageInput" type="file" accept="png,jpg,jpeg">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light-danger text-danger font-medium waves-effect text-start"
              data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-light-primary text-primary font-medium waves-effect text-start"
              data-bs-dismiss="modal">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  @forelse ($data as $i)
    {{-- Modal Edit --}}
    <div class="modal fade" id="edit-modal-{{ $i->id }}" tabindex="-1" aria-labelledby="bs-example-modal-lg"
      style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header d-flex align-items-center">
            <h4 class="modal-title" id="myLargeModalLabel"></h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form class="POST" action="{{ Route('pembimbing.update') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
              <div class="row">
                <div class="col-12 col-md-6">
                  <div class="form-floating mb-3">
                    <input type="text" name="name" value="{{ old('name') }}"
                      class="form-control border border-danger" placeholder="Nama" />
                    <label><i class="ti ti-user me-2 fs-4 text-danger"></i><span
                        class="border-start border-danger ps-3">Nama</span></label>
                  </div>
                  <div class="form-floating mb-3">
                    <input type="text" name="jurusan" value="{{ old('jurusan') }}"
                      class="form-control border border-danger" placeholder="Jurusan" />
                    <label><i class="ti ti-mail me-2 fs-4 text-danger"></i><span
                        class="border-start border-danger ps-3">Jurusan</span></label>
                  </div>
                  <div class="form-floating mb-3">
                    <input type="text" name="jabatan" value="{{ old('jabatan') }}"
                      class="form-control border border-danger" placeholder="Jabatan" />
                    <label><i class="ti ti-lock me-2 fs-4 text-danger"></i><span
                        class="border-start border-danger ps-3">Jabatan</span></label>
                  </div>
                </div>
                <div class="col-12 col-md-6 align-items-center d-flex">
                  <div>
                    <div class="mb-3">
                      <img id="imagePreview" name="image" value="{{ old('image') }}"
                        style="width: 100%; max-height: 400px; object-fit: cover"
                        src="{{ asset('assets/default-image/user.jpg') }}"
                        data-default-src="{{ asset('assets/default-image/user.jpg') }}" alt="">
                    </div>
                    <input id="imageInput" type="file" accept="png,jpg,jpeg">
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-light-danger text-danger font-medium waves-effect text-start"
                data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-light-primary text-primary font-medium waves-effect text-start"
                data-bs-dismiss="modal">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @empty
  @endforelse
@endsection

@section('script')
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>

  <script>
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');

    const defaultImageUrl = imagePreview.getAttribute('data-default-src');

    imageInput.addEventListener('change', function() {
      const file = this.files[0];

      if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
          imagePreview.src = e.target.result;
          imagePreview.style.display = 'block';
        };

        reader.readAsDataURL(file);
      } else {
        imagePreview.src = defaultImageUrl;
        imagePreview.style.display = 'block';
      }
    });
  </script>

  <script>
    $('#pembimbing-table').DataTable()
  </script>
@endsection
