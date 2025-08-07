<?php

namespace Modules\Payment\Http\Services;

use Illuminate\Http\Request;
use Modules\Payment\Http\Interfaces\PaymentGatewayInterface;
use function PHPUnit\Framework\isEmpty;

class PaymobPaymentService implements PaymentGatewayInterface
{

    protected  $apiKey;
    protected  $integrationsIds;

    public function __construct()
    {
        $this->apiKey = config('payment.PAYMOB_API_KEY');
        $this->integrationsIds = config('payment.integrations_ids');
        $this->header = [


        ];
        $this->baseUrl = config('payment.base_url');
    }

    public function GenarateToken()
    {
        //send to https://accept.paymob.com/api/auth/tokens
        $url = $this->baseUrl . '/auth/tokens';
        $data = [
            'username' => config('payment.username'),
            'password' => config('payment.password'),
            'expiration' => 999999999999, // Token expiration in seconds
        ];

        $response = \Http::withHeaders($this->header)->post($url, $data);

        if ($response->successful()) {
            $token = $response->json()['token'];
            // Now you can use this token for further API calls
            return $token;
        } else {
            return null;
        }
    }
    public function SendPayment(Request $request)
    {
       //get token and prepare to send it with the other request
        $token = $this->GenarateToken();
        if (!$token) {
            return response()->json(['error' => 'Failed to generate token'], 500);
        }


        // Prepare the payment data
        $paymentData = [
            'api_source' => "INVOICE",
            'amount_cents' => $request->input('amount_cents'),
            'currency' => $request->input('currency', 'EGP'),
            'billing_data' => [
                'first_name' => $request->input('customer_first_name', 'Test'),
                'last_name' => $request->input('customer_last_name', 'User'),
                'email'=>  $request->input('customer_email', "email@account.com"),
                'phone_number' => $request->input('phone_number', '+20123456789'),
            ],
            'shipping_data' => [
                $request->input('shipping_data', []),
                'first_name' => $request->input('customer_first_name', 'Test'),
                'last_name' => $request->input('customer_last_name', 'User'),
                'email'=>  $request->input('customer_email', "email@account.com"),
                'phone_number' => $request->input('phone_number', '+20123456789'),
            ],
            'redirection_url' => config('app.url'). '/api/payment/callback',
            'notification_url'=> config('app.url'). '/api/payment/callback',
            'payment_methods' => [$this->integrationsIds],
            'extras' =>[
                'description' => $request->input('description', 'Payment for order #12345')
                ],
        ];

        // Send the payment request https://accept.paymob.com/api/ecommerce/payment-links
        $url = $this->baseUrl . '/ecommerce/orders';
        // Add the token to the headers
        $headers = $this->header + [
            'Authorization' => 'Bearer ' . $token,
        ];

        $response = \Http::withHeaders($headers)->post($url, $paymentData);


        return $response;
    }

    public function CallBack(Request $request)
    {
        return response()->json([
            'message' => 'Payment callback received',
            'data' => $request->all(),
        ], 200);
    }
}
