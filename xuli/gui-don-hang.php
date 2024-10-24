<?php
	session_start();
	include('../inc/myconnect.php');
	include('../inc/function.php');
	
		$name = $_GET['name'];
		$email = $_GET['email'];
		$sdt = $_GET['sdt'];
		$tinh = $_GET['tinh'];
		$quan = $_GET['quan'];
		$sonha = $_GET['sonha'];
		$phuong = $_GET['phuong'];
		$code_order = ramdom_code();
		$address_customer = $sonha . ", " . $phuong;
		date_default_timezone_set("Asia/HO_CHI_MINH");
		$order_day = date("Y-m-d H:i:s");

		$alert_message = "Customer Name: $name\\nEmail: $email\\nPhone: $sdt\\nAddress: $address_customer\\nOrder Date: $order_day\\nDistrict: $quan\\nProducts:";
		echo "<script>console.log('$alert_message');</script>";
		
		foreach ($_SESSION['cart'] as $value) {
			$id_product = $value['id_product'];
			foreach ($value['quantity'] as $key_sl => $value_sl) {
				$size_product = $key_sl;
				$quantity_product = $value_sl;
				$alert_message .= "\\nProduct ID: $id_product, Size: $size_product, Quantity: $quantity_product";
			}
		}

		echo "<script>alert('$alert_message');</script>";

		foreach ($_SESSION['cart'] as $value) {
			$id_product = $value['id_product'];
			foreach ($value['quantity'] as $key_sl => $value_sl) {
				$size_product = $key_sl;
				$quantity_product = $value_sl;
				$query = "INSERT INTO tb_order(
					code_order,
					status_order,
					id_product,
					size_product,
					quantity_product,
					name_customer, 
					phone_customer,
					address_customer,
					email_customer,
					order_day,
					id_district
				) VALUES(
					'{$code_order}',
					'0',
					'{$id_product}', 
					'{$size_product}', 
					'{$quantity_product}', 
					'{$name}', 
					'{$sdt}', 
					'{$address_customer}', 
					'{$email}',
					'{$order_day}',
					'{$quan}' 
				)";

				$result = mysqli_query($dbc, $query);
	
				if (!$result) {
					// Alert the database error and stop further processing
					echo "<script>alert('Database error: " . mysqli_error($dbc) . "');</script>";
					die(); // Stop further processing
				}
			}
		}

		// Clear the cart after successful insertion
		unset($_SESSION['cart']);
	
?>
