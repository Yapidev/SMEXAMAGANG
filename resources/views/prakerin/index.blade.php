@extends('layouts.app')

@section('link')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
  <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endsection

@section('content')
  <div class="row mb-3">
    <div class="col-12 col-md-12 align-items-end">
      <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modaltambah">Tambah Siswa Prakerin <i
          class="ti ti-user-plus ms-1 fs-4"></i></button>
    </div>
  </div>

  {{-- Modal Tambah --}}
  <div class="modal fade modal-tambah animated pulse" id="modaltambah" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5 " id="exampleModalLabel"></h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body row px-4">
          <form action="{{ route('prakerin.store') }}" method="POST">
            @csrf
            <div class="row justify-content-center align-items-center">
              <div class="col-12 col-md-6 w-100" style="margin-top: 30px">
                <div class="mb-3">
                  <label class="form-label">Pilih Siswa</label>
                  <select class="form-select" name="siswa_id[]" id="siswa-magang" data-placeholder="Cari Nama" multiple>
                    @foreach ($siswa as $data)
                      <option value="{{ $data->id }}">{{ $data->name }}</option>
                    @endforeach
                  </select>
                  <div id="siswa-error"></div>
                </div>
                <div class="mb-3">
                  <label for="" class="form-label">Pilih Tempat Prakerin</label>
                  <select class="form-select" name="tempat_prakerin_id" id="tempat-prakerin"
                    data-placeholder="Pilih Tempat">
                    <option></option>
                    @foreach ($tempatPrakerin as $dataPrakerin)
                      <option value="{{ $dataPrakerin->id }}">{{ $dataPrakerin->name }}</option>
                    @endforeach 
                  </select>
                </div>
                <div class="mb-3 row">
                  <div class="col-md-6 col-12 mb-3">
                    <label class="mb-2" for="tanggalMulai">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="tanggalMulai" name="tanggal_mulai">
                  </div>
                  <div class="col-md-6 col-12 mb-3">
                    <label class="mb-2" for="tanggalSelesai">Tanggal Selesai</label>
                    <input type="date" class="form-control" id="tanggalSelesai" name="tanggal_selesai">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('script')
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    $('#modaltambah').on('shown.bs.modal', function() {
      $('#siswa-magang').select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        closeOnSelect: false,
      });

      $('#tempat-prakerin').select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
      });
    });
  </script>
@endsection
