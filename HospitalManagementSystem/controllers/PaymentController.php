<?php
include_once '../models/Payment.php';
include_once '../includes/db.php';

class PaymentController {
    private $payment;

    public function __construct() {
        $this->payment = new Payment();
    }

    public function processPayment() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $strategy = $_POST['strategy'];
            $amount = $_POST['amount'];

            if ($strategy == 'credit_card') {
                $this->payment->setStrategy(new CreditCardPayment());
            } elseif ($strategy == 'paypal') {
                $this->payment->setStrategy(new PayPalPayment());
            }

            $this->payment->process($amount);
        }
    }
}
?>
