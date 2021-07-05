<?php

    if(!isset($_SESSION)){
        session_start();
    }

    $pageName ="Shop"; 
    $pageShortSummary = "Checkout";
    $pageDescription = "";

    $token = '';
    $orderId = '';
    $status = '';
    $infoUrl = NULL;
    $refundUrl = NULL;
    $approveUrl = NULL;



    ?><!DOCTYPE html>
    <html lang="en-us">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/zalisting/snippets/head.php'; ?>
    <body>

        <main class="content" id='parentContainer'>
            <?php 

                echo "<div id='checkout-header'><img src='/zalisting/images/logo.png' alt='logo image'><h1 class='title'>Checkout</h1></div>";


                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                }
                if(isset($message)){
                    echo $message;
                }

                if(isset($_SESSION['checkoutDisplay'])){
                    echo $_SESSION['checkoutDisplay'];
                }    

                // Authentication
                $url = 'https://api-m.sandbox.paypal.com/v1/oauth2/token';
                $ch = curl_init();
                $clientId = "AVXa6GCHx5xrD29P-0iExrbo6WiKUSU0hbXQYxZ7ButLl0kQB5geh54uMWDbP7Di7DLcEy_51-z7Nqgo";
                $secret = "EOl1xtkaCveXvQN76c2uEn4GabNJlmH4N73OfdWixeS56_8XJN2EZ__nFwul1jQ9iAQapsgpEJF9Qj9S";

                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    "Accept: application/json"
                ));
                curl_setopt($ch, CURLOPT_USERPWD, $clientId.":".$secret);
                curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

                $json = curl_exec($ch);

                if(empty($json))die("Error: No response.");
                else
                {
                    $result = json_decode($json);
                    //print_r($result->access_token);

                    $token = $result->access_token;
                }


                // Create Order

                $data = array(
                        "intent"=>"CAPTURE",
                        "purchase_units"=> [
                                            array(
                                                "amount"=> array(
                                                "currency_code"=> "USD",
                                                "value"=> 100.00
                                                )
                                            )
                                        ]
                );

                $urlcheckput = 'https://api-m.sandbox.paypal.com/v2/checkout/orders';
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $urlcheckput);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                                            "Accept: application/json", 
                                                            "Content-Type: application/json", 
                                                            "Authorization: Bearer ".$token.""
                                                        ));

                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

                $json = curl_exec($ch);

                if(empty($json))die("Error: No response.");
                else
                {
                    $result = json_decode($json);
                    //echo $result->id;
                    //echo $result->links;

                    $key = 'rel';
                    $info = 'self';
                    $refund = 'refund';
                    $approve = 'approve';


                    foreach($result->links as $linkkey => $linkval) {

                        // request information
                        if ($linkval->$key == $info) {

                        $infoUrl = $linkval->href;
                        }
                        // approve payment
                        else if ($linkval->$key == $approve) {

                            $approveUrl = $linkval->href;
                        }
                        // refund payment
                        else if ($linkval->$key == $refund) {

                            $refundUrl = $linkval->href;
                        }
                    }

                    //echo "info URL: $infoUrl\napprove URL: $approveUrl\nrefund URL: $refundUrl";
                }
            
                $checkoutDisplay = "</div>";
                $checkoutDisplay .= "</form>";
                $checkoutDisplay .= "<a href='/zalisting/cart/' class='checkout-back button'>Back to Cart</a>";

                echo $checkoutDisplay;

            ?>
        </main>
    </body>
    <script src="/zalisting/js/updateCart.js"></script>
</html>