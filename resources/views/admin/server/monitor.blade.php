@extends('admin.layouts.app')

@section('page-title', 'Monitoring Server')

@section('breadcrumbs')
    <li class="nav-home">
        <a href="/admin/dashboard">
            <i class="flaticon-home"></i>
        </a>
    </li>
    <li class="separator">
        <i class="flaticon-right-arrow"></i>
    </li>
    <li class="nav-item">
        <a href="/admin/server/monitoring">Monitoring Server</a>
    </li>
@endsection

@section('content')
<div class="page-category">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Realtime CPU Usage</div>
                    </div>
                    <div class="card-body">
                        <div class="card-sub">
                            Monitoring realtime CPU usage with ChartJS.
                        </div>
                        <div class="chart-container">
                            <canvas id="htmlLegendsChart"></canvas>
                        </div>
                        <div id="myChartLegend"></div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Realtime RAM Usage</div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <div class="card-sub">
                                Monitoring realtime RAM usage with ChartJS.
                            </div>
                            <canvas id="pieChart" style="width: 50%; height: 50%"></canvas>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Network Realtime Statistik</div>
                    </div>
                    <div class="card-body">
                        <div class="card-header">
                            <div class="card-title">Realtime Network Usage</div>
                        </div>
                        <div class="chart-container">
                            <canvas id="multipleLineChart"></canvas>
                        </div>
                    </div>
                </div>
                
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var ctx = document.getElementById("htmlLegendsChart").getContext("2d");
                    
                    // Inisialisasi label dan data
                    var labels = [];
                    var data = [];
                
                    var myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: "CPU Usage",
                                data: data,
                                borderColor: '#177dff', 
                                fill: false,
                            }]
                        },
                        options : {
                            responsive: true, 
                            maintainAspectRatio: false,
                            legend: {
                                display: true
                            },
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        fontColor: "rgba(0,0,0,0.5)",
                                        fontStyle: "500",
                                        beginAtZero: true,
                                        maxTicksLimit: 5,
                                        padding: 20
                                    },
                                    gridLines: {
                                        drawTicks: false,
                                        display: false
                                    }
                                }],
                                xAxes: [{
                                    gridLines: {
                                        zeroLineColor: "transparent"
                                    },
                                    ticks: {
                                        padding: 20,
                                        fontColor: "rgba(0,0,0,0.5)",
                                        fontStyle: "500"
                                    }
                                }]
                            }
                        }
                    });
                
                    // Fungsi untuk mengambil data dari backend dan memperbarui chart
                    function updateChart() {
                        fetch('/admin/server/cpu-usage')
                            .then(response => response.json())
                            .then(responseData => {
                                if (labels.length > 9) {  // misalnya hanya menampilkan 10 data terakhir
                                    labels.shift();
                                    data.shift();
                                }
                                labels.push(new Date().toLocaleTimeString()); // Tambahkan waktu saat ini sebagai label
                                data.push(responseData.cpuUsage);
                
                                myChart.update();
                            });
                    }
                
                    // Panggil fungsi updateChart setiap 5 detik
                    // setInterval(updateChart, 5000);
                    setInterval(updateChart, 1000);
                });

                document.addEventListener('DOMContentLoaded', function() {
                    var pieChartCtx = document.getElementById('pieChart').getContext('2d');

                    var ramChart = new Chart(pieChartCtx, {
                        type: 'pie',
                        data: {
                            datasets: [{
                                data: [0, 0],  // Data awal (akan diperbarui)
                                backgroundColor :["#1d7af3","#f3545d"],
                                borderWidth: 0
                            }],
                            labels: ['Used RAM', 'Available RAM'] 
                        },
                        // (sisa konfigurasi Anda)
                    });

                    function updateRamChart() {
                        fetch('/admin/server/ram-usage')
                            .then(response => response.json())
                            .then(data => {
                                // Gunakan data persentase untuk chart
                                ramChart.data.datasets[0].data = [data.usedPercentage, data.availablePercentage];
                                
                                // Tambahkan data GB ke dataset (ini adalah trik untuk mengaksesnya nanti di dalam tooltip callback)
                                ramChart.data.datasets[0].dataGB = [data.usedRAMGB, data.availableRAMGB];
                                
                                // Ubah label untuk menampilkan data dalam GB dan %
                                ramChart.options.tooltips.callbacks = {
                                    label: function(tooltipItem, chartData) {
                                        var label = chartData.labels[tooltipItem.index];
                                        var valueInGB = chartData.datasets[tooltipItem.datasetIndex].dataGB[tooltipItem.index];
                                        return `${label}: ${valueInGB} GB (${tooltipItem.yLabel}%)`;
                                    }
                                };

                                ramChart.update();
                            });
                    }



                    // Panggil fungsi updateRamChart setiap 1 detik
                    setInterval(updateRamChart, 1000);
                });

                document.addEventListener('DOMContentLoaded', function() {
                    var multipleLineChartCtx = document.getElementById('multipleLineChart').getContext('2d');

                    var labels = []; // Anda bisa mempertimbangkan untuk menambahkan timestamp atau detik saat ini ke dalam array ini
                    var downloadData = [];
                    var uploadData = [];

                    var networkChart = new Chart(multipleLineChartCtx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: "Download",
                                borderColor: "#1d7af3",
                                backgroundColor: 'transparent',
                                data: downloadData,
                                fill: false,
                            }, {
                                label: "Upload",
                                borderColor: "#59d05d",
                                backgroundColor: 'transparent',
                                data: uploadData,
                                fill: false,
                            }]
                        },
                        options : {
                            responsive: true, 
                            maintainAspectRatio: false,
                            legend: {
                                position: 'top',
                            },
                            tooltips: {
                                bodySpacing: 4,
                                mode:"nearest",
                                intersect: 0,
                                position:"nearest",
                                xPadding:10,
                                yPadding:10,
                                caretPadding:10
                            },
                            layout:{
                                padding:{left:15,right:15,top:15,bottom:15}
                            }
                        }
                    });

                    function updateNetworkChart() {
                        fetch('/admin/server/network-stats')
                            .then(response => response.json())
                            .then(data => {
                                if (labels.length > 11) {  // Misalnya hanya menampilkan data 12 terakhir
                                    labels.shift();
                                    downloadData.shift();
                                    uploadData.shift();
                                }
                                labels.push(new Date().toLocaleTimeString());

                                // Contoh: menggunakan data dalam MB
                                downloadData.push(data.download.mb);
                                uploadData.push(data.upload.mb);

                                networkChart.update();
                            });
                    }

                    setInterval(updateNetworkChart, 1000);
                });


                </script>
            </div>
        </div>
    </div>
</div>
@endsection
