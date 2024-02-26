@extends('layouts.app')

@section('content')
  <!--  Owl carousel -->
  <div class="owl-carousel counter-carousel owl-theme">
    <div class="item">
      <div class="card border-0 zoom-in bg-light-primary shadow-none">
        <div class="card-body">
          <div class="text-center">
            <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-user-male.svg" width="50" height="50" class="mb-3" alt="" />
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
            <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-briefcase.svg" width="50" height="50" class="mb-3" alt="" />
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
            <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-mailbox.svg" width="50" height="50" class="mb-3" alt="" />
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
            <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-favorites.svg" width="50" height="50" class="mb-3" alt="" />
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
      var options_spline = {
        series: [{
            name: "series1",
            data: [31, 40, 28, 51, 42, 109, 100],
          },
          {
            name: "series2",
            data: [11, 32, 45, 32, 34, 52, 41],
          },
        ],
        chart: {
          fontFamily: "DM Sans,sans-serif",
          height: 350,
          type: "area",
          toolbar: {
            show: false,
          },
        },
        grid: {
          show: false,
        },
        colors: ["#615dff", "#3dd9eb"],
        dataLabels: {
          enabled: false,
        },
        stroke: {
          curve: "smooth",
        },
        xaxis: {
          type: "datetime",
          categories: [
            "2018-09-19T00:00:00.000Z",
            "2018-09-19T01:30:00.000Z",
            "2018-09-19T02:30:00.000Z",
            "2018-09-19T03:30:00.000Z",
            "2018-09-19T04:30:00.000Z",
            "2018-09-19T05:30:00.000Z",
            "2018-09-19T06:30:00.000Z",
          ],
          labels: {
            style: {
              colors: [
                "#a1aab2",
                "#a1aab2",
                "#a1aab2",
                "#a1aab2",
                "#a1aab2",
                "#a1aab2",
                "#a1aab2",
              ],
            },
          },
        },
        yaxis: {
          labels: {
            style: {
              colors: [
                "#a1aab2",
                "#a1aab2",
                "#a1aab2",
                "#a1aab2",
                "#a1aab2",
                "#a1aab2",
                "#a1aab2",
              ],
            },
          },
        },
        tooltip: {
          x: {
            format: "dd/MM/yy HH:mm",
          },
          theme: "dark",
        },
        legend: {
          labels: {
            colors: ["#a1aab2"],
          },
        },
      };

      var myChart = new ApexCharts(
        document.querySelector("#myChart"),
        options_spline
      );
      myChart.render();
    })
  </script>
@endsection
