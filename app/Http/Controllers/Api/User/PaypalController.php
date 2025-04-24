<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Modules\Service\Entities\Service;
use Modules\Service\Entities\AdditionalService;
use App\Models\AppointmentSchedule;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\CouponHistory;
use App\Models\PaypalPayment;
use App\Models\InstamojoPayment;
use App\Models\CurrencyCountry;
use App\Models\Currency;
use App\Models\Setting;
use Auth, Session, Mail;
use App\Models\User;
use App\Mail\OrderSuccessfully;
use App\Helpers\MailHelper;
use App\Models\EmailTemplate;

class PaypalController extends Controller
{
    public function payWithPaypal(Request $request){
        $rules = [
            'address'=>'required',
            'date'=>'required',
            'name'=>'required',
            'phone'=>'required',
            'schedule_time_slot'=>'required',
            'slug'=>'required',
        ];
        $customMessages = [
            'address.required' => trans('admin_validation.Address is required'),
            'date.required' => trans('admin_validation.Schedule date is required'),
            'name.required' => trans('admin_validation.Name is required'),
            'phone.required' => trans('admin_validation.Phone is required'),
            'schedule_time_slot.required' => trans('admin_validation.Schedule slot is required'),
            'slug.required' => trans('admin_validation.Slug is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $booking_info = (object) array(
            'ids' => $request->ids,
            'prices' => $request->prices,
            'names' => $request->names,
            'extra_total' => $request->extra_total,
            'total_amount' => $request->total_amount,
            'total' => $request->total,
            'date' => $request->date,
            'schedule_time_slot' => $request->schedule_time_slot,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'order_note' => $request->order_note,
            'slug' => $request->slug,
        );

        $service = Service::where(['status' => 'active', 'approve_by_admin' => 'enable', 'is_banned' => 'disable', 'slug' => $request->slug])->first();

        if(!$service)abort(404);

        if(!$booking_info){
            $notification = trans('admin_validation.Something went wrong, please try again');
            return response()->json([
                'message' => $notification
            ]);
        }

        $user = Auth::guard('api')->user();

        $influencer_id = $service->influencer_id;
        $client_id = $user->id;

        $coupon_discount = 0.00;

        $paypal_setting = PaypalPayment::first();

        $payable_amount = round(($booking_info->total - $coupon_discount) * $paypal_setting->currency->currency_rate,2);

        $booking_info = json_encode($booking_info);
        Session::put('booking_info', $booking_info);

        config(['paypal.mode' => $paypal_setting->account_mode]);

        if($paypal_setting->account_mode == 'sandbox'){
            config(['paypal.sandbox.client_id' => $paypal_setting->client_id]);
            config(['paypal.sandbox.client_secret' => $paypal_setting->secret_id]);
        }else{
            config(['paypal.sandbox.client_id' => $paypal_setting->client_id]);
            config(['paypal.sandbox.client_secret' => $paypal_setting->secret_id]);
            config(['paypal.sandbox.app_id' => 'APP-80W284485P519543T']);
        }

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal-payment-success-webview'),
                "cancel_url" => route('paypal-payment-cancled-webview'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => $paypal_setting->currency->currency_code,
                        "value" => $payable_amount
                    ]
                ]
            ]
        ]);

        Session::put('current_slug', $request->slug);

        if (isset($response['id']) && $response['id'] != null) {
            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }

            $notification = trans('admin_validation.Something went wrong, please try again');
            return response()->json([
                'message' => $notification
            ]);

        } else {
            $notification = trans('admin_validation.Something went wrong, please try again');
            return response()->json([
                'message' => $notification
            ]);
        }
    }


    public function paypalPaymentSuccess(Request $request){

        $paypal_setting = PaypalPayment::first();

        config(['paypal.mode' => $paypal_setting->account_mode]);

        if($paypal_setting->account_mode == 'sandbox'){
            config(['paypal.sandbox.client_id' => $paypal_setting->client_id]);
            config(['paypal.sandbox.client_secret' => $paypal_setting->secret_id]);
        }else{
            config(['paypal.sandbox.client_id' => $paypal_setting->client_id]);
            config(['paypal.sandbox.client_secret' => $paypal_setting->secret_id]);
            config(['paypal.sandbox.app_id' => 'APP-80W284485P519543T']);
        }

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {

            $current_slug = Session::get('current_slug');

            $service = Service::where(['status' => 'active', 'approve_by_admin' => 'enable', 'is_banned' => 'disable', 'slug' => $current_slug])->first();

            $booking_info = Session::get('booking_info');
            $booking_info = json_decode($booking_info);

            $user = Auth::guard('web')->user();

            $influencer_id = $service->influencer_id;
            $client_id = $user->id;

            $order = $this->create_order($user, $service, $booking_info, $influencer_id, $client_id, 'Paypal', 'success', $request->PayerID);

            $notification = trans('admin_validation.Your order has been placed. Thanks for your new order');
            return response()->json([
                'message' => $notification
            ]);


        } else {
            $current_slug = Session::get('current_slug');

            $notification = trans('admin_validation.Something went wrong, please try again');
            return response()->json([
                'message' => $notification
            ]);
        }

    }

    public function paypalPaymentCancled(Request $request){

        $current_slug = Session::get('current_slug');

        $notification = trans('admin_validation.Something went wrong, please try again');
        return response()->json([
            'message' => $notification
        ]);
    }

    public function create_order($user, $service, $booking_info, $influencer_id, $client_id, $payment_method, $payment_status, $tnx_info){

        $additional_services = array();

        if($booking_info->ids){
            foreach($booking_info->ids as $extra_index => $extra_id){
                $addition = AdditionalService::find($booking_info->ids[$extra_index]);
                if($addition){
                    $single_extra_service = array(
                        'id' => $addition->id,
                        'title' => $addition->title,
                        'price' => $addition->price,
                        'features' => json_decode($addition->features),
                    );
                    $additional_services[] = $single_extra_service;
                }
            }
        }

        $find_schedule = AppointmentSchedule::find($booking_info->schedule_time_slot);
        $time_slot = '';
        if($find_schedule){
            $time_slot = strtoupper(date('h:i A', strtotime($find_schedule->start_time))).' - '.strtoupper(date('h:i A', strtotime($find_schedule->end_time)));
        }

        $coupon_discount = 0.00;
        if(Session::get('coupon_code') && Session::get('offer_percentage')) {

            $coupon = Coupon::where(['coupon_code' => Session::get('coupon_code')])->first();

            if($coupon){
                $history = new CouponHistory();
                $history->user_id = $client_id;
                $history->influencer_id = $coupon->influencer_id;
                $history->coupon_code = $coupon->coupon_code;
                $history->coupon_id = $coupon->id;
                $history->discount_amount = $coupon_discount;
                $history->save();

                $offer_percentage = Session::get('offer_percentage');
                $coupon_discount = ($offer_percentage / 100) * ($booking_info->total);
            }

        }

        try{

            $order = new Order();
            $order->order_id = substr(rand(0,time()),0,10);
            $order->booking_date = $booking_info->date;
            $order->appointment_schedule_id = $booking_info->schedule_time_slot;
            $order->schedule_time_slot = $time_slot;
            $order->client_id = $client_id;
            $order->influencer_id = $influencer_id;
            $order->service_id = $service->id;
            $order->package_amount = $service->price;
            $order->additional_amount = $booking_info->extra_total;
            $order->coupon_discount  = $coupon_discount;
            $order->total_amount = $booking_info->total;
            $order->payment_method = $payment_method;
            $order->transection_id = $tnx_info;
            $order->payment_status = $payment_status;
            $order->order_status = 'awaiting_for_influencer_approval';
            $order->package_features = $service->features;
            $order->additional_services = json_encode($additional_services);
            $order->order_note = $booking_info->order_note;
            $order->client_name = $booking_info->name;
            $order->client_phone = $booking_info->phone;
            $order->client_email = $booking_info->email;
            $order->client_address = $booking_info->address;
            $order->save();

            MailHelper::setMailConfig();

            $setting = Setting::first();

            $template=EmailTemplate::where('id',8)->first();
            $subject=$template->subject;
            $message=$template->description;
            $message = str_replace('{{name}}',$user->name,$message);
            $message = str_replace('{{amount}}',$setting->currency_icon.$order->total_amount,$message);
            $message = str_replace('{{schedule_date}}',$order->booking_date,$message);
            $message = str_replace('{{order_id}}',$order->order_id,$message);
            Mail::to($user->email)->send(new OrderSuccessfully($message,$subject));

        } catch (\Exception $e) {
            \Log::error('Mail send error: ' . $e->getMessage());
        }
        
        try{
            $influencer = User::find($influencer_id);
            
            $template=EmailTemplate::where('id',9)->first();
            $subject=$template->subject;
            $message=$template->description;
            $message = str_replace('{{name}}',$influencer->name,$message);
            $message = str_replace('{{amount}}',$setting->currency_icon.$order->total_amount,$message);
            $message = str_replace('{{schedule_date}}',$order->booking_date,$message);
            $message = str_replace('{{order_id}}',$order->order_id,$message);
            Mail::to($influencer->email)->send(new OrderSuccessfully($message,$subject));
            
            Session::forget('coupon_code');
            Session::forget('offer_percentage');
            Session::forget('booking_info');
            
        } catch (\Exception $e) {
            \Log::error('Mail send error: ' . $e->getMessage());
        }

        return $order;
    }
}
