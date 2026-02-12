@extends('mgahed-laravel-starter::layouts.admin.master')

@section('pageContent')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        {{__('admin.settings.system-settings.System Settings')}}
                    </h1>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="{{ route('system-settings.cover') }}" class="btn btn-light-primary btn-sm" target="_blank">
                        {{__('admin.settings.system-settings.Cover preview')}}
                    </a>
                    <a href="{{ route('system-settings.cover', ['format' => 'pdf']) }}" class="btn btn-primary btn-sm" target="_blank">
                        {{__('admin.settings.system-settings.Download cover (PDF)')}}
                    </a>
                </div>
            </div>
        </div>

        <div class="row app-container container-fluid">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">{{__('admin.settings.system-settings.Company details')}}</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('system-settings.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-5">
                                    <label class="form-label">{{__('admin.settings.system-settings.Company Name')}}</label>
                                    <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $settings->company_name) }}" required>
                                </div>
                                <div class="col-md-6 mb-5">
                                    <label class="form-label">{{__('admin.settings.system-settings.General Manager (GF)')}}</label>
                                    <input type="text" name="general_manager" class="form-control" value="{{ old('general_manager', $settings->general_manager) }}" required>
                                </div>
                                <div class="col-md-6 mb-5">
                                    <label class="form-label">{{__('admin.settings.system-settings.Mandatory Health Approval Number')}}</label>
                                    <input type="text" name="health_approval_number" class="form-control" value="{{ old('health_approval_number', $settings->health_approval_number) }}" required>
                                </div>
                                <div class="col-md-6 mb-5">
                                    <label class="form-label">{{__('admin.settings.system-settings.Website')}}</label>
                                    <input type="text" name="website" class="form-control" value="{{ old('website', $settings->website) }}">
                                </div>
                                <div class="col-12 mb-5">
                                    <label class="form-label">{{__('admin.settings.system-settings.Full Address')}}</label>
                                    <textarea name="full_address" class="form-control" rows="3" required>{{ old('full_address', $settings->full_address) }}</textarea>
                                </div>
                                <div class="col-md-4 mb-5">
                                    <label class="form-label">{{__('admin.settings.system-settings.Landline')}}</label>
                                    <input type="text" name="landline" class="form-control" value="{{ old('landline', $settings->landline) }}">
                                </div>
                                <div class="col-md-4 mb-5">
                                    <label class="form-label">{{__('admin.settings.system-settings.Direct / Mobile')}}</label>
                                    <div class="input-group">
                                        <input type="text" name="mobile" class="form-control" value="{{ old('mobile', $settings->mobile) }}">
                                        <span class="input-group-text text-success">
                                            <em class="fab fa-whatsapp"></em>
                                        </span>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" name="whatsapp_enabled" value="1" id="whatsapp_enabled"
                                               {{ old('whatsapp_enabled', $settings->whatsapp_enabled) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="whatsapp_enabled">
                                            {{__('admin.settings.system-settings.Enable WhatsApp icon')}}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-5">
                                    <label class="form-label">{{__('admin.settings.system-settings.Tax ID')}}</label>
                                    <input type="text" name="tax_id" class="form-control" value="{{ old('tax_id', $settings->tax_id) }}">
                                </div>
                                <div class="col-md-4 mb-5">
                                    <label class="form-label">{{__('admin.settings.system-settings.VAT No.')}}</label>
                                    <input type="text" name="vat_no" class="form-control" value="{{ old('vat_no', $settings->vat_no) }}">
                                </div>
                                <div class="col-md-4 mb-5">
                                    <label class="form-label">{{__('admin.settings.system-settings.EORI No.')}}</label>
                                    <input type="text" name="eori_no" class="form-control" value="{{ old('eori_no', $settings->eori_no) }}">
                                </div>
                                <div class="col-md-4 mb-5">
                                    <label class="form-label">{{__('admin.settings.system-settings.Company Logo')}}</label>
                                    <input type="file" name="logo" class="form-control">
                                    <div class="form-text">{{__('admin.settings.system-settings.Used on headers, footers, and the official cover.')}}</div>
                                </div>
                                @if($logoUrl)
                                    <div class="col-12 mb-5">
                                        <div class="border rounded p-3 bg-light">
                                            <img src="{{ $logoUrl }}" alt="{{__('admin.settings.system-settings.Company Logo')}}" style="max-height: 120px;">
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">{{__('admin.settings.system-settings.Save settings')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow-sm mb-6">
                    <div class="card-header">
                        <h3 class="card-title">{{__('admin.settings.system-settings.PDF usage')}}</h3>
                    </div>
                    <div class="card-body">
                        <p class="mb-3">{{__('admin.settings.system-settings.These settings are used to build:')}}</p>
                        <ul class="mb-0">
                            <li>{{__('admin.settings.system-settings.Smart Header (company name, logo, approval number)')}}</li>
                            <li>{{__('admin.settings.system-settings.Legal Footer (tax and customs numbers)')}}</li>
                        </ul>
                    </div>
                </div>
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">{{__('admin.settings.system-settings.Official cover')}}</h3>
                    </div>
                    <div class="card-body">
                        <p class="mb-4">{{__('admin.settings.system-settings.Generate the HACCP folder cover with the logo centered and approval number below.')}}</p>
                        <div class="d-grid gap-2">
                            <a href="{{ route('system-settings.cover') }}" class="btn btn-light-primary" target="_blank">{{__('admin.settings.system-settings.Open preview')}}</a>
                            <a href="{{ route('system-settings.cover', ['format' => 'pdf']) }}" class="btn btn-primary" target="_blank">{{__('admin.settings.system-settings.Download PDF')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

