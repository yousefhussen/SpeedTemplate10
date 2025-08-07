<?php

namespace Modules\Payment\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Payment\Http\Interfaces\PaymentGatewayInterface;
use Modules\Payment\Http\Requests\ProcessPaymentRequest;

class PaymentController extends Controller
{
    protected PaymentGatewayInterface $paymentGateway;
    public function __construct( PaymentGatewayInterface $paymentGateway )
    {
        $this->paymentGateway = $paymentGateway;
    }

    public function processPayment(ProcessPaymentRequest $request)
    {
        // Validate the payment request using the custom request class
        //set some data
        $request->merge([
            'amount_cents' => $request->validated('amount_cents'), // Convert to cents
            'description' => $request->validated('description', 'Payment for order'),
            'phone_number' => $request->validated('shipping_data.phone_number', ''),
            'shipping_data' => $request->validated('shipping_data', []),
        ]);

        // Process the payment using the payment gateway
        $response = $this->paymentGateway->SendPayment($request);
        return response()->json([
            'message' => 'Payment callback received',
            'data' => $response->json(),
        ]);
    }

    public function paymentCallback(Request $request)
    {

        logger('Payment callback received', [
            'request_data' => $request->all(),
        ]);
        if (!$request->has('id') || !$request->has('success')) {
            return response()->json(['error' => 'Invalid callback data'], 400);
        }
        else {
            // Process the payment callback
            $paymentId = $request->input('id');
            $success = $request->input('success');

            // Here you can handle the payment status, e.g., update order status in your database
            if ($success) {
                // Payment was successful
                logger("Payment with ID {$paymentId} was successful.");
                return redirect(config('payment.frontend_url') . '/payment/success?payment_id=' . $paymentId);
            } else {
                // Payment failed
                logger("Payment with ID {$paymentId} failed.");
                return redirect(config('payment.frontend_url') . '/payment/failure?payment_id=' . $paymentId);
            }
        }
    }

}
