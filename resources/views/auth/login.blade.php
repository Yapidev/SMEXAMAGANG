@extends('layouts.auth')

@section('content')
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-sidebartype="full" data-sidebar-position="fixed"
    data-header-position="fixed">
    <div class="position-relative overflow-hidden min-vh-100">
      <div class="position-relative z-index-5">
        <div class="row">
          <div class="col-xl-7 col-xxl-8" style="background-color: #fcfcfc">
            <div class="d-none d-xl-flex flex-column align-items-center justify-content-center"
              style="height: calc(100vh - 80px);">
              <img src="{{ asset('assets/sekolah/sekolah.png') }}" alt="" class="img-fluid" width="200">
              <div class="text fs-7 fw-bolder text-dark w-60 text-center">
                <p>Website Management Prakerin Siswa SMKN 1 Probolinggo</p>
              </div>
            </div>
          </div>
          <div class="col-xl-5 col-xxl-4 ">
            <div class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4">
              <div class="col-sm-8 col-md-6 col-xl-9">
                <h2 class="mb-3 fs-7 fw-bolder">Management PKL</h2>
                <form action="{{ route('login') }}" method="POST">
                  @csrf
                  <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                      id="email" aria-describedby="emailHelp">
                    @error('email')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input name="password" type="password" class="form-control @error('password') is-invalid @enderror"
                      id="password">
                    @error('password')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <button type="submit" class="btn btn-danger w-100 py-8 mb-4 rounded-2">Masuk</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
@endsection
