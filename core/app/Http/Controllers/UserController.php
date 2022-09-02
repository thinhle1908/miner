<?php

namespace App\Http\Controllers;

use App\BasicSetting;
use App\Category;
use App\Compound;
use App\Deposit;
use App\DepositImage;
use App\Investment;
use App\Lib\HashF;
use App\PaymentLog;
use App\PaymentMethod;
use App\Plan;
use App\PlanLog;
use App\Repeat;
use App\RepeatLog;
use App\Support;
use App\SupportMessage;
use App\TraitsFolder\MailTrait;
use App\Trx;
use App\User;
use App\UserData;
use App\UserLog;
use App\WithdrawLog;
use App\WithdrawMethod;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Validator;
use App\Lib\GoogleAuthenticator;

class UserController extends Controller
{
    use MailTrait;
    public function __construct()
    {
        $this->middleware('verifyUser');
        $this->middleware('auth');
        $this->middleware('ckstatus');
    }
    public function getDashboard()
    {

        $data['page_title'] = 'User Dashboard';
        $data['basic_setting'] = BasicSetting::first();

        $data['user'] = Auth::user();
        $data['balance'] = $data['user'];
        $data['deposit'] = Deposit::whereUser_id(Auth::user()->id)->whereStatus(1)->sum('amount');
        $data['withdraw'] = WithdrawLog::whereUser_id(Auth::user()->id)->whereIn('status',[2])->sum('amount');

        $miners = Category::all();
        $user = Auth::user();

        foreach ($miners as $miner) {
            $userData = UserData::where(['user_id' => $user->id, 'category_id' => $miner->id])->first();

            if (!$userData) {
                UserData::create([
                    'user_id' => $user->id,
                    'category_id' => $miner->id,
                    'wallet' => '',
                    'balance' => 0
                ]);
            }
        }

        $data['balances'] = UserData::where('user_id', Auth::user()->id)->get();

        return view('user.dashboard',$data);
    }

    /*
     * User Packages
     * */

    public function allPack()

    {


        //$data['packages'] = Plan::where('status', '1')->get();
        $data['page_title'] = 'All Package';

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

        return view('user.pakage', $data);

    }

    public function purchasePlan($id)

    {

        $plan = Plan::find($id);
        $basic = BasicSetting::first();

        if ($plan) {

            $balance = Auth::user()->balance;

            if ($plan->price > $balance){

                session()->flash('alert', 'Not Enough Balance.');
                Session::flash('type', 'warning');
                session()->flash('title','Opps');

                return redirect()->back();

            }

            $user = Auth::user();
            $user->balance = $user->balance - $plan->price;
            $user->save();

            $request = PlanLog::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'status' => 0
            ]);

            $trx = Trx::create([
                'track' => $request->id,
                'sender' => $user->id,
                'receiver' => $basic->title,
                'gross_amount' => $plan->price,
                'charge' => '0',
                'net_amount' => $plan->price,
                'type' => 'PlanLog',
                'description' => 'Purchased ' . $plan->title,
                'trxid' => md5(uniqid(rand(), true)),
                'custom' => '',
                'status' => 'requested'
            ]);

            $email = $user->email;
            $mobile = $user->phone;

            $name = $user->name;
            $subject = 'Plan Purchased';
            $text = 'Purchased ' . $plan->title . ' .<br>';
            $text .= 'Plan Purchased Successfully.';


            $this->sendMail($email,$name,$subject,$text);
            $this->sendSms($mobile,$text);

            if ($request) {
                session()->flash('success', 'Plan Purchased Successfully.');
                Session::flash('type', 'success');
                session()->flash('title','Success');
            }

        }

        return redirect()->back();

    }

    public function purchasedPlan()

    {

        $data['logs'] = PlanLog::where('user_id', Auth::user()->id)->get();
        $data['page_title'] = 'Purchased Plan';

        foreach ($data['logs'] as $log) {

        	$purchaseDate = $log->created_at;
        	$now = Carbon::now();

        	$plan = $log->plan;

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

	        	if ($now->diffInHours($purchaseDate) > $hour) {
	        		
	        		$log->status = -10;
	        		$log->save();

	        	}

        	}

        }

        return view('user.purchased-plan', $data);

    }

    public function changePassword()
    {
        $data['page_title'] = "Change Password";
        return view('user.change-password', $data);
    }

    public function submitPassword(Request $request)
    {
        $this->validate($request, [
            'current_password' =>'required',
            'password' => 'required|min:5|confirmed'
        ]);
        try {
            $c_password = Auth::user()->password;
            $c_id = Auth::user()->id;
            $user = User::findOrFail($c_id);
            if(Hash::check($request->current_password, $c_password)){

                $password = Hash::make($request->password);
                $user->password = $password;
                $user->save();
                session()->flash('message', 'Password Changes Successfully.');
                session()->flash('title','Success');
                Session::flash('type', 'success');
                return redirect()->back();
            }else{
                session()->flash('alert', 'Current Password Not Match');
                Session::flash('type', 'warning');
                session()->flash('title','Opps');
                return redirect()->back();
            }

        } catch (\PDOException $e) {
            session()->flash('alert', $e->getMessage());
            Session::flash('type', 'warning');
            session()->flash('title','Opps');
            return redirect()->back();
        }
    }

    public function editProfile()
    {
        $data['page_title'] = "Edit Profile";
        $data['user'] = User::findOrFail(Auth::user()->id);
        return view('user.edit-profile', $data);
    }

    public function submitProfile(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'phone' => 'required|string|min:10|unique:users,phone,'.$user->id,
            'username' => 'required|min:5|unique:users,username,'.$user->id,
            'image' => 'mimes:png,jpg,jpeg'
        ]);
        $in = Input::except('_method','_token');
        $in['reference'] = $request->username;
        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = $request->username.'.'.$image->getClientOriginalExtension();
            $location = 'assets/images/' . $filename;
            $in['image'] = $filename;
            if ($user->image != 'user-default.png'){
                $path = './assets/images/';
                $link = $path.$user->image;
                if (file_exists($link)) {
                    unlink($link);
                }
            }
            Image::make($image)->resize(400,400)->save($location);
        }
        $user->fill($in)->save();
        session()->flash('message', 'Profile Updated Successfully.');
        session()->flash('title','Success');
        Session::flash('type', 'success');
        return redirect()->back();
    }
    public function depositMethod()
    {
        $data['page_title'] = 'Deposit Method';
        $data['methods'] = PaymentMethod::where('status', 1)->get();

        return view('user.deposit-fund',$data);
    }
    public function submitDepositFund(Request $r)
    {

        $basic = BasicSetting::first();

        $this->validate($r,[
            'amount'         => 'required|numeric',
            'payment_type'   => 'required|numeric',
        ]);

        $method = PaymentMethod::whereId($r->payment_type)->first();

        if (!$method) {
            session()->flash('message', 'Unexpected Error! Please Try Again.');
            session()->flash('title','Error');
            Session::flash('type', 'error');
            return redirect()->back();
        }

        if ($r->amount <= 0) {
            session()->flash('message', 'Amount Must Be Larger Then Zero.');
            session()->flash('title','Error');
            session()->flash('type', 'error');
//
//            session()->flash('message','Your Request Amount is Larger Then Your Current Balance.');
//            session()->flash('type','warning');
//            session()->flash('title','Opps');
            return redirect()->back();
        }

        $amount = $r->amount;
        $charge = ($method->fix + ( $amount*$method->percent / 100 ));

        $lo['member_id'] = Auth::user()->id;
        $lo['custom'] = strtoupper(Str::random(20));
        $lo['amount'] = $amount;
        $lo['charge'] = round($charge, $basic->deci);
        $lo['net_amount'] = $amount + $charge;
        
        if($r->payment_type == 5){

            $all = file_get_contents("https://blockchain.info/ticker");
            $res = json_decode($all);
            $lo['btc_amo'] = round( ($amount + $charge) * (1/$res->USD->last),16);
            $lo['usd'] = round(($amount + $charge), $basic->deci);

        }else{

            $lo['usd'] = round(($amount + $charge) / $method->rate, $basic->deci);

        }

        $lo['payment_type'] = $r->payment_type;
        $data['fund'] = PaymentLog::create($lo);

        session()->flash('track', $data['fund']->custom);

        return redirect()->route('deposit-preview');
    }
    public function depositPreview()
    {

        if (session('track') == NULL) return redirect()->back();

        $data['fund'] = PaymentLog::whereCustom(session('track'))->first();

        if (!$data['fund']) return redirect()->back();

        $data['page_title'] = $data['fund']->payment->name . ' Deposit';

        return view('user.deposit-preview', $data);
    }
    public function depositRedirect($track)

    {

        $fund = PaymentLog::whereCustom($track)->first();

        if ($fund) {
            $data['page_title'] = '';
            $data['fund'] = $fund;
            return view('user.deposit-form', $data);
        } else {
            return redirect()->back();
        }

    }
    public function historyDepositFund()

    {

        $data['page_title'] = "Deposit History";
        $data['deposit'] = Deposit::whereUser_id(Auth::user()->id)->orderBy('id','desc')->get();

        return view('user.deposit-history', $data);

    }
    public function userActivity()

    {

        $data['page_title'] = "Transaction Log";
        $data['logs'] = Trx::where('sender', Auth::user()->id)->orWhere('receiver', Auth::user()->id)->paginate(10);

        return view('user.user-activity',$data);

    }
    public function withdrawRequest()
    {

        $data['page_title'] = "Withdraw Fund";
        $data['basic'] = BasicSetting::first();

        if ($data['basic']->withdraw_status == 0){
            session()->flash('message','Currently Withdraw Is Deactivated.');
            session()->flash('type','warning');
            session()->flash('title','Warning');
        }

        $data['method'] = WithdrawMethod::whereStatus(1)->get();
        $data['coins'] = UserData::where('user_id', Auth::user()->id)->where('balance', '>', 0)->get();
        return view('user.withdraw-request', $data);

    }
    public function submitWithdrawRequest($type, Request $r)
    {

        $basic = BasicSetting::first();


        if ($type == 'general') {

            $r->validate([
                'method_id' => 'required|numeric',
                'amount' => 'required|numeric'
            ]);

            $method = WithdrawMethod::findOrFail($r->method_id);
            $charge = $method->fix + round(($r->amount * $method->percent) / 100, $basic->deci);
            $gross = $r->amount+$charge;

            if ($gross <= 0){

                session()->flash('message','Your Request Amount Must Be Larger Then Zero.');
                session()->flash('type','warning');
                session()->flash('title','Opps');

                return redirect()->back();

            }

            if ($gross < $method->withdraw_min){

                session()->flash('message','Your Request Amount is Smaller Then Withdraw Minimum Amount.');
                session()->flash('type','warning');
                session()->flash('title','Opps');

                return redirect()->back();

            }

            if ($gross > $method->withdraw_max){

                session()->flash('message','Your Request Amount is Larger Then Withdraw Maximum Amount.');
                session()->flash('type','warning');
                session()->flash('title','Opps');

                return redirect()->back();

            }

            if ($gross > Auth::user()->balance) {

                session()->flash('message','Your Request Amount is Larger Then Your Current Balance.');
                session()->flash('type','warning');
                session()->flash('title','Opps');

                return redirect()->back();

            } else {

                $trx = strtoupper(Str::random(20));

                $wl['amount'] = $r->amount;
                $wl['method_id'] = $r->method_id;
                $wl['charge'] = $charge;
                $wl['transaction_id'] = $trx;
                $wl['net_amount'] = $gross;
                $wl['user_id'] = Auth::user()->id;
                $wl['type'] = 'general';

                $log = WithdrawLog::create($wl);

                session()->flash('trx', $trx);

                return redirect()->route('withdraw-preview');

            }

        } elseif ($type == 'coin') {

            $r->validate([
                'miner_id' => 'required|numeric',
                'amount' => 'required|numeric'
            ]);

            $wallet = UserData::findOrFail($r->miner_id);

            if (!$wallet) return redirect()->back();

            $charge = ($r->amount * $basic->withdraw_charge) / 100;

            $gross = $r->amount+$charge;

            if ($gross <= 0){

                session()->flash('message','Your Request Amount Must Be Larger Then Zero.');
                session()->flash('type','warning');
                session()->flash('title','Opps');

                return redirect()->back();

            }

            if ($gross > $wallet->balance) {

                session()->flash('message','Your Request Amount is Larger Then Your Current Balance.');
                session()->flash('type','warning');
                session()->flash('title','Opps');

                return redirect()->back();

            } else {

                $trx = strtoupper(Str::random(20));

                $wl['amount'] = $r->amount;
                $wl['method_id'] = $r->miner_id;
                $wl['charge'] = $charge;
                $wl['transaction_id'] = $trx;
                $wl['net_amount'] = $gross;
                $wl['user_id'] = Auth::user()->id;
                $wl['type'] = 'coin';

                $log = WithdrawLog::create($wl);

                session()->flash('trx', $trx);

                return redirect()->route('withdraw-preview');

            }

        }
    }
    public function previewWithdraw()
    {

        if (session('trx') == NULL) return redirect()->back();

        $trx = session('trx');

        $log = WithdrawLog::whereTransaction_id($trx)->first();

        if (!$log) return redirect()->back();

        $data['page_title'] = ucfirst($log->type) . " Withdraw";

        if ($log->type == 'general') {

            $data['withdraw'] = $log;
            $data['method'] = WithdrawMethod::findOrFail($log->method_id);

            return view('user.withdraw-preview', $data);

        } elseif($log->type == 'coin') {

            $data['withdraw'] = $log;
            $data['data'] = UserData::findOrFail($log->method_id);

            return view('user.withdraw-preview-coin', $data);

        }

    }
    public function submitWithdraw(Request $r)
    {

        $r->validate([
           'withdraw_id' => 'required|numeric'
        ]);

        $basic = BasicSetting::first();

        $log = WithdrawLog::findOrFail($r->withdraw_id);

        if (!$log) return redirect()->back();

        if ($log->type == 'general') {

            $r->validate([
                'send_details' => 'required'
            ]);

            $log->send_details = $r->send_details;
            $log->message = $r->message;
            $log->save();

            $user = Auth::user();

            $user->balance = $user->balance - $log->net_amount;
            $user->save();

            $trx = Trx::create([
                'track' => $log->id,
                'sender' => $user->id,
                'receiver' => $basic->title,
                'gross_amount' => $log->net_amount,
                'charge' => $log->charge,
                'net_amount' => $log->amount,
                'type' => 'WithdrawLog',
                'description' => 'Withdraw Request.',
                'trxid' => $log->transaction_id,
                'custom' => '',
                'status' => 'requested'
            ]);

            if ($basic->email_notify == 1){
                $text = $log->amount." - ". $basic->currency." Withdraw Request Send via ".$log->method->name.". <br> Transaction ID Is : <b>#$log->transaction_id</b>";
                $this->sendMail($user->email, $user->name, 'Withdraw Request.', $text);
            }
            if ($basic->phone_notify == 1){
                $text = $log->amount." - ". $basic->currency." Withdraw Request Send via ".$log->method->name.". <br> Transaction ID Is : <b>#$log->transaction_id</b>";
                $this->sendSms($user->phone, $text);
            }

        } elseif ($log->type == 'coin') {

            $user = Auth::user();

            $wallet = UserData::findOrFail($log->method_id);

            $wallet->balance = $wallet->balance - $log->net_amount;
            $wallet->save();

            $trx = Trx::create([
                'track' => $log->id,
                'sender' => $user->id,
                'receiver' => $basic->title,
                'gross_amount' => $log->net_amount,
                'charge' => $log->charge,
                'net_amount' => $log->amount,
                'type' => 'WithdrawLog',
                'description' => 'Coin Withdraw Request.',
                'trxid' => $log->transaction_id,
                'custom' => '',
                'status' => 'requested'
            ]);$trx = Trx::create([
                'track' => $log->id,
                'sender' => $user->id,
                'receiver' => $basic->title,
                'gross_amount' => $log->net_amount,
                'charge' => $log->charge,
                'net_amount' => $log->amount,
                'type' => 'WithdrawLog',
                'description' => 'Coin Withdraw Request.',
                'trxid' => $log->transaction_id,
                'custom' => '',
                'status' => 'requested'
            ]);

            if ($basic->email_notify == 1){
                $text = $log->amount." - ". $wallet->miner->code . " Withdraw Request Send. <br> Transaction ID Is : <b>#$log->transaction_id</b>";
                $this->sendMail($user->email, $user->name, 'Withdraw Request.', $text);
            }
            if ($basic->phone_notify == 1){
                $text = $log->amount." - ". $wallet->miner->code." Withdraw Request Send. <br> Transaction ID Is : <b>#$log->transaction_id</b>";
                $this->sendSms($user->phone, $text);
            }

        }

        session()->flash('message','Withdraw request Successfully Submitted. Wait For Confirmation.');
        session()->flash('type','success');
        session()->flash('title','Success');
        return redirect()->route('withdraw-log');

    }
    public function withdrawLog()
    {
        $data['page_title'] = "Withdraw Log";
        $data['log'] = WithdrawLog::whereUser_id(Auth::user()->id)->orderBy('id','desc')->get();
        return view('user.withdraw-log',$data);
    }
    public function openSupport()
    {
        $data['page_title'] = "Open Support Ticket";
        return view('user.support-open', $data);
    }
    public function submitSupport(Request $request)
    {
        $this->validate($request,[
            'subject' => 'required',
            'message' => 'required'
        ]);
        $s['ticket_number'] = strtoupper(Str::random(12));
        $s['user_id'] = Auth::user()->id;
        $s['subject'] = $request->subject;
        $s['status'] = 1;
        $mm = Support::create($s);
        $mess['support_id'] = $mm->id;
        $mess['ticket_number'] = $mm->ticket_number;
        $mess['message'] = $request->message;
        $mess['type'] = 1;
        SupportMessage::create($mess);
        session()->flash('success','Support Ticket Successfully Open.');
        session()->flash('type','success');
        session()->flash('title','Success');
        return redirect()->route('support-all');
    }
    public function allSupport()
    {
        $data['page_title'] = "All Support Ticket";
        $data['support'] = Support::whereUser_id(Auth::user()->id)->orderBy('id','desc')->get();
        return view('user.support-all',$data);
    }
    public function supportMessage($id)
    {
        $data['page_title'] = "Support Message";
        $data['support'] = Support::whereTicket_number($id)->first();
        $data['message'] = SupportMessage::whereTicket_number($id)->orderBy('id','asc')->get();
        return view('user.support-message', $data);
    }
    public function userSupportMessage(Request $request)
    {
        $this->validate($request,[
            'message' => 'required',
            'support_id' => 'required'
        ]);
        $mm = Support::findOrFail($request->support_id);
        $mm->status = 3;
        $mm->save();
        $mess['support_id'] = $mm->id;
        $mess['ticket_number'] = $mm->ticket_number;
        $mess['message'] = $request->message;
        $mess['type'] = 1;
        SupportMessage::create($mess);
        session()->flash('message','Support Ticket Successfully Reply.');
        session()->flash('type','success');
        session()->flash('title','Success');
        return redirect()->back();
    }
    public function supportClose(Request $request)
    {
        $this->validate($request,[
            'support_id' => 'required'
        ]);
        $su = Support::findOrFail($request->support_id);
        $su->status = 9;
        $su->save();
        session()->flash('message','Support Successfully Closed.');
        session()->flash('type','success');
        session()->flash('title','Success');
        return redirect()->back();
    }

    public function newInvest()
    {
        $data['basic_setting'] = BasicSetting::first();
        $data['page_title'] = "User New Invest";
        $data['plan'] = Plan::whereStatus(1)->get();
        return view('user.investment-new',$data);
    }

    public function postInvest(Request $request)
    {
        $this->validate($request,[
            'id' => 'required'
        ]);
        $data['page_title'] = "Investment Preview";
        $data['plan'] = Plan::findOrFail($request->id);
        return view('user.investment-preview',$data);
    }

    public function investAmountReview(Request $request)
    {   
        $data = Plan::findOrFail($request->id);
        $data['compound_name'] = Plan::findOrFail($request->id)->compound->name;
        
        return response()->json($data);
        
        
    }


    public function chkInvestAmount(Request $request)
    {
        $plan = Plan::findOrFail($request->plan);
        $user = User::findOrFail(Auth::user()->id);
        $amount = $request->amount;

        if ($request->amount > $user->balance){
            return '<div class="col-sm-12">
                <div class="alert alert-warning"><i class="fa fa-times"></i> Amount Is Larger than Your Current Amount.</div>
            </div>
            <div class="col-sm-12">
                <button type="button" class="btn btn-primary btn-block bold uppercase btn-lg delete_button disabled"
                        >
                    <i class="fa fa-cloud-upload"></i> Invest Amount Under This Package
                </button>
            </div>';
        }
        if( $plan->minimum > $amount){
            return '<div class="col-sm-12">
                <div class="alert alert-warning"><i class="fa fa-times"></i> Amount Is Smaller than Plan Minimum Amount.</div>
            </div>
            <div class="col-sm-12">
                <button type="button" class="btn btn-primary btn-block bold uppercase btn-lg  delete_button disabled"
                        >
                    <i class="fa fa-cloud-upload"></i> Invest Amount Under This Package
                </button>
            </div>';
        }elseif( $plan->maximum < $amount){
            return '<div class="col-sm-12">
                <div class="alert alert-warning"><i class="fa fa-times"></i> Amount Is Larger than Plan Maximum Amount.</div>
            </div>
            <div class="col-sm-12">
                <button type="button" class="btn btn-primary btn-block bold uppercase btn-lg delete_button disabled"
                      >
                    <i class="fa fa-cloud-upload"></i> Invest Amount Under This Package
                </button>
            </div>';
        }else{
            return '<div class="col-sm-12">
                <div class="alert alert-success"><i class="fa fa-check"></i> Well Done. Invest This Amount Under this Package.</div>
            </div>
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary bold uppercase btn-block btn-lg delete_button"
                        data-toggle="modal" data-target="#DelModal"
                        data-id='.$amount.'>
                    <i class="fa fa-cloud-upload"></i> Invest Amount Under This Package
                </button>
            </div>';
        }

    }

    public function submitInvest(Request $request)
    {
        $basic = BasicSetting::first();
        $user_balance = User::findOrFail(Auth::user()->id)->balance;
        
        $validator = Validator::make($request->all(), [
              'amount' => 'required|numeric|max:'.$user_balance,
            'user_id' => 'required',
            'plan_id' => 'required'
        ]);

        if ($validator->fails()) {
            
            session()->flash('error','Something wrong try again!.');
            session()->flash('type','error');
            session()->flash('title','Ops!');
            return redirect()->back();
        };

        $in = Input::except('_method','_token');
        $in['trx_id'] = strtoupper(Str::random(20));
        $invest = Investment::create($in);

        $pak = Plan::findOrFail($request->plan_id);
        $com = Compound::findOrFail($pak->compound_id);
        $rep['user_id'] = $invest->user_id;
        $rep['investment_id'] = $invest->id;
        $rep['repeat_time'] = Carbon::parse()->addHours($com->compound);
        $rep['total_repeat'] = 0;
        Repeat::create($rep);

        $bal4 = User::findOrFail(Auth::user()->id);
        $ul['user_id'] = $bal4->id;
        $ul['amount'] = $request->amount;
        $ul['charge'] = null;
        $ul['amount_type'] = 14;
        $ul['post_bal'] = $bal4->balance - $request->amount;
        $ul['description'] = $request->amount." ".$basic->currency." Invest Under ".$pak->name." Plan.";
        $ul['transaction_id'] = $in['trx_id'];
        UserLog::create($ul);

        $bal4->balance = $bal4->balance - $request->amount;
        $bal4->save();

        $trx = $in['trx_id'];

        if ($basic->email_notify == 1){
            $text = $request->amount." - ". $basic->currency." Invest Under ".$pak->name." Plan. <br> Transaction ID Is : <b>#$trx</b>";
            $this->sendMail($bal4->email,$bal4->name,'New Investment',$text);
        }
        if ($basic->phone_notify == 1){
            $text = $request->amount." - ". $basic->currency." Invest Under ".$pak->name." Plan. <br> Transaction ID Is : <b>#$trx</b>";
            $this->sendSms($bal4->phone,$text);
        }

        session()->flash('success','Investment Successfully Completed.');
        session()->flash('type','success');
        session()->flash('title','Success');
        return redirect()->back();
    }

    public function historyInvestment()
    {
        $data['page_title'] = "Invest History";
        $data['history'] = Investment::whereUser_id(Auth::user()->id)->orderBy('id','desc')->get();
        return view('user.investment-history',$data);
    }

    public function repeatLog()
    {
        $data['user'] = User::findOrFail(Auth::user()->id);
        $data['page_title'] = 'All Repeat History';
        $data['log'] = RepeatLog::whereUser_id(Auth::user()->id)->orderBy('id','desc')->paginate(15);
        return view('user.repeat-history',$data);
    }
//    public function userReference()
//    {
//        $data['page_title'] = "Reference User";
//        $data['user'] = User::whereUnder_reference(Auth::user()->id)->orderBy('id','desc')->get();
//        return view('user.reference-user',$data);
//    }

    public function walletSettings()

    {

        $miners = Category::all();
        $user = Auth::user();

        foreach ($miners as $miner) {
            $userData = UserData::where(['user_id' => $user->id, 'category_id' => $miner->id])->first();

            if (!$userData) {
                UserData::create([
                    'user_id' => $user->id,
                    'category_id' => $miner->id,
                    'wallet' => '',
                    'balance' => 0
                ]);
            }
        }

        $data['user_datas'] = $user->userDatas;
        $data['page_title'] = 'Wallet Settings';

        return view('user.wallet', $data);

    }

    public function walletSettingsStore(Request $r)

    {

        $inputs = $r->except('_token');

        /*$r->validate(function () use ($input) {
            $rules = [];
            if ($input) {
                foreach ($input as $key => $value) {
                    $rules[$key] = 'required';
                }
            }
            return $rules;
        });*/

        foreach ($inputs as $key => $value) {
            $data = UserData::where(['user_id' => Auth::user()->id, 'category_id' => $key])->update([
                'wallet' => $value
            ]);
        }

        return redirect()->back()->with('message', 'Updated Successfully.');

    }

    public function google2fa()
    {
        $page_title = 'Enable Google Login Verification';

        $gnl = BasicSetting::first();
        $ga = new GoogleAuthenticator();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl(Auth::user()->username.'@'.$gnl->title, $secret);

        $prevcode = Auth::user()->secretcode;
        $prevqr = $ga->getQRCodeGoogleUrl(Auth::user()->username.'@'.$gnl->title, $prevcode);

        return view('user.goauth.create', compact('secret','qrCodeUrl','prevcode','prevqr','page_title'));

    }

    public function create2fa(Request $request)
    {
        $user = User::find(Auth::id());

        $this->validate($request,
            [
                'key' => 'required',
                'code' => 'required',
            ]);

        $ga = new GoogleAuthenticator();

        $secret = $request->key;
        $oneCode = $ga->getCode($secret);
        $userCode = $request->code;

        if ($oneCode == $userCode)
        {
            $user['secretcode'] = $request->key;
            $user['tauth'] = 1;
            $user['tfver'] = 1;
            $user->save();

            //$msg =  'Google Two Factor Authentication Enabled Successfully';
            //send_email($user->email, $user->username, 'Google 2FA', $msg);
            //$sms =  'Google Two Factor Authentication Enabled Successfully';
            //send_sms($user->mobile, $sms);

            return back()->with('success', 'Google Authenticator Enabeled Successfully');
        }
        else {

            return back()->with('alert', 'Wrong Verification Code');
        }


    }

    public function disable2fa(Request $request)
    {
        $this->validate($request,
            [
                'code' => 'required',
            ]);

        $user = User::find(Auth::id());
        $ga = new GoogleAuthenticator();

        $secret = $user->secretcode;
        $oneCode = $ga->getCode($secret);
        $userCode = $request->code;

        if ($oneCode == $userCode)
        {
            $user = User::find(Auth::id());
            $user['tauth'] = 0;
            $user['tfver'] = 1;
            $user['secretcode'] = '0';
            $user->save();

            // $msg =  'Google Two Factor Authentication Disabled Successfully';
            // send_email($user->email, $user->username, 'Google 2FA', $msg);
            // $sms =  'Google Two Factor Authentication Disabled Successfully';
            // send_sms($user->mobile, $sms);

            return back()->with('success', 'Two Factor Authenticator Disable Successfully');
        }
        else
        {
            return back()->with('alert', 'Wrong Verification Code');
        }

    }

}
