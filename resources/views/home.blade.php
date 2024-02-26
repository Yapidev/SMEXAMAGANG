@extends('layouts.app')

@section('content')
    <!--  Owl carousel -->
    <div class="owl-carousel counter-carousel owl-theme">
        <div class="item">
            <div class="card border-0 zoom-in bg-light-primary shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-user-male.svg"
                            width="50" height="50" class="mb-3" alt="" />
                        <p class="fw-semibold fs-3 text-primary mb-1"> Siswa </p>
                        <h5 class="fw-semibold text-primary mb-0">{{ $carouselData['siswa'] }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="card border-0 zoom-in bg-light-warning shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-briefcase.svg"
                            width="50" height="50" class="mb-3" alt="" />
                        <p class="fw-semibold fs-3 text-warning mb-1">Pembimbing</p>
                        <h5 class="fw-semibold text-warning mb-0">{{ $carouselData['pembimbing'] }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="card border-0 zoom-in bg-light-info shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-mailbox.svg"
                            width="50" height="50" class="mb-3" alt="" />
                        <p class="fw-semibold fs-3 text-info mb-1">Tempat PKL</p>
                        <h5 class="fw-semibold text-info mb-0">{{ $carouselData['tempat_prakerin'] }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="card border-0 zoom-in bg-light-danger shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-favorites.svg"
                            width="50" height="50" class="mb-3" alt="" />
                        <p class="fw-semibold fs-3 text-danger mb-1">Siswa PKL</p>
                        <h5 class="fw-semibold text-danger mb-0">{{ $carouselData['prakerin'] }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div>
            <p>Data Siswa Aktif Prakerin</p>
        </div>
        <div class="chart-spline">
            <div id="myChart"></div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/apex-chart/apex.area.init.js') }}"></script>
    <script>
      $(function() {
    var carouselData = @json($carouselData);

    var years = [];
    for (var i = carouselData.tahun[0]; i >= carouselData.tahun[0] - 4; i--) {
        years.push(i);
    }

    var data = years.map(function(year) {
        return carouselData.tahun.includes(year) ? Math.round(carouselData.totalSiswa[carouselData.tahun.indexOf(year)]) : 0;
    });

    var options_spline = {
        series: [{
            name: "Total Siswa",
            data: data,
        }],
        chart: {
            fontFamily: "DM Sans, sans-serif",
            height: 350,
            type: "area",
            toolbar: {
                show: false,
            },
        },
        xaxis: {
            categories: years,
            labels: {
                rotate: -45,
            },
        },
        yaxis: {
            title: {
                text: 'Jumlah',
            },
            labels: {
                formatter: function (value) {
                    return Math.round(value);
                }
            }
        },
        colors: ["#615dff"],
        tooltip: {
            theme: "dark",
        },
    };

    var myChart = new ApexCharts(
        document.querySelector("#myChart"),
        options_spline
    );
    myChart.render();
});
  </script>
@endsection
