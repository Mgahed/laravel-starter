@extends('mgahed-laravel-starter::layouts.admin.master')

@section('pageContent')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        Revision History
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('content-pages.index') }}" class="text-muted text-hover-primary">Content Pages</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('content-pages.edit', $page->id) }}" class="text-muted text-hover-primary">{{ $page->title }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Revisions</li>
                    </ul>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="{{ route('content-pages.edit', $page->id) }}" class="btn btn-sm btn-light">
                        <i class="ki-duotone ki-arrow-left fs-2"></i>
                        Back to Edit
                    </a>
                </div>
            </div>
        </div>

        <div class="app-container container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-5" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">
                                Revision History for "{{ $page->title }}"
                            </h3>
                            <div class="card-toolbar">
                                <span class="badge badge-light-info">{{ $revisions->count() }} Revision(s)</span>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            @if($revisions->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3 mb-0">
                                        <thead>
                                            <tr class="fw-bold text-muted bg-light">
                                                <th class="ps-4">Version</th>
                                                <th>Created</th>
                                                <th>Created By</th>
                                                <th>Change Notes</th>
                                                <th class="text-end pe-4">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($revisions as $revision)
                                                <tr>
                                                    <td class="ps-4">
                                                        <div class="d-flex align-items-center">
                                                            <span class="badge badge-lg badge-light-primary">
                                                                v{{ $revision->version }}
                                                            </span>
                                                            @if($revision->version === $page->version)
                                                                <span class="badge badge-sm badge-success ms-2">Current</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-gray-800 fw-bold">
                                                            {{ $revision->created_at->format('M d, Y') }}
                                                        </div>
                                                        <div class="text-muted fs-7">
                                                            {{ $revision->created_at->format('H:i:s') }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($revision->creator)
                                                            <div class="text-gray-800">{{ $revision->creator->name }}</div>
                                                            <div class="text-muted fs-7">{{ $revision->creator->email }}</div>
                                                        @else
                                                            <span class="text-muted">Unknown</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($revision->change_notes)
                                                            <div class="text-gray-700">{{ Str::limit($revision->change_notes, 50) }}</div>
                                                        @else
                                                            <span class="text-muted fs-7">No notes</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-end pe-4">
                                                        <button type="button" class="btn btn-sm btn-light btn-active-light-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#revisionModal{{ $revision->id }}">
                                                            <i class="ki-duotone ki-eye fs-5"></i>
                                                            View
                                                        </button>
                                                        @if($revision->version !== $page->version)
                                                            <form action="{{ route('content-pages.restore-revision', [$page->id, $revision->id]) }}"
                                                                  method="POST" style="display:inline-block;"
                                                                  onsubmit="return confirm('Are you sure you want to restore this version? Current content will be saved as a revision.');">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-light-info">
                                                                    <i class="ki-duotone ki-arrows-circle fs-5"></i>
                                                                    Restore
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>

                                                <!-- Revision Detail Modal -->
                                                <div class="modal fade" id="revisionModal{{ $revision->id }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-xl">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">
                                                                    Revision v{{ $revision->version }} - {{ $revision->created_at->format('M d, Y H:i') }}
                                                                </h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                @if($revision->change_notes)
                                                                    <div class="alert alert-light-info mb-5">
                                                                        <strong>Change Notes:</strong> {{ $revision->change_notes }}
                                                                    </div>
                                                                @endif

                                                                <div class="mb-5">
                                                                    <label class="form-label fw-bold">Title (English):</label>
                                                                    <div class="p-3 bg-light rounded">
                                                                        {{ $revision->getTranslation('title', 'en', false) ?: 'N/A' }}
                                                                    </div>
                                                                </div>

                                                                <div class="mb-5">
                                                                    <label class="form-label fw-bold">Content (English):</label>
                                                                    <div class="p-3 bg-light rounded" style="max-height: 300px; overflow-y: auto;">
                                                                        {{ $revision->getTranslation('content', 'en', false) ?: 'N/A' }}
                                                                    </div>
                                                                </div>

                                                                @if($revision->getTranslation('title', 'ar', false))
                                                                    <div class="mb-5">
                                                                        <label class="form-label fw-bold">Title (Arabic):</label>
                                                                        <div class="p-3 bg-light rounded" dir="rtl">
                                                                            {{ $revision->getTranslation('title', 'ar', false) }}
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-5">
                                                                        <label class="form-label fw-bold">Content (Arabic):</label>
                                                                        <div class="p-3 bg-light rounded" style="max-height: 300px; overflow-y: auto;" dir="rtl">
                                                                            {{ $revision->getTranslation('content', 'ar', false) }}
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="modal-footer">
                                                                @if($revision->version !== $page->version)
                                                                    <form action="{{ route('content-pages.restore-revision', [$page->id, $revision->id]) }}"
                                                                          method="POST"
                                                                          onsubmit="return confirm('Are you sure you want to restore this version?');">
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-primary">
                                                                            <i class="ki-duotone ki-arrows-circle fs-2"></i>
                                                                            Restore This Version
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-10">
                                    <div class="text-gray-400 fs-4 mb-5">
                                        <i class="ki-duotone ki-time fs-3x">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </div>
                                    <h3 class="text-gray-800 fw-bold mb-2">No Revisions Yet</h3>
                                    <p class="text-gray-500">Revisions will be created when you change the version number.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-sm mb-5">
                        <div class="card-header">
                            <h3 class="card-title">Current Page Info</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label text-muted">Title</label>
                                <div class="fw-bold">{{ $page->title }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">Slug</label>
                                <div><code>{{ $page->slug }}</code></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">Current Version</label>
                                <div>
                                    <span class="badge badge-lg badge-light-primary">v{{ $page->version }}</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">Status</label>
                                <div>
                                    @if($page->is_published)
                                        <span class="badge badge-light-success">Published</span>
                                    @else
                                        <span class="badge badge-light-warning">Draft</span>
                                    @endif
                                </div>
                            </div>
                            <div class="separator my-4"></div>
                            <div class="text-muted fs-7">
                                <div class="mb-2"><strong>Total Revisions:</strong> {{ $revisions->count() }}</div>
                                <div class="mb-2"><strong>Last Modified:</strong> {{ $page->updated_at->format('M d, Y H:i') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm bg-light-info">
                        <div class="card-body">
                            <h5 class="card-title text-info">
                                <i class="ki-duotone ki-information-5 fs-2 text-info me-2"></i>
                                About Revisions
                            </h5>
                            <p class="text-gray-700 fs-7 mb-0">
                                A new revision is automatically created when you change the version number and save the page.
                                This allows you to track changes and restore previous versions if needed.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

