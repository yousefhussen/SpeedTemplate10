<?php

namespace Modules\Payment\Http\Interfaces;



use Illuminate\Http\Request;

interface PaymentGatewayInterface
{
    public function SendPayment(Request $request);

    public function CallBack(Request $request);

}
