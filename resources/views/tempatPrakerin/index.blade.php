@extends('layouts.app')

@section('link')
    <link rel="stylesheet" href="{{ asset('assets/css/custome/tempatprakerin/style.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
@endsection


@section('content')
    <div class="card bg-white shadow-sm position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">List Tempat Prakerin</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">Tempat Prakerin</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12 col-md-12 align-items-end">
            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modaltambah">Tambah Tempat Prakerin <i
                    class="ti ti-map-pin-plus ms-1 fs-4"></i></button>
        </div>
    </div>

    <div class="row">
        @forelse ($prakerin as $data)
            <div class="col-12 col-md-4">
                <div class="card-custome border">
                    <div class="card-image">
                        <a href="javascript:void(0)" class="card text-white w-100 card-hover"
                            style="background: url('{{ asset('storage/' . $data->image) }}') center; background-size: cover; width: 100%; height: 200px; object-fit: cover;">
                        </a>
                    </div>
                    <div class="card-overlay">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="ms-auto">
                                    <div class="d-flex mt-4">
                                        <button class="me-2 fs-5" data-bs-target="#modalMap"
                                            id="buttonMap-{{ $data->id }}" data-latitude="{{ $data->latitude }}"
                                            data-longitude="{{ $data->longitude }}" data-id="{{ $data->id }}"
                                            data-name="{{ $data->name }}" data-bs-toggle="modal"
                                            style="border: none; background: transparent;"><i
                                                class="ti ti-map-2 text-white"></i></button>
                                        <button class="me-2 fs-5" data-bs-target="#modalEdit{{ $data->id }}"
                                            data-bs-toggle="modal" style="border: none; background: transparent;"><i
                                                class="ti ti-edit text-white"></i></button>
                                        <form id="deleteForm-{{ $data->id }}" action="{{ route('tempatPrakerin.destroy', $data->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button style="border: none; background: transparent;" type="button"
                                                class="fs-5 text-danger cursor-pointer" onclick="confirmDelete({{ $data->id }})"><i
                                                    class="ti ti-trash"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div style="margin-top: 100px">
                                <h4 class="card-title mb-1 text-light">{{ $data->name }}</h4>
                                <h6 class="card-text fw-normal text-light d-inline-block text-truncate"
                                    style="max-width: 150px">
                                    {{ $data->description }}
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
        @endforelse
    </div>

    <div class="modal fade animated pulse" id="modalMap" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="textdetail"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4">
                    <p class="fw-bold text-center">Lokasi Perusahaan</p>
                    <div class="preview-map-location" id="mapLocationData"
                        style="width: 100%; height: 500px; border-radius: 20px">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit --}}
    @foreach ($prakerin as $data)
        <div class="modal fade modal-edit animated pulse" id="modalEdit{{ $data->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit {{ $data->name }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body row px-4">
                        <div class="col-md-6 col-12">
                            <p class="fw-bold text-center">Edit lokasi perusahaan</p>
                            <div class="preview-map" style=" width: 100%; border-radius: 20px"
                                id="mapEdit-{{ $data->id }}"></div>
                        </div>
                        <div class="col-md-6 col-12">
                            <form id="formEdit" action="{{ route('tempatPrakerin.update', $data->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row justify-content-center align-items-center">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Perusahaan</label>
                                        <input id="name-edit" class="form-control" value="{{ $data->name }}"
                                            type="text" name="name" placeholder="Nama Perusahaan">
                                        <div id="name-error-edit"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Deskripsi Perusahaan</label>
                                        <input id="description-edit" class="form-control" type="text"
                                            value="{{ $data->description }}" name="description"
                                            placeholder="Deskripsi Perusahaan">
                                        <div id="description-error-edit"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Alamat Perusahaan</label>
                                        <input id="address-edit" class="form-control" type="text"
                                            value="{{ $data->address }}" name="address" placeholder="Alamat Perusahaan">
                                        <div id="address-error-edit"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="logo_perusahaan">Upload Logo Perusahaan</label>
                                        <div>
                                            @if ($data->image)
                                                <div class="mb-3">
                                                    <img src="{{ asset('storage/' . $data->image) }}" alt="Gambar Lama"
                                                        class="img-fluid" style="max-width: 200px;">
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <input id="image-edit" class="form-control" type="file" name="image"
                                                id="logo_perusahaan">
                                            <div id="image-error-edit"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Latitude</label>
                                        <input class="form-control" type="text"value="{{ $data->latitude }}"
                                            name="latitude" id="latitudeEdit-{{ $data->id }}"
                                            placeholder="Latitude">
                                        <div id="latitude-error-edit"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Longitude</label>
                                        <input class="form-control" type="text" value="{{ $data->longitude }}"
                                            name="longitude" id="longitudeEdit-{{ $data->id }}"
                                            placeholder="Longitude">
                                        <div id="longitude-error-edit"></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary"
                                            id="submitButtonEdit">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Modal Tambah --}}
    <div class="modal fade modal-tambah animated pulse" id="modaltambah" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 " id="exampleModalLabel">Tambah Tempat Prakerin</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row px-4">
                    <div class="col-md-6 col-12">
                        <p class="fw-bold text-center">Pilih lokasi perusahaan</p>
                        <div class="preview-map" id="map"></div>
                    </div>
                    <div class="col-md-6 col-12">
                        <form id="formTambah" action="{{ route('tempatPrakerin.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row justify-content-center align-items-center">
                                <div class="col-12 col-md-6 w-100" style="margin-top: 30px">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Perusahaan</label>
                                        <input id="name" class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name') }}" type="text" name="name"
                                            placeholder="Nama Perusahaan">
                                        <div id="name-error"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Deskripsi Perusahaan</label>
                                        <input id="description"
                                            class="form-control @error('description') is-invalid @enderror" type="text"
                                            value="{{ old('description') }}" name="description"
                                            placeholder="Deskripsi Perusahaan">
                                        <div id="description-error"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Alamat Perusahaan</label>
                                        <input id="address" class="form-control @error('address') is-invalid @enderror"
                                            type="text" value="{{ old('address') }}" name="address"
                                            placeholder="Alamat Perusahaan">
                                        <div id="address-error"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="logo_perusahaan">Upload Logo Perusahaan</label>
                                        <input id="image" class="form-control @error('image') is-invalid @enderror"
                                            type="file" value="{{ old('image') }}" name="image"
                                            id="logo_perusahaan">
                                        <div id="image-error"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Latitude</label>
                                        <input id="latitude" class="form-control @error('latitude') is-invalid @enderror"
                                            type="text" value="{{ old('latitude') }}" name="latitude" id="latitude"
                                            placeholder="Latitude">
                                        <div id="latitude-error"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Longitude</label>
                                        <input id="longitude"
                                            class="form-control @error('longitude') is-invalid @enderror" type="text"
                                            value="{{ old('longitude') }}" name="longitude" id="longitude"
                                            placeholder="Longtitude">
                                        <div id="longitude-error"></div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            var mapLocation;

            $('button[id^="buttonMap-"]').on('click', function() {
                var latitude = $(this).data('latitude');
                var longitude = $(this).data('longitude');
                var name = $(this).data('name');
                var id = $(this).data('id');

                var textDetail = $("#textdetail");
                textDetail.html('');
                textDetail.append(`<p>Detail Perusahaan ${name}</p>`);

                $('#modalMap').on('shown.bs.modal', function() {
                    initializeMapLocation(id, latitude, longitude);
                });
            });

            function initializeMapLocation(id, latitude, longitude) {

                if (mapLocation) {
                    mapLocation.remove();
                }

                mapLocation = L.map('mapLocationData').setView([latitude, longitude], 18);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: ''
                }).addTo(mapLocation);

                L.marker([latitude, longitude]).addTo(mapLocation)
                    .bindPopup('Ini lokasi perusahaannya!');

                mapLocation.on('resize', function() {
                    setTimeout(function() {
                        mapLocation.invalidateSize();
                    }, 400);
                });
            };
        });
    </script>

    {{-- Validasi --}}
    <script>
        document.getElementById('formEdit').addEventListener('submit', function(event) {
            var nameEdit = $('#name-edit').val();
            var descriptionEdit = $('#description-edit').val();
            var addressEdit = $('#address-edit').val();
            var imageEdit = $('#image-edit').val();
            var latitudeEdit = $('#latitude-edit').val();
            var longitudeEdit = $('#longitude-edit').val();

            var nameErrorEdit = $('#name-error-edit');
            var descriptionErrorEdit = $('#description-error-edit');
            var addressErrorEdit = $('#address-error-edit');
            var imageErrorEdit = $('#image-error-edit');
            var latitudeErrorEdit = $('#latitude-error-edit');
            var longitudeErrorEdit = $('#longitude-error-edit');

            var isValid = true;

            function addErrorMessage(errorElement, errorMessage) {
                if (errorElement.children().length === 0) {
                    errorElement.append('<p class="text-danger mt-2">' + errorMessage + '</p>');
                }
            }

            function removeErrorMessage(errorElement) {
                errorElement.children().remove();
            }

            if (nameEdit.length < 1) {
                addErrorMessage(nameErrorEdit, 'Nama Perusahaan tidak boleh kosong');
                isValid = false;
            } else {
                removeErrorMessage(nameErrorEdit);
            }

            if (descriptionEdit.length < 1) {
                addErrorMessage(descriptionErrorEdit, 'Deskripsi tidak boleh kosong');
                isValid = false;
            } else {
                removeErrorMessage(descriptionErrorEdit);
            }

            if (addressEdit.length < 1) {
                addErrorMessage(addressErrorEdit, 'Alamat tidak boleh kosong');
                isValid = false;
            } else {
                removeErrorMessage(addressErrorEdit);
            }

            if (imageEdit.length < 1) {
                addErrorMessage(imageErrorEdit, 'Logo Perusahaan tidak boleh kosong');
                isValid = false;
            } else {
                removeErrorMessage(imageErrorEdit);
            }

            if (latitudeEdit.length < 1) {
                addErrorMessage(latitudeErrorEdit, 'Latitude tidak boleh kosong');
                isValid = false;
            } else {
                removeErrorMessage(latitudeErrorEdit);
            }

            if (longitudeEdit.length < 1) {
                addErrorMessage(longitudeErrorEdit, 'Longitude tidak boleh kosong');
                isValid = false;
            } else {
                removeErrorMessage(longitudeErrorEdit);
            }

            if (isValid === false) {
                event.preventDefault();
            }
        });
    </script>

    <script>
        document.getElementById('formTambah').addEventListener('submit', function(event) {
            var name = $('#name').val();
            var description = $('#description').val();
            var address = $('#address').val();
            var image = $('#image').val();
            var latitude = $('#latitude').val();
            var longitude = $('#longitude').val();

            var nameError = $('#name-error');
            var descriptionError = $('#description-error');
            var addressError = $('#address-error');
            var imageError = $('#image-error');
            var latitudeError = $('#latitude-error');
            var longitudeError = $('#longitude-error');

            var isValid = true;

            function addErrorMessage(errorElement, errorMessage) {
                if (errorElement.children().length === 0) {
                    errorElement.append('<p class="text-danger mt-2">' + errorMessage + '</p>');
                }
            }

            function removeErrorMessage(errorElement) {
                errorElement.children().remove();
            }

            if (name.length < 1) {
                addErrorMessage(nameError, 'Nama Perusahaan tidak boleh kosong');
                isValid = false;
            } else {
                removeErrorMessage(nameError);
            }

            if (description.length < 1) {
                addErrorMessage(descriptionError, 'Deskripsi tidak boleh kosong');
                isValid = false;
            } else {
                removeErrorMessage(descriptionError);
            }

            if (address.length < 1) {
                addErrorMessage(addressError, 'Alamat tidak boleh kosong');
                isValid = false;
            } else {
                removeErrorMessage(addressError);
            }

            if (image.length < 1) {
                addErrorMessage(imageError, 'Logo Perusahaan tidak boleh kosong');
                isValid = false;
            } else {
                removeErrorMessage(imageError);
            }

            if (latitude.length < 1) {
                addErrorMessage(latitudeError, 'Latitude tidak boleh kosong');
                isValid = false;
            } else {
                removeErrorMessage(latitudeError);
            }

            if (longitude.length < 1) {
                addErrorMessage(longitudeError, 'Longitude tidak boleh kosong');
                isValid = false;
            } else {
                removeErrorMessage(longitudeError);
            }

            if (isValid === false) {
                event.preventDefault();
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            @foreach ($prakerin as $data)
                $('#modalEdit{{ $data->id }}').on('shown.bs.modal', function() {
                    initializeMapEdit('{{ $data->id }}', '{{ $data->latitude }}',
                        '{{ $data->longitude }}');
                });
            @endforeach

            function initializeMapEdit(uuid, latitude, longitude) {
                console.log('Initializing map for UUID:', uuid);

                var mapEdit = L.map('mapEdit-' + uuid).setView([latitude, longitude], 18);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: ''
                }).addTo(mapEdit);

                var markerEdit = L.marker([latitude, longitude], {
                    draggable: true
                }).addTo(mapEdit);

                markerEdit.on('dragend', function(event) {
                    var markerLatLng = markerEdit.getLatLng();
                    document.getElementById('latitudeEdit-' + uuid).value = markerLatLng.lat;
                    document.getElementById('longitudeEdit-' + uuid).value = markerLatLng.lng;
                });

                mapEdit.on('click', function(event) {
                    markerEdit.setLatLng(event.latlng);
                    document.getElementById('latitudeEdit-' + uuid).value = event.latlng.lat;
                    document.getElementById('longitudeEdit-' + uuid).value = event.latlng.lng;
                });

                mapEdit.on('resize', function() {
                    setTimeout(function() {
                        mapEdit.invalidateSize();
                    }, 400);
                });

                $('#modalEdit' + uuid).on('hidden.bs.modal', function() {
                    mapEdit.remove();
                });
            }
        });

        // Modal Tambah + Map
        document.addEventListener('DOMContentLoaded', function() {
            var mapTambah;

            function initializeMapTambah() {
                mapTambah = L.map('map').setView([-7.744245338286295, 113.21582794189455], 4);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: ''
                }).addTo(mapTambah);

                var markerTambah = L.marker([-7.744245338286295, 113.21582794189455], {
                    draggable: true
                }).addTo(mapTambah);

                markerTambah.on('dragend', function(event) {
                    var markerLatLng = markerTambah.getLatLng();
                    document.getElementById('latitude').value = markerLatLng.lat;
                    document.getElementById('longitude').value = markerLatLng.lng;
                });

                mapTambah.on('click', function(event) {
                    markerTambah.setLatLng(event.latlng);
                    document.getElementById('latitude').value = event.latlng.lat;
                    document.getElementById('longitude').value = event.latlng.lng;
                });
            }

            initializeMapTambah();

            $('#modaltambah').on('shown.bs.modal', function() {
                if (mapTambah) {
                    mapTambah.invalidateSize();
                } else {
                    initializeMapTambah();
                }
            });
        });

        // SweetAlert Delete
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda tidak bisa mengembalikan data ini lagi!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#FF5D5D',
                cancelButtonColor: '#FFB35D',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm-' + id).submit();
                }
            });
        }
    </script>
@endsection
