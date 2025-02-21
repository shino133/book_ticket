@push('foot')
<script src="{{ asset('js/chart.js/Chart.min.js') }}"></script>

<script>
    // Thiết lập font mặc định và màu chữ mặc định để giống với kiểu dáng mặc định của Bootstrap
    Chart.defaults.global.defaultFontFamily = 'Nunito',
        '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';

    @php
    use App\ Models\ Role;
    $movies = \App\ Models\ Movie::with('category') - > get();
    $categories = $movies - > groupBy('category_id');
    $categoryLabels = $categories - > map(fn($category) => $category[0] - > category - > title) - > values();
    $categoryCounts = $categories - > map(fn($category) => $category - > count()) - > values();

    // Lấy năm phát hành của phim và nhóm lại theo năm
    $releaseYears = $movies -
        >
        map(function($movie) {
            $movie - > release_year = $movie - > release_date - > year;
            return $movie;
        }) -
        >
        sortBy('release_year') -
        >
        groupBy('release_year');
    $years = $releaseYears - > keys();
    $yearCounts = $releaseYears - > map(fn($year) => $year - > count()) - > values();
    @endphp

    // Hàm tạo một mảng các màu nền ngẫu nhiên
    function generateBackgroundColors(numColors) {
        var colors = [];
        for (var i = 0; i < numColors; i++) {
            // Tạo một màu ngẫu nhiên dưới dạng mã hex
            var color = '#' + Math.floor(Math.random() * 16777215).toString(16);
            colors.push(color);
        }
        return colors;
    }

    var numCategories = @json($categoryLabels).length;
    var backgroundColors = generateBackgroundColors(numCategories);

    // Khởi tạo biểu đồ tròn
    var pieCtx = document.getElementById("manager-pie-chart");
    var myPieChart = new Chart(pieCtx, {
        type: 'doughnut',
        data: {
            labels: @json($categoryLabels),
            datasets: [{
                data: @json($categoryCounts),
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
            labels: @json($years), // Nhãn trục x (năm phát hành)
            datasets: [{
                label: "Số lượng", // Nhãn dữ liệu
                backgroundColor: "#4e73df",
                hoverBackgroundColor: "#2e59d9",
                borderColor: "#4e73df",
                data: @json($yearCounts), // Số lượng phim phát hành theo năm
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
                        max: @json(max($yearCounts - > toArray())), // Giá trị lớn nhất của trục y
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
