@extends('layouts.app')

@section('link')
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
@endsection

@section('content')
  <div id="map"></div>
@endsection

@section('script')
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <script>
    // Inisialisasi peta
    var map = L.map('map').setView([latitude, longitude], 15);

    // Menambahkan peta dasar dari OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Menambahkan marker ke lokasi perusahaan
    var companyLocation = L.marker([latitude, longitude]).addTo(map);
    companyLocation.bindPopup("<b>Nama Perusahaan</b><br>Alamat Perusahaan").openPopup();
</script>
@endsection
