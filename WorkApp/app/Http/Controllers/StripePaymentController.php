<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Stripe\Stripe;
use Stripe\Token;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\Charge;






class StripePaymentController extends Controller
{
    public function paymentStripe()
    {
        return view('stripe');
    }

    public function postPaymentStripe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_no' => 'required',
            'ccExpiryMonth' => 'required',
            'ccExpiryYear' => 'required',
            'cvvNumber' => 'required',
            // 'amount' => 'required',
        ]);

        $input = $request->except('_token');
        if ($validator->passes()) {
            $stripeSecretKey = config('services.stripe.key');
            Stripe::setApiKey($stripeSecretKey);

            try {

                // $token = PaymentMethod::create([
                //     'type' => 'card',
                //     'card' => [
                //         'number' => $request->get('card_no'),
                //         'exp_month' => $request->get('ccExpiryMonth'),
                //         'exp_year' => $request->get('ccExpiryYear'),
                //         'cvc' => $request->get('cvvNumber'),
                //     ],
                // ]);
                $token = PaymentMethod::create([
                    'type' => 'card',
                    'card' => [
                        'number' => $request->get('card_no'),
                        'exp_month' => $request->get('ccExpiryMonth'),
                        'exp_year' => $request->get('ccExpiryYear'),
                        'cvc' => $request->get('cvvNumber'),
                    ],
                ]);

                if (!isset($token['id'])) {

                    return redirect()->route('stripe.add.money');
                }

                // $charge = PaymentIntent::create([
                //     'card' => $token['id'],
                //     'currency' => 'jpy',
                //     'amount' => 5000,
                //     'description' => 'wallet',
                // ]);

                $charge = PaymentIntent::create([
                    'amount' => 5000,
                    'currency' => 'jpy',
                    'description' => 'wallet',
                    'payment_method_types' => ['card'],
                    'payment_method' => $token['id'], // カードのpayment_method IDを指定する
                  ]);

                  $charge->confirm([
                    'payment_method' => $token['id'], // カードのpayment_method IDを指定する
                  ]);

                if ($charge['status'] == 'succeeded') {
                    return redirect()->route('addmoney.paymentstripe');
                } else {
                    return redirect()->route('addmoney.paymentstripe')->with('error', 'Money not add in wallet!');
                }
            } catch (Exception $e) {
                return redirect()->route('addmoney.paymentstripe')->with('error', $e->getMessage());
            } catch (\Cartalyst\Stripe\Exception\CardErrorException $e) {
                return redirect()->route('addmoney.paymentstripe')->with('error', $e->getMessage());
            } catch (\Cartalyst\Stripe\Exception\MissingParameterException $e) {
                return redirect()->route('addmoney.paymentstripe')->with('error', $e->getMessage());
            }
        } else {
            return redirect()->back()->with('error', '全て入力してください');
        }
    }
}
