@extends('mgahed-laravel-starter::layouts.admin.master')

@section('pageContent')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        {{__('admin.content-pages.View content page')}}
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">{{__('admin.content-pages.Dashboard')}}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('content-pages.index') }}" class="text-muted text-hover-primary">{{__('admin.content-pages.Content pages')}}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">{{__('admin.content-pages.View')}}</li>
                    </ul>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="{{ route('content-pages.download-pdf', $page->id) }}" class="btn btn-sm btn-success" target="_blank">
                        <i class="ki-duotone ki-file-down fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        {{__('admin.content-pages.Download pdf')}}
                    </a>
                    <a href="{{ route('content-pages.edit', $page->id) }}" class="btn btn-sm btn-primary">
                        <i class="ki-duotone ki-pencil fs-2"></i>
                        {{__('admin.content-pages.Edit page')}}
                    </a>
                    <a href="{{ route('content-pages.index') }}" class="btn btn-sm btn-light">
                        <i class="ki-duotone ki-arrow-left fs-2"></i>
                        {{__('admin.content-pages.Back to list')}}
                    </a>
                </div>
            </div>
        </div>

        <div class="app-container container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow-sm mb-5">
                        <div class="card-header">
                            <h3 class="card-title">{{__('admin.content-pages.Page content')}}</h3>
                            <div class="card-toolbar">
                                @if($page->is_published)
                                    <span class="badge badge-success">{{__('admin.content-pages.Published')}}</span>
                                @else
                                    <span class="badge badge-warning">{{__('admin.content-pages.Draft')}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Language Tabs -->
                            <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6" role="tablist">
                                @foreach($locales as $code => $name)
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-bs-toggle="tab" href="#locale_{{ $code }}" role="tab">
                                            {{ $name }}
                                            @if($page->hasTranslation($code))
                                                <i class="ki-duotone ki-check-circle fs-5 text-success ms-1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            @else
                                                <i class="ki-duotone ki-cross-circle fs-5 text-muted ms-1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            <!-- Tab Content -->
                            <div class="tab-content">
                                @foreach($locales as $code => $name)
                                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="locale_{{ $code }}" role="tabpanel">
                                        @if($page->hasTranslation($code))
                                            <div class="mb-5">
                                                <h4 class="text-gray-800 mb-3">{{ $page->getTranslation('title', $code, false) }}</h4>
                                            </div>
                                            <div class="mb-5">
                                                <div class="text-gray-700 fs-6">
                                                    {!! nl2br(e($page->getTranslation('content', $code, false))) !!}
                                                </div>
                                            </div>
                                        @else
                                            <div class="alert alert-light-warning d-flex align-items-center p-5">
                                                <i class="ki-duotone ki-information-5 fs-2hx text-warning me-4">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                                <div class="d-flex flex-column">
                                                    <h5 class="mb-1">{{__('admin.content-pages.No translation available')}}</h5>
                                                    <span>{{__('admin.content-pages.This page has not been translated to')}} {{ $name }} {{__('admin.content-pages.yet')}}</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-sm mb-5">
                        <div class="card-header">
                            <h3 class="card-title">{{__('admin.content-pages.Page details')}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-5">
                                <label class="form-label text-muted">{{__('admin.content-pages.Slug')}}</label>
                                <div class="fw-bold fs-6">
                                    <code class="text-gray-800">{{ $page->slug }}</code>
                                </div>
                            </div>

                            @if($page->version)
                                <div class="mb-5">
                                    <label class="form-label text-muted">{{__('admin.content-pages.Version')}}</label>
                                    <div class="fw-bold fs-6">
                                        <span class="badge badge-light-info">{{ $page->version }}</span>
                                    </div>
                                </div>
                            @endif

                            <div class="mb-5">
                                <label class="form-label text-muted">{{__('admin.content-pages.Display order')}}</label>
                                <div class="fw-bold fs-6">{{ $page->record_order }}</div>
                            </div>

                            <div class="mb-5">
                                <label class="form-label text-muted">{{__('admin.content-pages.Status')}}</label>
                                <div>
                                    @if($page->is_published)
                                        <span class="badge badge-light-success">{{__('admin.content-pages.Published')}}</span>
                                    @else
                                        <span class="badge badge-light-warning">{{__('admin.content-pages.Draft')}}</span>
                                    @endif
                                </div>
                            </div>

                            @if($page->published_at)
                                <div class="mb-5">
                                    <label class="form-label text-muted">{{__('admin.content-pages.Published at')}}</label>
                                    <div class="fw-bold fs-6">{{ $page->published_at->format('M d, Y H:i') }}</div>
                                </div>
                            @endif

                            <div class="separator separator-dashed my-5"></div>

                            <div class="mb-5">
                                <label class="form-label text-muted">{{__('admin.content-pages.Available languages')}}</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($availableLanguages as $lang)
                                        <span class="badge badge-light-primary">{{ strtoupper($lang) }}</span>
                                    @endforeach
                                </div>
                            </div>

                            <div class="separator separator-dashed my-5"></div>

                            <div class="text-muted fs-7">
                                <div class="mb-2">
                                    <strong>{{__('admin.content-pages.Created')}}:</strong> {{ $page->created_at->format('M d, Y H:i') }}
                                </div>
                                <div class="mb-2">
                                    <strong>{{__('admin.content-pages.Updated')}}:</strong> {{ $page->updated_at->format('M d, Y H:i') }}
                                </div>
                                @if($page->created_by)
                                    <div class="mb-2">
                                        <strong>{{__('admin.content-pages.Created by')}}:</strong> {{ $page->created_by }}
                                    </div>
                                @endif
                                @if($page->updated_by)
                                    <div class="mb-2">
                                        <strong>{{__('admin.content-pages.Updated by')}}:</strong> {{ $page->updated_by }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('content-pages.edit', $page->id) }}" class="btn btn-primary">
                                    <i class="ki-duotone ki-pencil fs-2"></i>
                                    {{__('admin.content-pages.Edit page')}}
                                </a>
                                <a href="{{ route('content-pages.index') }}" class="btn btn-light">
                                    {{__('admin.content-pages.Back to list')}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

