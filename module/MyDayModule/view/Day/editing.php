<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MyDay</title>
    <!-- bootstrap -->
    <link rel="stylesheet" href="/css/bootstrap/bootstrap.min.css">
    <!-- timepicker -->
    <link rel="stylesheet" href="/css/jquery.timeselector.css">
    <!-- datepicker -->
    <link rel="stylesheet" href="/css/bootstrap/bootstrap-datepicker3.min.css">
    <!-- style -->
    <style>
            body{
                background-color: #00bb77;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='120' viewBox='0 0 120 120'%3E%3Cpolygon fill='%23000' fill-opacity='.1' points='120 0 120 60 90 30 60 0 0 0 0 0 60 60 0 120 60 120 90 90 120 60 120 0'/%3E%3C/svg%3E");
            }
            .card{
                box-shadow:4px 4px 10px rgba(0, 0, 0, 0.38);
                border: none;
            }
            .form-control[readonly]{
                background-color: #ffffff;
            }
    </style>
</head>

<body>
    <!-- jquery -->
    <script src="/js/jquery-3.4.1.min.js"></script>
    <!-- my js -->
    <script src="/js/myjs.js"></script>
    <!-- bootstrap -->
    <script src="/js/bootstrap/bootstrap.popper.min.js"></script>
    <script src="/js/bootstrap/bootstrap.min.js"></script>
    <!-- timepicker -->
    <script src="/js/jquery.timeselector.min.js"></script>
    <!-- datepicker -->
    <script src="/js/datepicker.min.js"></script>


    
    

    


    <div class="d-flex m-3 border-bottom">
        <a href="/statistic" class="mb-2 btn btn-light mr-auto">Xem thống kê</a>
        <div class="dropdown ml-auto">
            <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?=$account['name']?>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="/logout">Đăng xuất</a>
            </div>
        </div>
    </div>

    <main class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <h1 class="mb-5 text-center text-white"><?=$date?></h1>
                    <form action="/day/update" method="POST">
                        <div class="form-group">
                            <div class="card">
                                <p class="card-header bg-info text-white">Thời gian trong ngày</p>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Giờ dậy</span>
                                            </div>
                                            <input readonly name="waking_up_time" class="form-control time" type="text"
                                                value="<?=empty($day['waking_up_time']) ? '00:00' : $day['waking_up_time']?>" style="min-width:190px">
                                            <span class="input-group-prepend">
                                                <span class="input-group-text">Ngủ thêm</span>
                                            </span>
                                            <input readonly name="bonus_time" class="form-control time" type="text"
                                                value="<?=empty($day['bonus_time']) ? '00:00' : $day['bonus_time']?>" style="min-width:190px">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Giờ ngủ</span>
                                            </div>
                                            <input readonly name="sleeping_time" class="form-control time" type="text"
                                                value="<?=empty($day['sleeping_time']) ? '00:00' : $day['sleeping_time']?>" style="min-width:190px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="card">
                                <p class="card-header bg-info text-white">Ăn uống trong ngày</p>
                                <div class="card-body">
                                    <div id="eatting-list" class="form-group">




                                        <?php
                                        foreach ($day['eatting_list'] as $index => $value) {
                                            $describe = $value['describe'];
                                            $calorie = $value['calorie'];
                                            $id = $value['id'];

                                            echo "<div class='input-group mb-3'>
                                                    <div class='input-group-prepend'>
                                                        <span class='input-group-text'>tên
                                                            món</span>
                                                    </div>
                                                    <input name='name-{$index}' type='text' class='form-control' value='{$describe}' style='min-width:190px'>
                                                    <div class='input-group-prepend'>
                                                        <span class='input-group-text'>calorie</span>
                                                    </div>
                                                    <input name='calo-{$index}' type='number' class='form-control' value='{$calorie}' style='min-width:190px'>

                                                    <input name='id-{$index}' type='text' hidden value='{$id}'>
                                                </div>";
                                        }

                                    ?>



                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-info" onclick="addEattingTab(event)"> Thêm món </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="card">
                                <p class="card-header bg-info text-white">Thành tích trong ngày</p>
                                <div class="card-body">
                                    <textarea style="min-height:150px" class="form-control"
                                        name="achievement"><?=$day['achievement']?></textarea>
                                </div>
                            </div>
                        </div>
                        <input type="text" name="day_id" style="display:none" value="<?=$day['id']?>">
                        <div class="row mt-4">
                            <input class="m-2 btn btn-light font-weight-bold text-info mr-auto" style="height:39px;width:200px;cursor:pointer" id="datepicker" onchange="changeTime(event)" type="text" value="Sửa ngày khác" readonly>
                            <button type="submit" class="m-2 mb-5 btn btn-light font-weight-bold text-success ml-auto">-->   Lưu ngay   <--</button>
                        </div>
                        <p class="mt-5 text-white" style="font-size:.7rem">Lần sửa đổi gần nhất: <?=MyDateFormat::getByFormat($day['updated_at'], 'Y-m-d H:i:s', 'H:i d/m/Y')?></p>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
    function addEattingTab(event) {
        event.preventDefault();


        let manager = new InnerManagement('eatting-list', 'new-eatting-tab');
        let element = manager.insert(`<div class="input-group mb-3 new-eatting-tab"></div>`);
        if (element !== null) {
            let tab =
                `<div class="input-group-prepend">
                    <span class="input-group-text">tên món</span>
                </div>
                <input name="new-name-${element.dataset.index}" type="text" class="form-control" style="min-width:190px">
                <div class="input-group-prepend">
                    <span class="input-group-text">calorie</span>
                </div>
                <input name="new-calo-${element.dataset.index}" type="number" class="form-control" style="min-width:190px">`;
            element.innerHTML += tab;
        } else {
            alert('lỗi không tìm thấy element');
        }
    }
    </script>

    <script>
    $(function() {
        $('.time').timeselector({
            hours12: false
        })
    });
    let container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    $('#datepicker').datepicker({
            format: 'dd/mm/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,});
    </script>
    <script>
        var fa = true;
        function changeTime(event){
            event.preventDefault();
            if(fa)
            {
                fa = false;
                let date = $('#datepicker').val();
                window.location.href = `/day/update/with?date=${date}`;
            }
        }
    </script>
    <style>
        .datepicker{
            box-shadow: 5px 5px 15px rgb(50,50,50);
        }
    </style>
</body>

</html>












