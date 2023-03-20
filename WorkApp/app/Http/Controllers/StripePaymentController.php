<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Stripe\Stripe;
use Stripe\Token;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\Charge;
use App\Models\Work;






class StripePaymentController extends Controller
{
    public function paymentStripe(Request $request, $id)
    {
        $price = $id;
        $work_id = $request->input("work_id");

        return view('stripe', compact('price', 'work_id'));
    }

    public function postPaymentStripe(Request $request, $id)
    {
        $price = $id;
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
                    'amount' => $price,
                    'currency' => 'jpy',
                    'description' => 'wallet',
                    'payment_method_types' => ['card'],
                    'payment_method' => $token['id'], // カードのpayment_method IDを指定する
                  ]);

                  $charge->confirm([
                    'payment_method' => $token['id'], // カードのpayment_method IDを指定する
                  ]);

                if ($charge['status'] == 'succeeded') {
                    
                    ////////////////////////////////////////////////////////////////
                    //支払い済みフラグ
                    ////////////////////////////////////////////////////////////////
                    $work_id = $request->input("work_id");
                    $work_info = work::find($work_id);
                    $work_info->pay_flg = 1;
                    $work_info->save();
                    ///////////////////////////////////

                    ////////////////////////////////////////////////////////////////
                    //支払い完了メール送信
                    ////////////////////////////////////////////////////////////////

                    ////////////////////////////////

                    return redirect()->back();
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
