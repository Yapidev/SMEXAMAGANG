@extends('layouts.app')

@section('link')
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
@endsection

@section('content')
  
@endsection

@section('script')
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var map = L.map('map').setView([-2.5489, 118.0149], 4);

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
      }).addTo(map);

      var marker = L.marker([-2.5489, 118.0149], {
        draggable: true
      }).addTo(map);

      marker.on('dragend', function(event) {
        var markerLatLng = marker.getLatLng();
        document.getElementById('latitude').value = markerLatLng.lat;
        document.getElementById('longitude').value = markerLatLng.lng;
      });

      map.on('click', function(event) {
        marker.setLatLng(event.latlng);
        document.getElementById('latitude').value = event.latlng.lat;
        document.getElementById('longitude').value = event.latlng.lng;
      });
    });
  </script>
@endsection
