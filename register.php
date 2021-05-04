<?php include('server.php');

$total_price = $_SESSION['total_price'];
$addrg = $_SESSION['addrg'];
$duration = $_SESSION['duration'];
$cart_item = $_SESSION['cart_item'];

$_SESSION['addrg2'] = $addrg;
$_SESSION['total_price2'] = $total_price;

$q1 = 0;
$q2 = 0;
$q3 = 0;
foreach ($cart_item as $item) {

  if ($item["name"] == 'Tandem') {
    $q3 = $item['quantity'];
  } elseif ($item["name"] == 'Non Gear') {
    $q1 = $item['quantity'];
  } elseif ($item["name"] == 'Gear') {
    $q2 = $item['quantity'];
  }
}



?>
<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>
    Booking Details
  </title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/register.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>

<body>
  <div class="form_wrapper" id="register_form">
    <div class="form_container">
      <div class="title_cont ainer">
        <h2>Registration Form</h2>
      </div>
      <div class="row clearfix">
        <div class="">
          <form method="POST" action="register.php">
            <?php include('errors.php'); ?>
            <div class="input_field"> <span><i aria-hidden="true" class="fa fa-envelope"></i></span>
              <input type="email" name="email" placeholder="Email" required />
            </div>
            <div class="input_field"> <span><i aria-hidden="true" class="fa fa-phone"></i></span>
              <input type="text" name="phone" placeholder="Mobile Number" required />
            </div>
            <div class="input_field"> <span><i aria-hidden="true" class="fa fa-phone"></i></span>
              <input type="text" name="phone2" placeholder="Alternate Mobile Number" required />
            </div>

            <h4>Selected Delivery Address:</h4>
            <div class="input_field"> <span><i aria-hidden="true" class="fa fa-address-card"></i></span>
              <input type="text" name="addrg" value="<?php echo $addrg ?>" required readonly />
            </div>


            <h4>Selected Non Gear Cycles:</h4>
            <div class="input_field"> <span></i></span>
              <input type="text" name="ngear" value="<?php echo $q1 ?>" required readonly />
            </div>

            <h4>Selected Gear Cycles:</h4>
            <div class="input_field"> <span></span>
              <input type="text" name="gear" value="<?php echo $q2 ?>" required readonly />
            </div>

            <h4>Selected Tandem Cycles:</h4>
            <div class="input_field"> <span></span>
              <input type="text" name="tandem" value="<?php echo $q3 ?>" required readonly />
            </div>

            <h4>Selected Duration:</h4>
            <div class="input_field"> <span><i aria-hidden="true" class="fa fa-address-card"></i></span>
              <input type="text" name="duration" value="<?php echo $duration ?>" required readonly />
            </div>

            <h4>Personal Details</h4>
            <div class="row clearfix">
              <div class="col_half">
                <div class="input_field"> <span><i aria-hidden="true" class="fa fa-user"></i></span>
                  <input type="text" name="fname" placeholder="First Name" />
                </div>
              </div>
              <div class="col_half">
                <div class="input_field"> <span><i aria-hidden="true" class="fa fa-user"></i></span>
                  <input type="text" name="lname" placeholder="Last Name" required />
                </div>
              </div>
            </div>
            <div class="input_field">
              <textarea style="width: 100%;" name="address" placeholder="Addresss"></textarea>

            </div>
            <div class="input_field radio_option">
              <input type="radio" name="radiogroup1" id="rd1" value="Male">
              <label for="rd1">Male</label>
              <input type="radio" name="radiogroup1" id="rd2" value="Female">
              <label for="rd2">Female</label>
            </div>

            <div class="input_field radio_option">
              <h4>Select ID</h4>
              <input type="radio" name="radiogroup2" id="rd3" value="Voter ID">
              <label for="rd3">Voter ID</label>
              <input type="radio" name="radiogroup2" id="rd4" value="Aadhar Number">
              <label for="rd4">Aadhar Number</label>
              <input type="radio" name="radiogroup2" id="rd5" value="Driving License">
              <label for="rd5">Driving License</label>
            </div>
            <div class="input_field"> <span><i aria-hidden="true" class="fa fa-id-card"></i></span>
              <input type="text" name="id_card" placeholder="Id Number" required />
            </div>

            <div class="input_field checkbox_option">
              <input type="checkbox" id="cb1">
              <label for="cb1">I agree with terms and conditions</label>
            </div>
            <div class="input_field">
              <label>Total Price to be Paid</label>
              <input type="text" id="amt" value="Rs. <?php echo $total_price; ?>" readonly>

            </div>

            <input class="button" type="submit" name="reg_user" value="Register Yourself" onclick="change()" />
          </form>
        </div>
      </div>
    </div>
  </div>

  <p class="credit">&copy; Pink Pedals</p>


</body>

</html>