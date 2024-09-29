@extends('dashboard.admin.profile.index')

@section('profile_content')
    <div class="flex-row-fluid ml-lg-8">
        <form class="form" method="post" action="{{route('admin.profile.update')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="card card-custom card-stretch">
                <div class="card-header py-3">
                    <div class="card-title align-items-start flex-column">
                        <h3 class="card-label font-weight-bolder text-dark"
                            style="padding-top: 9px;">{{__('admin/dashboard.personal_info')}}</h3>
                    </div>
                    <div class="card-toolbar">
                        <button type="submit" class="btn btn-success mr-2">{{__('admin/dashboard.save')}}</button>
                        <button type="reset" class="btn btn-secondary">{{__('admin/dashboard.cancel')}}</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <label class="col-xl-3"></label>
                        <div class="col-lg-9 col-xl-6">
                            <h5 class="font-weight-bold mb-6">{{__('admin/dashboard.personal_info')}}</h5>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('admin/dashboard.image')}}</label>
                        <div class="col-lg-9 col-xl-6">
                            <div class="image-input image-input-outline" id="kt_profile_avatar"
                                 style="background-size: cover;background-image: url({{auth()->user()->photo ?? resolvePhoto(null,'admin')}})">
                                <div  class="image-input-wrapper"></div>
                                <label
                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                    data-action="change" data-toggle="tooltip" title=""
                                    data-original-title="{{__('admin/dashboard.edit_image')}}">
                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                    <input type="file" name="photo" accept=".png, .jpg, .jpeg"/>
                                    <input type="hidden" name="photo"/>
                                </label>
                                <span
                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                    data-action="cancel" data-toggle="tooltip" title="{{__('admin/dashboard.cancel_image')}}">
                                        <i class="ki ki-bold-close icon-xs text-muted"></i>
                               </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('admin/dashboard.name')}}</label>
                        <div class="col-lg-9 col-xl-6">
                            <input class="form-control form-control-lg form-control-solid" type="text" name="name"
                                   value="{{Auth::user()->name}}"
                                   placeholder="{{__('admin/dashboard.enter')}} {{__('admin/dashboard.name')}}"/>
                            <div class="text-danger">
                                <strong>{{ $errors->has('name') ? $errors->first('name') : '' }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-xl-3"></label>
                        <div class="col-lg-9 col-xl-6">
                            <h5 class="font-weight-bold mt-10 mb-6">{{__('admin/dashboard.contact_info')}}</h5>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('admin/dashboard.phone')}}</label>
                        <div class="col-lg-9 col-xl-6">
                            <div class="input-group input-group-lg input-group-solid">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="la la-phone"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control form-control-lg form-control-solid" name="phone"
                                       value="{{Auth::user()->phone}}"
                                       placeholder="{{__('admin/dashboard.enter')}} {{__('admin/dashboard.phone')}}">
                            </div>
                            <div class="text-danger">
                                <strong>{{ $errors->has('phone') ? $errors->first('phone') : '' }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('admin/dashboard.email')}}</label>
                        <div class="col-lg-9 col-xl-6">
                            <div class="input-group input-group-lg input-group-solid">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="la la-at"></i>
                                    </span>
                                </div>
                                <input type="email" class="form-control form-control-lg form-control-solid" name="email"
                                       value="{{Auth::user()->email}}"
                                       placeholder="{{__('admin/dashboard.enter')}} {{__('admin/dashboard.email')}}">
                            </div>
                            <div class="text-danger">
                                <strong>{{ $errors->has('email') ? $errors->first('email') : '' }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
