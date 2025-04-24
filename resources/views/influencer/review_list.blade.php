@extends('influencer.master_layout')
@section('title')
<title>{{__('admin.Review List')}}</title>
@endsection
@section('influencer-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.Review List')}}</h1>

          </div>

          <div class="section-body">
            <div class="row mt-4">
                <div class="col">
                  <div class="card">
                    <div class="card-body">
                      <div class="table-responsive table-invoice">
                        <table class="table table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th width="5%">{{__('admin.SN')}}</th>
                                    <th width="15%">{{__('admin.Client')}}</th>
                                    <th width="30%">{{__('admin.Service')}}</th>
                                    <th width="5%">{{__('admin.Rating')}}</th>
                                    <th width="10%">{{__('admin.Status')}}</th>
                                    <th width="20%">{{__('admin.Created At')}}</th>
                                    <th width="10%">{{__('admin.Action')}}</th>
                                  </tr>
                            </thead>
                            <tbody>
                                @foreach ($reviews as $index => $review)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $review->user ? $review->user->name : '' }}</td>
                                        <td><a href="{{ route('influencer.service.edit', ['service' => $review->service_id, 'lang_code' => front_lang()]) }}">{{ $review->service->translate->title }}</a></td>

                                        <td>{{ $review->rating }}</td>
                                        <td>
                                            @if ($review->status==1)
                                            <span class="badge badge-success">{{__('admin.Active')}}</span>
                                            @else
                                            <span class="badge badge-danger">{{__('admin.Inactive')}}</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $review->created_at->format('H:i A, d-m-Y') }}
                                        </td>
                                        <td>
                                            <a href="{{ route('influencer.show-review',$review->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                        </td>
                                    </tr>
                                  @endforeach
                            </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
          </div>
        </section>
      </div>


@endsection
