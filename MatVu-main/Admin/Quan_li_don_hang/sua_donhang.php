<head>
    <title>Quản lý hãng</title>
    <link rel="shortcut icon" type="image/png" href="../img/logo.png" />
</head>

<body>
<?php
include '../Main_QuanTri/nav.php';
include '../Main_QuanTri/connect.php';
?>
    <div class="content">
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <div class="container-fluid bg-secondary">
                    <div class="hstack gap-2 ">
                        <div class="p-2">
                            <h5>Sửa đơn hàng</h5>
                        </div>
                    </div>
                </div>
                <div class="accordion-body">
                            <b style="position: fixed;font-size: 16px;color:#FFF;padding: 2px;text-align: center;background-color: #82af6f;;width: 700px; height: 30px;margin-left: 700px;">Thông tin người nhận hàng</b>
                            <ul style="position: fixed;margin-left: 700px;margin-top: 40px;font-size: 18px;">
                                <?php
                                    $sql = "SELECT * FROM don_hang";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        // Lặp qua mỗi hàng dữ liệu
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<li> Tên: ' . $row['ho_ten'] . '</li>';
                                            echo '<li> Địa chỉ: ' . $row['dia_chi'] . '</li>';
                                            echo '<li> Số điện thoại: ' . $row['so_dien_thoai'] . '</li>';
                                            echo '<li> Email: ' . $row['email'] . '</li>';
                                        }
                                    } else {
                                        echo "Không có dữ liệu.";
                                    }
                                ?>
                            </ul>
                            
                            <?php
                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                    // Lấy thông tin được gửi từ biểu mẫu
                                    $trangthai_donhang = $_POST["trangthai_donhang"];
                                    $trangthai_vanchuyen = $_POST["trangthai_vanchuyen"];
                                    $trangthai_thanhtoan = $_POST["trangthai_thanhtoan"];
                                
                                    // Query SQL để cập nhật thông tin tài khoản
                                    $sql= "UPDATE chi_tiet_don_hang SET trangthai_donhang='$trangthai_donhang', trangthai_vanchuyen='$trangthai_vanchuyen', trangthai_thanhtoan='$trangthai_thanhtoan'";
                                
                                    if (mysqli_query($conn, $sql)) {
                                        header("Location: index.php");
                                        exit();
                                    } else {
                                        echo "Lỗi: " . mysqli_error($conn);
                                    }
                                
                                    // Đóng kết nối CSDL
                                    mysqli_close($conn);
                                }
                            ?>
                        <form action="#" method="post">
                            <div class="mb-3 row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Trạng thái đơn hàng:</label>
                                <div class="col-sm-10">
                                    <select class="span10 col-sm-12" name="trangthai_donhang" style="height:40px; width: 150px;">;=
                                        <option value="Chờ xử lý">Chờ xử lý</option>
                                        <option value="Hoàn thành">Hoàn thành</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Trạng thái vận chuyển:</label>
                                <div class="col-sm-10">
                                    <select class="span10 col-sm-12" name="trangthai_vanchuyen" style="height:40px; width: 150px;">
                                        <option value="Chưa giao hàng">Chưa giao hàng</option>
                                        <option value="Đang giao hàng">Đang giao hàng</option>
                                        <option value="Đã giao hàng">Đã giao hàng</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Trạng thái thanh toán:</label>
                                <div class="col-sm-10">
                                    <select class="span10 col-sm-12" name="trangthai_thanhtoan" style="height:40px; width: 150px;">
                                        <option value="Chưa thanh toán">Chưa thanh toán</option>
                                        <option value="Đã thanh">Đã thanh toán</option>
                                    </select>
                                </div>
                            </div>
                        
                        <br>
                        <table class="table table-bordered table-hover vertical-center">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Mã sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Giá sản phẩm</th>
                                        <th>Tổng cộng</th>
                                    </tr>
                                </thead>
                                <?php
                                    $sql = "SELECT chi_tiet_don_hang.*, san_pham.ten_san_pham,san_pham.gia_ban FROM chi_tiet_don_hang
                                    LEFT JOIN san_pham ON chi_tiet_don_hang.ma_san_pham = san_pham.id";
                                    $result = $conn->query($sql);
                                ?>
                                <tbody>
                                    <tr>
                                        <?php
                                            if ($result->num_rows > 0) {
                                                // Lặp qua mỗi hàng dữ liệu
                                                while ($row = $result->fetch_assoc()) {
                                                    echo '<td>' . $row['ma_don_hang'] . '</td>';
                                                    echo '<td>' . $row['ten_san_pham'] . '</td>';
                                                    echo '<td>' . $row['ma_san_pham'] . '</td>';
                                                    echo '<td>' . $row['so_luong'] . '</td>';
                                                    echo '<td>' . number_format($row['gia_ban']). ' đ'; '</td>';
                                                    echo '<td>' . number_format($row['gia']). ' đ'; '</td>';
                                                }
                                            } else {
                                                echo "Không có dữ liệu.";
                                            }
                                        ?>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="control-group form-group buttons">
                            <input class="btn btn-primary" href="index.php" id="btnAddCate" type="submit" value="Cập nhật"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>