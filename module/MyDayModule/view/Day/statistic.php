<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MyDay</title>
    <!-- bootstrap -->
    <link rel="stylesheet" href="/css/bootstrap/bootstrap.min.css">
    <!-- style -->
    <style>
    body {
        background-color: #330033;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='392' height='392' viewBox='0 0 800 800'%3E%3Cg fill='none' stroke='%23404' stroke-width='1'%3E%3Cpath d='M769 229L1037 260.9M927 880L731 737 520 660 309 538 40 599 295 764 126.5 879.5 40 599-197 493 102 382-31 229 126.5 79.5-69-63'/%3E%3Cpath d='M-31 229L237 261 390 382 603 493 308.5 537.5 101.5 381.5M370 905L295 764'/%3E%3Cpath d='M520 660L578 842 731 737 840 599 603 493 520 660 295 764 309 538 390 382 539 269 769 229 577.5 41.5 370 105 295 -36 126.5 79.5 237 261 102 382 40 599 -69 737 127 880'/%3E%3Cpath d='M520-140L578.5 42.5 731-63M603 493L539 269 237 261 370 105M902 382L539 269M390 382L102 382'/%3E%3Cpath d='M-222 42L126.5 79.5 370 105 539 269 577.5 41.5 927 80 769 229 902 382 603 493 731 737M295-36L577.5 41.5M578 842L295 764M40-201L127 80M102 382L-261 269'/%3E%3C/g%3E%3Cg fill='%23505'%3E%3Ccircle cx='769' cy='229' r='7'/%3E%3Ccircle cx='539' cy='269' r='7'/%3E%3Ccircle cx='603' cy='493' r='7'/%3E%3Ccircle cx='731' cy='737' r='7'/%3E%3Ccircle cx='520' cy='660' r='7'/%3E%3Ccircle cx='309' cy='538' r='7'/%3E%3Ccircle cx='295' cy='764' r='7'/%3E%3Ccircle cx='40' cy='599' r='7'/%3E%3Ccircle cx='102' cy='382' r='7'/%3E%3Ccircle cx='127' cy='80' r='7'/%3E%3Ccircle cx='370' cy='105' r='7'/%3E%3Ccircle cx='578' cy='42' r='7'/%3E%3Ccircle cx='237' cy='261' r='7'/%3E%3Ccircle cx='390' cy='382' r='7'/%3E%3C/g%3E%3C/svg%3E");
    }

    .card {
        box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.38);
        border: none;
    }

    .chart {
        background-color: #ffffff;
    }
    .row{
        margin-left:0;
    }
    </style>
</head>

<body>
    <!-- jquery -->
    <script src="/js/jquery-3.4.1.min.js"></script>
    <!-- bootstrap -->
    <script src="/js/bootstrap/bootstrap.popper.min.js"></script>
    <script src="/js/bootstrap/bootstrap.min.js"></script>
    <!-- my js -->
    <script src="/js/chart.min.js"></script>

    <div class="d-flex m-3 border-bottom">
        <a href="/day/update" class="mb-2 btn btn-success mr-auto">Ngày hôm nay</a>
        <div class="dropdown ml-auto">
            <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <?=$account['name']?>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="/logout">Đăng xuất</a>
            </div>
        </div>
    </div>

    <div class='container mt-5'>
        <div class="card mt-3">
            <p class="card-header">Thành tích của bạn</p>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <tbody>
                      
                        <?php
                            foreach ($achievement as $value) {
                                echo '<tr><td>' . $value['day'] . '</td>';
                                echo '<td>' . $value['achievement'] . '</td></tr>';
                            }
                        ?>
                      
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class='container mt-3'>
        <div class="container row">
            <div class='col-md-9'>
                <div class="card mt-3">
                    <p class="card-header">Tổng năng lượng nạp vào mỗi ngày</p>
                    <div class="card-body p-1">
                        <canvas class='chart rounded ' id="myChart1"></canvas>
                    </div>
                </div>
                <div class="card mt-3">
                    <p class="card-header">Tổng thời gian ngủ mỗi ngày</p>
                    <div class="card-body p-1">
                        <canvas class='chart rounded ' id="myChart2"></canvas>
                    </div>
                </div>
            </div>
            <div class='col-md-3'>
                <div class="card mt-3">
                    <p class="card-header">Thường ngủ lúc</p>
                    <div class="card-body p-2">
                        <canvas class='chart rounded' id="myChart3"></canvas>
                    </div>
                </div>
                <div class="card mt-3">
                    <p class="card-header">Thường dậy lúc</p>
                    <div class="card-body p-2">
                        <canvas class='chart rounded' id="myChart4"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    
        
        <script>
    let dates = [ 
        <?php
        foreach($lineCharts as $value) {
            if(!empty($value['calories']))
            {
                echo '"' . $value['aday'] . '",';
            }
        } ?>
    ];
    let dates2 = [ 
        <?php
        foreach($lineCharts as $value) {
            if(!empty($value['sleeping_time']))
            {
                echo '"' . $value['aday'] . '",';
            }
        } ?>
    ];

    let calories = [ 
        <?php
        foreach($lineCharts as $value) {
            if(!empty($value['calories']))
            {
                echo $value['calories'] . ',';
            }
        } ?>
    ];

    let sleepings = [ 
        <?php
        foreach($lineCharts as $value) {
            if(!empty($value['sleeping_time']))
            {
                echo $value['sleeping_time'] . ',';
            }
        } ?>
    ];

    let usuallyWakeUpTime = [ 
        <?php
        foreach($doughnutCharts['usuallyWakeUp'] as $value) {
            echo '"' . $value['waking_up_time'] . '",';
        } ?>
    ];
    let usuallyWakeUpNum = [ 
        <?php
        foreach($doughnutCharts['usuallyWakeUp'] as $value) {
            echo $value['num'] . ',';
        } ?>
    ];

    let usuallySleepTime = [ 
        <?php
        foreach($doughnutCharts['usuallySleep'] as $value) {
            echo '"' . $value['sleeping_time'] . '",';
        } ?>
    ];
    let usuallySleepNum = [ 
        <?php
        foreach($doughnutCharts['usuallySleep'] as $value) {
            echo $value['num'] . ',';
        } ?>
    ];


    let canvas = document.getElementById("myChart1");
    let ctx = canvas.getContext('2d');
    let myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: 'Tổng calorie trong ngày',
                data: calories,
                borderColor: [
                    'rgb(138, 58, 191)'
                ],
                borderWidth: 3,
                pointBorderWidth: 4,
                pointHitRadius: 20
            }]
        },
        options: {
            legend: {
                display: false,
            }
        }
    });
    let canvas2 = document.getElementById("myChart2");
    let ctx2 = canvas2.getContext('2d');
    let myChart2 = new Chart(ctx2, {
        type: 'line',
        data: {
            labels: dates2,
            datasets: [{
                label: 'Tổng ngủ trong ngày',
                data: sleepings,
                borderColor: [
                    'rgb(34, 81, 120)'
                ],
                borderWidth: 3,
                pointBorderWidth: 4,
                pointHitRadius: 20
            }]
        },
        options: {
            legend: {
                display: false,
            }
        }
    });
    let canvas3 = document.getElementById("myChart3");
    let ctx3 = canvas3.getContext('2d');
    let myChart3 = new Chart(ctx3, {
        type: 'doughnut',
        data: {
            labels: usuallySleepTime,
            datasets: [{
                label: 'Giờ ngủ mỗi ngày',
                data: usuallySleepNum,
                backgroundColor: [
                    '#922B21',
                    '#B03A2E',
                    '#76448A',
                    '#6C3483',
                    '#1F618D',
                    '#2874A6',
                    '#148F77',
                    '#117A65',
                    '#1E8449',
                    '#239B56',
                    '#B7950B',
                    '#B9770E',
                    '#AF601A',
                    '#A04000',
                    '#B3B6B7',
                    '#909497',
                    '#717D7E',
                    '#616A6B',
                    '#283747',
                    '#212F3D'
                ],
            }]
        },
        options: {
            legend: {
                display: false,
            }
        }
    });
    let canvas4 = document.getElementById("myChart4");
    let ctx4 = canvas4.getContext('2d');
    let myChart4 = new Chart(ctx4, {
        type: 'doughnut',
        data: {
            labels: usuallyWakeUpTime,
            datasets: [{
                label: 'Giờ ngủ mỗi ngày',
                data: usuallyWakeUpNum,
                backgroundColor: [
                    '#922B21',
                    '#B03A2E',
                    '#76448A',
                    '#6C3483',
                    '#1F618D',
                    '#2874A6',
                    '#148F77',
                    '#117A65',
                    '#1E8449',
                    '#239B56',
                    '#B7950B',
                    '#B9770E',
                    '#AF601A',
                    '#A04000',
                    '#B3B6B7',
                    '#909497',
                    '#717D7E',
                    '#616A6B',
                    '#283747',
                    '#212F3D'
                ],
            }]
        },
        options: {
            legend: {
                display: false,
            }
        }
    });
    </script>



</body>

</html>