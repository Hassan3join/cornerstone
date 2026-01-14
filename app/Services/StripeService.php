<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Exception;

class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    /**
     * Create a PaymentIntent for the frontend to process
     */
    public function createPaymentIntent($amount, $currency = 'usd', $metadata = [])
    {
        try {
            return PaymentIntent::create([
                'amount' => $amount * 100, // Stripe expects cents
                'currency' => $currency,
                'metadata' => $metadata,
                'automatic_payment_methods' => ['enabled' => true],
            ]);
        } catch (Exception $e) {
            throw new Exception("Stripe Error: " . $e->getMessage());
        }
    }

    /**
     * Verify that a payment was actually successful
     */
    public function verifyPayment($paymentIntentId)
    {
        try {
            $intent = PaymentIntent::retrieve($paymentIntentId);
            return $intent->status === 'succeeded' ? $intent : false;
        } catch (Exception $e) {
            return false;
        }
    }
}