@extends('layouts.app')

@section('link')
  <link rel="stylesheet" href="{{ asset('assets/css/custome/tempatprakerin/style.css') }}">
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
@endsection


@section('content')
  <div class="row mb-3">
    <div class="col-12 col-md-12 align-items-end">
      <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modaltambah">Tambah Tempat Prakerin <i
          class="ti ti-map-pin-plus ms-1 fs-4"></i></button>
    </div>
  </div>

  <div class="row">
    @forelse ($prakerin as $i)
      <div class="col-12 col-md-4">
        <div class="card-custome">
          <div class="card-image">
            <a href="javascript:void(0)" class="card text-white w-100 card-hover"
              style="background: url('{{ asset('storage/' . $i->image) }}') center; background-size: cover; width: 100%; height: 200px; object-fit: cover;">
            </a>
          </div>
          <div class="card-overlay">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="ms-auto">
                  <div class="d-flex mt-4">
                    <button class="me-2 fs-5" data-bs-target="#modalEdit{{ $i->id }}" data-bs-toggle="modal"
                      style="border: none; background: transparent;"><i class="ti ti-edit text-white"></i></button>
                    <form id="deleteForm" action="{{ route('tempatPrakerin.destroy', $i->id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button style="border: none; background: transparent;" type="button"
                        class="fs-5 text-danger cursor-pointer" onclick="confirmDelete()"><i
                          class="ti ti-trash"></i></button>
                    </form>
                  </div>
                </div>
              </div>
              <div style="margin-top: 100px">
                <h4 class="card-title mb-1 text-light">{{ $i->name }}</h4>
                <h6 class="card-text fw-normal text-light d-inline-block text-truncate" style="max-width: 150px">
                  {{ $i->description }}
                </h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    @empty
    @endforelse
  </div>

  {{-- Modal Edit --}}
  @foreach ($prakerin as $i)
    <div class="modal fade modal-edit" id="modalEdit{{ $i->id }}" tabindex="-1"
      aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit {{ $i->name }}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body row px-4">
            <div class="col-md-6 col-12">
              <p class="fw-bold text-center">Edit lokasi perusahaan</p>
              <div class="preview-map" style=" width: 100%; border-radius: 20px" id="mapEdit-{{ $i->id }}"></div>
            </div>
            <div class="col-md-6 col-12">
              <form action="{{ route('tempatPrakerin.update', $i->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row justify-content-center align-items-center">
                  <div class="mb-3">
                    <label class="form-label">Nama Perusahaan</label>
                    <input class="form-control @error('name') is-invalid @enderror" value="{{ $i->name }}"
                      type="text" name="name" placeholder="Nama Perusahaan">
                    @error('name')
                      <div id="name-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Deskripsi Perusahaan</label>
                    <input class="form-control @error('description') is-invalid @enderror" type="text"
                      value="{{ $i->description }}" name="description" placeholder="Deskripsi Perusahaan">
                    @error('description')
                      <div id="description-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Alamat Perusahaan</label>
                    <input class="form-control @error('address') is-invalid @enderror" type="text"
                      value="{{ $i->address }}" name="address" placeholder="Alamat Perusahaan">
                    @error('address')
                      <div id="address-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-3">
                    <label class="form-label" for="logo_perusahaan">Upload Logo Perusahaan</label>
                    <div>
                      @if ($i->image)
                        <div class="mb-3">
                          <img src="{{ asset('storage/' . $i->image) }}" alt="Gambar Lama" class="img-fluid"
                            style="max-width: 200px;">
                        </div>
                      @endif
                    </div>
                    <div>
                      <input class="form-control @error('image') is-invalid @enderror" type="file" name="image"
                        id="logo_perusahaan">
                      @error('image')
                        <div id="image-error" class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Latitude</label>
                    <input class="form-control @error('latitude') is-invalid @enderror" type="text"
                      value="{{ $i->latitude }}" name="latitude" id="latitudeEdit-{{ $i->id }}"
                      placeholder="Latitude">
                    @error('latitude')
                      <div id="latitude-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Longitude</label>
                    <input class="form-control @error('longitude') is-invalid @enderror" type="text"
                      value="{{ $i->longitude }}" name="longitude" id="longitudeEdit-{{ $i->id }}"
                      placeholder="Longitude">
                    @error('longitude')
                      <div id="latitude-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
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
    </div>
  @endforeach

  {{-- Modal Tambah --}}
  <div class="modal fade modal-tambah" id="modaltambah" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
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
                      value="{{ old('name') }}" type="text" name="name" placeholder="Nama Perusahaan">
                    <div id="name-error" class="invalid-feedback"></div>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Deskripsi Perusahaan</label>
                    <input id="description" class="form-control @error('description') is-invalid @enderror"
                      type="text" value="{{ old('description') }}" name="description"
                      placeholder="Deskripsi Perusahaan">
                    <div id="description-error" class="invalid-feedback"></div>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Alamat Perusahaan</label>
                    <input id="address" class="form-control @error('address') is-invalid @enderror" type="text"
                      value="{{ old('address') }}" name="address" placeholder="Alamat Perusahaan">
                    <div id="address-error" class="invalid-feedback"></div>
                  </div>
                  <div class="mb-3">
                    <label class="form-label" for="logo_perusahaan">Upload Logo Perusahaan</label>
                    <input id="image" class="form-control @error('image') is-invalid @enderror" type="file"
                      value="{{ old('image') }}" name="image" id="logo_perusahaan">
                    <div id="image-error" class="invalid-feedback"></div>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Latitude</label>
                    <input id="latitude" class="form-control @error('latitude') is-invalid @enderror" type="text"
                      value="{{ old('latitude') }}" name="latitude" id="latitude" placeholder="Latitude">
                    <div id="latitude-error" class="invalid-feedback"></div>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Longitude</label>
                    <input id="longitude" class="form-control @error('longitude') is-invalid @enderror" type="text" value="{{ old('longitude') }}" name="longitude" id="longitude" placeholder="Longtitude">
                    <div id="longitude-error" class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  <button type="button" class="btn btn-primary" id="submitButton">Simpan</button>
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
    // Validation
    document.addEventListener("DOMContentLoaded", function() {
      document.getElementById("submitButton").addEventListener("click", function(event) {
        console.log('button clicked');
        if (validateForm()) {
          document.getElementById("formTambah").submit();
        }
      });

      function validateForm() {
        const name = document.getElementById("name").value;
        const description = document.getElementById("description").value;
        const address = document.getElementById("address").value;
        const image = document.getElementById("image");
        const latitude = parseFloat(document.getElementById("latitude").value);
        const longitude = parseFloat(document.getElementById("longitude").value);

        // Mengatur ulang pesan kesalahan sebelumnya
        resetErrorMessages();

        let isValid = true;

        if (name.trim() == "") {
          isValid = false;
          displayErrorMessage("name-error", "Nama Perusahaan harus diisi");
        }

        if (description.trim() == "") {
          isValid = false;
          displayErrorMessage("description-error", "Deskripsi Perusahaan harus diisi");
        }

        if (address.trim() == "") {
          isValid = false;
          displayErrorMessage("address-error", "Alamat Perusahaan harus diisi");
        }

        if (image.value.trim() == "") {
          isValid = false;
          displayErrorMessage("image-error", "Upload Logo Perusahaan harus diisi");
        } else if (!isValidImageFile(image)) {
          isValid = false;
          displayErrorMessage("image-error", "File harus berupa gambar (png, jpg, jpeg)");
        }

        if (!isValidCoordinate(latitude)) {
          isValid = false;
          displayErrorMessage("latitude-error", "Latitude harus berada di antara -90 dan 90");
        }

        if (!isValidCoordinate(longitude)) {
          isValid = false;
          displayErrorMessage("longitude-error", "Longitude harus berada di antara -180 dan 180");
        }

        return isValid;
      }

      function isValidCoordinate(value) {
        return !isNaN(value) && value >= -90 && value <= 90;
      }

      function isValidImageFile(fileInput) {
        const allowedExtensions = ["png", "jpg", "jpeg"];
        const fileName = fileInput.value.toLowerCase();
        return allowedExtensions.some(ext => fileName.endsWith(ext));
      }

      function displayErrorMessage(elementId, errorMessage) {
        document.getElementById(elementId).innerHTML = errorMessage;
      }

      function resetErrorMessages() {
        document.querySelectorAll(".invalid-feedback").forEach(element => {
          element.innerHTML = "";
        });
      }
    });

    // Modal Edit + Map
    $(document).ready(function() {
      @foreach ($prakerin as $i)
        $('#modalEdit{{ $i->id }}').on('shown.bs.modal', function() {
          initializeMapEdit('{{ $i->id }}', '{{ $i->latitude }}', '{{ $i->longitude }}');
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
    function confirmDelete() {
      Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Anda tidak bisa mengembalikan data ini lagi!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#FF5D5D',
        cancelButtonColor: '#FFB35D',
        confirmButtonText: 'Ya, Hapus!'
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('deleteForm').submit();
        }
      });
    }
  </script>
@endsection
