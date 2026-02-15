@extends('mgahed-laravel-starter::layouts.admin.master')

@section('pageContent')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        {{__('admin.content-pages.Create content page')}}
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
                        <li class="breadcrumb-item text-muted">{{__('admin.content-pages.Create')}}</li>
                    </ul>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="{{ route('content-pages.index') }}" class="btn btn-sm btn-light">
                        <i class="ki-duotone ki-arrow-left fs-2"></i>
                        {{__('admin.content-pages.Back to list')}}
                    </a>
                </div>
            </div>
        </div>

        <div class="app-container container-fluid">
            <form method="POST" action="{{ route('content-pages.store') }}">
                @csrf
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card shadow-sm mb-5">
                            <div class="card-header">
                                <h3 class="card-title">{{__('admin.content-pages.Page content')}}</h3>
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
                                                       value="{{ old('title.'.$code) }}"
                                                       {{ $code === $defaultLocale ? 'required' : '' }}>
                                                @error('title.'.$code)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-5">
                                                <label class="form-label required">{{__('admin.content-pages.Content')}} ({{ $name }})</label>
                                                <textarea name="content[{{ $code }}]" id="content[{{ $code }}]" class="form-control @error('content.'.$code) is-invalid @enderror"
                                                          rows="15"
                                                          {{ $code === $defaultLocale ? 'required' : '' }}>{{ old('content.'.$code) }}</textarea>
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
                                    <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror"
                                           value="{{ old('slug') }}" placeholder="auto-generated-from-title">
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">{{__('admin.content-pages.Leave empty to auto generate from title')}}</div>
                                </div>

                                <div class="mb-5">
                                    <label class="form-label">{{__('admin.content-pages.Version')}}</label>
                                    <input type="text" name="version" class="form-control @error('version') is-invalid @enderror"
                                           value="{{ old('version', '1.0') }}" placeholder="1.0">
                                    @error('version')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">{{__('admin.content-pages.Optional version tracking')}}</div>
                                </div>

                                <div class="mb-5">
                                    <label class="form-label">{{__('admin.content-pages.Display order')}}</label>
                                    <input type="number" name="record_order" class="form-control @error('record_order') is-invalid @enderror"
                                           value="{{ old('record_order', 100) }}" min="0">
                                    @error('record_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-5">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_published" value="1" id="is_published"
                                               {{ old('is_published') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_published">
                                            {{__('admin.content-pages.Publish this page')}}
                                        </label>
                                    </div>
                                    <div class="form-text">{{__('admin.content-pages.Only published pages are visible on the website')}}</div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ki-duotone ki-check fs-2"></i>
                                        {{__('admin.content-pages.Create page')}}
                                    </button>
                                    <a href="{{ route('content-pages.index') }}" class="btn btn-light">
                                        {{__('admin.content-pages.Cancel')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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

    // Auto-generate slug from default language title
    document.addEventListener('DOMContentLoaded', function() {
        const defaultLocale = '{{ $defaultLocale }}';
        const titleInput = document.querySelector(`input[name="title[${defaultLocale}]"]`);
        const slugInput = document.querySelector('input[name="slug"]');

        if (titleInput && slugInput) {
            titleInput.addEventListener('input', function() {
                if (!slugInput.value || slugInput.dataset.autoGenerated) {
                    const slug = this.value
                        .toLowerCase()
                        .replace(/[^\w\s-]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-')
                        .trim();
                    slugInput.value = slug;
                    slugInput.dataset.autoGenerated = 'true';
                }
            });

            slugInput.addEventListener('input', function() {
                if (this.value) {
                    delete this.dataset.autoGenerated;
                }
            });
        }
    });
</script>
@endpush
