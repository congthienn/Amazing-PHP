<?php
    require_once __DIR__.'/../../vendor/autoload.php';
    function inputdata($data){
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = stripcslashes($data);
        return $data;
    }
    if(isset($_POST["btn_order"])){
        $hotenkh = inputdata($_POST["name"]);
        $sonha = inputdata($_POST["sonha"]);
        $toanha = inputdata($_POST["toanha"]);
        $province = inputdata($_POST["province"]);
        $district = inputdata($_POST["district"]);
        $ward = inputdata($_POST["ward"]);
        $payment = inputdata($_POST["payment"]);
        $check_1 = inputdata($_POST["district"]);
        $district = inputdata($_POST["district"]);
       
    }
    // $stripe = new \Stripe\StripeClient(
    //     'sk_test_51K4M0IK4LLs2jGGUSspuQglEykdgwqGQ1mmQQBRqYtF1mg6ctPKt3KvHAlfgmcooGsU0aRGc7mxWq7ol7IgvtFGc000PoSSyLg'
    // );
    // $paymentMethod = $stripe->paymentMethods->create([
    //     'type' => 'card',
    //     'card' => [
    //       'number' => '4242424242424242',
    //       'exp_month' => 3,
    //       'exp_year' => 2025,
    //       'cvc' => '314',
    //     ],
    // ]);
    // $paymentIntents = $stripe->paymentIntents->create([
    //     'amount' => 200000,
    //     'currency' => 'vnd',
    //     'payment_method' => $paymentMethod["id"],
    // ]);
    // $retrieve = $stripe->paymentIntents->confirm(
    //     $paymentIntents["id"],
    //     ['payment_method' => 'pm_card_visa']
    // );
    // echo json_encode($retrieve);
?>