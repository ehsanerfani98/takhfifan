<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:setting-list', ['only' => ['edit']]);
        $this->middleware('permission:setting-edit', ['only' => ['update']]);
    }

    public function edit()
    {
        $settings = get_settings();
        return view('admin.setting.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        update_setting('payment_gateway_type', $request->payment_gateway_type);
        update_setting('payment_gateway_status', $request->payment_gateway_status);
        update_setting('merchantId', $request->merchantId);
        update_setting('payment_gateway_unit', $request->payment_gateway_unit);

        update_setting('apiKey', $request->apiKey);
        update_setting('originator', $request->originator);
        update_setting('patternCode', $request->patternCode);
        update_setting('sms_status', $request->sms_status);

        update_setting('company_name', $request->company_name);
        update_setting('company_content', $request->company_content);
        update_setting('tagline', $request->tagline);
        update_setting('company_address', $request->company_address);
        update_setting('company_phone', $request->company_phone);
        update_setting('company_fax', $request->company_fax);
        update_setting('company_mobile', $request->company_mobile);
        update_setting('company_email', $request->company_email);

        update_setting('login_type', $request->login_type);

        update_setting('mail_mailer', $request->mail_mailer);
        update_setting('mail_host', $request->mail_host);
        update_setting('mail_port', $request->mail_port);
        update_setting('mail_encryption', $request->mail_encryption);
        update_setting('mail_username', $request->mail_username);
        update_setting('mail_password', $request->mail_password);
        update_setting('mail_from_address', $request->mail_from_address);
        update_setting('mail_from_name', $request->mail_from_name);

        update_setting('PUSHER_APP_ID', $request->PUSHER_APP_ID);
        update_setting('PUSHER_APP_KEY', $request->PUSHER_APP_KEY);
        update_setting('PUSHER_APP_SECRET', $request->PUSHER_APP_SECRET);
        update_setting('PUSHER_APP_CLUSTER', $request->PUSHER_APP_CLUSTER);
        update_setting('PUSHER_PORT', $request->PUSHER_PORT);
        update_setting('PUSHER_SCHEME', $request->PUSHER_SCHEME);

        return redirect()->back()->with('success', 'تنظیمات با موفقیت ذخیره شد.');

    }
}
