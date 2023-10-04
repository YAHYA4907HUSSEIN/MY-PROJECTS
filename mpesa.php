<?php

    //echo $billid;

    if (isset($_POST['pay'])) {
        $billid = $_POST['billid'];
        $amount = $_POST['amount'];

        session_start();
        error_reporting(0);
        include('includes/dbconnection.php');

        /*use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;*/

        $errors  = array();
        $errmsg  = '';

        $config = array(
            "env"              => "sandbox",
            "BusinessShortCode"=> "174379",
            "key"              => "j0A054W0HGRu2cMAgmrInQHH0s1GbSVp", //Enter your consumer key here
            "secret"           => "QR6Zac1lXYCmspBy", //Enter your consumer secret here
            "username"         => "MpesaTest",
            "TransactionType"  => "CustomerPayBillOnline",
            "passkey"          => "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919", //Enter your passkey here
            "CallBackURL"      => "https://f899-41-90-64-220.ngrok.io/mpesa/callback.php", //When using localhost, Use Ngrok to forward the response to your Localhost
            "AccountReference" => "CompanyXLTD",
            "TransactionDesc"  => "Payment of X" ,
        );



        if (isset($_POST['mobileno'])) {

            $phone = $_POST['mobileno'];
            $orderNo = "#";
            $orderNo = mt_rand(0000, 9999);
            $amount = $_POST['total_price'];

            $phone = (substr($phone, 0, 1) == "+") ? str_replace("+", "", $phone) : $phone;
            $phone = (substr($phone, 0, 1) == "0") ? preg_replace("/^0/", "254", $phone) : $phone;
            $phone = (substr($phone, 0, 1) == "7") ? "254{$phone}" : $phone;



            $access_token = ($config['env']  == "live") ? "https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials" : "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials"; 
            $credentials = base64_encode($config['key'] . ':' . $config['secret']); 
            
            $ch = curl_init($access_token);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Basic " . $credentials]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
            $response = curl_exec($ch);
            curl_close($ch);
            $result = json_decode($response); 
            $token = isset($result->{'access_token'}) ? $result->{'access_token'} : "N/A";

            $timestamp = date("YmdHis");
            $password  = base64_encode($config['BusinessShortCode'] . "" . $config['passkey'] ."". $timestamp);

            $curl_post_data = array( 
                "BusinessShortCode" => $config['BusinessShortCode'],
                "Password" => $password,
                "Timestamp" => $timestamp,
                "TransactionType" => $config['TransactionType'],
                "Amount" => $amount,
                "PartyA" => $phone,
                "PartyB" => $config['BusinessShortCode'],
                "PhoneNumber" => $phone,
                "CallBackURL" => $config['CallBackURL'],
                "AccountReference" => $config['AccountReference'],
                "TransactionDesc" => $config['TransactionDesc'],
            ); 

            $data_string = json_encode($curl_post_data);

            $endpoint = ($config['env'] == "live") ? "https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest" : "https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest"; 

            $ch = curl_init($endpoint );
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer '.$token,
                'Content-Type: application/json'
            ]);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response     = curl_exec($ch);
            curl_close($ch);

            $result = json_decode(json_encode(json_decode($response)), true);

            if(!preg_match('/^[0-9]{10}+$/', $phone) && array_key_exists('errorMessage', $result)){
                $errors['phone'] = $result["errorMessage"];
            }

            if($result['ResponseCode'] === "0"){         //STK Push request successful

                $MerchantRequestID = $result['MerchantRequestID'];
                $CheckoutRequestID = $result['CheckoutRequestID'];

                foreach($value as $pdid=> $qty){
                    $query=mysqli_query($con,"insert into tblorders(ProductId,Quantity,InvoiceNumber,CustomerName,CustomerContactNo,PaymentMode,total_price) values('$pdid','$qty','$invoiceno','$cname','$cmobileno','$pmode','$total_price')") ; 
                }
                //echo '<script>alert("Invoice generated successfully. Invoice number is "+"'.$invoiceno.'")</script>';  
                unset($_SESSION["cart_item"]);
                $_SESSION['invoice']=$invoiceno;

                $invoice_id = $con->insert_id;
                $qry = $con->query("SELECT tblorders.*, tblproducts.ProductName FROM tblorders INNER JOIN tblproducts ON tblproducts.id=tblorders.ProductId WHERE tblorders.id='$invoice_id'")->fetch_array();
                $product_name = $qry['ProductName'];
                $InvoiceNumber = $qry['InvoiceNumber'];
                $qty = $qry['Quantity'];
                $cus_name = $qry['CustomerName'];
                $payment_method = $qry['PaymentMode'];
                $price = $qry['total_price'];
                $date_paid = date('M, d Y H:i:s', strtotime($qry['InvoiceGenDate']));

                /*$message = "
                    <table border='1' style='border-collapse:collapse;'>
                        <tr>
                            <th>Customer</th>
                            <th>Invoice #</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Total Amount</th>
                            <th>Payment Mode</th>
                            <th>Date</th>
                        </tr>
                        <tr>
                            <td>$cus_name</td>
                            <td>$InvoiceNumber</td>
                            <td>$product_name</td>
                            <td>$qty</td>
                            <td>$price</td>
                            <td>$payment_method</td>
                            <td>$date_paid</td>
                        </tr>
                    </table>
                ";


                require 'API/PHPMailer.php';
                require 'API/Exception.php';
                require 'API/SMTP.php';

                //Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);

                try {
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'ommykmathy@gmail.com';                     //SMTP username
                    $mail->Password   = 'wjnvemdowysgtsrw';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
                    //Recipients
                    $mail->setFrom('from@example.com', 'Taru Farm');
                    $mail->addAddress($email);     //Add a recipient
            
                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Order Confirmation';
                    $mail->Body    = $message;
                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            
                    $mail->send();
                    echo "<script>window.location.href='invoice.php'</script>";
                    echo '<script>alert("Invoice generated successfully. Email Sent. Invoice number is "+"'.$cmobileno.'")</script>';
                } catch (Exception $e) {
                    echo "<script>window.location.href='invoice.php'</script>";
                    echo '<script>alert("Invoice generated successfully. Email not sent. Invoice number is "+"'.$cmobileno.'")</script>';
                }*/

                echo "Paid";
                
                
            }else{
                $errors['mpesastk'] = $result['errorMessage'];
                foreach($errors as $error) {
                    $errmsg .= $error . '<br />';
                }
            }
            
        }
    }