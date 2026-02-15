@extends('mgahed-laravel-starter::layouts.admin.master')

@section('pageContent')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        Content Pages
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Content Pages</li>
                    </ul>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="{{ route('content-pages.create') }}" class="btn btn-sm btn-primary">
                        <i class="ki-duotone ki-plus fs-2"></i>
                        New Page
                    </a>
                </div>
            </div>
        </div>

        <div class="app-container container-fluid">
            <div class="card shadow-sm">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <form method="GET" action="{{ route('content-pages.index') }}" class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center position-relative">
                                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <input type="text" name="search" value="{{ $search }}" class="form-control form-control-solid w-250px ps-13" placeholder="Search pages...">
                            </div>
                            <select name="published" class="form-select form-select-solid w-150px">
                                <option value="">All Status</option>
                                <option value="1" {{ $published === '1' ? 'selected' : '' }}>Published</option>
                                <option value="0" {{ $published === '0' ? 'selected' : '' }}>Draft</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                            @if($search || $published !== null)
                                <a href="{{ route('content-pages.index') }}" class="btn btn-sm btn-secondary">Clear</a>
                            @endif
                        </form>
                    </div>
                </div>
                <div class="card-body pt-0">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($pages->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                                <thead>
                                    <tr class="fw-bold text-muted">
                                        <th class="min-w-150px">Title</th>
                                        <th class="min-w-120px">Slug</th>
                                        <th class="min-w-80px">Version</th>
                                        <th class="min-w-100px">Status</th>
                                        <th class="min-w-100px">Languages</th>
                                        <th class="min-w-100px">Updated</th>
                                        <th class="text-end min-w-100px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pages as $page)
                                        <tr>
                                            <td>
                                                <a href="{{ route('content-pages.edit', $page->id) }}" class="text-dark fw-bold text-hover-primary">
                                                    {{ $page->title }}
                                                </a>
                                            </td>
                                            <td>
                                                <code class="text-gray-700">{{ $page->slug }}</code>
                                            </td>
                                            <td>
                                                @if($page->version)
                                                    <span class="badge badge-light-info">{{ $page->version }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($page->is_published)
                                                    <span class="badge badge-light-success">Published</span>
                                                @else
                                                    <span class="badge badge-light-warning">Draft</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $langs = $page->getAvailableLanguages();
                                                @endphp
                                                <div class="d-flex gap-1">
                                                    @foreach($langs as $lang)
                                                        <span class="badge badge-light-primary">{{ strtoupper($lang) }}</span>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="text-muted">
                                                {{ $page->updated_at->diffForHumans() }}
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('content-pages.edit', $page->id) }}" class="btn btn-icon btn-light btn-active-light-primary btn-sm me-1">
                                                    <i class="ki-duotone ki-pencil fs-3">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </a>
                                                @if(!$page->protected)
                                                    <form action="{{ route('content-pages.destroy', $page->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this page?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-icon btn-light btn-active-light-danger btn-sm">
                                                            <i class="ki-duotone ki-trash fs-3">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                                <span class="path4"></span>
                                                                <span class="path5"></span>
                                                            </i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-5">
                            <div class="text-muted">
                                Showing {{ $pages->firstItem() }} to {{ $pages->lastItem() }} of {{ $pages->total() }} pages
                            </div>
                            <div>
                                {{ $pages->links() }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-10">
                            <div class="text-gray-400 fs-4 mb-5">
                                <i class="ki-duotone ki-files fs-3x">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                            <h3 class="text-gray-800 fw-bold mb-2">No Content Pages Found</h3>
                            <p class="text-gray-500">Start by creating your first content page.</p>
                            <a href="{{ route('content-pages.create') }}" class="btn btn-primary mt-3">
                                <i class="ki-duotone ki-plus fs-2"></i>
                                Create First Page
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

