@extends('manager.layout')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Movies</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $numOfMovies }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-film fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Chương trình</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $numOfShows }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-compact-disc fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Chương trình trong tuần tới
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $showsNextWeek }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Khách hàng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $numOfCustomers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <!-- Bar Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ngày phát hành phim</h6>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="manager-bar-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Thể loại phim</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="manager-pie-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('foot')
    <script src="{{ asset('js/chart.js/Chart.min.js') }}"></script>

    <script>
        // Thiết lập font mặc định và màu chữ mặc định để giống với kiểu dáng mặc định của Bootstrap
        Chart.defaults.global.defaultFontFamily =
            'Nunito, -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';

        const categoryLabels = @json($categoryLabels);
        const categoryCounts = @json($categoryCounts);
        const years = @json($years);
        const yearCounts = @json($yearCounts);

        // Hàm tạo một mảng các màu nền ngẫu nhiên
        function generateBackgroundColors(numColors) {
            var colors = [];
            for (var i = 0; i < numColors; i++) {
                var color = '#' + Math.floor(Math.random() * 16777215).toString(16).padStart(6, '0');
                colors.push(color);
            }
            return colors;
        }


        var numCategories = categoryLabels.length;
        var backgroundColors = generateBackgroundColors(numCategories);

        // Khởi tạo biểu đồ tròn
        var pieCtx = document.getElementById("manager-pie-chart");
        var myPieChart = new Chart(pieCtx, {
            type: 'doughnut',
            data: {
                labels: categoryLabels,
                datasets: [{
                    data: categoryCounts,
                    backgroundColor: backgroundColors,
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false, // Giữ tỉ lệ khung hình
                tooltips: {
                    backgroundColor: "rgb(255,255,255)", // Màu nền tooltip
                    bodyFontColor: "#858796", // Màu chữ tooltip
                    borderColor: '#dddfeb', // Màu viền tooltip
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
                cutoutPercentage: 80, // Điều chỉnh phần rỗng ở giữa biểu đồ
            },
        });

        // Khởi tạo biểu đồ cột
        var barCtx = document.getElementById("manager-bar-chart");
        var myBarChart = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: years, // Nhãn trục x (năm phát hành)
                datasets: [{
                    label: "Số lượng", // Nhãn dữ liệu
                    backgroundColor: "#4e73df",
                    hoverBackgroundColor: "#2e59d9",
                    borderColor: "#4e73df",
                    data: yearCounts, // Số lượng phim phát hành theo năm
                }],
            },
            options: {
                maintainAspectRatio: false, // Giữ tỉ lệ khung hình
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'year' // Đơn vị trục x là năm
                        },
                        gridLines: {
                            display: false, // Ẩn lưới dọc
                            drawBorder: false
                        },
                        maxBarThickness: 25, // Độ dày tối đa của cột
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0, // Giá trị nhỏ nhất của trục y
                            max: yearCounts.length ? Math.max(...yearCounts) :
                            10, // Giá trị mặc định là 10 nếu mảng rỗng
                            maxTicksLimit: 5, // Giới hạn số vạch chia trên trục y
                            padding: 10, // Khoảng cách giữa vạch chia và giá trị
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)", // Màu của lưới
                            zeroLineColor: "rgb(234, 236, 244)", // Màu của đường gốc trục y
                            drawBorder: false,
                            borderDash: [2], // Định dạng đường nét đứt
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false // Ẩn chú thích
                },
                tooltips: {
                    titleMarginBottom: 10, // Khoảng cách giữa tiêu đề và nội dung tooltip
                    titleFontColor: '#6e707e', // Màu chữ tiêu đề tooltip
                    titleFontSize: 14, // Kích thước chữ tiêu đề tooltip
                    backgroundColor: "rgb(255,255,255)", // Màu nền tooltip
                    bodyFontColor: "#858796", // Màu chữ nội dung tooltip
                    borderColor: '#dddfeb', // Màu viền tooltip
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10, // Khoảng cách giữa tooltip và điểm dữ liệu
                },
            }
        });
    </script>
@endpush
