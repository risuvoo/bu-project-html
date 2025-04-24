@extends('influencer.master_layout')
@section('title')
<title>{{__('admin.Coupon Histories')}}</title>
@endsection
@section('influencer-content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>{{__('admin.Coupon Histories')}}</h1>
      </div>

        <div class="section-body">

            <div class="row mt-sm-4">
                <div class="col-12">
                    <div class="card ">
                        <div class="card-body">
                            <div class="table-responsive table-invoice">
                                <table class="table table-striped" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>{{__('admin.SN')}}</th>
                                            <th>{{__('admin.Coupon Code')}}</th>
                                            <th>{{__('admin.Discount Amount')}}</th>
                                            <th>{{__('admin.Date')}}</th>
                                          </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($coupon_histories as $index => $coupon_history)
                                            <tr>
                                                <td>{{ ++$index }}</td>
                                                <td>{{ $coupon_history->coupon_code }}</td>
                                                <td>

                                                    {{ currency($coupon_history->discount_amount) }}

                                                </td>
                                                <td>{{ date('H:iA, d M Y', strtotime($coupon_history->created_at)) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

