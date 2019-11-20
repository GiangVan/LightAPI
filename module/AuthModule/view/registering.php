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
        background-color: #a38aff;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1600 900'%3E%3Cpolygon fill='%23cc0000' points='957 450 539 900 1396 900'/%3E%3Cpolygon fill='%23aa0000' points='957 450 872.9 900 1396 900'/%3E%3Cpolygon fill='%23c6004c' points='-60 900 398 662 816 900'/%3E%3Cpolygon fill='%23a4003d' points='337 900 398 662 816 900'/%3E%3Cpolygon fill='%23bf006c' points='1203 546 1552 900 876 900'/%3E%3Cpolygon fill='%239d0056' points='1203 546 1552 900 1162 900'/%3E%3Cpolygon fill='%23b80084' points='641 695 886 900 367 900'/%3E%3Cpolygon fill='%23970069' points='587 900 641 695 886 900'/%3E%3Cpolygon fill='%23b10098' points='1710 900 1401 632 1096 900'/%3E%3Cpolygon fill='%238f007a' points='1710 900 1401 632 1365 900'/%3E%3Cpolygon fill='%23aa00aa' points='1210 900 971 687 725 900'/%3E%3Cpolygon fill='%23880088' points='943 900 1210 900 971 687'/%3E%3C/svg%3E");
        background-attachment: fixed;
        background-size: cover;
    }

    .card {
        box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.38);
        border: none;
    }
    </style>
</head>

<body>
    <!-- jquery -->
    <script src="/js/jquery-3.4.1.min.js"></script>
    <!-- bootstrap -->
    <script src="/js/bootstrap/bootstrap.popper.min.js"></script>
    <script src="/js/bootstrap/bootstrap.bundle.min.js"></script>

    <script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
    </script>

    <?php if(isset($notification)) { echo $notification; } ?>

    <main class="py-5 vh-100 vw-100 d-flex justify-content-center">
        <div class="col-md-3">
            <div class="card">
                <h5 class="card-header bg-danger text-white">Đăng ký tài khoản</h5>
                <div class="card-body">
                    <form action="/register" method="POST">
                        <div class="form-group">
                            <label>Tên tài khoản</label>
                            <input placeholder="nguyen_van_a" class="form-control" name="id"
                                value="<?php if(isset($id)) { echo $id; } ?>" data-toggle="tooltip" data-placement="top"
                                title="Tên này sử dụng để đăng nhập">
                        </div>
                        <div class="form-group">
                            <label>Họ và tên</label>
                            <input placeholder="Nguyễn Văn A" class="form-control" name="name"
                                value="<?php if(isset($name)) { echo $name; } ?>" data-toggle="tooltip"
                                data-placement="top" title="Tên này sử dụng để hiển thị cho mọi người">
                        </div>
                        <button type="submit" class="btn btn-danger"> Đăng ký ngay! </button>
                        <a class="btn btn-light" href="/login"> Đăng nhập </a>
                    </form>
                </div>
            </div>
        </div>
    </main>






</body>

</html>