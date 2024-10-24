<?php
?>
<?PHP
include('includes/header.php');
include('inc/function.php');
?>
<div class="row">
    <div class="col-12">
        <h2 style=" color: red">Danh sách đơn đặt hàng
            <a href="list_order_review.php" class="btn btn-primary" style="float: right;">Các đơn hàng đã duyệt</a>
        </h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Họ và tên</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Ngày đặt hàng</th>
                    <th>Xem chi tiết</th>
                    <th>Chỉnh sửa</th>
                    <th>Duyệt</th>
                    <th>Xóa</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "
            SELECT 
                o.code_order,
                o.name_customer,
                o.phone_customer,
                o.address_customer,
                o.order_day
            FROM 
                tb_order o
            WHERE 
                o.status_order = '0' 
            ORDER BY 
                o.order_day DESC;
        ";

                $result = mysqli_query($dbc, $query);
                kt_query($query, $result);

                while ($order = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $check = check_order($order['code_order']);
                ?>
                    <tr style="<?php echo ($check) ? 'color: #bd0103' : ''; ?>">
                        <td><?php echo $order['code_order']; ?></td>
                        <td><?php echo $order['name_customer']; ?></td>
                        <td><?php echo $order['phone_customer']; ?></td>
                        <td><?php echo $order['address_customer']; ?></td>
                        <td><?php
                            $date = date_create($order['order_day']);
                            echo date_format($date, "H:i - d/m/Y");
                            ?></td>
                        <td class="text-center">
                            <a href="order_detail.php?code_order=<?php echo $order['code_order']; ?>">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </a>
                        </td>
                        <td>
                            <a href="edit_order.php?code_order=<?php echo $order['code_order']; ?>">
                                <i class="fa fa-fw fa-pencil" style="font-size: 20px; color:#1b926c;"></i>
                            </a>
                        </td>
                        <?php if ($check) { ?>
                            <td style="color: #bd0103; text-align: center;">
                                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                            </td>
                        <?php } else { ?>
                            <td class="text-center">
                                <a onClick="return confirm('Bạn muốn chuyển đơn hàng này qua bên hóa đơn?');" href="functions/review_order.php?id_order=<?php echo $order['code_order']; ?>">
                                    <i class="glyphicon glyphicon-ok"></i>
                                </a>
                            </td>
                            <td align="center">
                                <a onClick="return confirm('Bạn thật sự muốn xóa không ?');" href="delete_order.php?code_order=<?php echo $order['code_order']; ?>">
                                    <i class="fa fa-fw fa-trash" style="font-size: 20px; color:rgba(26,27,23,0.87);"></i>
                                </a>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>


    </div>



    <?PHP
    include('includes/footer.php');
    ?>

    <script language="JavaScript">
        function chkallClick(o) {
            var form = document.frmForm;
            for (var i = 0; i < form.elements.length; i++) {
                if (form.elements[i].type == "checkbox" && form.elements[i].name != "chkall") {
                    form.elements[i].checked = document.frmForm.chkall.checked;
                }
            }
        }
    </script>
    <script type="text/javascript">
        $('.kinh-doanh .collapse').addClass('in');
        $('.kinh-doanh .dathang').css({
            'background-color': '#e1e1e1'
        });
    </script>