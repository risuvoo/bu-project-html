@php
    $auth_user = Auth::guard('web')->user();
    $unseen_ticket = App\Models\TicketMessage::where('user_id', $auth_user->id)->where('unseen_user',0)->count();
@endphp

<div class="col-lg-3 col-md-4 col-12 inflanar-personals__list mg-top-30">
    <div class="inflanar-psidebar inflanar-default-bg">
        <!-- Auhtor Info -->
        <div class="inflanar-psidebar__author">
            <div class="inflanar-psidebar__athumb">
                @if ($auth_user->image)
                <img id="preview-user-avatar" src="{{ asset($auth_user->image) }}">
                @else
                <img id="preview-user-avatar" src="{{ asset($setting->default_avatar) }}">
                @endif


                <div class="inflanar-psidebar__aedit">
                    <label for="file-input"><span class="inflanar-psidebar__aupload"><i class="fas fa-pencil"></i></label>
                        <form id="upload_user_avatar_form" enctype="multipart/form-data" method="POST">
                            @csrf
                            <input class="d-none" type="file" name="image" id="file-input" hidden onchange="previewThumnailImage(event)">
                        </form>
                </div>
            </div>
            <h4 class="inflanar-psidebar__atitle">{{ html_decode($auth_user->name) }} <span>{{ html_decode($auth_user->designation) }}</span></h4>
        </div>
        <!-- Features Tab List -->
        <div class="list-group inflanar-psidebar__list">
            <a class="list-group-item {{ Route::is('user.dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">
                <span class="inflanar-psidebar__icon">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.1805 20H5.81977C3.51103 20 1.63942 18.214 1.63942 16.0108V11.133C1.63942 10.4248 1.3446 9.74559 0.81981 9.2448C-0.396073 8.0845 -0.238008 6.16205 1.15263 5.19692L7.54136 0.762995C9.0072 -0.254332 10.993 -0.254332 12.4589 0.762995L18.8476 5.19691C20.2383 6.16205 20.3963 8.0845 19.1804 9.2448C18.6556 9.74559 18.3608 10.4248 18.3608 11.133V16.0108C18.3608 18.214 16.4892 20 14.1805 20ZM8.00012 15.25C7.58591 15.25 7.25012 15.5858 7.25012 16C7.25012 16.4142 7.58591 16.75 8.00012 16.75H12.0001C12.4143 16.75 12.7501 16.4142 12.7501 16C12.7501 15.5858 12.4143 15.25 12.0001 15.25H8.00012Z"/>
                    </svg>
                </span>
                <span class="inflanar-psidebar__title">{{__('admin.Dashboard')}}</span>
            </a>
            <a class="list-group-item {{ Route::is('user.orders') || Route::is('user.order') ? 'active' : '' }}" href="{{ route('user.orders') }}">
                <span class="inflanar-psidebar__icon">
                    <svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.00007 8.88889C10.5248 8.88889 12.5715 6.89904 12.5715 4.44444C12.5715 1.98985 10.5248 0 8.00007 0C5.47534 0 3.42864 1.98985 3.42864 4.44444C3.42864 6.89904 5.47534 8.88889 8.00007 8.88889ZM8.00012 19.9982C12.4184 19.9982 16.0001 18.0084 16.0001 15.5538C16.0001 13.0992 12.4184 11.1094 8.00012 11.1094C3.58184 11.1094 0.00012207 13.0992 0.00012207 15.5538C0.00012207 18.0084 3.58184 19.9982 8.00012 19.9982Z"/>
                    </svg>
                </span>
                <span class="inflanar-psidebar__title">{{__('admin.Orders')}}</span>
            </a>
            <a class="list-group-item {{ Route::is('user.support-tickets') || Route::is('user.support-ticket') ? 'active' : '' }}" href="{{ route('user.support-tickets') }}">
                <span class="inflanar-psidebar__icon">
                    <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.00012 18C1.79098 18 0.00012207 16.2091 0.00012207 14V13C0.00012207 12.4477 0.460125 12.0163 0.982016 11.8356C2.15666 11.4289 3.00012 10.313 3.00012 9C3.00012 7.68702 2.15666 6.57105 0.982017 6.16437C0.460125 5.98368 0.00012207 5.55228 0.00012207 5V4C0.00012207 1.79086 1.79098 0 4.00012 0H16.0001C18.2093 0 20.0001 1.79086 20.0001 4V5C20.0001 5.55228 19.5401 5.98368 19.0182 6.16437C17.8436 6.57105 17.0001 7.68702 17.0001 9C17.0001 10.313 17.8436 11.4289 19.0182 11.8356C19.5401 12.0163 20.0001 12.4477 20.0001 13V14C20.0001 16.2091 18.2093 18 16.0001 18H4.00012ZM7.00012 7C7.55241 7 8.00012 6.55228 8.00012 6C8.00012 5.44771 7.55241 5 7.00012 5C6.44784 5 6.00012 5.44771 6.00012 6C6.00012 6.55228 6.44784 7 7.00012 7ZM14.0001 12C14.0001 12.5523 13.5524 13 13.0001 13C12.4478 13 12.0001 12.5523 12.0001 12C12.0001 11.4477 12.4478 11 13.0001 11C13.5524 11 14.0001 11.4477 14.0001 12ZM13.5305 6.53033C13.8233 6.23744 13.8233 5.76256 13.5305 5.46967C13.2376 5.17678 12.7627 5.17678 12.4698 5.46967L6.46979 11.4697C6.1769 11.7626 6.1769 12.2374 6.46979 12.5303C6.76269 12.8232 7.23756 12.8232 7.53045 12.5303L13.5305 6.53033Z"/>
                    </svg>
                </span>
                <span class="inflanar-psidebar__title inflanar-psidebar__title--support">{{__('admin.Support Ticket')}}
                    @if ($unseen_ticket > 0)
                    <b>{{ $unseen_ticket }}</b>
                    @endif
                    </span>
            </a>
            <a class="list-group-item {{ Route::is('user.wishlists') ? 'active' : '' }}" href="{{ route('user.wishlists') }}">
                <span class="inflanar-psidebar__icon">
                    <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.7652 1.70229L10.0001 2.52422L9.23507 1.70229C7.12245 -0.567428 3.69721 -0.56743 1.58459 1.70229C-0.528033 3.972 -0.528034 7.65194 1.58459 9.92165L8.47002 17.3191C9.31507 18.227 10.6852 18.227 11.5302 17.3191L18.4157 9.92165C20.5283 7.65194 20.5283 3.972 18.4157 1.70229C16.303 -0.567429 12.8778 -0.567429 10.7652 1.70229Z"/>
                    </svg>
                </span>
                <span class="inflanar-psidebar__title">{{__('admin.Favorite List')}}</span>
            </a>

            <a class="list-group-item {{ Route::is('user.reviews') ? 'active' : '' }}" href="{{ route('user.reviews') }}">
                <span class="inflanar-psidebar__icon">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.03293 1.27141C8.83762 -0.423802 11.1626 -0.423805 11.9673 1.27141L13.358 4.20118C13.6776 4.87435 14.2952 5.34094 15.0097 5.44888L18.1195 5.91869C19.9188 6.19053 20.6373 8.48954 19.3352 9.80908L17.085 12.0896C16.568 12.6136 16.3321 13.3685 16.4541 14.1084L16.9853 17.3285C17.2927 19.1918 15.4117 20.6126 13.8024 19.7329L11.0209 18.2126C10.3819 17.8633 9.61838 17.8633 8.97929 18.2126L6.19789 19.7329C4.58851 20.6126 2.70755 19.1918 3.01491 17.3285L3.54611 14.1084C3.66816 13.3685 3.43223 12.6136 2.9152 12.0896L0.664997 9.80908C-0.637012 8.48954 0.0814502 6.19053 1.88078 5.91869L4.9905 5.44888C5.70501 5.34094 6.32269 4.87435 6.64223 4.20118L8.03293 1.27141Z"/>
                    </svg>
                </span>
                <span class="inflanar-psidebar__title">{{__('admin.Reviews')}}</span>
            </a>
            <a class="list-group-item {{ Route::is('user.edit-profile') ? 'active' : '' }}" href="{{ route('user.edit-profile') }}">
                <span class="inflanar-psidebar__icon">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16.0001 0H4.00012C1.79098 0 0.00012207 1.79086 0.00012207 4V16C0.00012207 17.8642 1.27544 19.4306 3.00123 19.8743C3.32052 19.9563 3.65522 20 4.00012 20H16.0001C16.345 20 16.6797 19.9563 16.999 19.8743C18.7248 19.4306 20.0001 17.8642 20.0001 16V4C20.0001 1.79086 18.2093 0 16.0001 0ZM13.0001 7C13.0001 5.34315 11.657 4 10.0001 4C8.34327 4 7.00012 5.34315 7.00012 7C7.00012 8.65685 8.34327 10 10.0001 10C11.657 10 13.0001 8.65685 13.0001 7ZM5.15269 15.0155C5.70097 13.2824 7.66335 12 10.0001 12C12.3369 12 14.2993 13.2824 14.8475 15.0155C15.0141 15.5421 14.5524 16 14.0001 16H6.00012C5.44784 16 4.98611 15.5421 5.15269 15.0155Z"/>
                    </svg>
                </span>
                <span class="inflanar-psidebar__title">{{__('admin.My Profile')}}</span>
            </a>
            <a class="list-group-item {{ Route::is('user.change-password') ? 'active' : '' }}" href="{{ route('user.change-password') }}">
                <span class="inflanar-psidebar__icon">
                    <svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.00012 0.25C5.37677 0.25 3.25012 2.49007 3.25012 5.25333V5.32204C1.39948 5.6731 0.00012207 7.29905 0.00012207 9.25184V15.9985C0.00012207 18.2077 1.79098 19.9985 4.00012 19.9985H12.0001C14.2093 19.9985 16.0001 18.2077 16.0001 15.9985V9.25185C16.0001 7.29905 14.6008 5.6731 12.7501 5.32204V5.25333C12.7501 2.49007 10.6235 0.25 8.00012 0.25ZM11.2501 5.25185C11.2494 3.36187 9.79458 1.83 8.00012 1.83C6.20567 1.83 4.75089 3.36187 4.75012 5.25185H11.2501ZM10.0001 12.626C10.0001 13.7895 9.10469 14.7327 8.00012 14.7327C6.89555 14.7327 6.00012 13.7895 6.00012 12.626C6.00012 11.4626 6.89555 10.5194 8.00012 10.5194C9.10469 10.5194 10.0001 11.4626 10.0001 12.626Z"/>
                    </svg>
                </span>
                <span class="inflanar-psidebar__title">{{__('admin.Change Password')}}</span>
            </a>
            <a class="list-group-item" data-bs-toggle="modal" data-bs-target="#logout_modal">
                <span class="inflanar-psidebar__icon">
                    <svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.01938 1.65551C5.16191 1.70905 5.30365 1.76412 5.44695 1.81613C6.19054 2.08842 6.89541 2.44025 7.56929 2.85174C7.98833 3.10721 8.39111 3.38714 8.71721 3.75963C9.47242 4.62315 9.98983 5.61211 10.2803 6.71121C10.3895 7.12347 10.4484 7.55179 10.491 7.97705C10.5599 8.67536 10.6087 9.37597 10.6443 10.0766C10.7071 11.2958 10.7234 12.5157 10.6567 13.7349C10.632 14.1946 10.6033 14.6542 10.577 15.1139C10.5739 15.1736 10.577 15.234 10.577 15.3036C10.7907 15.2837 10.9952 15.2401 11.1819 15.1529C12.2431 14.6558 12.9596 13.881 13.1416 12.7016C13.219 12.2029 13.2632 11.6996 13.3166 11.1979C13.3538 10.8468 13.573 10.5852 13.903 10.5156C14.346 10.4215 14.7783 10.7749 14.7682 11.2292C14.7643 11.4067 14.748 11.5849 14.7248 11.7608C14.6559 12.2763 14.604 12.7964 14.5025 13.3058C14.3685 13.9789 14.0347 14.5655 13.5994 15.0956C13.051 15.764 12.3763 16.2689 11.5467 16.5419C11.1989 16.6566 10.8287 16.7086 10.4685 16.7836C10.405 16.7966 10.3771 16.8203 10.3616 16.8823C10.24 17.3572 10.0619 17.807 9.74197 18.1902C9.41045 18.5864 9.0007 18.8632 8.48483 18.9696C8.17578 19.033 7.87137 18.9856 7.56541 18.9328C6.24709 18.7049 5.01784 18.2353 3.85675 17.5882C3.4408 17.3565 3.03105 17.1048 2.65383 16.8173C2.1279 16.4165 1.7561 15.8765 1.42536 15.3135C0.986171 14.5663 0.673243 13.7708 0.529172 12.9165C0.470304 12.5692 0.436223 12.2182 0.404466 11.8671C0.354893 11.3202 0.313066 10.7718 0.276661 10.2234C0.252649 9.86548 0.233284 9.50676 0.227862 9.14804C0.214695 8.28987 0.224764 7.43247 0.285956 6.57583C0.35102 5.67024 0.428477 4.76542 0.590364 3.87053C0.713521 3.18828 1.01715 2.58481 1.4393 2.03564C2.0365 1.25931 2.79248 0.695615 3.74521 0.426386C4.19059 0.300185 4.65533 0.232877 5.11543 0.16557C5.84741 0.059255 6.58558 0.00724475 7.32607 0.0011259C8.03093 -0.00499295 8.7358 0.0118339 9.43524 0.101322C10.0115 0.174748 10.5894 0.250469 11.1587 0.364433C11.9665 0.525817 12.6389 0.951077 13.2214 1.51478C13.872 2.14425 14.3422 2.8854 14.5172 3.77569C14.6233 4.31339 14.6752 4.86179 14.7442 5.40636C14.7635 5.55934 14.7759 5.7169 14.7643 5.87063C14.7388 6.22094 14.4158 6.51158 14.0602 6.52305C13.7264 6.53376 13.3918 6.27295 13.3391 5.93641C13.2918 5.63276 13.2756 5.32376 13.2376 5.01858C13.1788 4.54973 13.1594 4.07093 12.9634 3.6319C12.5645 2.74084 11.9162 2.09607 10.965 1.80007C10.6095 1.68916 10.23 1.6448 9.85816 1.59662C8.9062 1.47347 7.94883 1.43294 6.98913 1.45894C6.32997 1.47653 5.6739 1.52854 5.01938 1.65627V1.65551Z" />
                        <path d="M17.4784 7.76288C17.4304 7.71316 17.3839 7.66191 17.3351 7.61373C16.9541 7.23512 16.5691 6.86034 16.1926 6.47715C16.1005 6.38384 16.0199 6.27064 15.9634 6.15362C15.8054 5.82855 15.9905 5.47366 16.2407 5.3161C16.5404 5.12718 16.8991 5.1486 17.1454 5.38723C17.5257 5.75742 17.9014 6.13297 18.2786 6.50622C18.7627 6.98578 19.2468 7.46458 19.7278 7.94644C19.8014 8.01987 19.8719 8.104 19.9184 8.19578C20.057 8.47113 20.016 8.73424 19.82 8.96829C19.7115 9.09755 19.5899 9.21687 19.4691 9.33618C18.7302 10.0666 17.9897 10.7963 17.2499 11.5267C17.1113 11.6636 16.9618 11.7814 16.7604 11.8105C16.4568 11.8549 16.1733 11.7241 16.0191 11.4717C15.8627 11.217 15.8735 10.9126 16.0633 10.6686C16.157 10.5485 16.2709 10.4429 16.3793 10.3351C16.731 9.98555 17.0842 9.6383 17.4366 9.29029C17.4467 9.28035 17.4544 9.26735 17.4738 9.24287C17.4258 9.23981 17.3925 9.23675 17.3584 9.23675C15.7333 9.23599 14.1083 9.23446 12.4832 9.23522C12.1889 9.23522 11.9534 9.13044 11.8062 8.87498C11.5235 8.38394 11.8984 7.77741 12.4669 7.782C13.9696 7.7927 15.4723 7.78659 16.975 7.78735C17.1384 7.78735 17.3026 7.78735 17.466 7.78735C17.4707 7.77894 17.4746 7.77129 17.4792 7.76288H17.4784Z" />
                    </svg>
                </span>
                <span class="inflanar-psidebar__title">{{__('admin.Logout')}}</span>
            </a>
        </div>
    </div>
</div>

<!-- Logout Modal  -->
<div class="inflanar-preview__modal modal fade" id="logout_modal" tabindex="-1" aria-labelledby="logoutmodal" aria-hidden="true" >
    <div class="modal-dialog modal-dialog-centered inflanar-preview__logout">
        <div class="modal-content">
            <div class="modal-header inflanar__modal__header">
                <h4 class="modal-title inflanar-preview__modal-title" id="logoutmodal">{{__('admin.Confirm')}}</h4>
                <button type="button" class="inflanar-preview__modal--close btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-remove"></i></button>
            </div>
            <div class="modal-body inflanar-modal__body">
                <div class="inflanar-preview__close">
                    <div class="inflanar-preview__close-img">
                        <img src="{{ asset('frontend/img/in-logout-icon.svg') }}" alt="#">
                    </div>
                    <h2 class="inflanar-preview__close-title">{{__('admin.Are you sure you want to Logout')}} <span>{{__('admin.Inflanar?')}}</span></h2>
                    <div class="inflanar__item-button--group">


                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button onclick="event.preventDefault();
                            this.closest('form').submit();" class="inflanar-btn" type="submit">{{__('admin.Yes Logout')}}</button>
                        </form>

                        <button class="inflanar-btn inflanar-btn__cancel" data-bs-dismiss="modal">
                            <span class="ntfmax__btn-textgr">{{__('admin.Cancel')}}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Logout Modal -->

    <script>
        (function($) {
            "use strict";
            $(document).ready(function () {
                $("#upload_user_avatar_form").on("submit", function(e){
                    e.preventDefault();

                    var isDemo = "{{ env('APP_MODE') }}"
                    if(isDemo == 'DEMO'){
                        toastr.error('This Is Demo Version. You Can Not Change Anything');
                        return;
                    }

                    $.ajax({
                        type: 'POST',
                        data:new FormData(this),
                        dataType:'JSON',
                        contentType: false,
                        cache: false,
                        processData: false,
                        url: "{{ route('user.upload-user-avatar') }}",
                        success: function (response) {
                            toastr.success(response.message)
                        },
                        error: function(response) {

                        }
                    });
                })
            });
        })(jQuery);


        function previewThumnailImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('preview-user-avatar');
                output.src = reader.result;
            }

            reader.readAsDataURL(event.target.files[0]);
            $("#upload_user_avatar_form").submit();
        };
    </script>
