<!DOCTYPE html>
<html lang="en">

<head>
    <!-- <meta http-equiv="refresh" content="60"> -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Early Warning System </title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/fonts/ionicons.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/ews.css'); ?>">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body style="font-family: Poppins, sans-serif;font-size: 13px;">
    <nav class="navbar navbar-light navbar-expand-md py-2">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center">
                <span class="d-flex justify-content-center align-items-center me-2">
                    <img src="<?php echo base_url('assets/images/logo.png'); ?>" alt="Logo">
                </span>
                <span style="font-size: 21px;font-family: 'Quicksand', sans-serif;">
                    <strong>Early Warning System</strong>
                </span>
            </a>
        </div>
    </nav>
    <nav class="navbar navbar-light navbar-expand-md py-2 fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <span style="font-size: 21px;font-family: 'Quicksand', sans-serif;">
                    <strong>Early Warning System</strong>
                </span>
            </a>
            <div class="d-flex align-items-center">
                <div class="border-left mx-2" style="height: 50px;"></div>
                <img src="<?php echo base_url('assets/images/logo.png'); ?>" alt="Logo"
                    style="width:50px; margin-right:15px;">
                <div style="border-left: 1px solid grey; height: 50px;"></div>
                <img src="<?php echo base_url('assets/images/logo2.png'); ?>" alt="Logo"
                    style="width:50px; margin-left:15px;">
            </div>
        </div>
    </nav>

    <nav class="navbar navbar-expand-md py-1" style="background: #c7000d;height: 10px;">
        <div class="container">

        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2" style="background: #eadcdc;">
                <div class="row">
                    <div class="col">
                        <div class="row text-center">
                            <button class="table-button" id="table-button">Table</button>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row text-center">
                            <button class="chart-button" id="chart-button">Chart</button>
                        </div>
                    </div>
                </div>

                <!-- table container 1-->

                <div class="row" id="myTableContainer1">
                    <div class="col-12 text-center">
                        <h3 class="fw-bold mb-2 mt-4">Table</h3>
                        <hr>
                        <strong>Hide column</strong>
                    </div>
                    <div class="col-12 checkbox2">
                        <div class="form-check" style="margin-top: 5px;"><input class="form-check-input" type="checkbox"
                                id="hide-col-1"><label class="form-check-label" for="hide-col-1">Temperature</label>
                        </div>
                        <div class="form-check "><input class="form-check-input" type="checkbox" id="hide-col-2"><label
                                class="form-check-label" for="hide-col-2">Humidity</label>
                        </div>
                        <div class="form-check"><input class="form-check-input" type="checkbox" id="hide-col-3"><label
                                class="form-check-label" for="hide-col-3">Fire
                                anomaly</label>
                        </div>
                    </div>
                </div>

                <!-- --- -->

                <!-- chart container 1-->
                <div class="row" id="myChartContainer1" style="display:none">
                    <div class="col">
                        <div class="text-center">
                            <h3 class="fw-bold mb-2 mt-4">Chart</h3>
                            <hr>
                            <strong>Show data</strong>
                        </div>
                        <div class="checkbox2">
                            <div>
                                <input type="checkbox" id="temp-checkbox" checked>
                                <label for="temp-checkbox">Temperature</label>
                            </div>
                            <div>
                                <input type="checkbox" id="hum-checkbox" checked>
                                <label for="hum-checkbox">Humidity</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- table container 2-->

            <div class="col-lg-7" style="height: 100%;" id="myTableContainer2">
                <div style=" margin-top: 40px;">
                    <div class="table-responsive">
                        <table class="table table-hover" id="mydatatable">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Temperature</th>
                                    <th>Humidity</th>
                                    <th>Fire anomaly</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ews as $value): ?>
                                <tr>
                                    <td><?php echo $value['date'] ?></td>
                                    <td><?php echo $value['time'] ?></td>
                                    <td>
                                        <?php 
                                        if ($value['temp'] >= 24 && $value['temp'] <= 30) {
                                            echo '<b style="color:red;">' . $value['temp'] . ' °C </b>'; 
                                        } else if ($value['temp'] >= 31) {
                                            echo '<b style="color:red;">' . $value['temp'] . ' °C <span style="color:red;">&#9888;</span></b>'; // add warning symbol
                                        } else {
                                            echo $value['temp'] . ' °C'; 
                                        }
                                    ?>
                                    </td>
                                    <td><?php 
                                    if($value['hum'] >= 80){
                                        echo '<b style="color:blue;">'. $value['hum'] . ' % </b>';
                                    } else {
                                        echo $value['hum']. ' %';
                                    }
                                    ?>
                                    </td>
                                    <td><?php echo $value['fa'] ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ---  -->

            <!-- chart container 2 -->

            <div class="col-lg-7" style="display:none;margin-top: 40px; margin-bottom: 60px;" id="myChartContainer2">
                <div class="col">
                    <div id="chart-container">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- --- -->

            <div class="col">
                <div class="row">
                    <div class="col">
                        <div class="card-a">
                            <h5 class="fw-bold">Print</h5>
                            <hr class="hr-divide">
                            <form action="<?= base_url('/printpdf') ?>" method="get" target="_blank"
                                onsubmit="return checkDate()">
                                <div class="form-group row ms-2">
                                    <div class="col">
                                        <label class="mt-1" for="date">Select Date :</label>
                                    </div>
                                    <div class="col">
                                        <input type="date" id="date" name="date" value="<?= set_value('date') ?>">
                                    </div>
                                </div>
                                <div>
                                    <button type="submit" class="print-btn">
                                        <i class="bi bi-printer"></i> Print
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card-b">
                            <div class="card-body" style>
                                <h5 class="fw-bold">Predict</h5>
                                <hr class="hr-divide">
                                <form method="post" action="<?= base_url('/predict') ?>">
                                    <div class="form-group row ms-2">
                                        <div class="col">
                                            <label for="suhu_luar_besok" class="col-lg-11 col-form-label">Temperature
                                                outside:</label>
                                            <input type="number" class="form-control" name="suhu_luar_besok"
                                                id="suhu_luar_besok" placeholder="°C"
                                                value="<?= isset($_POST['suhu_luar_besok']) ? $_POST['suhu_luar_besok'] : '' ?>">
                                        </div>
                                        <div class="col">
                                            <label for="suhu_ac_besok" class="col-lg-11 col-form-label">Temp. inside
                                                (with AC):</label>
                                            <input type="number" class="form-control" name="suhu_ac_besok"
                                                id="suhu_ac_besok" placeholder="°C"
                                                value="<?= isset($_POST['suhu_ac_besok']) ? $_POST['suhu_ac_besok'] : '' ?>">
                                        </div>
                                    </div>
                                    <hr class="hr-divide" style="margin-top: 15px;">
                                    <div class="form-group row ms-2 mt-2">
                                        <div class="col">
                                            <label for="suhu_luar_besok" class="col-lg-11 col-form-label">Predicted :
                                                temp.</label>
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control mt-2" id="hasil" placeholder="Result"
                                                value="<?php echo isset($last_line) ? $last_line : ''; ?>" readonly>
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <?php if (strpos(current_url(), '/predict') === false): ?>
                                            <input type="submit" id="submit-predict" class="predict-btn"
                                                value="Predict">
                                            <?php endif; ?>
                                            <?php if (strpos(current_url(), '/predict') !== false): ?>
                                            <a type="button" id="reset-predict" class="predict-btn"
                                                href="<?= base_url('/') ?>">Reset</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- <div class="container-fluid" style="background: #aedcdc;height: 20px;">

            </div> -->
        </div>
    </div>

    <footer class="text-center text-footer">
        <div class="container-fluid" style="background: #c7000d;height: 20px;">
            <p class="mb-0 mt-1">
            <div style="font-size: 10px;">© 2023 PetroChina. All Rights Reserved. | Powered by Ilmu Komputer UNILA.
            </div>
            </p>
        </div>
    </footer>


    <!-- JavaScript files -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>


    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/theme.js"></script>
    <script>
    function checkDate() {
        var date = document.getElementById("date").value;
        if (date == "") {
            alert("Please pick a date first");
            return false;
        }
        return true;
    }
    </script>

    <script>
    document.getElementById("chart-button").addEventListener("click", function() {
        document.getElementById("myChartContainer1").style.display = "block";
        document.getElementById("myChartContainer2").style.display = "block";
        document.getElementById("myTableContainer1").style.display = "none";
        document.getElementById("myTableContainer2").style.display = "none";
    });

    document.getElementById("table-button").addEventListener("click", function() {
        document.getElementById("myChartContainer1").style.display = "none";
        document.getElementById("myChartContainer2").style.display = "none";
        document.getElementById("myTableContainer1").style.display = "block";
        document.getElementById("myTableContainer2").style.display = "block";
    });
    </script>

    <script>
    const checkbox1 = document.getElementById('hide-col-1');
    const checkbox2 = document.getElementById('hide-col-2');
    const checkbox3 = document.getElementById('hide-col-3');
    const table = document.getElementById('mydatatable');

    checkbox1.addEventListener('change', function() {
        if (this.checked) {
            hideColumn(3);
        } else {
            showColumn(3);
        }
    });

    checkbox2.addEventListener('change', function() {
        if (this.checked) {
            hideColumn(4);
        } else {
            showColumn(4);
        }
    });

    checkbox3.addEventListener('change', function() {
        if (this.checked) {
            hideColumn(5);
        } else {
            showColumn(5);
        }
    });

    function hideColumn(columnIndex) {
        for (let i = 0; i < table.rows.length; i++) {
            table.rows[i].cells[columnIndex - 1].style.display = 'none';
        }
    }

    function showColumn(columnIndex) {
        for (let i = 0; i < table.rows.length; i++) {
            table.rows[i].cells[columnIndex - 1].style.display = '';
        }
    }
    </script>
    <script>
    $(document).ready(function() {
        $('#mydatatable').DataTable({
            paging: true
        });
    });
    </script>

    <!-- <script>
        setInterval(function(){
            location.reload();
        }, 300000); // refresh every 60 seconds
    </script> -->

    <script>
    var ews = <?php echo json_encode($ews); ?>;
    var times = [];
    var temps = [];
    var hums = [];

    var count = 0; // variabel hitungan

    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                    label: 'Temperature',
                    data: [],
                    backgroundColor: 'red',
                    borderColor: 'red',
                    borderWidth: 1,
                    hidden: false // initially show temperature data
                },
                {
                    label: 'Humidity',
                    data: [],
                    backgroundColor: 'blue',
                    borderColor: 'blue',
                    borderWidth: 1,
                    hidden: false // initially show humidity data
                }
            ]
        },
        options: {
            responsive: true,
            // maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    },
                    height: 800
                }],
                xAxes: [{
                    type: 'time',
                    time: {
                        displayFormats: {
                            hour: 'HH:mm'
                        }
                    }
                }]
            },
            legend: {
                display: false, // hide the legend
            },
        },
    });

    var tempCheckbox = document.getElementById('temp-checkbox');
    var humCheckbox = document.getElementById('hum-checkbox');

    tempCheckbox.addEventListener('change', function() {
        if (tempCheckbox.checked) {
            chart.data.datasets[0].hidden = false; // show temperature dataset
        } else {
            chart.data.datasets[0].hidden = true; // hide temperature dataset
        }
        chart.update();
    });

    humCheckbox.addEventListener('change', function() {
        if (humCheckbox.checked) {
            chart.data.datasets[1].hidden = false; // show humidity dataset
        } else {
            chart.data.datasets[1].hidden = true; // hide humidity dataset
        }
        chart.update();
    });

    for (var i = 0; i < ews.length; i++) {
        if (count == 20) { // reset setiap 50 data
            chart.data.labels = [];
            chart.data.datasets[0].data = [];
            chart.data.datasets[1].data = [];
            count = 0;
        }

        chart.data.labels.push(ews[i].time);
        chart.data.datasets[0].data.push(ews[i].temp);
        chart.data.datasets[1].data.push(ews[i].hum);

        count++;
    }

    chart.update();
    </script>

</body>

</html>
