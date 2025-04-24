@extends('layout')
@section('title')
    <title>{{ $service->seo_title }}</title>
    @php
        $tags = '';
        if($service->tags){
            foreach (json_decode($service->tags) as $service_tag) {
                $tags .= $service_tag->value.', ';
            }
        }
    @endphp

    <meta name="keywords" content="{{ $tags }}">
    <meta name="title" content="{{ $service->seo_title }}">
    <meta name="description" content="{{ $service->seo_description }}">
@endsection
@section('frontend-content')

    <!-- Breadcrumbs -->
    <section class="inflanar-breadcrumb" style="background-image: url({{ asset($breadcrumb) }});">
        <div class="container">
            <div class="row">
                <!-- Breadcrumb-Content -->
                <div class="col-12">
                    <div class="inflanar-breadcrumb__inner">
                        <div class="inflanar-breadcrumb__content">
                            <h2 class="inflanar-breadcrumb__title m-0">{{__('admin.Services')}}</h2>
                            <ul class="inflanar-breadcrumb__menu list-none">
                                <li><a href="{{ route('home') }}">{{__('admin.Home')}}</a></li>
                                <li class="active"><a href="javascript:;">{{__('admin.Services')}}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End breadcrumbs -->


    <!-- Features -->
    <section class="pd-top-90 pd-btm-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-12 mg-top-30">
                    <div class="inflanar-sdetail">
                        <!-- Service Thumb -->
                        <div class="inflanar-sdetail__thumb">
                            <img src="{{ $service->thumbnail_image ? asset($service->thumbnail_image) : asset($setting->default_placeholder) }}" alt="#">
                        </div>
                        <!-- Service Content -->
                        <div class="inflanar-sdetail__content">
                            <h2 class="inflanar-sdetail__title">{{ $service->title }}</h2>
                            <!--Tab Nav -->
                            <div class="list-group inflanar-sdetail__tabnav" id="list-tab" role="tablist">
                                <a class="list-group-item active" data-bs-toggle="list" href="#in-tab3" role="tab">
                                    <span>
                                        <svg width="28" height="24" viewBox="0 0 28 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M14.0104 0C13.7983 0.0681296 13.5873 0.118956 13.3894 0.203307C9.21856 1.97035 5.04988 3.74388 0.877923 5.5066C0.364081 5.72397 0.00220467 6.03974 0.0131375 6.62155C0.022977 7.18172 0.397973 7.48236 0.88011 7.68567C5.05535 9.44406 9.22512 11.2133 13.4113 12.9435C13.7524 13.0841 14.2564 13.0776 14.5997 12.936C18.7695 11.2111 22.9228 9.4473 27.0817 7.69864C27.5835 7.48777 27.9782 7.18821 27.9814 6.60208C27.9836 6.0192 27.6086 5.71423 27.0981 5.49903C22.9414 3.7428 18.7902 1.97684 14.6358 0.217366C14.4379 0.133015 14.228 0.0746181 14.0104 0ZM24.05 6.57072C23.9024 6.65507 23.8445 6.69725 23.7789 6.72428C20.6215 8.05659 17.4663 9.39323 14.3023 10.7072C14.1055 10.7893 13.806 10.7547 13.5993 10.6682C10.6529 9.4419 7.7142 8.19718 4.77437 6.95679C4.51089 6.8454 4.25179 6.72753 3.91943 6.58154C7.25612 5.16487 10.5086 3.78173 13.7666 2.40941C13.8967 2.35426 14.0913 2.35317 14.2214 2.40725C17.4783 3.77957 20.7319 5.16271 24.05 6.57072Z"/>
                                            <path d="M-0.000171019 17.4422C0.0523064 18.0391 0.379195 18.3419 0.875544 18.5506C3.6492 19.7175 6.41629 20.9017 9.18666 22.0772C10.5882 22.6719 11.9953 23.257 13.3925 23.8626C13.8058 24.0421 14.1819 24.0454 14.5962 23.868C18.7824 22.0826 22.9729 20.309 27.1602 18.5269C27.8927 18.2154 28.1682 17.6314 27.8916 17.0312C27.6139 16.4257 27.017 16.2375 26.2812 16.5479C22.3399 18.2132 18.3997 19.8808 14.4639 21.5624C14.1381 21.7019 13.8779 21.7084 13.5478 21.5678C9.63053 19.8916 5.70675 18.2316 1.78297 16.5695C0.963007 16.2223 0.320159 16.4321 0.0741712 17.1199C0.0326266 17.2367 0.0173215 17.3632 -0.000171019 17.4422Z"/>
                                            <path d="M13.9749 18.5745C14.2132 18.5031 14.445 18.4566 14.6582 18.3669C18.8006 16.6225 22.9408 14.875 27.0811 13.1252C27.924 12.7694 28.2159 12.1119 27.8278 11.476C27.5173 10.9678 26.9597 10.8207 26.2994 11.0975C23.8931 12.1076 21.489 13.123 19.0848 14.1385C17.5324 14.7938 15.9854 15.4643 14.4209 16.0916C14.1716 16.191 13.8087 16.19 13.5605 16.0872C9.69575 14.4781 5.84085 12.8451 1.98376 11.2176C1.85037 11.1613 1.71699 11.104 1.58033 11.0543C0.9189 10.811 0.346021 11.0359 0.0923798 11.6361C-0.143769 12.1952 0.0912869 12.7683 0.726483 13.0452C2.1718 13.6735 3.63024 14.2758 5.08321 14.8879C7.82187 16.0429 10.5605 17.1978 13.3014 18.3485C13.5157 18.4372 13.742 18.4966 13.9749 18.5745Z"/>
                                        </svg>
                                        {{__('admin.Description')}}
                                    </span>
                                </a>
                                <a class="list-group-item" data-bs-toggle="list" href="#in-tab4" role="tab">
                                    <span>
                                        <svg width="24" height="23" viewBox="0 0 24 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12.4855 0C18.9225 0.0414624 24.1416 5.26302 23.9971 11.7699C23.8579 18.0452 18.6939 23.136 12.2118 22.9972C5.88232 22.8611 0.768882 17.654 0.961314 11.1498C1.14471 4.91871 6.23466 0.0405611 12.4855 0ZM22.2065 11.486C22.3031 6.32572 17.9152 1.7919 12.4991 1.77748C7.1417 1.76305 2.65435 6.22838 2.7474 11.5229C2.65164 16.6949 7.11822 21.4649 12.9318 21.2225C17.9928 21.0115 22.3067 16.6886 22.2074 11.486H22.2065Z"/>
                                            <path d="M11.5764 8.8549C11.5764 7.9905 11.5728 7.12519 11.5782 6.26079C11.58 5.90295 11.739 5.62714 12.0597 5.45678C12.3669 5.29454 12.6731 5.29904 12.9659 5.49013C13.2486 5.67491 13.3769 5.94892 13.3769 6.28152C13.3778 7.8616 13.3778 9.44078 13.376 11.0209C13.376 11.1074 13.4004 11.1624 13.4718 11.2156C14.4719 11.961 15.4693 12.7118 16.4694 13.4581C16.7269 13.6501 16.9211 13.8782 16.9337 14.2135C16.9473 14.5677 16.7874 14.8372 16.4847 15.0112C16.1884 15.1806 15.8767 15.1851 15.5903 14.9931C15.2543 14.7687 14.9299 14.5262 14.6056 14.2838C13.7509 13.6438 12.9035 12.993 12.0444 12.3594C11.7146 12.116 11.5764 11.8005 11.5764 11.4048C11.5782 10.5549 11.5764 9.70488 11.5764 8.8558V8.8549Z"/>
                                        </svg>
                                        {{__('admin.Availability')}}
                                    </span>
                                </a>
                                <a class="list-group-item" data-bs-toggle="list" href="#in-tab5" role="tab">
                                    <span>
                                        <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M4.04182 14.0393C3.89749 14.0393 3.75684 13.9925 3.62446 13.9007C3.26501 13.6512 3.21629 13.2364 3.49851 12.8199C4.20637 11.7739 5.04662 10.9362 5.99625 10.3297C6.47429 10.0251 6.96612 9.7608 7.48736 9.48095L7.49747 9.47545C7.7273 9.3525 7.95896 9.22771 8.19063 9.09925L8.4131 8.97539L8.22464 8.80381C6.88614 7.57889 6.31985 6.06586 6.54324 4.3051C6.69676 3.0912 7.25937 2.05804 8.21453 1.23409C9.13751 0.438585 10.3069 0 11.5084 0C12.8349 0 14.0916 0.519328 15.0459 1.46164C15.9937 2.39753 16.5434 3.77935 16.5158 5.15658C16.4965 6.12917 16.1849 7.55136 14.8151 8.7983L14.6377 8.96071L14.8409 9.08916C15.1212 9.26625 15.4108 9.43966 15.6894 9.60665C16.3439 9.99844 17.0205 10.404 17.6227 10.8793C18.223 11.3537 18.7323 11.9794 19.225 12.5841L19.396 12.7933C19.5578 12.9915 19.6286 13.2025 19.5992 13.4025C19.5716 13.5915 19.4585 13.7585 19.2728 13.8851C19.1331 13.9797 18.9924 14.0283 18.8554 14.0283C18.5539 14.0283 18.3241 13.7971 18.1844 13.6025C16.6133 11.4142 14.4952 10.2398 11.889 10.1131C11.7299 10.1058 11.5709 10.1012 11.4165 10.1012C8.78725 10.1012 6.59932 11.1995 4.91332 13.3649C4.86919 13.4218 4.82782 13.4805 4.78645 13.5392C4.7552 13.5842 4.72578 13.6246 4.69636 13.6649C4.5171 13.9063 4.28451 14.0393 4.04182 14.0393ZM11.4909 1.45706C9.57234 1.45706 7.99114 3.03247 7.9654 4.9694C7.95253 5.91172 8.31014 6.7999 8.97019 7.47062C9.63301 8.14409 10.522 8.51662 11.4716 8.5212H11.4863C13.4536 8.5212 15.0128 6.98891 15.0367 5.0318C15.0477 4.0959 14.6873 3.20681 14.0218 2.52783C13.3562 1.84885 12.4718 1.46898 11.5314 1.45797L11.4909 1.45706Z"/>
                                            <path d="M4.04415 13.9476C3.91912 13.9476 3.79594 13.9063 3.67918 13.8256C3.36111 13.6044 3.3225 13.2475 3.57714 12.8713C4.27765 11.8354 5.1087 11.0059 6.04822 10.4068C6.52166 10.1049 7.01349 9.84067 7.53381 9.56174C7.76732 9.43603 8.00266 9.31033 8.23892 9.17912L8.57354 8.99378L8.29132 8.73595C6.97396 7.53214 6.41778 6.04572 6.63658 4.31707C6.78734 3.12702 7.33984 2.11314 8.27753 1.30387C9.18304 0.522124 10.3312 0.0917969 11.5107 0.0917969C12.8134 0.0917969 14.0461 0.601032 14.9838 1.52683C15.9142 2.44621 16.4538 3.80141 16.4262 5.15387C16.4069 6.10903 16.1017 7.50461 14.7558 8.72953L14.4892 8.97268L14.7945 9.16536C15.0739 9.34153 15.3644 9.51586 15.6448 9.68469C16.2966 10.0756 16.9704 10.4793 17.568 10.9509C18.16 11.4188 18.6666 12.04 19.1565 12.6419L19.3275 12.8511C19.4728 13.0291 19.5362 13.2154 19.5114 13.3897C19.4875 13.553 19.3882 13.698 19.2246 13.81C19.1005 13.8944 18.9773 13.9366 18.8587 13.9366C18.5958 13.9366 18.3898 13.7255 18.263 13.5494C16.6744 11.3372 14.5334 10.1499 11.8977 10.0214C11.7378 10.0141 11.5778 10.0095 11.4215 10.0095C8.762 10.0095 6.54924 11.1197 4.84578 13.309C4.80073 13.3668 4.75844 13.4273 4.71616 13.487C4.68674 13.5283 4.65824 13.5696 4.6279 13.6099C4.46335 13.8283 4.25651 13.9476 4.04415 13.9476ZM11.4932 1.36534C9.52502 1.36534 7.90154 2.98113 7.87488 4.96761C7.86201 5.9347 8.22789 6.84582 8.90633 7.53397C9.58661 8.22488 10.4986 8.6075 11.473 8.61117H11.4877C13.5056 8.61117 15.1052 7.0385 15.13 5.03092C15.142 4.07117 14.7715 3.15822 14.0884 2.46181C13.4054 1.76539 12.498 1.37635 11.5337 1.36443L11.4932 1.36534Z"/>
                                            <path d="M1.54633 23C1.51139 23 1.4737 22.9927 1.43049 22.9395C1.345 22.8349 1.2972 22.5936 1.32937 22.4339C1.38729 22.1467 1.49301 21.8669 1.60424 21.5705C1.65297 21.4393 1.70445 21.3044 1.75041 21.1686C1.77799 21.087 1.80097 21.008 1.82947 20.908C1.84418 20.8576 1.85981 20.8016 1.87911 20.7374L1.91864 20.6025L1.83223 20.4915C1.80281 20.4538 1.77431 20.4116 1.7449 20.3676C1.66032 20.2437 1.56471 20.1024 1.42498 19.9905C1.13356 19.7584 0.825594 19.5436 0.52774 19.3363C0.438568 19.2739 0.348477 19.2115 0.259304 19.1482C-0.0339527 18.9417 -0.0192439 18.8133 0.023044 18.6894C0.0690091 18.5555 0.153585 18.4316 0.455116 18.4316H0.479937C0.54153 18.4334 0.603123 18.4334 0.664716 18.4334C0.781468 18.4334 0.898219 18.4316 1.01497 18.4298C1.12896 18.4279 1.24204 18.4261 1.35603 18.4261C1.52794 18.4261 1.66767 18.4307 1.79638 18.4408C1.8405 18.4444 1.88279 18.4463 1.92416 18.4463C2.45 18.4463 2.79014 18.1627 2.93447 17.6049C2.99606 17.3682 3.07329 17.1369 3.15602 16.8929C3.20567 16.7461 3.25715 16.5938 3.30403 16.4405C3.39596 16.1423 3.50352 16.1194 3.6359 16.1194C3.79861 16.1212 3.88779 16.1726 3.97696 16.4589C4.03396 16.6415 4.09647 16.8241 4.15714 17.0011C4.24172 17.248 4.32905 17.503 4.39892 17.7544C4.52486 18.2077 4.83099 18.438 5.30811 18.438H5.34212C5.48002 18.4353 5.61699 18.4343 5.75489 18.4343C5.8698 18.4343 5.98471 18.4353 6.10054 18.4353C6.21638 18.4362 6.33313 18.4362 6.44896 18.4362C6.57031 18.4362 6.69074 18.4353 6.81208 18.4334H6.82955C7.12924 18.4334 7.21198 18.5619 7.25703 18.7013C7.29196 18.8105 7.30759 18.9427 7.04007 19.1335C6.91045 19.2262 6.78083 19.3189 6.65213 19.4115C6.39656 19.595 6.14191 19.7776 5.88451 19.9575C5.45519 20.2575 5.32925 20.6713 5.51863 21.1549C5.61699 21.4053 5.70341 21.6696 5.78706 21.9256C5.83854 22.0834 5.89094 22.2421 5.94518 22.399C6.0601 22.7284 6.02608 22.8211 5.89922 22.9147C5.83303 22.9633 5.77235 22.9872 5.7126 22.9872C5.6271 22.9872 5.52139 22.9395 5.39176 22.8422C5.2171 22.711 5.03599 22.5844 4.86133 22.4614C4.66735 22.3256 4.46603 22.1843 4.27757 22.0394C4.06981 21.8797 3.85561 21.799 3.64141 21.799C3.42078 21.799 3.20567 21.8806 2.98595 22.0495C2.77267 22.2128 2.54653 22.3724 2.32773 22.5257C2.16594 22.6394 1.99954 22.7569 1.83683 22.8771C1.72927 22.956 1.62355 23 1.54633 23Z"/>
                                            <path d="M17.2902 22.9872C17.2268 22.9872 17.1624 22.9606 17.0926 22.9064C16.9795 22.8193 16.9445 22.7238 17.0493 22.4211C17.0889 22.3064 17.1275 22.1908 17.1661 22.0751C17.2553 21.8081 17.3472 21.531 17.4529 21.2705C17.6947 20.6786 17.5476 20.2116 17.0172 19.8813C16.7625 19.7226 16.5244 19.5455 16.2707 19.3574C16.1641 19.2776 16.0565 19.1987 15.9489 19.1207C15.6906 18.9344 15.7108 18.7995 15.7495 18.6885C15.7945 18.5619 15.8772 18.4334 16.153 18.4334H16.165C16.3406 18.4362 16.5171 18.4362 16.6927 18.4362C16.8499 18.4362 17.0061 18.4353 17.1624 18.4353L17.4557 18.4343C18.2867 18.4325 18.4099 18.3435 18.6609 17.5719L18.7657 17.2498C18.8337 17.0388 18.9027 16.8277 18.9716 16.6167L18.9928 16.5525C19.104 16.2066 19.1545 16.1194 19.3623 16.1194C19.5747 16.1221 19.6243 16.2056 19.73 16.5332C19.742 16.569 19.753 16.6057 19.7659 16.6415L19.8137 16.78C19.9185 17.0846 20.027 17.3984 20.1079 17.7095C20.2338 18.1949 20.5537 18.4398 21.0584 18.4398C21.0796 18.4398 21.1007 18.4398 21.1228 18.4389C21.2579 18.4334 21.4041 18.4316 21.5824 18.4316C21.6973 18.4316 21.8132 18.4325 21.9281 18.4334C22.0448 18.4343 22.1616 18.4353 22.2783 18.4353C22.3657 18.4353 22.453 18.4343 22.5403 18.4334H22.5578C22.8557 18.4334 22.9375 18.5628 22.9825 18.7023C23.0175 18.8105 23.0312 18.9427 22.7628 19.1344C22.6396 19.2225 22.5183 19.3115 22.396 19.4005C22.1533 19.5776 21.9033 19.7611 21.6514 19.9272C21.1779 20.2401 21.0446 20.6686 21.257 21.2016C21.3544 21.4457 21.439 21.7026 21.5208 21.9522C21.5705 22.1018 21.6192 22.2513 21.6716 22.4C21.7865 22.7257 21.7488 22.8211 21.6229 22.9138C21.5567 22.9624 21.4969 22.9853 21.4381 22.9853C21.3517 22.9853 21.2469 22.9376 21.1154 22.8385C20.7661 22.5752 20.3846 22.3027 19.9488 22.0045C19.844 21.9329 19.7328 21.8852 19.6243 21.8393C19.5783 21.8201 19.5296 21.799 19.48 21.776L19.3596 21.7191L19.24 21.7779C19.195 21.7999 19.149 21.821 19.1031 21.8412C18.9909 21.8916 18.8742 21.9439 18.7629 22.0201C18.3833 22.2798 17.9907 22.5596 17.5963 22.8514C17.4768 22.9422 17.3739 22.9872 17.2902 22.9872Z"/>
                                            <path d="M13.5923 19.7886C13.5251 19.7886 13.4387 19.7537 13.3542 19.6932C13.2273 19.6023 13.1004 19.5115 12.9736 19.4207C12.695 19.2225 12.4073 19.0169 12.1287 18.8114C11.9246 18.6609 11.7141 18.5839 11.5027 18.5839C11.2903 18.5839 11.0789 18.6609 10.8748 18.8133C10.6293 18.9968 10.3747 19.1803 10.1292 19.3564C9.99503 19.4528 9.86173 19.5491 9.72751 19.6464C9.608 19.7335 9.51056 19.7758 9.43058 19.7758C9.39473 19.7758 9.33773 19.7684 9.25591 19.7069C9.12445 19.6088 9.07205 19.5078 9.17134 19.2537C9.28349 18.9665 9.38278 18.672 9.47838 18.3866C9.53262 18.2269 9.58594 18.0673 9.64202 17.9086C9.80841 17.4388 9.67971 17.0396 9.27062 16.7561C9.084 16.6268 8.89646 16.4891 8.71536 16.357C8.50852 16.2056 8.29432 16.0487 8.07645 15.9001C7.96981 15.8276 7.80617 15.6817 7.8981 15.5211C7.96245 15.4092 8.15735 15.2835 8.35224 15.2293C8.41659 15.211 8.49289 15.2027 8.5931 15.2027C8.66848 15.2027 8.74662 15.2073 8.82936 15.2119C8.91669 15.2174 9.00678 15.222 9.09779 15.222C9.16674 15.2211 9.22649 15.2211 9.28349 15.2211C9.36439 15.2211 9.43977 15.2211 9.50872 15.222C9.56847 15.222 9.62455 15.2229 9.67603 15.2229C10.5052 15.2229 10.599 15.022 10.8629 14.1714C10.8913 14.0806 10.9226 13.9806 10.9575 13.8686C10.9805 13.7952 11.0017 13.7209 11.0228 13.6457C11.0734 13.464 11.1212 13.2915 11.2039 13.1612C11.2756 13.0474 11.4218 12.941 11.4751 12.9346C11.5624 12.9382 11.7463 13.0529 11.7822 13.13C11.9614 13.5172 12.0864 13.9494 12.2069 14.3678L12.2501 14.5173C12.3871 14.9871 12.6978 15.2257 13.1731 15.2257C13.1905 15.2257 13.2089 15.2257 13.2273 15.2248C13.3725 15.2192 13.5288 15.2174 13.7191 15.2174C13.8441 15.2174 13.9701 15.2183 14.0951 15.2192C14.222 15.2202 14.3488 15.2211 14.4757 15.2211C14.5318 15.2211 14.6605 15.2202 14.6605 15.2202C15.0043 15.2202 15.0622 15.3248 15.099 15.4505C15.1486 15.6202 15.133 15.7661 14.894 15.9258C14.6274 16.1047 14.3672 16.2964 14.1163 16.4818C13.9765 16.5845 13.8377 16.6873 13.6971 16.7882C13.322 17.0571 13.2043 17.4287 13.356 17.8618C13.3983 17.9829 13.4424 18.1031 13.4865 18.2242C13.6171 18.5793 13.7393 18.9151 13.8175 19.2629C13.8469 19.3931 13.7982 19.6106 13.7154 19.7189C13.6713 19.7803 13.6281 19.7886 13.5923 19.7886Z"/>
                                        </svg>
                                        {{__('admin.Reviews')}} ({{ $service->total_review }})
                                    </span>
                                </a>
                            </div>
                            <!-- Tab Content -->
                            <div class="tab-content mg-top-30" id="nav-tabContent">
                                <!-- Single Tab -->
                                <div class="tab-pane fade active show" id="in-tab3" role="tabpanel">
                                    <div class="inflanar-sdetail__tcontent">
                                        {!! clean($service->description) !!}
                                        <h4 class="inflanar-sdetail__tcontent--title mg-top-40">{{__('admin.Package Features')}}</h4>
                                        <div class="row mg-btm-20">
                                            <div class="col-lg-6 col-12">
                                                <ul class="inflanar-list-style inflanar-list-style__grey  inflanar-list-style__row list-none">
                                                    @if ($service->features)
                                                        @foreach (json_decode($service->features) as $feature)
                                                            @if ($feature)
                                                            <li><img src="{{ asset('frontend/img/in-check-icon2.svg') }}">{{ $feature }}</li>
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- Single Tab -->
                                <div class="tab-pane fade" id="in-tab4" role="tabpanel">
                                    <div class="inflanar-sdetail__tcontent">
                                        <h4 class="inflanar-sdetail__tcontent--title mg-top-40">{{__('admin.Service Availability')}}</h4>
                                        <div class="row mg-btm-20">
                                            <div class="col-lg-6 col-12">
                                                <ul class="inflanar-service__list list-none">
                                                    @foreach ($schedule_list as $schedule)
                                                        <li><span class="inflanar-service__list--day">{{ $schedule['day'] }}</span><span>{{ $schedule['start_time'] }} - {{ $schedule['end_time'] }}</span></li>
                                                    @endforeach

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Single Tab -->
                                <div class="tab-pane fade" id="in-tab5" role="tabpanel">

                                    @foreach ($reviews as $index => $review)
                                        <!-- Single Review -->
                                        <div class="inflanar-testimonial inflanar-testimonial--review inflanar-border mg-top-30">
                                            <!-- Testimonial Text -->
                                            <div class="inflanar-testimonial__bottom">
                                                <!-- Testimonial Author -->
                                                <div class="inflanar-testimonial__author">
                                                    <img src="{{ asset($review->user->image) ? asset($review->user->image) : asset($setting->default_avatar) }}" alt="#">
                                                    <div class="inflanar-testimonial__author--info">
                                                        <h5 class="inflanar-testimonial__author--title">{{ $review->user->name }}</h5>
                                                        <p class="inflanar-testimonial__author--position">{{ $review->created_at->format('d F, Y') }}</p>
                                                    </div>
                                                </div>
                                                <div class="inflanar-rating--main mg-btm-15">
                                                    <!-- Author Rating -->
                                                    <ul class="inflanar-rating list-none">
                                                        @for ($i = 1; $i <= 5 ; $i++)
                                                            @if ($i <= $review->rating)
                                                                <li><i class="fa-solid fa-star"></i></li>
                                                            @else
                                                                <li><i class="fa-regular fa-star"></i></li>
                                                            @endif
                                                        @endfor
                                                    </ul>

                                                </div>
                                            </div>
                                            <p class="inflanar-testimonial__text">{{ html_decode($review->comment) }}</p>

                                        </div>
                                        <!-- Single Review -->
                                    @endforeach


                                    <!-- Pagination -->
                                    <div class="mg-top-40">
                                        {{ $reviews->links('custom_pagination') }}
                                    </div>

                                    <!-- Comments Form -->
                                    <div class="inflanar-comments-form inflanar-comments-form--reviews mg-top-50">
                                        <h2 class="inflanar-comments-form__title m-0">{{__('admin.Write Your Reviews')}}</h2>
                                        <form id="serviceReviewForm">
                                            @csrf
                                        <div class="inflanar-form-input--review">
                                            <ul class="inflanar-rating list-none">
                                                <li><i class="fa-solid fa-star service_rat" data-rating="1" onclick="productReview(1)"></i></li>
                                                <li><i class="fa-solid fa-star service_rat" data-rating="2" onclick="productReview(2)"></i></li>
                                                <li><i class="fa-solid fa-star service_rat" data-rating="3" onclick="productReview(3)"></i></li>
                                                <li><i class="fa-solid fa-star service_rat" data-rating="4" onclick="productReview(4)"></i></li>
                                                <li><i class="fa-solid fa-star service_rat" data-rating="5" onclick="productReview(5)"></i></li>
                                            </ul>
                                        </div>

                                            <div class="row">

                                                <input type="hidden" id="service_id" name="service_id" value="{{ $service->id }}">
                                                <input type="hidden" id="influencer_id" name="influencer_id" value="{{ $service->influencer_id }}">
                                                <input type="hidden" name="rating" value="5" id="service_rating">

                                                <div class="col-12">
                                                    <div class="form-group inflanar-form-input">
                                                        <label>{{__('admin.Review')}}*</label>
                                                        <textarea class="ecom-wc__form-input" name="comment" placeholder="{{__('admin.Write your review')}}"></textarea>
                                                    </div>
                                                </div>

                                                @if($google_recaptcha->status==1)
                                                    <div class="col-12">
                                                        <div class="form-group inflanar-form-input">
                                                            <div class="g-recaptcha" data-sitekey="{{ $google_recaptcha->site_key }}"></div>
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="col-12 mg-top-20">
                                                    <button type="submit" class="inflanar-btn"><span>{{__('admin.Submit Review')}}</span></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- End Comments Form -->
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-3 col-12 mg-top-30">
                    <div class="service-single__sidebar">
                        <!-- Pricing Single -->
                        <div class="inflanar-psingle">
                            <div class="inflanar-psingle__head">
                                <h4 class="inflanar-psingle__title">{{__('admin.My Package')}}</h4>
                                <div class="inflanar-psingle__amount">

                                    <div>
                                        {{ currency($service->price) }}
                                    </div>

                                </div>
                            </div>
                            <div class="inflanar-psingle__body">
                                <ul class="inflanar-psingle__list">
                                    @if ($service->features)
                                        @foreach (json_decode($service->features) as $feature)
                                            @if ($feature)
                                            <li><span class="inflanar-psingle__icon"><img src="{{ asset('frontend/img/in-check-icon2.svg') }}"></span>{{ $feature }}</li>
                                            @endif
                                        @endforeach
                                    @endif
                                </ul>
                                <div class="inflanar-psingle__button">
                                    <a href="{{ route('booking-service', $service->slug) }}" class="inflanar-btn"><span>{{__('admin.Book Now')}}</span></a>
                                </div>
                            </div>
                        </div>
                        <!-- End Pricing Single -->
                    </div>

                    <div class="service-single__sidebar mg-top-30">
                        <!-- Single Influencer-->
                        <div class="inflanar-influencer">
                            <!-- Influencer Head-->
                            <div class="inflanar-influencer__head">
                                <img src="{{ $service_author->image ? asset($service_author->image) : asset($setting->default_avatar) }}" alt="#">
                                <h4 class="inflanar-influencer__title">
                                    <a href="{{ route('influencer', html_decode($service_author->username)) }}">{{ html_decode($service_author->name) }}<span>{{ html_decode($service_author->designation) }}</span></a>
                                </h4>
                            </div>
                            <!-- Influencer Body -->
                            <div class="inflanar-influencer__body">
                                <div class="inflanar-influencer__follower">
                                    <div class="inflanar-influencer__follower--single">
                                        <b>{{ html_decode($service_author->total_follower) }}</b><span>{{__('admin.Followers')}}</span>
                                    </div>
                                    <div class="inflancer-hborder"></div>
                                    <div class="inflanar-influencer__follower--single in-right">
                                        <b>{{ html_decode($service_author->total_following) }}</b><span>{{__('admin.Following')}}</span>
                                    </div>
                                </div>

                                @auth('web')
                                    <a class="inflanar-btn-full  mg-top-20" href="javascript:;" onclick="sendNewMessage('{{ $service_author->name }}','{{ $service_author->id }}', '{{ $service_author->designation }}', '{{ $service_author->image }}', '{{ $service->id }}', '{{ $service->name }}', '{{ $service->image }}')">{{__('admin.Contact Here')}}</a>
                                @else
                                    <a class="inflanar-btn-full  mg-top-20" href="javascript:;" onclick="sendNewMessagePrevLogin()">{{__('admin.Contact Here')}}</a>
                                @endauth

                            </div>
                            <!-- End Influencer Body -->
                        </div>
                        <!-- End Single Influencer-->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Features -->

    @if ($related_services->count() > 0)
        <!-- Related Service -->
        <section class="pd-btm-120">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- Section TItle -->
                        <div class="inflanar-section__head  mg-btm-10">
                            <div class="inflanar-section__slide">
                                <h2 class="inflanar-section__title inflanar-section__title--medium "  data-aos="fade-in" data-aos-delay="400">{{__('admin.Related Services')}}</h2>
                                <div class="inflanar-section__border"></div>
                                <div class="inflanar-controls">
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <!-- Testimonial Slider -->
                        <div class="swiper mySwiper inflanar-slider-related loading">
                            <div class="swiper-wrapper mg-top-30">

                                @foreach ($related_services as $related_service)
                                    <div class="swiper-slide mg-btm-30">
                                        <!-- Single property-->
                                        <div class="inflanar-service">
                                            <!-- Property Head-->
                                            <div class="inflanar-service__head">
                                                <img src="{{ $related_service->thumbnail_image ? asset($related_service->thumbnail_image) : asset($setting->default_placeholder) }}" alt="#">
                                                @auth('web')
                                                    <div class="inflanar-service__wishlist {{ $service->is_wishlist($related_service->id) == true ? 'active' : '' }} add_to_wishlist" data-service_id="{{ $related_service->id }}">
                                                        <a href="javascript:;" ><i class="fas fa-heart"></i></a>
                                                    </div>
                                                @else
                                                    <div class="inflanar-service__wishlist add_to_wishlist" data-service_id="{{ $related_service->id }}">
                                                        <a href="javascript:;" ><i class="fas fa-heart"></i></a>
                                                    </div>
                                                @endauth
                                            </div>
                                            <!-- Property Body-->
                                            <div class="inflanar-service__body">
                                                <div class="inflanar-service__top">
                                                    @if ($related_service->category)
                                                    <a href="{{ route('services', ['categories[]' => $related_service->category->slug]) }}" class="inflanar-service__cat"><img src="{{ asset('frontend/img/in-cat-label.svg') }}">{{ $related_service->category->name }}</a>
                                                    @endif

                                                    <div class="inflanar-service__price">
                                                        {{ currency($related_service->price) }}
                                                    </div>
                                                </div>
                                                <h3 class="inflanar-service__title"><a href="{{ route('service', $related_service->slug) }}">{{ $related_service->title }}</a></h3>
                                                <div class="inflanar-service__author">
                                                    <div class="inflanar-service__author--info">
                                                        @if ($related_service->influencer)
                                                            <a href="{{ route('influencer', $related_service->influencer->username) }}"><img src="{{ $related_service->influencer->image ? asset($related_service->influencer->image) : asset($setting->default_avatar) }}">{{ $related_service->influencer->name }}</a>
                                                        @endif

                                                    </div>

                                                    <div class="inflanar-service__author--rating">
                                                        @php
                                                            if ($related_service->total_review > 0) {
                                                                $average = $related_service->average_rating;

                                                                $int_average = intval($average);

                                                                $next_value = $int_average + 1;
                                                                $review_point = $int_average;
                                                                $half_review=false;
                                                                if($int_average < $average && $average < $next_value){
                                                                    $review_point= $int_average + 0.5;
                                                                    $half_review=true;
                                                                }
                                                            }
                                                        @endphp
                                                        <div class="inflanar-service__author--star">
                                                            @if ($related_service->total_review > 0)
                                                                @for ($i = 1; $i <=5; $i++)
                                                                    @if ($i <= $review_point)
                                                                    <span><i class="fa-solid fa-star"></i></span>
                                                                    @elseif ($i> $review_point )
                                                                        @if ($half_review==true)
                                                                        <span><i class="fa-solid fa-star-half-stroke"></i></span>
                                                                            @php
                                                                                $half_review=false
                                                                            @endphp
                                                                        @else
                                                                        <span><i class="fa-regular fa-star"></i></span>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            @else
                                                                <span><i class="fa-regular fa-star"></i></span>
                                                                <span><i class="fa-regular fa-star"></i></span>
                                                                <span><i class="fa-regular fa-star"></i></span>
                                                                <span><i class="fa-regular fa-star"></i></span>
                                                                <span><i class="fa-regular fa-star"></i></span>
                                                            @endif

                                                        </div>
                                                        <div class="inflanar-service__author--label">({{ $related_service->total_review }})</div>
                                                    </div>

                                                </div>
                                                <a class="inflanar-btn-full inflanar-btn-full--v2 mg-top-20" href="{{ route('booking-service', $related_service->slug) }}">{{__('admin.Book Now')}}</a>
                                            </div>
                                        </div>
                                        <!-- End Single property-->
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        <!-- End Testimonial Slider -->
                        <!-- Slider Pagination -->
                        <div class="swiper-pagination swiper-pagination__service--related mg-top-10"></div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Related Service -->
    @endif
    <script>
        (function($) {
        "use strict";
        $(document).ready(function () {
            /* Testimonial Slider */
            var swiper = new Swiper(".inflanar-slider-related", {
                    autoplay: {
                        delay: 3333500,
                    },
                    mousewheel: true,
                    keyboard: true,
                    loop: true,
                    grabCursor: true,
                    spaceBetween: 30,
                    centeredSlides: false,
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                    breakpoints: {
                        320: {
                            slidesPerView: "1",
                        },
                        428: {
                            slidesPerView:"2",
                        },
                        768: {
                            slidesPerView:"3",
                        },
                        1024: {
                            slidesPerView:"4",
                        },
                    },
                });
            });

        })(jQuery);
    </script>


<script>
    (function($) {
        "use strict";
        $(document).ready(function () {
            $("#after_login").on("click",function(){
                toastr.error('Please Login First');
            })


            $("#serviceReviewForm").on('submit', function(e){
                e.preventDefault();
                var isDemo = "{{ env('APP_MODE') }}"
                if(isDemo == 'DEMO'){
                    toastr.error('This Is Demo Version. You Can Not Change Anything');
                    return;
                }
                $.ajax({
                    type: 'POST',
                    data: $('#serviceReviewForm').serialize(),
                    url: "{{ route('user.store-review') }}",
                    success: function (response) {
                        if(response.status == 1){
                            toastr.success(response.message)
                            $("#serviceReviewForm").trigger("reset");
                        }

                        if(response.status == 0){
                            toastr.error(response.message)
                            $("#serviceReviewForm").trigger("reset");
                        }
                    },
                    error: function(response) {

                        if(response.status == 402){
                            toastr.error("{{__('admin.Please login first')}}")
                        }

                        if(response.responseJSON.errors.comment)toastr.error(response.responseJSON.errors.comment[0])

                        if(!response.responseJSON.errors.comment){
                            toastr.error("{{__('admin.Please complete the recaptcha to submit the form')}}")
                        }
                    }
                });
            })

        });
    })(jQuery);


    function productReview(rating){
        $(".service_rat").each(function(){
            var service_rat = $(this).data('rating')
            if(service_rat > rating){
                $(this).removeClass('fa-solid fa-star').addClass('fa-regular fa-star');
            }else{
                $(this).removeClass('fa-regular fa-star').addClass('fa-solid fa-star');
            }
        })
        $("#service_rating").val(rating);
        let html = `(${rating}.0)`
        $("#show_rating").html(html);
    }

</script>
@endsection
