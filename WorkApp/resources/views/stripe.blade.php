<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel 9 How To Integrate Stripe Payment Gateway</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class='row'>
            <h1 class="text-center">支払い画面</h1>
            <div class='col-md-12'>
                <div class="card">
                    <div class="card-body">
                    @if (Session::has('error'))
                        <font color="red">{{ Session::get('error') }}</font>
                    @endif
                    <form class="form-horizontal" method="post" id="payment-form" role="form" action="{{ url('postPaymentStripe', $price) }}" >
                        @csrf
                        <div class="mb-3">
                            <label class='control-label'>カード番号</label>
                            <input autocomplete='off' class='form-control card-number' size='20' type='text' name="card_no">
                        </div>
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label class='control-label'>CVV</label>
                                <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='text' name="cvvNumber">
                            </div>
                            <div class="col-auto">
                                <label class='control-label'>期限</label>
                                <input class='form-control card-expiry-month' placeholder='MM' size='4' type='text' name="ccExpiryMonth">
                            </div>
                            <div class="col-auto">
                                <label class='control-label'>年</label>
                                <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text' name="ccExpiryYear">
                                <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='hidden' name="amount" value="300">
                            </div>
                            <div><input name="work_id" type="hidden" value="{{ $work_id }}"></div>
                        </div>

                        <div class="mb-3" style="padding-top:20px;">
                            <h5 class='total' >金額:<span class='amount'>{{ number_format($price) }}円</span></h5>
                        </div>

                        <div class="mb-3">
                            <button class='form-control btn btn-success submit-button' type='submit'>支払う</button>
                        </div>

                        <div class="mb-3">
                            <div class='alert-danger alert' style="display:none;">
                                    Please correct the errors and try again.
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
