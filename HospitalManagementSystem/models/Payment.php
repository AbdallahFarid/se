<?php
interface PaymentStrategy {
    public function processPayment($amount);
}

class CreditCardPayment implements PaymentStrategy {
    public function processPayment($amount) {
        echo "Processing credit card payment of $" . $amount;
    }
}

class PayPalPayment implements PaymentStrategy {
    public function processPayment($amount) {
        echo "Processing PayPal payment of $" . $amount;
    }
}

class Payment {
    private $strategy;

    public function setStrategy(PaymentStrategy $strategy) {
        $this->strategy = $strategy;
    }

    public function process($amount) {
        $this->strategy->processPayment($amount);
    }
}
?>
