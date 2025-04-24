<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use App\Models\Order;
use App\Models\Review;
use App\Rules\Captcha;
use App\Models\Setting;
use App\Models\SeoSetting;
use App\Helpers\MailHelper;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Models\MultiCurrency;
use App\Models\ContactMessage;
use Modules\Page\Entities\Faq;
use Modules\Blog\Entities\Blog;
use App\Mail\SendContactMessage;
use App\Models\CustomPagination;
use App\Models\EmailConfiguration;
use Modules\Page\Entities\AboutUs;
use App\Models\AppointmentSchedule;
use Modules\Page\Entities\HomePage;
use App\Http\Controllers\Controller;
use Modules\Page\Entities\ContactUs;
use Modules\Page\Entities\CustomPage;
use Modules\Section\Entities\Partner;
use Modules\Service\Entities\Service;
use Modules\Blog\Entities\BlogComment;
use Modules\Service\Entities\Category;
use Illuminate\Support\Facades\Session;
use Modules\Blog\Entities\BlogCategory;
use Modules\Language\Entities\Language;
use Modules\Section\Entities\SliderOne;
use Modules\Page\Entities\PrivacyPolicy;
use Modules\Section\Entities\OurFeature;

use Modules\Section\Entities\Testimonial;
use Modules\Section\Entities\WhyChooseUs;
use Str, Mail, Hash, Auth,Config;

use Modules\Page\Entities\TermAndCondition;
use Modules\Section\Entities\WorkingProccess;
use Modules\Service\Entities\AdditionalService;

class HomeController extends Controller
{
    public function website_setup(Request $request){
        $setting = Setting::first();
        $language_list = Language::where('status', 1)->get();
        $currency_list = MultiCurrency::where('status', 'active')->get();


        if($request->lang_code){
            $lang_code = $request->lang_code;
        }else{
            $default_lang = Language::where('id', 1)->first();
            if($default_lang){
                $lang_code = $default_lang->lang_code;
            }else{
                $lang_code = 'en';
            }
        }

        Session::put('front_lang', $lang_code);
        config(['app.locale' => $lang_code]);

        try{
            $localizations = include(lang_path($lang_code.'/admin.php'));
        }catch(Exception $ex){
            return response()->json([
                'message' => trans('Fetch to faild localization'),
            ],403);
        }

        $home_page = HomePage::first();

        $footer_cta = (object) array(
            'title' => $home_page->provider_joining_title,
            'image' => $home_page->provider_joining_image,
        );

        $breadcrumb = $setting->breadcrumb_image;

        return response()->json([
            'setting' => $setting,
            'breadcrumb' => $breadcrumb,
            'language_list' => $language_list,
            'currency_list' => $currency_list,
            'footer_cta' => $footer_cta,
            'localizations' => $localizations,
        ]);
    }


    public function index(Request $request){
        $slider = SliderOne::first();
        $our_feature = OurFeature::first();
        $working_proccess = WorkingProccess::first();
        $partners = Partner::all();
        $blogs = Blog::with('author')->where('show_homepage', 'yes')->orderBy('id','desc')->get();
        $featured_services = Service::with('category','influencer')->where(['status' => 'active', 'approve_by_admin' => 'enable', 'is_banned' => 'disable'])->orderBy('id','desc')->get()->take(8);
        $categories = Category::where('status', 'active')->get();
        $why_choose_us = WhyChooseUs::first();
        $testimonials = Testimonial::orderBy('id','desc')->get();
        $faqs = Faq::orderBy('id','desc')->get();
        $influencers = User::where(['status' => 'enable' , 'is_banned' => 'no', 'is_influencer' => 'yes'])->where('email_verified_at', '!=', null)->orderBy('id','desc')->select('id','name','username','designation','total_follower','total_following','image','status','is_banned','is_influencer')->get()->take(8);

        $home_page = HomePage::first();

        $video_section = (object) array(
            'video_title' => $home_page->video_title,
            'video_description' => $home_page->video_description,
            'video_image' => $home_page->video_image,
            'video_id' => $home_page->video_id,
        );

        $social_media_section = (object) array(
            'facebook_image' => $home_page->facebook_image,
            'facebook_follower' => $home_page->facebook_follower,
            'twitter_image' => $home_page->twitter_image,
            'twitter_follower' => $home_page->twitter_follower,
            'tiktok_image' => $home_page->tiktok_image,
            'tiktok_follower' => $home_page->tiktok_follower,
            'instagram_image' => $home_page->instagram_image,
            'instagram_follower' => $home_page->instagram_follower,
        );

        $funcfact = (object) array(
            'title' => $home_page->partner_title,
            'description' => $home_page->partner_description,
        );

        $faq_section = (object) array(
            'title' => $home_page->faq_title,
            'description' => $home_page->faq_description,
            'image' => $home_page->faq_image,
        );

        return response()->json([
            'slider' => $slider,
            'our_feature' => $our_feature,
            'working_proccess' => $working_proccess,
            'video_section' => $video_section,
            'social_media_section' => $social_media_section,
            'funcfact' => $funcfact,
            'partners' => $partners,
            'blogs' => $blogs,
            'featured_services' => $featured_services,
            'categories' => $categories,
            'why_choose_us' => $why_choose_us,
            'testimonials' => $testimonials,
            'faq_section' => $faq_section,
            'faqs' => $faqs,
            'influencers' => $influencers,
        ]);

    }

    public function about_us(Request $request){

        $our_feature = OurFeature::first();
        $about_us = AboutUs::first();
        $working_proccess = WorkingProccess::first();
        $partners = Partner::all();
        $testimonials = Testimonial::where('status', 'enable')->orderBy('id','desc')->get();

        $home_page = HomePage::first();

        $funcfact = (object) array(
            'title' => $home_page->partner_title,
            'description' => $home_page->partner_description,
        );


        $social_media_section = (object) array(
            'facebook_image' => $home_page->facebook_image,
            'facebook_follower' => $home_page->facebook_follower,
            'twitter_image' => $home_page->twitter_image,
            'twitter_follower' => $home_page->twitter_follower,
            'tiktok_image' => $home_page->tiktok_image,
            'tiktok_follower' => $home_page->tiktok_follower,
            'instagram_image' => $home_page->instagram_image,
            'instagram_follower' => $home_page->instagram_follower,
        );

        return response()->json([
            'our_feature' => $our_feature,
            'about_us' => $about_us,
            'working_proccess' => $working_proccess,
            'funcfact' => $funcfact,
            'social_media_section' => $social_media_section,
            'partners' => $partners,
            'testimonials' => $testimonials,
        ]);
    }

    public function contact_us(){
        $contact_us = ContactUs::first();

        return response()->json([
            'contact_us' => $contact_us,
        ]);
    }

    public function store_contact_message(Request $request){
        $rules = [
            'name'=>'required',
            'email'=>'required',
            'subject'=>'required',
            'message'=>'required',
            'g-recaptcha-response'=>new Captcha()
        ];
        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
            'email.required' => trans('admin_validation.Email is required'),
            'subject.required' => trans('admin_validation.Subject is required'),
            'message.required' => trans('admin_validation.Message is required')
        ];
        $this->validate($request, $rules,$customMessages);

        $setting = Setting::first();

        if( $setting->save_contact_message == 'enable'){
            $contact_message = new ContactMessage();
            $contact_message->name = $request->name;
            $contact_message->email = $request->email;
            $contact_message->phone = $request->phone;
            $contact_message->subject = $request->subject;
            $contact_message->message = $request->message;
            $contact_message->save();
        }

        if($setting->send_contact_message == 'enable'){
            try{
                MailHelper::setMailConfig();

                $template = EmailTemplate::find(2);
                $message = $template->description;
                $subject = $template->subject;
                $message = str_replace('{{name}}',$request->name,$message);
                $message = str_replace('{{email}}',$request->email,$message);
                $message = str_replace('{{phone}}',$request->phone,$message);
                $message = str_replace('{{subject}}',$request->subject,$message);
                $message = str_replace('{{message}}',$request->message,$message);

                Mail::to($setting->contact_message_mail)->send(new SendContactMessage($message,$subject, $request->email, $request->name));

            } catch (\Exception $e) {
                \Log::error('Mail send error: ' . $e->getMessage());
            }

        }

        $notification= trans('admin_validation.Your message has send successfully');
        return response()->json([
            'message' => $notification
        ]);
    }


    public function blogs(Request $request){

        $paginate_info = CustomPagination::where('id', 1)->first();

        $blogs = Blog::with('author')->orderBy('id','desc')->where('status', 1);

        if($request->category){
            $blog_category = BlogCategory::where('slug', $request->category)->first();
            $blogs = $blogs->where('blog_category_id', $blog_category->id);
        }

        if($request->search){
            $blogs = $blogs->whereHas('translations', function ($query) use ($request) {
                            $query->where('title', 'like', '%' . $request->search . '%')
                                ->orWhere('description', 'like', '%' . $request->search . '%');
                        })
                        ->orWhere(function ($query) use ($request) {
                            $query->whereJsonContains('tags', ['value' => $request->search]);
                        });
        }

        $blogs = $blogs->paginate($paginate_info->qty);

        $popular_blogs = Blog::where('is_popular', 'yes')->where('status', 1)->orderBy('id','desc')->get();

        $categories = BlogCategory::where('status', 1)->get();

        return response()->json([
            'blogs' => $blogs,
            'popular_blogs' => $popular_blogs,
            'categories' => $categories,
        ]);
    }

    public function blog_show(Request $request, $slug){
        $blog = Blog::where('status', 1)->where(['slug' => $slug])->first();

        if(!$blog){
            return response()->json(['message' => trans('Blog not found')], 404);
        }

        $blog_comments = BlogComment::orderBy('id','desc')->where('blog_id', $blog->id)->where('status', 1)->get();

        $popular_blogs = Blog::where('is_popular', 'yes')->where('status', 1)->orderBy('id','desc')->get();

        $categories = BlogCategory::where('status', 1)->get();

        $author = $blog->author;

        return response()->json([
            'author' => $author,
            'blog' => $blog,
            'blog_comments' => $blog_comments,
            'popular_blogs' => $popular_blogs,
            'categories' => $categories,
        ]);
    }

    public function store_comment(Request $request){
        $rules = [
            'blog_id'=>'required',
            'name'=>'required',
            'email'=>'required',
            'comment'=>'required',
        ];
        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
            'email.required' => trans('admin_validation.Email is required'),
            'comment.required' => trans('admin_validation.Comment is required')
        ];
        $this->validate($request, $rules,$customMessages);

        $blog_comment = new BlogComment();
        $blog_comment->blog_id = $request->blog_id;
        $blog_comment->name = $request->name;
        $blog_comment->email = $request->email;
        $blog_comment->comment = $request->comment;
        $blog_comment->save();

        $notification= trans('admin_validation.Blog comment has submited');
        return response()->json([
            'message' => $notification
        ]);
    }

    public function faq(){
        $faqs = Faq::get();
        $testimonials = Testimonial::where('status', 'enable')->orderBy('id','desc')->get();

        return response()->json([
            'faqs' => $faqs,
            'testimonials' => $testimonials,
        ]);
    }

    public function terms_conditions(){
        $terms_conditions = TermAndCondition::where('lang_code', Session::get('front_lang'))->first();

        return response()->json([
            'terms_conditions' => $terms_conditions,
        ]);
    }

    public function privacy_policy(){
        $privacy_policy = PrivacyPolicy::where('lang_code', Session::get('front_lang'))->first();

        return response()->json([
            'privacy_policy' => $privacy_policy,
        ]);
    }

    public function services(Request $request){

        $seo_setting = SeoSetting::where('id', 8)->first();
        $paginate_info = CustomPagination::where('id', 2)->first();
        $services = Service::with('category','influencer')->where(['status' => 'active', 'approve_by_admin' => 'enable', 'is_banned' => 'disable']);

        if($request->categories){
            $filter_category = array();

            foreach($request->categories as $req_category){
                $find_cat = Category::where('slug', $req_category)->first();
                if($find_cat){
                    $filter_category[] = $find_cat->id;
                }
            }

            $services = $services->whereIn('category_id', $filter_category);
        }

        if($request->min_amount && $request->max_amount){
            $services = $services->where('price', '>=', $request->min_amount)->where('price', '<=', $request->max_amount);
        }

        if($request->search){
            $services = $services->whereHas('translations', function ($query) use ($request) {
                            $query->where('title', 'like', '%' . $request->search . '%')
                                ->orWhere('description', 'like', '%' . $request->search . '%');
                        })
                        ->orWhere(function ($query) use ($request) {
                            $query->whereJsonContains('tags', ['value' => $request->search]);
                        });
        }

        $services = $services->orderBy('id','desc')->paginate($paginate_info->qty);
        $categories = Category::where('status', 'active')->get();
        $max_amount = Service::orderBy('price', 'desc')->first();

        $max_amount = $max_amount ? $max_amount->price : 0;
        $req_max_amount = $request->max_amount ? $request->max_amount : $max_amount;
        $req_min_amount =  $request->min_amount ? $request->min_amount : 0;

        return response()->json([
            'services' => $services,
            'categories' => $categories,
            'max_amount' => $max_amount,
            'req_max_amount' => $req_max_amount,
            'req_min_amount' => $req_min_amount,
        ]);
    }

    public function service_show($slug){
        $service = Service::with('category','influencer')->where(['status' => 'active', 'approve_by_admin' => 'enable', 'is_banned' => 'disable', 'slug' => $slug])->first();

        if(!$service)abort(404);

        $related_services = Service::with('category','influencer')->where(['status' => 'active', 'approve_by_admin' => 'enable', 'is_banned' => 'disable', 'category_id' => $service->category_id])->where('id' , '!=', $service->id)->get()->take(10);
        $service_author = User::where('id', $service->influencer_id)->first();

        if(!$service_author)abort(404);

        $days = array(
            'Sunday',
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday'
        );


        $schedule_list = array();

        foreach($days as $day_item){
            $schedule_item = AppointmentSchedule::where('user_id', $service->influencer_id)->where('day', $day_item)->orderBy('start_time','asc')->first();

            if($schedule_item){
                $start_time = strtoupper(date('h:i A', strtotime($schedule_item->start_time)));

                $schedule_item = AppointmentSchedule::where('user_id', $service->influencer_id)->where('day', $day_item)->orderBy('end_time','desc')->first();
                $end_time = strtoupper(date('h:i A', strtotime($schedule_item->end_time)));

                $schedule = array(
                    'day' => $day_item,
                    'start_time' => $start_time,
                    'end_time' => $end_time
                );

                $schedule_list[] = $schedule;
            }
        }

        $reviews = Review::with('user')->orderBy('id','desc')->where('status', 1)->where('service_id', $service->id)->paginate(10);

        return response()->json([
            'service' => $service,
            'service_author' => $service_author,
            'schedule_list' => $schedule_list,
            'related_services' => $related_services,
            'reviews' => $reviews,

        ]);

    }

    public function influencers(Request $request){
        $paginate_info = CustomPagination::where('id', 3)->first();
        $influencers = User::where(['status' => 'enable' , 'is_banned' => 'no', 'is_influencer' => 'yes'])->where('email_verified_at', '!=', null)->orderBy('id','desc')->select('id','name','username','designation','total_follower','total_following','image','status','is_banned','is_influencer')->paginate($paginate_info->qty);

        return response()->json([
            'influencers' => $influencers,

        ]);

    }

    public function influencer(Request $request, $username){

        $influencer = User::where(['status' => 'enable' , 'is_banned' => 'no', 'is_influencer' => 'yes'])->where('email_verified_at', '!=', null)->orderBy('id','desc')->select('id','name','username','designation','total_follower','total_following','image','status','is_banned','is_influencer','tags','created_at','about_me','varsity_name','varsity_year','school_name','school_year','phone','email','address','facebook','tiktok','twitter','instagram')->where('username', $username)->first();

        if(!$influencer){
            return response()->json(['message' => trans('Influencer Not found')], 404);
        }

        $services = Service::with('category','influencer')->where(['status' => 'active', 'approve_by_admin' => 'enable', 'is_banned' => 'disable'])->where('influencer_id', $influencer->id)->orderBy('id','desc')->get();
        $total_review = Review::where('status', 1)->where('influencer_id', $influencer->id)->count();

        $avg_rating = Review::where('status', 1)->where('influencer_id', $influencer->id)->avg('rating');

        $avg_rating = sprintf('%.2f', $avg_rating);

        $total_pending = Order::where('order_status','awaiting_for_influencer_approval')->where('influencer_id', $influencer->id)->count();
        $active_booking = Order::where('order_status','approved_by_influencer')->where('influencer_id', $influencer->id)->count();
        $complete_booking = Order::where('order_status','complete')->where('influencer_id', $influencer->id)->count();
        $cancel_booking = Order::where('influencer_id', $influencer->id)->where('order_status','order_decliened_by_influencer')->orWhere('order_status', 'order_decliened_by_client')->count();

        return response()->json([
            'influencer' => $influencer,
            'services' => $services,
            'total_review' => $total_review,
            'avg_rating' => $avg_rating,
            'active_booking' => $active_booking,
            'total_pending' => $total_pending,
            'cancel_booking' => $cancel_booking,
            'complete_booking' => $complete_booking,

        ]);
    }


    public function language_switcher(Request $request){

        $request_lang = Language::where('lang_code', $request->lang_code)->first();

        Session::put('front_lang', $request->lang_code);
        Session::put('lang_dir', $request_lang->lang_direction);

        app()->setLocale($request->lang_code);

        $notification= trans('admin_validation.Language switched successfully');
        return response()->json([
            'message' => $notification
        ]);
    }

    public function currency_switcher(Request $request){

        $request_currency = MultiCurrency::where('currency_code', $request->currency_code)->first();

        Session::put('currency_icon', $request_currency->currency_icon);
        Session::put('currency_code', $request_currency->currency_code);
        Session::put('currency_rate', $request_currency->currency_rate);
        Session::put('currency_position', $request_currency->currency_position);

        $notification= trans('admin_validation.Currency switched successfully');
        return response()->json([
            'message' => $notification
        ]);

    }
}
