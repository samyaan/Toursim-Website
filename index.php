<?php
session_start();

require_once("dbcontroller.php");
$db_handle = new DBController();
if (!empty($_GET["action"])) {
	switch ($_GET["action"]) {
		case "add":
			if (!empty($_POST["quantity"])) {
				$productByCode = $db_handle->runQuery("SELECT * FROM cycle_rental WHERE id='" . $_GET["id"] . "'");
				$itemArray = array($productByCode[0]["id"] => array('name' => $productByCode[0]["name"], 'id' => $productByCode[0]["id"], 'quantity' => $_POST["quantity"], 'amount' => $productByCode[0]["amount"], 'img' => $productByCode[0]["img"],  'link' => $productByCode[0]["link"]));

				if (!empty($_SESSION["cart_item"])) {
					if (in_array($productByCode[0]["id"], array_keys($_SESSION["cart_item"]))) {
						foreach ($_SESSION["cart_item"] as $k => $v) {
							if ($productByCode[0]["id"] == $k) {
								if (empty($_SESSION["cart_item"][$k]["quantity"])) {
									$_SESSION["cart_item"][$k]["quantity"] = 0;
								}
								$_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
							}
						}
					} else {
						$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $itemArray);
					}
				} else {
					$_SESSION["cart_item"] = $itemArray;
				}
			}
			break;
		case "remove":
			if (!empty($_SESSION["cart_item"])) {
				foreach ($_SESSION["cart_item"] as $k => $v) {
					if ($_GET["id"] == $k)
						unset($_SESSION["cart_item"][$k]);
					if (empty($_SESSION["cart_item"]))
						unset($_SESSION["cart_item"]);
				}
			}
			break;
		case "empty":
			unset($_SESSION["cart_item"]);
			break;
	}
}
?>

<html>

<head>
	<meta charset="utf-8">
	<TITLE>Rentals Selection</TITLE>
	<link href="style.css" type="text/css" rel="stylesheet" />
</HEAD>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="book.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>


</style>

</head>


<body style="background-image: none;">
	<nav style="width: 100%;">
		<input type="checkbox" id="check">
		<label for="check" class="checkbtn">
			<i class="fas fa-bars"></i>
		</label>
		<label class="logo">Pink-Pedals</label>
		<ul>
			<li><a href="index.html">Home</a></li>
			<li><a href="#">About</a></li>
			<li><a href="#">Services</a></li>
			<li><a href="#">Contact</a></li>
			<li><a href="#">Feedback</a></li>
		</ul>
	</nav>

	<HTML>

	<div id="shopping-cart">
		<div class="txt-heading">Shopping Cart</div>

		<a id="btnEmpty" href="index.php?action=empty">Empty Cart</a>
		<?php
		if (isset($_SESSION["cart_item"])) {
			$total_quantity = 0;
			$total_price = 0;
			$security = 1000;
		?>
			<table class="tbl-cart" cellpadding="10" cellspacing="1">
				<tbody>
					<tr>
						<th style="text-align:left;">Name</th>

						<th style="text-align:left;">Code</th>
						<th style="text-align:right;" width="5%">Quantity</th>
						<th style="text-align:right;" width="10%">Unit Price</th>
						<th style="text-align:right;" width="10%">Price</th>
						<th style="text-align:center;" width="5%">Remove</th>
					</tr>
					<?php
					foreach ($_SESSION["cart_item"] as $item) {

						$item_price = $item["quantity"] * $item["amount"];

					?>

						<tr>
							<td><?php echo $item["name"]; ?></td>
							<td><?php echo $item["id"]; ?></td>
							<td style="text-align:right;"><?php echo $item["quantity"]; ?></td>

							<?php

							echo "<td style='text-align:right;'> Rs" . $item['amount'] . "</td>";

							?>
							<td style="text-align:right;"><?php echo "Rs " . number_format($item_price, 2); ?></td>
							<td style="text-align:center;"><a href="index.php?action=remove&id=<?php echo $item["id"]; ?>" class="btnRemoveAction"><img src="icon-delete.png" alt="Remove Item" /></a></td>
						</tr>
					<?php
						$total_quantity += $item["quantity"];

						$total_price += ($item["amount"] * $item["quantity"]);
					}
					?>
					<tr>
						<form method="post" action="index.php">
							<td>Delivery Charges</td>
							<td>
								<div class="custom-select">
									<select name="addr" style="width: 40%;">
										<option value="Self Pickup Jawahar Circle">Self Pickup Jawahar Circle</option>
										<option value="Vaishali Nagar">Vaishali Nagar</option>
										<option value="Vidhyadhar Nagar"> Vidhyadhar Nagar</option>
										<option value="Nemi Nagar">Nemi Nagar</option>
										<option value="Chitrakoot"> Chitrakoot</option>
										<option value="Jothwara">Jothwara</option>
										<option value="Jaguar">Jaguar</option>
										<option value="Railway station">Railway station</option>
										<option value="Gurjar Ki Thadi">Gurjar Ki Thadi</option>
										<option value="Sodala">Sodala</option>
										<option value="22 Godam"> 22 Godam</option>
										<option value="C-Scheme"> C-Scheme</option>
										<option value="Raja Park">Raja Park</option>
										<option value="Adarsh Nagar">Adarsh Nagar</option>
										<option value="Aatish Market"> Aatish Market</option>
										<option value="Ridhi Sidhi"> Ridhi Sidhi</option>
										<option value="Jagatpura">Jagatpura</option>
										<option value="Mansarovar">Mansarovar</option>
										<option value="Pratap Nagar"> Pratap Nagar</option>
										<option value="Mahaveer Nagar">Mahaveer Nagar</option>
										<option value="Gopalpura"> Gopalpura</option>
										<option value="Tonk Phatak"> Tonk Phatak</option>
										<option value="Mahesh Nagar">Mahesh Nagar</option>
										<option value="Malviya Nagar">Malviya Nagar</option>


									</select>

								</div>
							</td>
							<td>
								<input type="submit" value="Select Address" class="btnAddAction" style="width: 100%;" />
							</td>
						</form>
						<?php
						if (isset($_POST['addr'])) {
							$_SESSION['addrg'] = $_POST['addr'];
						} else {
							$_SESSION['addrg'] = 1;
						}
						?>
						<?php
						$pay = 0;
						if (isset($_POST['addr'])) {
							if ($_POST['addr'] == 'Self Pickup Jawahar Circle') {
								$pay = 0;
								echo "<td style='text-align:right;'> Rs" . $pay . "</td>";
							} elseif ($_POST['addr'] == 'Vaishali Nagar' || $_POST['addr'] == 'Vidhyadhar Nagar' || $_POST['addr'] == 'Nemi Nagar' || $_POST['addr'] == 'Chitrakoot' || $_POST['addr'] == 'Jothwara' || $_POST['addr'] == 'Railway station') {
								$pay = 350;
								echo "<td style='text-align:right;'> Rs" . $pay . "</td>";
							} elseif ($_POST['addr'] == 'Gurjar Ki Thadi' || $_POST['addr'] == 'Sodala'  || $_POST['addr'] ==  '22 Godam'  || $_POST['addr'] == 'C-Scheme' || $_POST['addr'] == 'Raja Park' || $_POST['addr'] == 'Adarsh Nagar' || $_POST['addr'] == 'Aatish Market' || $_POST['addr'] == 'Ridhi Sidhi' || $_POST['addr'] == 'Jagatpura' || $_POST['addr'] == 'Mansarovar' || $_POST['addr'] == 'Pratap Nagar') {
								$pay = 250;
								echo "<td style='text-align:right;'> Rs" . $pay . "</td>";
							} elseif ($_POST['addr'] == 'Mahaveer Nagar' || $_POST['addr'] == 'Gopalpura' || $_POST['addr'] == 'Tonk Phatak' || $_POST['addr'] == 'Mahesh Nagar' || $_POST['addr'] == 'Malviya Nagar') {
								$pay = 150;
								echo "<td style='text-align:right;'> Rs" . $pay . "</td>";
							}
						}

						?>
						<td style="text-align:right;"><?php echo "Rs " . number_format($pay, 2); ?></td>
						<td style="text-align:center;"></td>
					</tr>
					<tr>
						<td>Security Deposit</td>
						<td></td>
						<td></td>
						<?php
						echo "<td style='text-align:right;'> Rs" . $security . "</td>";
						?>

						<td style="text-align:right;"><?php echo "Rs " . number_format($security, 2); ?></td>
						<td style="text-align:center;"></td>
					</tr>
					<?php


					$total_price += $pay;

					?>

					<tr>
						<td colspan="2" align="right">Total:</td>
						<td align="right"><?php echo $total_quantity; ?></td>
						<?php
						$total_price += $security;
						?>
						<td align="right" colspan="2"><strong><?php echo "Rs " . number_format($total_price, 2); ?></strong></td>
						<td></td>
						<?php $_SESSION['total_price'] = $total_price; ?>

					</tr>
					<form action="register.php" method="POST">
						<tr>
							<td colspan="2" align="right"></td>
							<td align="right">
								<center>
									<input type="submit" value="Book Now!" />
								</center>
							</td>

							<td align=" right" colspan="2"></td>
							<td></td>
						</tr>

					</form>
				</tbody>
			</table>
			<?php $_SESSION['total_price'] = $total_price; ?>
			<br><br>

		<?php
		} else {
		?>
			<div class="no-records">Your Cart is Empty</div>
		<?php
		}
		?>
	</div>


	<form method="post" action="index.php">

		<br>
		<br>

		<div id="product-grid-2" style="margin: 40px;">
			<div class="txt-heading">Duration</div>

			<div class="product-item">

				<div class="custom-select">
					<select name="duration">

						<option value="Select Duration">Select Duration</option>
						<option value="2 Days">2 Days</option>
						<option value="3 Days">3 Days</option>
						<option value="Weekly">Weekly</option>
						<option value="15 Days">15 Days</option>
						<option value="Monthly">Monthly</option>
					</select>

					<input type="submit" value="Search Available Bicycles" class="btnAddAction" />

				</div>


			</div>

		</div>
	</form>
	<br>

	<div id="product-grid">
		<div class="txt-heading">Cycle Available</div>
		<?php

		if (isset($_POST['duration'])) {
			$_SESSION['duration'] = $_POST['duration'];
			if ($_POST['duration'] == 'Select Duration') {
				echo "Select Duration<br>";
			} elseif ($_POST['duration'] == '2 Days') {
				echo "Selected Duration : 2 Days<br>";
			} elseif ($_POST['duration'] == '3 Days') {
				echo "Selected Duration : 3 Days<br>";
			} elseif ($_POST['duration'] == 'Weekly') {
				echo "Selected Duration : Weekly<br>";
			} elseif ($_POST['duration'] == '15 Days') {
				echo "Selected Duration : 15 Days<br>";
			} elseif ($_POST['duration'] == 'Monthly') {
				echo "Selected Duration : Monthly<br>";
			}
		}
		$num = '';
		if (isset($_POST['duration']))
			$num = $_POST['duration'];
		if ($num && $num != 'Select Duration') {

			$query1 = "SELECT * FROM cycle_rental ORDER BY id ASC";
			$query2 = "SELECT * FROM cycle_rental Where id!=3";
			$query3 = "SELECT * FROM cycle_rental Where id=3";

			if ($num == 'Select Duration') {
				$product_array = $db_handle->runQuery($query1);
			} elseif ($num == '2 Days' || $num == '3 Days') {
				$product_array = $db_handle->runQuery($query3);
			} else {
				$product_array = $db_handle->runQuery($query2);
			}

			if (!empty($product_array)) {
				foreach ($product_array as $key => $value) {
		?>
					<div class="product-item">
						<form method="post" action="index.php?action=add&id=<?php echo $product_array[$key]["id"]; ?>">
							<div class="product-image"><img src="<?php echo $product_array[$key]["img"]; ?>" style="width: 250px; height: 150px;"></div>
							<div class="product-tile-footer">
								<div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
								<div class="product-title"><a href="<?php echo $product_array[$key]["link"]; ?>">

										Details
									</a></div>
								<div class="product-price">
									<?php echo "Rs" . $product_array[$key]["amount"]; ?>
								</div>
								<div class="cart-action"><input type="number" class="product-quantity" name="quantity" value="1" size="2" min="1" max="8" /><input type="submit" value="Add to Cart" class="btnAddAction" /></div>
							</div>
						</form>
					</div>
		<?php
				}
			}
		}
		?>


	</div>
	<br><br><br>
	<br><br><br>
	<br><br><br>
	<br><br><br>
	<br><br><br>
	<br><br><br>
	<br><br><br>
	<br><br><br>
	<script>
		var myDate = new Date();
		var hrs = myDate.getHours();

		var greet;


		if ((hrs >= 18 && hrs <= 24) || (hrs >= 3 && hrs <= 8)) {
			greet = 'Hello customer!';
			document.getElementById('product-grid').innerHTML =
				'<b>' + greet + '</b> The booking currently closed now!, Booking will Resume from 8 A.M.';
		}
	</script>

</BODY>

</html>