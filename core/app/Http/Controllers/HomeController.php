<?php

namespace App\Http\Controllers;

use App\BasicSetting;
use App\Category;
use App\Feature;
use App\Deposit;
use App\Faqs;
use App\Investment;
use App\Menu;
use App\Partner;
use App\PaymentLog;
use App\PaymentMethod;
use App\Plan;
use App\PlanLog;
use App\Procedure;
use App\ReturnLog;
use App\RepeatLog;
use App\Service;
use App\Slider;
use App\Testimonial;
use App\TraitsFolder\MailTrait;
use App\Trx;
use App\User;
use App\UserData;
use App\UserLog;
use App\WithdrawLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Token;
use App\Lib\coinPayments;
use App\Lib\GoogleAuthenticator;
use Auth;

class HomeController extends Controller
{
    use MailTrait;
    public function gggetHome()
    {
        $data['basic_setting'] = BasicSetting::first();
        $data['page_title'] = "Home Page";
        $data['plan'] = Plan::whereStatus(1)->get();
        $data['slider'] = Slider::all();
        $data['service'] = Service::take(8)->get();
        $data['total_repeat'] = RepeatLog::sum('amount');
        $data['total_user'] = User::all()->count();
        $data['total_deposit'] = Deposit::whereNotIn('status',[0])->sum('amount');
        $data['total_withdraw'] = WithdrawLog::whereStatus(2)->sum('amount');
        $data['top_investor'] = DB::table('investments')
            ->select('amount','user_id', DB::raw('SUM(amount) as total_invest'))
            ->groupBy('amount','user_id')
            ->orderBy('total_invest','desc')
            ->take(8)
            ->get();
        $data['testimonial'] = Testimonial::orderBy('id','desc')->get();
        $data['latest_deposit'] = Deposit::whereStatus(1)->orderBy('id','desc')->take(6)->get();
        $data['latest_withdraw'] = WithdrawLog::whereStatus(2)->orderBy('id','desc')->take(6)->get();
        $data['payment'] = PaymentMethod::take(4)->get();
        return view('home.home',$data);
    }

    public function getHome()
    {
        $data['basic_setting'] = BasicSetting::first();
        $data['page_title'] = "Trang Chủ";
        $data['features'] = Feature::all();
        $data['slider_text'] = Slider::all()->first();
        $data['partners'] = Partner::all();
        $data['service'] = Service::take(8)->get();
        $data['total_plan'] = Plan::count();
        $data['total_user'] = User::all()->count();
        $data['total_deposit'] = Deposit::whereNotIn('status',[0])->sum('amount');
        $data['total_withdraw'] = WithdrawLog::whereStatus(2)->sum('amount');
        $data['top_investor'] = DB::table('investments')
            ->select('amount','user_id', DB::raw('SUM(amount) as total_invest'))
            ->groupBy('amount','user_id')
            ->orderBy('total_invest','desc')
            ->take(8)
            ->get();
        $data['testimonial'] = Testimonial::orderBy('id','desc')->get();
        $data['latest_deposit'] = Deposit::whereStatus(1)->orderBy('id','desc')->take(6)->get();
        $data['latest_withdraw'] = WithdrawLog::whereStatus(2)->orderBy('id','desc')->take(6)->get();
        $data['payment'] = PaymentMethod::all();
        $plans = [];
        $categories = Category::all();
        if ($categories) {
            foreach ($categories as $category) {
                $p = Plan::where(['category_id' => $category->id, 'status' => 1])->orderBy('price', 'ASC')->first();
                if ($p) {
                    $p->miner = $category->name;
                    $plans[$category->id] = $p;
                }
            }
        }
        $data['plan'] = $plans;
        return view('newhome.home',$data);
    }

    public function menu($id,$name)
    {
        $data['menu1'] = Menu::findOrFail($id);
        $data['page_title'] = $data['menu1']->name;
        return view('newhome.menu',$data);
    }
    public function getAbout()
    {
        $data['page_title'] = 'Trang Giới Thiệu';
        return view('newhome.about',$data);
    }

    public function term_of_use()

    {

        $data['page_title'] = 'Term Of Use';
        return view('newhome.term_of_use',$data);

    }

    public function privacy_policy()

    {

        $data['page_title'] = 'Privacy Policy';
        return view('newhome.privacy_policy',$data);

    }

    public function howWorks()

    {

        $data['page_title'] = 'How It Works?';
        $data['steps'] = Procedure::all();

        return view('newhome.howworks', $data);

    }
    public function getFaqs()
    {
        $data['page_title'] = 'Trang hỏi đáp thắc mắc';
        $data['faqs'] = Faqs::orderBy('id','desc')->paginate(10);
        return view('newhome.faqs',$data);
    }
    public function getContact()
    {
        $data['page_title'] = 'Trang Liên Hệ';
        return view('newhome.contact',$data);
    }
    public function submitContact(Request $request)
    {
        $request->validate([
           'name' => 'required',
           'email' => 'required',
           'message' => 'required',
        ]);
        $request->subject = isset($request->subject)?$request->subject:'New Contact Request';
        $request->phone = isset($request->phone)?$request->phone:'';
        $this->sendContact($request->email,$request->name,$request->subject,$request->message,$request->phone);
        session()->flash('message','Contact Message Successfully Send.');
        return redirect()->back();
    }
    public function paypalIpn()
    {
        $payment_type		=	$_POST['payment_type'];
        $payment_date		=	$_POST['payment_date'];
        $payment_status		=	$_POST['payment_status'];
        $address_status		=	$_POST['address_status'];
        $payer_status		=	$_POST['payer_status'];
        $first_name			=	$_POST['first_name'];
        $last_name			=	$_POST['last_name'];
        $payer_email		=	$_POST['payer_email'];
        $payer_id			=	$_POST['payer_id'];
        $address_country	=	$_POST['address_country'];
        $address_country_code	= $_POST['address_country_code'];
        $address_zip		=	$_POST['address_zip'];
        $address_state		=	$_POST['address_state'];
        $address_city		=	$_POST['address_city'];
        $address_street		=	$_POST['address_street'];
        $business			=	$_POST['business'];
        $receiver_email		=	$_POST['receiver_email'];
        $receiver_id		=	$_POST['receiver_id'];
        $residence_country	=	$_POST['residence_country'];
        $item_name			=	$_POST['item_name'];
        $item_number		=	$_POST['item_number'];
        $quantity			=	$_POST['quantity'];
        $shipping			=	$_POST['shipping'];
        $tax				=	$_POST['tax'];
        $mc_currency		=	$_POST['mc_currency'];
        $mc_fee				=	$_POST['mc_fee'];
        $mc_gross			=	$_POST['mc_gross'];
        $mc_gross_1			=	$_POST['mc_gross_1'];
        $txn_id				=	$_POST['txn_id'];
        $notify_version		=	$_POST['notify_version'];
        $custom				=	$_POST['custom'];

        $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

        $paypal = PaymentMethod::whereId(1)->first();

        $paypal_email = $paypal->val1;

        if($payer_status=="verified" && $payment_status=="Completed" && $receiver_email==$paypal_email && $ip=="notify.paypal.com"){

            $data = PaymentLog::where('custom' , $custom)->first();

            $totalamo = $data->usd;

            if($totalamo == $mc_gross)
            {
                $basic = BasicSetting::first();
                $mem = User::findOrFail($data->member_id);
                $de['user_id'] = $mem->id;
                $de['amount'] = $data->amount;
                $de['payment_type'] = 1;
                $de['charge'] = $data->charge;
                $de['rate'] = $data->payment->rate;
                $de['net_amount'] = $data->net_amount;
                $de['transaction_id'] = $data->custom;
                $de['status'] = 1;
                Deposit::create($de);

                $trx = Trx::create([
                    'track' => $data->id,
                    'sender' => $mem->id,
                    'receiver' => $basic->title,
                    'gross_amount' => $data->net_amount,
                    'charge' => $data->charge,
                    'net_amount' => $data->amount,
                    'type' => 'PaymentLog',
                    'description' => 'Deposit Via ' . $data->payment->name,
                    'trxid' => $data->custom,
                    'custom' => '',
                    'status' => 'requested'
                ]);

                $mem->balance = $mem->balance + ($data->amount);

                $mem->save();

                if ($basic->email_notify == 1){
                    $text = $data->amount." - ". $basic->currency ." Deposit via Paypal Successfully Completed. <br> Transaction ID Is : <b>#".$data->custom."</b>";
                    $this->sendMail($mem->email,$mem->name,'Deposit Completed.',$text);
                }
                if ($basic->phone_notify == 1){
                    $text = $data->amount." - ".$basic->currency ." Deposit Successfully Completed. <br> Transaction ID Is : <b>#".$data->custom."</b>";
                    $this->sendSms($mem->phone,$text);
                }

                $data->status = 1;
                $data->save();
                session()->flash('message','Deposit Successfully Complete.');
                session()->flash('type','success');
                session()->flash('title','Completed');
                return redirect()->route('deposit-fund');
            }
        }
    }
    public function perfectIPN()
    {
        $pay = PaymentMethod::whereId(2)->first();
        $passphrase=strtoupper(md5($pay->val2));

        define('ALTERNATE_PHRASE_HASH',  $passphrase);
        define('PATH_TO_LOG',  '/somewhere/out/of/document_root/');
        $string=
            $_POST['PAYMENT_ID'].':'.$_POST['PAYEE_ACCOUNT'].':'.
            $_POST['PAYMENT_AMOUNT'].':'.$_POST['PAYMENT_UNITS'].':'.
            $_POST['PAYMENT_BATCH_NUM'].':'.
            $_POST['PAYER_ACCOUNT'].':'.ALTERNATE_PHRASE_HASH.':'.
            $_POST['TIMESTAMPGMT'];

        $hash=strtoupper(md5($string));
        $hash2 = $_POST['V2_HASH'];

        if($hash==$hash2){

            $amo = $_POST['PAYMENT_AMOUNT'];
            $unit = $_POST['PAYMENT_UNITS'];
            $custom = $_POST['PAYMENT_ID'];


            $data = PaymentLog::where('custom' , $custom)->first();

            if($_POST['PAYEE_ACCOUNT']=="$pay->val1" && $unit=="USD" && $amo == $data->usd){

                $basic = BasicSetting::first();
                $mem = User::findOrFail($data->member_id);
                $de['user_id'] = $mem->id;
                $de['amount'] = $data->amount;
                $de['payment_type'] = 2;
                $de['charge'] = $data->charge;
                $de['rate'] = $data->payment->rate;
                $de['net_amount'] = $data->net_amount;
                $de['status'] = 1;
                $de['transaction_id'] = $data->custom;
                Deposit::create($de);

                $trx = Trx::create([
                    'track' => $data->id,
                    'sender' => $mem->id,
                    'receiver' => $basic->title,
                    'gross_amount' => $data->net_amount,
                    'charge' => $data->charge,
                    'net_amount' => $data->amount,
                    'type' => 'PaymentLog',
                    'description' => 'Deposit Via ' . $data->payment->name,
                    'trxid' => $data->custom,
                    'custom' => '',
                    'status' => 'requested'
                ]);


                $mem->balance = $mem->balance + ($data->amount);
                $mem->save();

                if ($basic->email_notify == 1){
                    $text = $data->amount." - ". $basic->currency ." Deposit via Perfect Money Successfully Completed. <br> Transaction ID Is : <b>#".$data->custom."</b>";
                    $this->sendMail($mem->email,$mem->name,'Deposit Completed.',$text);
                }
                if ($basic->phone_notify == 1){
                    $text = $data->amount." - ".$basic->currency ." Deposit Successfully Completed. <br> Transaction ID Is : <b>#".$data->custom."</b>";
                    $this->sendSms($mem->phone,$text);
                }

                $data->status = 1;
                $data->save();
                session()->flash('message', 'Deposit Completed Successfully');
                session()->flash('type','success');
                session()->flash('title','Completed');
                return redirect()->route('deposit-fund');
            }else{
                session()->flash('message', 'Something error....');
                Session::flash('type', 'warning');
                return redirect()->route('deposit-fund');
            }
        }
    }

    public function skrillIPN()

    {

        $skrill = PaymentMethod::whereId(6)->first();

        $concatFields = $_POST['merchant_id']
            .$_POST['transaction_id']
            .strtoupper(md5($skrill->val2))
            .$_POST['mb_amount']
            .$_POST['mb_currency']
            .$_POST['status'];

        if (strtoupper(md5($concatFields)) == $_POST['md5sig'] && $_POST['status'] == 2 && $_POST['pay_to_email'] == $skrill->val1) {

            $amo = $_POST['mb_amount'];
            $unit = $_POST['mb_currency'];
            $depoistTrack = $_POST['transaction_id'];

            //$DepositData = $db->query("SELECT usid, method, amount, charge, amountus, status FROM deposit_data WHERE track='".$depoistTrack."'")->fetch();
            $DepositData = PaymentLog::where('custom' , $depoistTrack)->first();

            if ($unit=="USD" && $amo ==$DepositData->usd) {

                $basic = BasicSetting::first();
                $mem = User::findOrFail($DepositData->member_id);
                $de['user_id'] = $mem->id;
                $de['amount'] = $DepositData->amount;
                $de['payment_type'] = 6;
                $de['charge'] = $DepositData->charge;
                $de['rate'] = $DepositData->payment->rate;
                $de['net_amount'] = $DepositData->net_amount;
                $de['status'] = 1;
                $de['transaction_id'] = $DepositData->custom;
                Deposit::create($de);

                $trx = Trx::create([
                    'track' => $DepositData->id,
                    'sender' => $mem->id,
                    'receiver' => $basic->title,
                    'gross_amount' => $DepositData->net_amount,
                    'charge' => $DepositData->charge,
                    'net_amount' => $DepositData->amount,
                    'type' => 'PaymentLog',
                    'description' => 'Deposit Via ' . $DepositData->payment->name,
                    'trxid' => $DepositData->custom,
                    'custom' => '',
                    'status' => 'requested'
                ]);


                $mem->balance = $mem->balance + ($DepositData->amount);
                $mem->save();

                if ($basic->email_notify == 1){
                    $text = $DepositData->amount." - ". $basic->currency ." Deposit via Skrill Successfully Completed. <br> Transaction ID Is : <b>#".$DepositData->custom."</b>";
                    $this->sendMail($mem->email,$mem->name,'Deposit Completed.',$text);
                }
                if ($basic->phone_notify == 1){
                    $text = $DepositData->amount." - ".$basic->currency ." Deposit Successfully Completed. <br> Transaction ID Is : <b>#".$DepositData->custom."</b>";
                    $this->sendSms($mem->phone,$text);
                }

                $DepositData->status = 1;
                $DepositData->save();

            }

        }

    }

    public function btcPreview(Request $request)
    {
        $data['amount'] = $request->amount;
        $data['custom'] = $request->custom;
        $pay = PaymentMethod::whereId(3)->first();
        $tran = PaymentLog::whereCustom($data['custom'])->first();

        $blockchain_root = "https://blockchain.info/";
        $blockchain_receive_root = "https://api.blockchain.info/";
        $mysite_root = url('/');
        $secret = "ABIR";
        $my_xpub = $pay->val2;
        $my_api_key = $pay->val1;
        $invoice_id = $tran->custom;
        $callback_url = route('btc_ipn',['invoice_id'=>$invoice_id,'secret'=>$secret]);

        if ($tran->btc_acc == null){

            $url = $blockchain_receive_root . "v2/receive?key=" . $my_api_key . '&callback=' . urlencode($callback_url) . '&xpub=' . $my_xpub;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $resp = curl_exec($ch);
                
            $response = json_decode($resp);

            if (isset($response->address)) {
                $sendto = $response->address;
                $api = "https://blockchain.info/tobtc?currency=USD&value=".$tran->usd;
                $usd = file_get_contents($api);
                $tran->btc_amo = $usd;
                $tran->btc_acc = $sendto;
                $tran->save();
            } else {
                session()->flash('message', "SOME ISSUE WITH API");
                Session::flash('type', 'warning');
                Session::flash('title', 'Opps!');
                return redirect()->route('deposit-fund');
            }
        }else{
            $usd = $tran->btc_amo;
            $sendto = $tran->btc_acc;
        }
        /*$sendto = "1HoPiJqnHoqwM8NthJu86hhADR5oWN8qG7";
        $usd =100;*/


        $var = "bitcoin:$sendto?amount=$usd";
        $data['code'] =  "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$var&choe=UTF-8\" title='' style='width:300px;' />";

        $data['site_currency'] = "USD";
        $data['page_title'] = "BlockChain Deposit Preview";
        $data['paypal'] = PaymentMethod::whereId(1)->first();
        $data['perfect'] = PaymentMethod::whereId(2)->first();
        $data['btc'] = PaymentMethod::whereId(3)->first();
        $data['stripe'] = PaymentMethod::whereId(4)->first();
        $data['amount'] = $request->amount;
        $data['payment_type'] = $tran->payemnt_type;
        $data['fund'] = $tran;
        $data['usd'] = $usd;
        $data['add'] = $sendto;
        return view('user.btc-preview',$data);
    }
    public function btcIPN(){

        $depoistTrack = $_GET['invoice_id'];
        $secret = $_GET['secret'];
        $address = $_GET['address'];
        $value = $_GET['value'];
        $confirmations = $_GET['confirmations'];
        $value_in_btc = $_GET['value'] / 100000000;

        $trx_hash = $_GET['transaction_hash'];

        $data = PaymentLog::whereCustom($depoistTrack)->first();

        if($data->status == 0){

            if ($data->btc_amo == $value_in_btc && $data->btc_acc == $address && $secret=="ABIR" && $confirmations>2){

                $basic = BasicSetting::first();
                $mem = User::findOrFail($data->member_id);
                $de['user_id'] = $mem->id;
                $de['amount'] = $data->amount;
                $de['payment_type'] = 3;
                $de['charge'] = $data->charge;
                $de['rate'] = $data->payment->rate;
                $de['net_amount'] = $data->net_amount;
                $de['status'] = 1;
                $de['transaction_id'] = $data->custom;
                Deposit::create($de);

                $trx = Trx::create([
                    'track' => $data->id,
                    'sender' => $mem->id,
                    'receiver' => $basic->title,
                    'gross_amount' => $data->net_amount,
                    'charge' => $data->charge,
                    'net_amount' => $data->amount,
                    'type' => 'PaymentLog',
                    'description' => 'Deposit Via ' . $data->payment->name,
                    'trxid' => $data->custom,
                    'custom' => '',
                    'status' => 'requested'
                ]);

                $mem->balance = $mem->balance + ($data->amount);
                $mem->save();

                if ($basic->email_notify == 1){
                    $text = $data->amount." - ". $basic->currency ." Deposit via Bitcoin - (Blockchain) Successfully Completed. <br> Transaction ID Is : <b>#".$data->custom."</b>";
                    $this->sendMail($mem->email,$mem->name,'Deposit Completed.',$text);
                }
                if ($basic->phone_notify == 1){
                    $text = $data->amount." - ".$basic->currency ." Deposit Successfully Completed. <br> Transaction ID Is : <b>#".$data->custom."</b>";
                    $this->sendSms($mem->phone,$text);
                }

                $data->status = 1;
                $data->save();
                session()->flash('message','Successfully Deposit Completed Wait For Confirmation');
                session()->flash('type','success');
                session()->flash('title','Completed');
                return redirect()->route('deposit-fund');
            }
        }
    }
    public function stripePreview(Request $request)
    {
        $data['site_currency'] = "USD";
        $data['page_title'] = "Credit Card Deposit Preview";
        $data['paypal'] = PaymentMethod::whereId(1)->first();
        $data['perfect'] = PaymentMethod::whereId(2)->first();
        $data['btc'] = PaymentMethod::whereId(3)->first();
        $data['stripe'] = PaymentMethod::whereId(4)->first();



        $data['btc_coin'] = PaymentMethod::whereId(6)->first();
        $data['payment_type'] = 4;
        $data['amount'] = $request->amount;
        $data['custom'] = $request->custom;
        $data['fund'] = PaymentLog::whereCustom($request->custom)->first();
        return view('user.stripe-preview',$data);
    }
    public function submitStripe(Request $request)
    {
        $this->validate($request,[
            'amount' => 'required',
            'custom' => 'required',
            'cardNumber' => 'required|numeric',
            'cardExpiryMonth' => 'required|numeric',
            'cardExpiryYear' => 'required|numeric',
            'cardCVC' => 'required|numeric',
        ]);
        $data = PaymentLog::whereCustom($request->custom)->first();
        $amm = $data->usd;
        $cc = $request->cardNumber;
        $emo = $request->cardExpiryMonth;
        $eyr = $request->cardExpiryYear;
        $cvc = $request->cardCVC;
        $basic = PaymentMethod::whereId(4)->first();
        Stripe::setApiKey($basic->val1);
        try{
            $token = Token::create(array(
                "card" => array(
                    "number" => "$cc",
                    "exp_month" => $emo,
                    "exp_year" => $eyr,
                    "cvc" => "$cvc"
                )
            ));
            if (!isset($token['id'])) {
                session()->flash('message','The Stripe Token was not generated correctly');
                return Redirect::to($request->url);
            }

            $charge = Charge::create(array(
                'card' => $token['id'],
                'currency' => 'USD',
                'amount' => $data->usd * 100,
                'description' => 'item',
            ));
//dd($charge);
            if ($charge['status'] == 'succeeded' ) {

                $basic = BasicSetting::first();
                $mem = User::findOrFail($data->member_id);
                $de['user_id'] = $mem->id;
                $de['amount'] = $data->amount;
                $de['payment_type'] = 4;
                $de['charge'] = $data->charge;
                $de['rate'] = $data->payment->rate;
                $de['net_amount'] = $data->net_amount;
                $de['status'] = 1;
                $de['transaction_id'] = $data->custom;
                Deposit::create($de);

                $trx = Trx::create([
                    'track' => $data->id,
                    'sender' => $mem->id,
                    'receiver' => $basic->title,
                    'gross_amount' => $data->net_amount,
                    'charge' => $data->charge,
                    'net_amount' => $data->amount,
                    'type' => 'PaymentLog',
                    'description' => 'Deposit Via ' . $data->payment->name,
                    'trxid' => $data->custom,
                    'custom' => '',
                    'status' => 'requested'
                ]);

                $mem->balance = $mem->balance + ($data->amount);
                $mem->save();

                if ($basic->email_notify == 1){

                    $text = $data->amount." - ". $basic->currency ." Deposit via Credit Card Successfully Completed. <br> Transaction ID Is : <b>#".$data->custom."</b>";
                    $this->sendMail($mem->email,$mem->name,'Deposit Completed.',$text);

                }

                if ($basic->phone_notify == 1){

                    $text = $data->amount." - ".$basic->currency ." Deposit Successfully Completed. <br> Transaction ID Is : <b>#".$data->custom."</b>";
                    $this->sendSms($mem->phone,$text);

                }

                $data->status = 1;
                $data->save();

                session()->flash('message','Card Successfully Charged.');
                session()->flash('title','Success');
                session()->flash('type','success');

                return redirect()->route('deposit-fund');

            }else{

                session()->flash('message','Something Is Wrong.');
                session()->flash('title','Opps..');
                session()->flash('type','warning');

                return redirect()->route('deposit-fund');

            }

        }catch (\Exception $e){
            echo $e->getLine();
            session()->flash('message',$e->getMessage());
            session()->flash('title','Opps..');
            session()->flash('type','warning');

            return redirect()->route('deposit-fund');
        }
    }

    public function btcCoinPreview(Request $request){

        $this->validate($request,
            [
                'amount' => 'required',
            ]);

        if ($request->amount <= 0) 
        {
            return redirect()->route('deposit')->with('alert', 'Invalid Amount');
        }
        else
        {
            $payment = PaymentLog::findOrFail($request->fund_id);
            $method = PaymentMethod::whereId(5)->first();
        // You need to set a callback URL if you want the IPN to work
            $callbackUrl = route('ipn.coinPay');

        // Create an instance of the class
            $CP = new coinPayments();

        // Set the merchant ID and secret key (can be found in account settings on CoinPayments.net)
            $CP->setMerchantId($method->val1);
            $CP->setSecretKey($method->val2);

           $data['page_title']  =  'CoinPyment Confirm';
           $data['bcoin']  =  $payment->btc_amo;
           $data['amon']   =  $payment->usd;
           $data['form']   = $CP->createPayment('Deposit USD', 'btc',  $payment->btc_amo, $payment->custom, $callbackUrl);


           return view('user.btccoinconfirm', $data);
        }
    }

    public function btcCoinIPN(Request $request){

        $track = $request->custom;
        $status = $request->status;
        $amount1 = floatval($request->amount1);
        $currency1 = $request->currency1;

        $data = PaymentLog::where('custom', $track)->first();


        if ($currency1 == "btc" && $amount1 >= $data->usd && $data->status == '0') {

            if ($status>=100 || $status==2) {

                $basic = BasicSetting::first();
                $mem = User::findOrFail($data->member_id);
                $de['user_id'] = $mem->id;
                $de['amount'] = $data->amount;
                $de['payment_type'] = 3;
                $de['charge'] = $data->charge;
                $de['rate'] = $data->payment->rate;
                $de['net_amount'] = $data->net_amount;
                $de['status'] = 1;
                $de['transaction_id'] = $data->custom;
                Deposit::create($de);

                $trx = Trx::create([
                    'track' => $data->id,
                    'sender' => $mem->id,
                    'receiver' => $basic->title,
                    'gross_amount' => $data->net_amount,
                    'charge' => $data->charge,
                    'net_amount' => $data->amount,
                    'type' => 'PaymentLog',
                    'description' => 'Deposit Via ' . $data->payment->name,
                    'trxid' => $data->custom,
                    'custom' => '',
                    'status' => 'requested'
                ]);

                $mem->balance = $mem->balance + ($data->amount);
                $mem->save();

                if ($basic->email_notify == 1){
                    $text = $data->amount." - ". $basic->currency ." Deposit via Bitcoin - (CoinPyment) Successfully Completed. <br> Transaction ID Is : <b>#".$data->custom."</b>";
                    $this->sendMail($mem->email,$mem->name,'Deposit Completed.',$text);
                }
                if ($basic->phone_notify == 1){
                    $text = $data->amount." - ".$basic->currency ." Deposit Successfully Completed. <br> Transaction ID Is : <b>#".$data->custom."</b>";
                    $this->sendSms($mem->phone,$text);
                }

                $data->status = 1;
                $data->save();
                session()->flash('message','Successfully Deposit Completed Wait For Confirmation');
                session()->flash('type','success');
                session()->flash('title','Completed');
                return redirect()->route('deposit-fund');
                

            }

        }



    }

    public function miner($id) {

        $category = Category::find($id);

        if ($category) {
            if ($category->plans) {
                $data['plans'] = $category->plans;
                $data['page_title'] = $category->name . ' Miner';
                return view('newhome.miner', $data);
            }
        }

        return redirect()->back();

    }

    public function cronGenerate()

    {

        $users = User::all();

        if ($users) {

            foreach ($users as $user) {

                $planlogs = PlanLog::where(['user_id' => $user->id, 'status' => 1])->get();

                if ($planlogs) {

                    $amount = '';

                    foreach ($planlogs as $planlog) {

                        $returnLog = ReturnLog::where(['user_id' => $user->id, 'plan_log' => $planlog->id])->first();

                        if (!$returnLog) {

                            $returnLog = ReturnLog::create([
                                'user_id' => $user->id,
                                'plan_log' => $planlog->id,
                                'last' => $planlog->created_at
                            ]);

                        }

                        $last = Carbon::parse($returnLog->last);
                        $now = Carbon::now();

                        if ($now->diffInHours($last) >= 24) {

                            $plan = $planlog->plan;

                            if ($plan) {

                                if ($plan->ptyp == 'day') {

                                    $hour = $plan->period*24;

                                } elseif ($plan->ptyp == 'month') {

                                    $hour = $plan->period*730;

                                } elseif ($plan->ptyp == 'year') {

                                    $hour = $plan->period*24*365;

                                } else {
                                    $hour = 0;
                                }

                                $purchaseDate = $planlog->created_at;

                                if ($now->diffInHours($purchaseDate) <= $hour) {

                                    $return_amount = $plan->return;

                                    $miner = $plan->category;

                                    if ($miner) {

                                        $wallet = UserData::where(['user_id' => $user->id, 'category_id' => $miner->id])->first();

                                        if ($wallet) {

                                            $basic = BasicSetting::first();

                                            $wallet->balance = $wallet->balance + $return_amount;

                                            Trx::create([
                                                'track' => $returnLog->id,
                                                'sender' => $basic->title,
                                                'receiver' => $user->id,
                                                'gross_amount' => $return_amount,
                                                'charge' => 0,
                                                'net_amount' => $return_amount,
                                                'type' => 'ReturnLog',
                                                'description' => 'Received Plan Return.',
                                                'trxid' => Str::random(20),
                                                'custom' => '',
                                                'status' => 'requested'
                                            ]);

                                            $returnLog->last = Carbon::now();

                                            $returnLog->save();
                                            $wallet->save();

                                        }

                                    }

                                }

                            }

                        }

                    }

                }

            }

        }

    }

    public function authorization()
    {
        if(Auth::user()->tfver == '1')
        {
            return redirect()->route('user-dashboard');
        }
        else
        {

            $data['page_title'] = "Google App Verification";

            return view('auth.notauthor',$data);
        }
    }


    public function verify2fa( Request $request)
    {
        $user = User::find(Auth::id());

        $this->validate($request,
            [
                'code' => 'required',
            ]);
        $ga = new GoogleAuthenticator();

        $secret = $user->secretcode;
        $oneCode = $ga->getCode($secret);
        $userCode = $request->code;

        if ($oneCode == $userCode) {
            $user['tfver'] = 1;
            $user->save();
            $data['page_title'] = "User Dashboard";
            return redirect()->route('user-dashboard');
        } else {

            return back()->with('alert', 'Wrong Verification Code');
        }

    }

}
