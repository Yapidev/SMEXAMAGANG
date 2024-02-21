@extends('layouts.app')

@section('link')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
  <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
  <link rel="stylesheet" href="{{ asset('assets/css/custome/tempatprakerin/style.css') }}">
@endsection

@section('content')
  <div class="card bg-white shadow-sm position-relative overflow-hidden">
    <div class="card-body px-4 py-3">
      <div class="row align-items-center">
        <div class="col-9">
          <h4 class="fw-semibold mb-8">List Prakerin Siswa</h4>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item" aria-current="page">Prakerin</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    @forelse ($prakerin as $data)
      <div class="col-12 col-md-4 gy-3">
        <div class="card-custome border">
          <div class="card-image">
            <a href="javascript:void(0)" class="card text-white w-100 card-hover"
              style="background: url('{{ asset('storage/' . $data->tempat_prakerin->image) }}') center; background-size: cover; width: 100%; height: 200px; object-fit: cover;">
            </a>
          </div>
          <div class="card-overlay">
            <a href="{{ route('prakerin.show', $data->id) }}">
              <div class="card-body">
                <div style="margin-top: 100px">
                  <h4 class="card-title mb-1 text-light">{{ $data->tempat_prakerin->name }}</h4>
                  <h6 class="card-text fw-normal text-light d-inline-block text-truncate" style="max-width: 150px">
                    {{ $data->tempat_prakerin->description }}
                  </h6>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
    @empty
      <div class="col-md-12">
        <p class="fw-bold">Data Prakerin belum ada silahkan isi data tempat prakerin terlebih dahulu!</p>
      </div>
    @endforelse
  </div>
@endsection
