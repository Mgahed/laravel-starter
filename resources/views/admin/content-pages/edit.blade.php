@extends('mgahed-laravel-starter::layouts.admin.master')

@section('pageContent')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        {{__('admin.content-pages.Edit content page')}}
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
                        <li class="breadcrumb-item text-muted">{{__('admin.content-pages.Edit')}}</li>
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
                    <a href="{{ route('content-pages.revisions', $page->id) }}" class="btn btn-sm btn-light-info">
                        <i class="ki-duotone ki-time fs-2"></i>
                        {{__('admin.content-pages.View revisions')}}
                    </a>
                    <a href="{{ route('content-pages.index') }}" class="btn btn-sm btn-light">
                        <i class="ki-duotone ki-arrow-left fs-2"></i>
                        {{__('admin.content-pages.Back to list')}}
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

            <form method="POST" action="{{ route('content-pages.update', $page->id) }}">
                @csrf
                @method('PUT')
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
                                                @if($code === $defaultLocale)
                                                    <span class="badge badge-sm badge-light-primary ms-2">{{__('admin.content-pages.Default')}}</span>
                                                @endif
                                                @if($page->hasTranslation($code))
                                                    <i class="ki-duotone ki-check-circle fs-5 text-success ms-1">
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
                                            <div class="mb-5">
                                                <label class="form-label required">{{__('admin.content-pages.Title')}} ({{ $name }})</label>
                                                <input type="text" name="title[{{ $code }}]" class="form-control @error('title.'.$code) is-invalid @enderror"
                                                       value="{{ old('title.'.$code, $page->getTranslation('title', $code, false)) }}"
                                                       {{ $code === $defaultLocale ? 'required' : '' }}>
                                                @error('title.'.$code)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-5">
                                                <label class="form-label required">{{__('admin.content-pages.Content')}} ({{ $name }})</label>
                                                <textarea name="content[{{ $code }}]" id="content[{{ $code }}]" class="form-control @error('content.'.$code) is-invalid @enderror"
                                                          rows="15"
                                                          {{ $code === $defaultLocale ? 'required' : '' }}>{{ old('content.'.$code, $page->getTranslation('content', $code, false)) }}</textarea>
                                                @error('content.'.$code)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div class="form-text">{{__('admin.content-pages.You can use html and markdown in the content')}}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card shadow-sm mb-5">
                            <div class="card-header">
                                <h3 class="card-title">{{__('admin.content-pages.Page settings')}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-5">
                                    <label class="form-label">{{__('admin.content-pages.Slug')}}</label>
                                    <input type="text" class="form-control bg-light" value="{{ $page->slug }}" readonly disabled>
                                    <div class="form-text">{{__('admin.content-pages.The slug cannot be changed after page creation')}}</div>
                                </div>

                                <div class="mb-5">
                                    <label class="form-label">{{__('admin.content-pages.Version')}}</label>
                                    <input type="text" name="version" class="form-control @error('version') is-invalid @enderror"
                                           value="{{ old('version', $page->version) }}" placeholder="1.0">
                                    @error('version')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">{{__('admin.content-pages.Change version to create a new revision')}}</div>
                                </div>

                                <div class="mb-5">
                                    <label class="form-label">{{__('admin.content-pages.Change notes')}}</label>
                                    <textarea name="change_notes" class="form-control @error('change_notes') is-invalid @enderror"
                                              rows="3" placeholder="{{__('admin.content-pages.Describe what changed in this version')}}">{{ old('change_notes') }}</textarea>
                                    @error('change_notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">{{__('admin.content-pages.Notes will be saved if version changes')}}</div>
                                </div>

                                <div class="mb-5">
                                    <label class="form-label">{{__('admin.content-pages.Display order')}}</label>
                                    <input type="number" name="record_order" class="form-control @error('record_order') is-invalid @enderror"
                                           value="{{ old('record_order', $page->record_order) }}" min="0">
                                    @error('record_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-5">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_published" value="1" id="is_published"
                                               {{ old('is_published', $page->is_published) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_published">
                                            {{__('admin.content-pages.Publish this page')}}
                                        </label>
                                    </div>
                                    <div class="form-text">{{__('admin.content-pages.Only published pages are visible on the website')}}</div>
                                </div>

                                @if($page->published_at)
                                    <div class="alert alert-light-info d-flex align-items-center p-5 mb-5">
                                        <i class="ki-duotone ki-information-5 fs-2hx text-info me-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                        <div class="d-flex flex-column">
                                            <h5 class="mb-1">{{__('admin.content-pages.Published')}}</h5>
                                            <span>{{ $page->published_at->format('M d, Y H:i') }}</span>
                                        </div>
                                    </div>
                                @endif

                                <div class="separator separator-dashed my-5"></div>

                                <div class="text-muted fs-7">
                                    <div class="mb-2">
                                        <strong>{{__('admin.content-pages.Created')}}:</strong> {{ $page->created_at->format('M d, Y H:i') }}
                                    </div>
                                    <div class="mb-2">
                                        <strong>{{__('admin.content-pages.Updated')}}:</strong> {{ $page->updated_at->format('M d, Y H:i') }}
                                    </div>
                                    <div class="mb-2">
                                        <strong>{{__('admin.content-pages.Revisions')}}:</strong>
                                        <a href="{{ route('content-pages.revisions', $page->id) }}" class="text-primary">
                                            {{ $page->revisions()->count() }} {{__('admin.content-pages.Revisions')}}
                                        </a>
                                    </div>
                                    <div class="mb-2">
                                        <strong>{{__('admin.content-pages.Available languages')}}:</strong>
                                        @foreach($availableLanguages as $lang)
                                            <span class="badge badge-light-primary">{{ strtoupper($lang) }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ki-duotone ki-check fs-2"></i>
                                        {{__('admin.content-pages.Update page')}}
                                    </button>
                                    <a href="{{ route('content-pages.index') }}" class="btn btn-light">
                                        {{__('admin.content-pages.Cancel')}}
                                    </a>
                                    @if(!$page->protected)
                                        <button type="button" class="btn btn-light-danger" onclick="if(confirm('{{__('admin.content-pages.Are you sure you want to delete this page')}}')) document.getElementById('delete-form').submit();">
                                            <i class="ki-duotone ki-trash fs-2"></i>
                                            {{__('admin.content-pages.Delete page')}}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            @if(!$page->protected)
                <form id="delete-form" action="{{ route('content-pages.destroy', $page->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            @endif
        </div>
    </div>
@endsection
@push('scripts')
	<script src="{{URL("assets/plugins/custom/tinymce/tinymce.bundle.js")}}"></script>
	<script>
		@foreach($locales as $code => $name)
		tinymce.init({
			selector: "#content\\[{{ $code }}\\]",
			height: "480",
			toolbar: "advlist | autolink | link | image | lists charmap | print preview | imageupload | bold italic | bullist numlist | outdent indent | code | fullscreen",
			plugins: "advlist autolink link image lists charmap print preview searchreplace visualblocks code fullscreen",
			image_title: true,
			automatic_uploads: true,
			file_picker_types: 'image',
			file_picker_callback: (cb, value, meta) => {
				const input = document.createElement('input');
				input.setAttribute('type', 'file');
				input.setAttribute('accept', 'image/*,.webp');

				input.addEventListener('change', (e) => {
					const file = e.target.files[0];

					if (file) {
						const reader = new FileReader();
						reader.addEventListener('load', () => {
							const id = 'blobid' + (new Date()).getTime();
							const blobCache = tinymce.activeEditor.editorUpload.blobCache;
							const base64 = reader.result.split(',')[1];
							const blobInfo = blobCache.create(id, file, base64);
							blobCache.add(blobInfo);

							cb(blobInfo.blobUri(), { title: file.name });
						});
						reader.readAsDataURL(file);
					}
				});

				input.click();
			},
			content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
		});
		@endforeach
	</script>
@endpush

