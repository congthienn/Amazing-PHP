<?php
    require_once __DIR__.'/../../vendor/autoload.php';
    $stripe = new \Stripe\StripeClient(
        'sk_test_51Kd7GhDWkXErzwl3yesCRvk7xS4WV0LUmnpZ4o43fzahoGrycp71MxJZOQdKdV4Y2YxllRgX2xU59oGHxyrFDuFx00ARcuallu'
      );
    $paymentMethod = $stripe->paymentMethods->create([
        'type' => 'card',
        'card' => [
          'number' => '4242424242424242',
          'exp_month' => 3,
          'exp_year' => 2025,
          'cvc' => '314',
        ],
    ]);
    $paymentIntents = $stripe->paymentIntents->create([
        'amount' => 200000,
        'currency' => 'vnd',
        'payment_method' => $paymentMethod["id"],
    ]);
    $retrieve = $stripe->paymentIntents->confirm(
        $paymentIntents["id"],
        ['payment_method' => 'pm_card_visa']
    );
    echo json_encode($retrieve);
?>