@extends('layouts.app')

@section('link')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">

    {{-- Custom CSS --}}
    <style>
        .image-preview {
            width: 200px;
            height: 200px;
            /* Atur tinggi sesuai kebutuhan */
            object-fit: cover;
            /* Mengatur gambar untuk di-fit secara proporsional */
        }
    </style>
@endsection

@section('content')
    {{-- Datatable --}}
    <div class="datatables">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body px-4 py-3">
                        <div class="mb-2">
                            <h5 class="mb-0">Tabel List Data Pembimbing</h5>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-start mt-2">
                                <button class="btn btn-danger me-md-2 mb-2 mb-md-0" data-bs-target="#create-siswa-modal"
                                    data-bs-toggle="modal"><i class="ti me-1 ti-user-plus"></i> Tambah Pembimbing </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="list-siswa" class="table border table-bordered text-nowrap">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Jurusan</th>
                                        <th>Gender</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="data-siswa-container">
                                    @forelse ($dataPembimbing as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}.</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $data->image ? Storage::url($data->image) : asset('assets/images/profile/user-1.jpg') }}"
                                                        class="rounded-circle" width="40" height="40"
                                                        style="object-fit: cover" />
                                                    <div class="ms-3">
                                                        <h6 class="mb-0">{{ $data->name }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $data->jurusan }}</td>
                                            <td>{{ $data->gender }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-warning edit-btn"
                                                    data-url="{{ route('siswa.edit', ['siswa' => $data->id]) }}">
                                                    <i class="ti ti-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger delete-btn"
                                                    data-url="{{ route('siswa.destroy', ['siswa' => $data->id]) }}">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Datatable --}}

    {{-- Modal Create --}}
    <div id="create-siswa-modal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pembimbing Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pembimbing.store') }}" class="ps-3 pr-3" method="POST" id="create-siswa-form"
                        enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="dari" class="form-label">Nama :</label>
                                    <input class="form-control" type="name" id="from-input"
                                        placeholder="Contoh : Muhammad Arya" name="name" />
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="untuk" class="form-label">Jurusan :</label>
                                    <select name="jurusan" class="form-control" id="">
                                        <option value="" selected disabled>Pilih Jurusan</option>
                                        <!-- Kelas X -->
                                        <option value="RPL">RPL</option>
                                        <option value="AK">AK</option>
                                        <option value="MP">MP</option>
                                        <option value="LP">LP</option>
                                        <option value="BD">BD</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="untuk" class="form-label">Tempat Prakerin :</label>
                                    <select name="tempat_pkl" class="form-control" id="">
                                        <option value="" selected disabled>Pilih Tempat Prakerin</option>
                                        <!-- Kelas X -->
                                        <option value="RPL">RPL</option>
                                        <option value="AK">AK</option>
                                        <option value="MP">MP</option>
                                        <option value="LP">LP</option>
                                        <option value="BD">BD</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jenis Kelamin :</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="create-laki"
                                            value="L">
                                        <label class="form-check-label cursor-pointer" for="create-laki">
                                            Laki-laki
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender"
                                            id="create-perempuan" value="P">
                                        <label class="form-check-label cursor-pointer" for="create-perempuan">
                                            Perempuan
                                        </label>
                                    </div>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat :</label>
                                    <textarea class="form-control" name="alamat" id="" cols="30" rows="5"></textarea>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-center mt-2 mb-4">
                                    <img id="create-image-preview" src="https://via.placeholder.com/200"
                                        alt="Preview Image" class="img-fluid mb-3 image-preview">
                                </div>
                                <div class="mb-3">
                                    <label for="formFileLg" class="form-label">Masukkan foto pembimbing jika ada
                                        (Opsional)</label>
                                    <input class="form-control" id="formFileLg" type="file" name="image"
                                        accept="image/*" onchange="createPreviewImage(event)" />
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-light-info text-info font-medium">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Create --}}

    {{-- Modal Edit --}}
    <div id="edit-siswa-modal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('siswa.update', ['siswa' => 'siswa_id']) }}" class="ps-3 pr-3" method="POST"
                        id="edit-siswa-form" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="dari" class="form-label">Nama :</label>
                                    <input class="form-control" type="name" id="from-input"
                                        placeholder="Contoh : Muhammad Arya" name="name" />
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="untuk" class="form-label">Jurusan :</label>
                                    <select name="jurusan" class="form-control" id="">
                                        <option value="" selected disabled>Pilih Jurusan</option>
                                        <!-- Kelas X -->
                                        <option value="RPL">RPL</option>
                                        <option value="AK">AK</option>
                                        <option value="MP">MP</option>
                                        <option value="LP">LP</option>
                                        <option value="BD">BD</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="untuk" class="form-label">Tempat Prakerin :</label>
                                    <select name="tempat_pkl" class="form-control" id="">
                                        <option value="" selected disabled>Pilih Tempat Prakerin</option>
                                        <!-- Kelas X -->
                                        <option value="RPL">RPL</option>
                                        <option value="AK">AK</option>
                                        <option value="MP">MP</option>
                                        <option value="LP">LP</option>
                                        <option value="BD">BD</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Nomor Telpon</label>
                                    <input type="number" name="phone_number" class="form-control"
                                        placeholder="Contoh : 085XXXXXXXXX">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">NIK</label>
                                    <input type="number" name="nik" class="form-control"
                                        placeholder="Contoh format NIK  [YYMMDD] [RRRR] [KK]">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jenis Kelamin :</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="edit-laki"
                                            value="L">
                                        <label class="form-check-label cursor-pointer" for="edit-laki">
                                            Laki-laki
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender"
                                            id="edit-perempuan" value="P">
                                        <label class="form-check-label cursor-pointer" for="edit-perempuan">
                                            Perempuan
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat :</label>
                                    <textarea class="form-control" name="alamat" id="" cols="30" rows="5"></textarea>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-center mt-2 mb-4">
                                    <img id="edit-image-preview" src="https://via.placeholder.com/200"
                                        alt="Preview Image" class="img-fluid mb-3 image-preview">
                                </div>
                                <div class="mb-3">
                                    <label for="formFileLg" class="form-label">Masukkan foto siswa jika ada
                                        (Opsional)</label>
                                    <input class="form-control" id="formFileLg" type="file" name="image"
                                        accept="image/*" onchange="editPreviewImage(event)" />
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-light-info text-info font-medium" id="submit-btn-edit"
                                data-url="">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Edit --}}
@endsection

@section('script')
    {{-- Import Script Datatable --}}
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/swal.js') }}"></script>
    <script src="{{ asset('assets/js/loader.js') }}"></script>

    {{-- Import Script Swal --}}
    <script src="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.js') }}"></script>

    {{-- Script Function initDataTable --}}
    <script>
        function initDataTable() {
            $('#list-siswa').DataTable({
                "lengthMenu": [
                    [10, 20, 50, -1],
                    [10, 20, 50, "All"]
                ],
                "pageLength": 10,

                "language": {
                    "decimal": "",
                    "emptyTable": "Tidak ada data yang tersedia",
                    "info": "Menampilkan _START_ sampai _END_ dari total _TOTAL_ baris",
                    "infoEmpty": "Tidak ada data yang tersedia",
                    "infoFiltered": "(disaring dari total _MAX_ baris)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Tampilkan _MENU_ baris",
                    "loadingRecords": "Memuat...",
                    "processing": "Sedang diproses...",
                    "search": "Cari:",
                    "zeroRecords": "Tidak ditemukan data yang cocok",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    },
                    "aria": {
                        "sortAscending": ": aktifkan untuk mengurutkan kolom secara ascending",
                        "sortDescending": ": aktifkan untuk mengurutkan kolom secara descending"
                    }
                }
            });
        }
    </script>
    {{-- Script Function initDataTable --}}

    {{-- Script yang dijalankan pada saat awal halaman dimuat --}}
    <script>
        $(document).ready(function() {
            initDataTable();

            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });
        });
    </script>
    {{-- Script yang dijalankan pada saat awal halaman dimuat --}}

    {{-- Script function handleSuccessResponse --}}
    <script>
        function handleSuccessResponse(response) {
            // Clear Container
            $('#data-siswa-container').empty();

            // Append Data
            var dataPembimbing = response.dataPembimbing;
            if (dataPembimbing && dataPembimbing.length > 0) {
                $.each(dataPembimbing, function(index, siswa) {
                    var html = `
                            <tr>
                                <td>${index + 1}.</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="${siswa.image ? 'storage/' + siswa.image : 'assets/images/profile/user-1.jpg'}"
                                            class="rounded-circle" width="40" height="40" style="object-fit: cover" />
                                        <div class="ms-3">
                                            <h6 class="mb-0">${siswa.name}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>${siswa.jurusan}</td>
                                <td>${siswa.gender}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning edit-btn" data-url="{{ url('edit-siswa/${siswa.id}') }}">
                                        <i class="ti ti-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-btn" data-url="{{ url('destroy-siswa/${siswa.id}') }}">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    $('#data-siswa-container').append(html);
                });
            } else {

            };
        };
    </script>
    {{-- Script function handleSuccessResponse --}}

    {{-- Script for Preview Image --}}
    <script>
        function createPreviewImage(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const preview = document.getElementById('create-image-preview');
                    preview.src = e.target.result;
                };

                reader.readAsDataURL(input.files[0]);
            };
        };

        function editPreviewImage(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const preview = document.getElementById('edit-image-preview');
                    preview.src = e.target.result;
                };

                reader.readAsDataURL(input.files[0]);
            };
        };
    </script>
    {{-- Script for Preview Image --}}

    {{-- Script for Create Siswa --}}
    <script>
        $(document).ready(function() {
            $('#create-siswa-form').on('submit', function(event) {
                event.preventDefault();

                showLoader();

                var form = this;
                var formData = new FormData(form);

                $.ajax({
                    type: 'POST',
                    url: form.action,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            // Handle old validation
                            $('#create-siswa-modal input').each(function() {
                                $(this).removeClass('is-invalid');
                                $(this).next('.invalid-feedback').text('');
                            });

                            $('#create-siswa-modal select').each(function() {
                                $(this).removeClass('is-invalid');
                                $(this).next('.invalid-feedback').text('');
                            });

                            // Remove Datatable
                            var table = $('#list-siswa').DataTable().destroy();

                            // Handle Success Response
                            handleSuccessResponse(response);

                            // Inisialisasi Ulang Datatable
                            initDataTable();

                            // Handle Modal
                            var modal = $('#create-siswa-modal');
                            modal.modal('hide');
                            modal.find('select').val('');
                            modal.find('input:not(:radio)').val('');
                            modal.find('input[type="radio"]').prop('checked', false);
                            modal.find('input[type="file"]').val(null);
                            modal.find('#create-image-preview').attr('src',
                                'https://via.placeholder.com/200');

                            hideLoader();

                            // Swal Success
                            showSuccessPopup('Berhasil', 'Berhasil menambah data');
                        }
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = 'Terjadi kesalahan dalam permintaan';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;

                            if (xhr.status === 422 && xhr.responseJSON.errors) {
                                var errors = xhr.responseJSON.errors;

                                $('#create-siswa-modal input').each(function() {
                                    $(this).removeClass('is-invalid');
                                    $(this).next('.invalid-feedback').text('');
                                });

                                $('#create-siswa-modal select').each(function() {
                                    $(this).removeClass('is-invalid');
                                    $(this).next('.invalid-feedback').text('');
                                });

                                $('#create-siswa-modal textarea').each(function() {
                                    $(this).removeClass('is-invalid');
                                    $(this).next('.invalid-feedback').text('');
                                });

                                Object.keys(errors).forEach(function(fieldName) {
                                    var input = $('#create-siswa-modal input[name="' +
                                        fieldName + '"]');
                                    input.addClass('is-invalid');
                                    input.next('.invalid-feedback').text(errors[
                                        fieldName][0]);

                                    var select = $('#create-siswa-modal select[name="' +
                                        fieldName + '"]');
                                    select.addClass('is-invalid');
                                    select.next('.invalid-feedback').text(errors[
                                        fieldName][0]);

                                    var textarea = $(
                                        '#create-siswa-modal textarea[name="' +
                                        fieldName + '"]');
                                    textarea.addClass('is-invalid');
                                    textarea.next('.invalid-feedback').text(errors[
                                        fieldName][0]);
                                });

                                hideLoader();
                            };
                        } else {
                            // Swal Error
                            showErrorPopup('Gagal', 'Gagal menambah data, silahkan coba lagi');
                        };
                    }
                });
            });
        });
    </script>
    {{-- Script for Create Siswa --}}

    {{-- Script For Edit Siswa --}}
    <script>
        $(document).ready(function() {
            $(document).on('click', '.edit-btn', function() {

                var url = $(this).data('url');
                var modal = $('#edit-siswa-modal');

                $('#edit-siswa-modal input').each(function() {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').text('');
                });

                $('#edit-siswa-modal select').each(function() {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').text('');
                });

                $('#edit-siswa-modal textarea').each(function() {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').text('');
                });

                $.ajax({
                    type: 'GET',
                    url: url,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {

                            $.each(response.dataPembimbing, function(fieldName, value) {
                                var inputField = modal.find('[name="' + fieldName +
                                    '"]');
                                if (inputField.length > 0 && inputField.attr('type') !==
                                    'file') {
                                    if (inputField.attr('type') !== 'radio') {
                                        inputField.val(value);
                                    } else if (fieldName === 'gender') {
                                        modal.find('[name="gender"]').each(function() {
                                            if ($(this).val() === value) {
                                                $(this).prop('checked', true);
                                            }
                                        });
                                    }
                                }
                            });

                            if (response.dataPembimbing.image != null) {
                                modal.find('#edit-image-preview').attr('src', 'storage/' +
                                    response
                                    .dataPembimbing
                                    .image);
                            } else {
                                modal.find('#edit-image-preview').attr('src',
                                    'https://via.placeholder.com/200');
                            }

                            var updateUrl = '{{ route('siswa.update', ['siswa' => 'id']) }}';
                            updateUrl = updateUrl.replace('id', response.dataPembimbing.id);

                            modal.find('.btn-light-info').attr('data-url', updateUrl);

                            modal.modal('show');
                        }
                    },
                    error: function(error) {
                        // Swal Error
                        showErrorPopup('Gagal', 'Gagal mengedit data, silahkan coba lagi');
                    }
                });
            });

            $('#edit-siswa-form').on('submit', function(event) {
                event.preventDefault();

                showLoader();

                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                var form = this;
                var formData = new FormData(form);

                formData.append('_token', csrfToken);
                formData.append('_method', 'PUT');

                var url = document.getElementById('submit-btn-edit').dataset.url;

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {

                            // Handle old validation
                            $('#edit-siswa-modal input').each(function() {
                                $(this).removeClass('is-invalid');
                                $(this).next('.invalid-feedback').text('');
                            });

                            $('#edit-siswa-modal select').each(function() {
                                $(this).removeClass('is-invalid');
                                $(this).next('.invalid-feedback').text('');
                            });

                            $('#edit-siswa-modal textarea').each(function() {
                                $(this).removeClass('is-invalid');
                                $(this).next('.invalid-feedback').text('');
                            });

                            // Remove Datatable
                            var table = $('#list-siswa').DataTable().destroy();

                            // Handle Success Response
                            handleSuccessResponse(response);

                            // Inisialisasi Ulang Datatable
                            initDataTable();

                            // Handle Modal
                            var modal = $('#edit-siswa-modal');
                            modal.modal('hide');
                            modal.find('input:not(:radio)').val('');
                            modal.find('input[type="radio"]').prop('checked', false);
                            modal.find('input[type="file"]').val(null);
                            modal.find('#edit-image-preview').attr('src',
                                'https://via.placeholder.com/200');

                            hideLoader();

                            if (response.success == 'Berhasil mengedit data pembimbing') {
                                // Swal Success
                                showSuccessPopup('Berhasil', 'Berhasil mengedit data');
                            } else {
                                // Swal Info
                                showWarningPopup('Info', response.success)
                            }
                        };
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = 'Terjadi kesalahan dalam permintaan';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;

                            if (xhr.status === 422 && xhr.responseJSON.errors) {
                                var errors = xhr.responseJSON.errors;

                                $('#edit-siswa-modal input').each(function() {
                                    $(this).removeClass('is-invalid');
                                    $(this).next('.invalid-feedback').text('');
                                });

                                $('#edit-siswa-modal select').each(function() {
                                    $(this).removeClass('is-invalid');
                                    $(this).next('.invalid-feedback').text('');
                                });

                                $('#edit-siswa-modal textarea').each(function() {
                                    $(this).removeClass('is-invalid');
                                    $(this).next('.invalid-feedback').text('');
                                });

                                Object.keys(errors).forEach(function(fieldName) {
                                    var input = $('#edit-siswa-modal input[name="' +
                                        fieldName + '"]');
                                    input.addClass('is-invalid');
                                    input.next('.invalid-feedback').text(errors[
                                        fieldName][0]);

                                    var select = $('#edit-siswa-modal select[name="' +
                                        fieldName + '"]');
                                    select.addClass('is-invalid');
                                    select.next('.invalid-feedback').text(errors[
                                        fieldName][0]);

                                    var textarea = $(
                                        '#edit-siswa-modal textarea[name="' +
                                        fieldName + '"]');
                                    textarea.addClass('is-invalid');
                                    textarea.next('.invalid-feedback').text(errors[
                                        fieldName][0]);
                                });

                                hideLoader();
                            };
                        } else {
                            // Swal Error
                            showErrorPopup('Gagal', 'Gagal mengedit data, silahkan coba lagi');
                        };
                    }
                });
            });
        });
    </script>
    {{-- Script For Edit Siswa --}}

    {{-- Script For Delete Siswa --}}
    <script>
        $(document).on('click', '.delete-btn', function() {

            var url = $(this).data('url');
            var splitUrl = url.split('/');
            var siswaId = splitUrl.pop();

            Swal.fire({
                title: 'Anda yakin?',
                text: "Anda tidak akan dapat mengembalikan data ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoader();

                    $.ajax({
                        type: 'DELETE',
                        url: url,
                        data: siswaId,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.success) {
                                // Remove Datatable
                                var table = $('#list-siswa').DataTable().destroy();

                                // Handle Success Response
                                handleSuccessResponse(response);

                                // Inisialisasi Ulang Datatable
                                initDataTable();

                                hideLoader();
                                // Swal Success
                                showSuccessPopup('Berhasil', 'Berhasil menghapus data');
                            }
                        },
                        error: function(error) {
                            // Swal Error
                            showErrorPopup('Gagal', 'Gagal menghapus data, silahkan coba lagi')
                        },
                    });
                };
            });
        });
    </script>
    {{-- Script For Delete Siswa --}}

    {{-- Script for Import Siswa --}}
    <script>
        $('#btn-import').on('click', function() {
            $('#import-input').click();
        });
        $('#import-input').on('change', function() {
            showLoader();

            let form = $('#import-form');
            let formData = new FormData(form[0]);

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        // Handle Success Response
                        handleSuccessResponse(response);

                        // Inisialisasi Ulang Datatable
                        initDataTable();

                        hideLoader();
                        showSuccessPopup('Berhasil', 'Berhasil mengimport siswa');
                    }
                },
                error: function(error) {
                    $('#import-input').val('');
                    hideLoader();
                    showErrorPopup('Gagal', 'Gagal mengimport siswa');
                }
            })
        });
    </script>
    {{-- Script for Import Siswa --}}
@endsection
