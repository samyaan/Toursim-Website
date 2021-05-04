<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

?>




<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
if (!empty($_GET["action"])) {
	switch ($_GET["action"]) {
		case "add":
			if (!empty($_POST["quantity"])) {
				$productByCode = $db_handle->runQuery("SELECT * FROM tour WHERE id='" . $_GET["id"] . "'");
				$itemArray = array($productByCode[0]["id"] => array('name' => $productByCode[0]["name"], 'id' => $productByCode[0]["id"], 'quantity' => $_POST["quantity"], 'price1' => $productByCode[0]["price1"], 'img' => $productByCode[0]["img"], 'price2' => $productByCode[0]["price2"], 'link' => $productByCode[0]["link"]));

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



<head>
	<meta charset="utf-8">
	<TITLE>Tour Selection</TITLE>
	<link href="style.css" type="text/css" rel="stylesheet" />
</HEAD>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="book.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


</head>


<body style="background-image: none;">
	<nav>
		<input type="checkbox" id="check">
		<label for="check" class="checkbtn">
			<i class="fas fa-bars"></i>
		</label>
		<label class="logo"> <img src="images/Pink_Pedals Big.png" style="width: 100px; height: 50px;"></label>
		<ul>
			<li><a href="index.html">Home</a></li>
			<li><a href="#">About</a></li>
			<li><a href="#">Services</a></li>
			<li><a href="#">Contact</a></li>
			<li><a href="#">Feedback</a></li>
		</ul>


		<HTML>

		<div id="shopping-cart">
			<div class="txt-heading">Shopping Cart</div>
			<form method="POST" action="register.php">
				<a id="btnEmpty" href="TxnTest.php?action=empty">Empty Cart</a>
				<?php
				if (isset($_SESSION["cart_item"])) {
					$total_quantity = 0;
					$total_price = 0;
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
								if ($item['quantity'] <= 5) {
									$item_price = $item["quantity"] * $item["price1"];
								} else {
									$item_price = $item["quantity"] * $item["price2"];
								}
							?>

								<tr>
									<td><img src="<?php echo $item["img"]; ?>" class="cart-item-image" /><?php echo $item["name"]; ?></td>
									<td><?php echo $item["id"]; ?></td>
									<td style="text-align:right;"><?php echo $item["quantity"]; ?></td>

									<?php
									if ($item['quantity'] <= 5) {
										echo "<td style='text-align:right;'> Rs" . $item['price1'] . "</td>";
									} else {
										echo "<td style='text-align:right;'> Rs" . $item['price2'] . "</td>";
									}
									?>
									<td style="text-align:right;"><?php echo "Rs " . number_format($item_price, 2); ?></td>
									<td style="text-align:center;"><a href="TxnTest.php?action=remove&id=<?php echo $item["id"]; ?>" class="btnRemoveAction"><img src="icon-delete.png" alt="Remove Item" /></a></td>
								</tr>
							<?php
								$total_quantity += $item["quantity"];
								if ($item['quantity'] <= 5) {
									$total_price += ($item["price1"] * $item["quantity"]);
								} else {
									$total_price += ($item["price2"] * $item["quantity"]);
								}
							}
							?>

							<tr>
								<td colspan="2" align="right">Total:</td>
								<td align="right"><?php echo $total_quantity; ?></td>
								<td align="right" colspan="2"><strong><?php echo "Rs " . number_format($total_price, 2); ?></strong></td>
								<td></td>
							</tr>


						</tbody>

					</table>
				<?php
				} else {
				?>
					<div class="no-records">Your Cart is Empty</div>
				<?php
				}
				?>
				<div>

					<input type="submit" value="Checkout" />

				</div>
			</form>

		</div>

		<div id="product-grid">
			<div class="txt-heading">Products</div>
			<?php
			$product_array = $db_handle->runQuery("SELECT * FROM tour ORDER BY id ASC");
			if (!empty($product_array)) {
				foreach ($product_array as $key => $value) {
			?>
					<div class="product-item">
						<form method="post" action="TxnTest.php?action=add&id=<?php echo $product_array[$key]["id"]; ?>">
							<div class="product-image"><img src="<?php echo $product_array[$key]["img"]; ?>"></div>
							<div class="product-tile-footer">
								<div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
								<div class="product-title"><a href="<?php echo $product_array[$key]["link"]; ?>">

										Details
									</a></div>
								<div class="product-price">
									<?php echo "Rs" . $product_array[$key]["price1"]; ?>
								</div>
								<div class="cart-action"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btnAddAction" /></div>
							</div>
						</form>
					</div>
			<?php
				}
			}
			?>
		</div>
		<script>
			var myDate = new Date();
			var hrs = myDate.getHours();

			var greet;


			if ((hrs >= 18 && hrs <= 24) || (hrs >= 0 && hrs <= 8)) {
				greet = 'Hello customer!';
				document.getElementById('product-grid').innerHTML =
					'<b>' + greet + '</b> The booking currently closed now!, Booking will Resume from 8 A.M.';
			}
		</script>
</BODY>

</HTML>









<!--

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
	<title>Merchant Check Out Page</title>
	<meta name="GENERATOR" content="Evrsoft First Page">
</head>

<body>
	<h1>Merchant Check Out Page</h1>
	<pre>
	</pre>
	<form method="post" action="pgRedirect.php">
		<table border="1">
			<tbody>
				<tr>
					<th>S.No</th>
					<th>Label</th>
					<th>Value</th>
				</tr>
				<tr>
					<td>1</td>
					<td><label>ORDER_ID::*</label></td>
					<td><input id="ORDER_ID" tabindex="1" maxlength="20" size="20" name="ORDER_ID" autocomplete="off" value="<?php echo  "ORDS" . rand(10000, 99999999) ?>">
					</td>
				</tr>
				<tr>
					<td>2</td>
					<td><label>CUSTID ::*</label></td>
					<td><input id="CUST_ID" tabindex="2" maxlength="12" size="12" name="CUST_ID" autocomplete="off" value="CUST001"></td>
				</tr>
				<tr>
					<td>3</td>
					<td><label>INDUSTRY_TYPE_ID ::*</label></td>
					<td><input id="INDUSTRY_TYPE_ID" tabindex="4" maxlength="12" size="12" name="INDUSTRY_TYPE_ID" autocomplete="off" value="Retail"></td>
				</tr>
				<tr>
					<td>4</td>
					<td><label>Channel ::*</label></td>
					<td><input id="CHANNEL_ID" tabindex="4" maxlength="12" size="12" name="CHANNEL_ID" autocomplete="off" value="WEB">
					</td>
				</tr>
				<tr>
					<td>5</td>
					<td><label>txnAmount*</label></td>
					<td><input title="TXN_AMOUNT" tabindex="10" type="text" name="TXN_AMOUNT" value="1">
					</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td><input value="CheckOut" type="submit" onclick=""></td>
				</tr>
			</tbody>
		</table>
		* - Mandatory Fields
	</form>
</body>

</html>
	-->