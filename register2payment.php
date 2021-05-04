<?php
session_start();
$total_price = $_SESSION['total_price2'];

?>
<html>

<head>
    <meta charset="utf-8">
    <title>
        Redirecting Payment
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

</head>

<body>
    <div class="form_wrapper" id="register_form">
        <div class="form_container">
            <p>Registration Successful! Click on button below to Proceed to Payment</p>
            <form method="POST" action="pgRedirect.php">
                <table border="1" style="visibility: hidden;" id="tabul">
                    <tbody style="visibility: hidden;">
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
                            <td><input title="TXN_AMOUNT" tabindex="10" type="text" name="TXN_AMOUNT" value="<?php echo $total_price; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <input value="CheckOut" type="submit" onclick="" id="payment" ">
            </form>
        </div>
    </div>
</body>

</html>