<?php
?>
<style type="text/css">
</style>
<?PHP 
    include('includes/header.php');
    include('inc/function.php');
?>
    <div class="row">
        <div class="col-xs-12">
            <h2 style=" color: red;">Danh Sách Giao hàng  <a href="list_delivery_sent.php" class="btn btn-primary" style="float: right;">Các các đơn hàng đã gửi </a></h2> 
            <table class="table table-striped"> 
    <thead> 
        <tr>
            <th>Mã hóa đơn</th>
            <th>Mã ship</th>
            <th>Họ và tên</th>
            <th>Số điện thoại</th>
            <th>Địa chỉ</th>
            <th>Ngày đặt hàng</th>
            <th class="text-center">Xem chi tiết</th>
            <th class="text-center">Đã gửi</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            // Updated SQL query to select the required fields with specific status
            $query = "SELECT 
                            code_ship, 
                            name_customer, 
                            phone_customer, 
                            address_customer, 
                            order_day, 
                            code_bill, 
                            status_ship 
                      FROM 
                            tb_order, tb_bill, tb_ship 
                      WHERE 
                            tb_order.id_order = tb_bill.id_order 
                            AND tb_bill.id_bill = tb_ship.id_bill 
                            AND (status_ship = '0' OR status_ship = '2')  
                      GROUP BY 
                            code_ship";

            $result = mysqli_query($dbc, $query);
            kt_query($query, $result); // Check for errors in the query

            while ($order = mysqli_fetch_array($result, MYSQLI_NUM)) {
        ?>                    
        <tr style="<?php echo $order[6] == '2' ? 'background: #e1e1e1' : ''; ?>">
            <td><?php echo $order[5]; ?></td> <!-- Mã hóa đơn -->
            <td><?php echo $order[0]; ?></td> <!-- Mã ship -->
            <td><?php echo $order[1]; ?></td> <!-- Họ và tên -->
            <td><?php echo $order[2]; ?></td> <!-- Số điện thoại -->
            <td><?php echo $order[3]; ?></td> <!-- Địa chỉ -->
            <td><?php 
                $date = date_create($order[4]);
                echo date_format($date, "H:i - d/m/Y"); 
            ?></td> <!-- Ngày đặt hàng -->
            <td class="text-center">
                <a href="delivery_detail.php?code_ship=<?php echo $order[0]; ?>">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                </a>
            </td>
            <?php 
                if ($order[6] == '0') { // Check if status_ship is '0'
            ?>
                <td class="text-center">
                    <a onClick="return confirm('Hóa đơn đã được gửi');" href="functions/review_ship.php?code_ship=<?php echo $order[0]; ?>">
                        <i class="glyphicon glyphicon-ok"></i>
                    </a>
                </td>
            <?php
                } else {
                    echo '<td></td>'; // Empty cell if not eligible for sending
                }
            ?>
        </tr>
        <?php
            }
        ?>
    </tbody>
</table>

    </div>  



<?PHP 
    include('includes/footer.php');
?>

<script language="JavaScript">
    $("tr").attr("disabled", "disabled").off('click');
    function chkallClick(o) {
        var form = document.frmForm;
        for (var i = 0; i < form.elements.length; i++) {
            if (form.elements[i].type == "checkbox" && form.elements[i].name!="chkall") {
                form.elements[i].checked = document.frmForm.chkall.checked;
            }
        }
    }
</script>
<script type="text/javascript">
    $('.giao-hang .collapse').addClass('in');
    $('.giao-hang .giaohang').css({'background-color': '#e1e1e1'});
</script>