@extends('layouts.app')

@section('link')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
  <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endsection

@section('content')
  <div class="row">
    <div class="col-12 col-md-4">
      <div class="card p-4">
        <div class="card-title">
          <h5>Guru Pembimbing</h5>
        </div>
        @foreach ($pembimbing as $pembimbings)
          <div class="card-body justify-content-center align-items-center d-flex flex-column">
            <div class="profile-image mb-3">
              <img src="{{ asset('storage/' . $pembimbings->image) }}" alt="{{ $pembimbings->name }}" width="100"
                height="100" class="rounded-circle" style="object-fit: cover">
            </div>
            <div class="nama-pembimbing text-center">
              <p class="text-capitalize fw-bold" style="font-size:18px; letter-spacing: 1px;">{{ $pembimbings->name }}</p>
            </div>
            <div class="jurusan">
              <span class="mb-1 badge rounded-pill font-medium bg-light-danger text-danger">
                {{ $pembimbings->jurusan }}
              </span>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <div class="col-12 col-md-8">
      <div class="card p-4">
        <div class="card-title mb-4">
          <h5>Data Prakerin</h5>
        </div>
        <div class="row">
          <div class="col-12 col-md-6">
            <div
              class="card d-flex flex-column justify-content-center align-items-center py-5 bg-light-danger text-danger">
              <div class="title fw-bold mb-3" style="font-size: 24px; letter-spacing: 1px;">
                Siswa Aktif
              </div>
              <div class="countdata" style="font-size: 30px;">
                {{ $siswaaktifcount }}
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div
              class="card d-flex flex-column justify-content-center align-items-center py-5 bg-light-danger text-danger">
              <div class="title fw-bold mb-3" style="font-size: 24px; letter-spacing: 1px;">
                Siswa Selesai
              </div>
              <div class="countdata" style="font-size: 30px;">
                {{ $siswaselesaicount }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="card p-4">
    <div class="row mb-3 align-items-center">
      <div class="col-12 col-md-6">
        <h5 class="mb-0">Siswa Aktif Prakerin</h5>
      </div>
      <div class="col-12 col-md-6 d-flex justify-content-end">
        <div>
          <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modaltambah">Tambah Siswa Prakerin <i
              class="ti ti-user-plus ms-1 fs-4"></i></button>
        </div>
      </div>
    </div>
    <div class="table-responsive rounded-2">
      <table class="table border text-nowrap customize-table mb-0 align-middle">
        <thead class="text-dark fs-4">
          <tr class="text-center">
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Nama</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Kelas</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Masa Prakerin</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Status</h6>
            </th>
            <th>
              <h6 class="fs-4 fw-semibold mb-0">Aksi</h6>
            </th>
          </tr>
        </thead>
        <tbody>
          @forelse ($prakerinData as $data)
            <tr class="text-center">
              <td>
                <div class="d-flex align-items-center">
                  <img src="{{ asset('storage/' . $data->siswa->image) }}" style="object-fit: cover"
                    class="rounded-circle" width="50" height="50" />
                  <div class="ms-3">
                    <h6 class="fs-4 fw-semibold mb-0">{{ $data->siswa->name }}</h6>
                  </div>
                </div>
              </td>
              <td>
                <p class="mb-0 fw-normal fs-4">{{ $data->siswa->class }}</p>
              </td>
              <td>
                <span class="badge rounded-pill font-medium bg-light-primary text-primary px-3 py-2">
                  {{ $data->tanggal_mulai }}
                </span>
                -
                <span class="badge rounded-pill font-medium bg-light-secondary text-secondary px-3 py-2">
                  {{ $data->tanggal_selesai }}
                </span>
              </td>
              <td>
                @php
                  $statusMappings = [
                      'sedang_magang' => 'Sedang Magang',
                      'selesai_magang' => 'Selesai Magang',
                      'diberhentikan' => 'Diberhentikan',
                  ];

                  $statusText = $statusMappings[$data->status] ?? $data->status;
                @endphp
                @if (isset($statusMappings[$data->status]))
                  @if ($data->status === 'sedang_magang')
                    <span class="badge rounded-pill font-medium bg-light-success text-success px-3 py-2">
                      {{ $statusText }}
                    </span>
                  @elseif($data->status === 'selesai_magang')
                    <span class="badge rounded-pill font-medium bg-light-secondary text-secondary px-3 py-2">
                      {{ $statusText }}
                    </span>
                  @else
                    <span class="badge rounded-pill font-medium bg-light-danger text-danger px-3 py-2">
                      {{ $statusText }}
                    </span>
                  @endif
                @endif
              </td>
              <td>
                <button type="button" data-bs-toggle="modal" data-bs-target="#editData" data-id="{{ $data->id }}"
                  data-name="{{ $data->siswa->name }}" data-status="{{ $data->status }}"
                  data-tanggalmulai="{{ $data->tanggal_mulai }}" data-tanggalselesai="{{ $data->tanggal_selesai }}"
                  class="btn mb-1 waves-effect waves-light btn-circle btn-light-secondary text-secondary me-2"
                  id="editButton-{{ $data->id }}"><i class="ti ti-edit-circle"></i></button>

                <button type="button" class="btn mb-1 waves-effect waves-light btn-circle btn-light-danger text-danger"
                  data-id="{{ $data->id }}" data-title="Konfirmasi" data-text="Anda yakin ingin menghapus data ini?"
                  data-icon="warning" onclick="confirmDelete(this)">
                  <i class="ti ti-trash"></i>
                </button>
                <form action="{{ route('prakerin.destroy', $data->id) }}" method="POST" data-id="{{ $data->id }}">
                  @csrf
                  @method('DELETE')
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="12" class="text-center">Data siswa yang prakerin di tempat ini masih belum ada</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="mt-3">
      {{ $prakerinData->links('pagination::bootstrap-5') }}
    </div>
  </div>

  {{-- Modal Edit --}}
  <div class="modal fade animated pulse" id="editData" tabindex="-1" aria-labelledby="mySmallModalLabel"
    aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
      <div class="modal-content">
        <div class="modal-header d-flex align-items-center">
          <h5 class="modal-title" id="edit-title-name"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="POST" id="formTarget">
          @csrf
          @method('PUT')
          <div class="modal-body" id="formEdit">

          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-light-primary text-primary font-medium waves-effect">Simpan</button>
            <button type="button" class="btn btn-light-danger text-danger font-medium waves-effect"
              data-bs-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- Modal Tambah --}}
  <div class="modal fade modal-tambah animated pulse" id="modaltambah" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Siswa</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body row px-4">
          <form action="{{ route('prakerin.store') }}" method="POST" id="formTambah">
            @csrf
            <input type="hidden" name="prakerinId" value="{{ $prakerin->id }}">
            <div class="row justify-content-center align-items-center">
              <div class="col-12 col-md-6 w-100" style="margin-top: 30px">
                <div class="mb-3">
                  <label class="form-label">Pilih Siswa</label>
                  <select class="form-select" name="siswa_id[]" id="siswa-magang" data-placeholder="Cari Nama"
                    multiple>
                    @foreach ($siswa as $data)
                      <option value="{{ $data->id }}">{{ $data->name }}</option>
                    @endforeach
                  </select>
                  <div id="siswa-error"></div>
                </div>
                <div class="mb-3 row">
                  <div class="col-md-6 col-12 mb-3">
                    <label class="mb-2" for="tanggalMulai">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="tanggalMulai" name="tanggal_mulai">
                    <div id="tanggalmulai-error"></div>
                  </div>
                  <div class="col-md-6 col-12 mb-3">
                    <label class="mb-2" for="tanggalSelesai">Tanggal Selesai</label>
                    <input type="date" class="form-control" id="tanggalSelesai" name="tanggal_selesai">
                    <div id="tanggalselesai-error"></div>
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  {{-- Modal Edit --}}
  <script>
    $(document).ready(function() {
      $('button[id^="editButton-"]').on('click', function() {
        // Data
        var dataId = $(this).data('id');
        var dataName = $(this).data('name');
        var dataStatus = $(this).data('status');
        var dataTanggalMulai = $(this).data('tanggalmulai');
        var dataTanggalSelesai = $(this).data('tanggalselesai');
        // Element
        var formContainer = $('#formEdit');
        var titleContainer = $('#edit-title-name');
        var formAction = $('#formTarget');
        // Form Action
        $('#formTarget').attr('action', `/prakerin/update/${dataId}`);


        // Title
        titleContainer.html('');

        titleContainer.append(`
          <p>Edit ${dataName}</p>
        `);

        if (dataStatus == 'sedang_magang') {
          dataStatusText = 'Sedang Magang';
        } else if (dataStatus == 'selesai_magang') {
          dataStatusText = 'Selesai Magang';
        } else {
          dataStatusText = 'Diberhentikan';
        }

        // Modal Add Element
        formContainer.html('');

        formContainer.append(`
        <div class="form-group mb-3">
              <label class="mr-sm-2 mb-1" for="status">Pilih Status</label>
              <select class="form-select mr-sm-2" name="status" id="status">
                <option selected value="${dataStatus}">${dataStatusText}</option>
                <option value="sedang_magang">Sedang Magang</option>
                <option value="selesai_magang">Selesai Magang</option>
                <option value="diberhentikan">Diberhentikan</option>
              </select>
        </div>
        <div class="mb-3 row">
              <div class="col-md-6 col-12 mb-3">
                <label class="mb-2" for="tanggalMulai">Tanggal Mulai</label>
                <input type="date" class="form-control" value="${dataTanggalMulai}" id="tanggalMulai" name="tanggal_mulai">
              </div>
              <div class="col-md-6 col-12 mb-3">
                <label class="mb-2" for="tanggalSelesai">Tanggal Selesai</label>
                <input type="date" class="form-control" value="${dataTanggalSelesai}" id="tanggalSelesai" name="tanggal_selesai">
              </div>
        </div>
        `);

        var initialStatus = dataStatus;

        $('#editForm').submit(function(event) {
          event.preventDefault();

          var selectedStatus = $('#status').val();

          if (selectedStatus === initialStatus) {
            Swal.fire({
              title: 'Anda tidak merubah apapun',
              icon: 'warning',
              confirmButtonText: 'OK'
            });
          } else {

            $('#editModal').modal('hide');
          }
        });
      });
    });
  </script>

  <script>
    function confirmDelete(button) {
      var deleteUrl = "{{ route('prakerin.destroy', ':id') }}".replace(':id', button.getAttribute('data-id'));

      Swal.fire({
        title: button.getAttribute('data-title') || 'Konfirmasi',
        text: button.getAttribute('data-text') || 'Anda yakin ingin menghapus data ini?',
        icon: button.getAttribute('data-icon') || 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
      }).then((result) => {
        if (result.isConfirmed) {
          var form = document.querySelector('form[data-id="' + button.getAttribute('data-id') + '"]');
          form.submit();
        }
      });
    }
  </script>

  {{-- Modal Tambah Siswa --}}
  <script>
    $('#modaltambah').on('shown.bs.modal', function() {
      $('#formTambah').submit(function(event) {
        var siswa = $('#siswa-magang').val();
        var tanggalmulai = $('#tanggalMulai').val();
        var tanggalselesai = $('#tanggalSelesai').val();

        var siswaError = $('#siswa-error');
        var tanggalmulaiError = $('#tanggalmulai-error');
        var tanggalselesaiError = $('#tanggalselesai-error');

        var isValid = true;

        function addErrorMessage(errorElement, errorMessage) {
          if (errorElement.children().length === 0) {
            errorElement.append('<p class="text-danger mt-2 fs-sm">' + errorMessage + '</p>');
          }
        }

        function removeErrorMessage(errorElement) {
          errorElement.children().remove();
        }

        if (siswa.length < 1) {
          addErrorMessage(siswaError, 'Siswa tidak boleh kosong');
          isValid = false;
        } else {
          removeErrorMessage(siswaError);
        }

        if (tanggalmulai.length < 1) {
          addErrorMessage(tanggalmulaiError, 'Tanggal mulai tidak boleh kosong');
          isValid = false;
        } else {
          removeErrorMessage(tanggalmulaiError);
        }

        if (tanggalselesai.length < 1) {
          addErrorMessage(tanggalselesaiError, 'Tanggal selesai tidak boleh kosong');
          isValid = false;
        } else {
          removeErrorMessage(tanggalselesaiError);
        }

        if (isValid === false) {
          event.preventDefault();
        }
      });


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
