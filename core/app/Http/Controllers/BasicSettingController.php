<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Api;
use App\BasicSetting;
use App\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class BasicSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function getChangePass()
    {
        $data['page_title'] = "Change Password";
        return view('admin.change-pass',$data);
    }
    public function postChangePass(Request $request)
    {
        $this->validate($request, [
            'current_password' =>'required',
            'password' => 'required|min:5|confirmed'
        ]);
        try {
            $c_password = Auth::guard('admin')->user()->password;
            $c_id = Auth::guard('admin')->user()->id;

            $user = Admin::findOrFail($c_id);

            if(Hash::check($request->current_password, $c_password)){

                $password = Hash::make($request->password);
                $user->password = $password;
                $user->save();
                session()->flash('message', 'Password Changes Successfully.');
                session()->flash('title','Success');
                Session::flash('type', 'success');
                return redirect()->back();
            }else{
                session()->flash('message', 'Current Password Not Match');
                Session::flash('type', 'warning');
                session()->flash('title','Opps');
                return redirect()->back();
            }

        } catch (\PDOException $e) {
            session()->flash('message', $e->getMessage());
            Session::flash('type', 'warning');
            session()->flash('title','Opps');
            return redirect()->back();
        }

    }
    public function getBasicSetting()
    {
        $data['page_title'] = "Basic Setting";
        $data['facebook'] = Api::where('provider', 'facebook')->first();
        $data['google'] = Api::where('provider', 'google')->first();
        $cron = route('repeat-generate');
        return view('webControl.basic-setting',$data);
    }
    protected function putBasicSetting(Request $request,$id)
    {
        $basic = BasicSetting::findOrFail($id);
        $this->validate($request,[
           'title' => 'required',
        ]);
        $in = Input::except('_method','_token', 'facebook_app', 'facebook_secret', 'google_app', 'google_secret');
        $in['user_reg'] = $request->user_reg == 'on' ? '1' : '0';
        $in['email_verify'] = $request->email_verify == 'on' ? '1' : '0';
        $in['phone_verify'] = $request->phone_verify == 'on' ? '1' : '0';
        $in['withdraw_status'] = $request->withdraw_status == 'on' ? '1' : '0';
        $in['repeat_status'] = $request->repeat_status == 'on' ? '1' : '0';
        $in['email_notify'] = $request->email_notify == 'on' ? '1' : '0';
        $in['phone_notify'] = $request->phone_notify == 'on' ? '1' : '0';
        $in['google_recap'] = $request->google_recap == 'on' ? '1' : '0';
        $in['fb_login'] = $request->fb_login == 'on' ? '1' : '0';
        $in['g_login'] = $request->g_login == 'on' ? '1' : '0';
        $basic->fill($in)->save();

        Api::where('provider', 'facebook')->update([
            'client_id' => $request->facebook_app,
            'client_secret' => $request->facebook_secret
        ]);

        Api::where('provider', 'google')->update([
            'client_id' => $request->google_app,
            'client_secret' => $request->google_secret
        ]);

        session()->flash('message', 'Basic Setting Updated Successfully.');
        Session::flash('type', 'success');
        Session::flash('title', 'Success');
        return redirect()->back();
    }

    public function getTAP()

    {

        $data['page_title'] = 'Terms And Policy Setting';

        return view('webControl.tap',$data);

    }

    public function postTAP(Request $r)

    {

        $r->validate([
           'tou' => 'required',
           'pp' => 'required'
        ]);

        $basic = BasicSetting::find(1);

        $basic->tou = $r->tou;
        $basic->pp = $r->pp;

        $basic->save();

        session()->flash('message', 'Updated Successfully.');
        Session::flash('type', 'success');
        Session::flash('title', 'Success');
        return redirect()->back();

    }

    public function getContact()
    {
        $data['page_title'] = "Contact Setting";
        return view('webControl.contact-setting',$data);
    }
    public function putContactSetting(Request $request, $id)
    {
        $basic = BasicSetting::findOrFail($id);
        $request->validate([
           'phone' => 'required',
           'email' => 'required',
           'address' => 'required',
        ]);
        $in = Input::except('_method','_token');
        $basic->fill($in)->save();
        session()->flash('message', 'Contact Setting Updated Successfully.');
        Session::flash('type', 'success');
        Session::flash('title', 'Success');
        return redirect()->back();
    }
    public function emailSetting()
    {
        $data['page_title'] = "Manage Email Setting";
        return view('webControl.email-setting',$data);
    }
    public function updateEmailSetting(Request $request)
    {
        $this->validate($request,[
            'from_email' => 'required',
            'email_body' => 'required'
        ]);
        $basic = BasicSetting::first();
        $basic->from_email = $request->from_email;
        $basic->email_body = $request->email_body;
        $basic->save();
        session()->flash('message', 'Email Setting Successfully Updated.');
        Session::flash('type', 'success');
        Session::flash('title', 'Success');
        return redirect()->back();
    }
    public function smsSetting()
    {
        $data['page_title'] = "Manage SMS Setting";
        return view('webControl.sms-setting',$data);
    }
    public function updateSmsSetting(Request $request)
    {
        $basic = BasicSetting::first();
        $basic->smsapi = $request->smsapi;
        $basic->save();
        session()->flash('message', 'SMS Setting Successfully Updated.');
        Session::flash('type', 'success');
        Session::flash('title', 'Success');
        return redirect()->back();
    }

}
