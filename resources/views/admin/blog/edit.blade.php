@extends('admin.layout')

@section('title', 'تعديل المقال')
@section('page-title', 'تعديل المقال')

@section('styles')
    <link rel="stylesheet" href="{{ \App\Support\VersionedAsset::url('assets/css/admin/blogs.css') }}">
@endsection

@php
    $tempFeaturedImage = old('temp_featured_image');
    $featuredPreviewUrl = $tempFeaturedImage
        ? asset('storage/' . $tempFeaturedImage)
        : ($blog->featured_image ? asset('storage/' . $blog->featured_image) : null);
    $tempGalleryImages = old('temp_gallery_images', []);
    $tempGalleryAlts = old('image_alts', []);
    $tempGalleryCaptions = old('image_captions', []);
@endphp

@section('content')
<div class="blog-edit-page">
<!-- Page Banner -->
<div class="blogs-page-banner admin-fade-in">
    <div class="blogs-page-banner-content">
        <i class="fas fa-edit"></i>
        <div>
            <h4>تعديل المقال</h4>
            <p>تعديل بيانات ومحتوى المقال</p>
        </div>
    </div>
    <a href="{{ route('admin.blogs.index') }}" class="blogs-banner-back-btn">
        <i class="fas fa-arrow-right"></i>
        العودة للقائمة
    </a>
</div>

@include('admin.partials.validation-alert')

<div class="blogs-form-card admin-fade-in" style="animation-delay: 0.1s;">
    <div class="blogs-form-header">
        <i class="fas fa-edit"></i>
        <h5>تعديل بيانات المقال</h5>
    </div>
    <div class="blogs-form-body">
        <form action="{{ route('admin.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data" id="postForm">
            @csrf
            @method('PUT')
            <input type="hidden" name="temp_featured_image" id="temp_featured_image" value="{{ $tempFeaturedImage }}">

            <div class="row">
                <!-- المحتوى الكامل في كارد واحد -->
                <div class="col-12 blog-main-column">
                    <!-- العنوان و الرابط -->
                    <div class="blog-field-group">
                        <div class="blog-field-group-header">
                            <i class="fas fa-heading"></i>
                            <span>العنوان والرابط</span>
                        </div>
                        <div class="row">
                            <div class="col-md-7 mb-3">
                                <label for="title" class="form-label">عنوان المقال <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title" value="{{ old('title', $blog->title) }}" required
                                    class="form-control @error('title') is-invalid @enderror" onkeyup="generateSlug()"
                                    placeholder="اكتب عنوان جذاب للمقال...">
                                @error('title')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-5 mb-3">
                                <label for="slug" class="form-label">الرابط المخصص (Slug)</label>
                                <input type="text" name="slug" id="slug" value="{{ old('slug', $blog->slug) }}"
                                    class="form-control @error('slug') is-invalid @enderror" dir="ltr"
                                    placeholder="auto-generated-slug">
                                <small class="form-text text-muted"><i class="fas fa-magic me-1"></i>سيتم توليده تلقائياً</small>
                                @error('slug')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- صف واحد للتصنيف والشريك والصورة -->
                    <div class="blog-field-group">
                        <div class="blog-field-group-header">
                            <i class="fas fa-cog"></i>
                            <span>الإعدادات الأساسية</span>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="category_id" class="form-label">التصنيف <span class="text-danger">*</span></label>
                                <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                    <option value="">اختر التصنيف...</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $blog->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="featured_image" class="form-label">صورة المقال</label>
                                <div class="featured-image-preview mb-2 {{ $featuredPreviewUrl ? '' : 'd-none' }}">
                                    <img src="{{ $featuredPreviewUrl ?? '' }}" id="featured-image-preview" alt="Current featured image" class="img-fluid rounded" style="max-height: 100px;">
                                </div>
                                <input type="file" name="featured_image" id="featured_image" accept="image/*"
                                    class="form-control @error('featured_image') is-invalid @enderror" onchange="previewFeaturedImage(this)">
                                @error('featured_image')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- مقال خارجي -->
                    <div class="blog-field-group">
                        <div class="blog-field-group-header">
                            <i class="fas fa-external-link-alt"></i>
                            <span>نوع المقال</span>
                        </div>
                        <div class="blog-toggle-card">
                            <label class="form-check form-switch mb-0">
                                <input type="checkbox" name="is_external" id="is_external" value="1" {{ old('is_external', $blog->is_external) ? 'checked' : '' }}
                                    class="form-check-input" onchange="toggleExternalArticle()">
                                <span class="form-check-label">
                                    <strong><i class="fas fa-external-link-alt me-1"></i> مقال خارجي</strong>
                                    <small class="d-block text-muted mt-1">
                                        <i class="fas fa-info-circle me-1"></i>
                                        فعّل هذا الخيار إذا كان المقال منشور على منصة أخرى (مثل Medium, LinkedIn, إلخ)
                                    </small>
                                </span>
                            </label>
                        </div>

                        {{-- External URL Field --}}
                        <div class="mt-3 {{ old('is_external', $blog->is_external) ? '' : 'd-none' }}" id="external_url_group">
                            <label for="external_url" class="form-label">
                                <i class="fas fa-link me-1"></i>
                                رابط المقال الخارجي <span class="text-danger">*</span>
                            </label>
                            <input type="url" name="external_url" id="external_url" value="{{ old('external_url', $blog->external_url) }}"
                                class="form-control @error('external_url') is-invalid @enderror"
                                dir="ltr" placeholder="https://example.com/article">
                            <x-form-error name="external_url" />
                            <small class="form-text text-muted">
                                <i class="fas fa-lightbulb me-1 text-warning"></i>
                                سيتم عرض المقال مباشرة في الموقع عبر إطار مضمن (iframe)
                            </small>
                        </div>
                    </div>

                    <!-- محتوى المقال -->
                    <div class="blog-field-group" id="content_group">
                        <div class="blog-field-group-header">
                            <i class="fas fa-pen-nib"></i>
                            <span>محتوى المقال</span>
                            <span class="blog-field-optional">اختياري</span>
                        </div>
                        <textarea id="editor" name="content" class="@error('content') is-invalid @enderror">{!! old('content', $blog->content) !!}</textarea>
                        @error('content')
                        <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                        <div class="blog-content-hints">
                            <span><i class="fas fa-image me-1"></i> يمكنك إدراج صور وجداول</span>
                            <span><i class="fas fa-globe me-1"></i> يعمل مع المقالات الداخلية والخارجية</span>
                            <span class="text-warning"><i class="fas fa-exclamation-triangle me-1"></i> الصور المحذوفة من المحرر تُحذف تلقائياً</span>
                        </div>
                    </div>

                    <!-- صور المعرض الحالية -->
                    <div class="blog-field-group">
                        <div class="blog-field-group-header">
                            <i class="fas fa-images"></i>
                            <span>صور المعرض الحالية</span>
                        </div>
                        @if($blog->images->count() > 0)
                        <div class="gallery-preview">
                            @foreach($blog->images as $index => $image)
                            <div class="gallery-item-container" data-id="{{ $image->id }}">
                                <div class="gallery-item {{ in_array($image->id, old('images_to_delete', [])) ? 'marked-for-delete' : '' }}">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->alt_text ?? $image->caption }}">
                                    <button type="button" class="gallery-remove" onclick="markForDeletion('{{ $image->id }}')">×</button>
                                </div>
                                <input type="text" name="existing_image_alts[{{ $index }}]" value="{{ old('existing_image_alts.' . $index, $image->alt_text) }}"
                                    class="gallery-alt form-control form-control-sm mt-2"
                                    placeholder="نص بديل (Alt Text) - للسيو وإمكانية الوصول">
                                <input type="text" name="existing_image_captions[{{ $index }}]" value="{{ old('existing_image_captions.' . $index, $image->caption) }}"
                                    class="gallery-caption form-control form-control-sm mt-2"
                                    placeholder="وصف الصورة (Caption)">
                                <input type="hidden" name="existing_image_ids[{{ $index }}]" value="{{ $image->id }}">
                            </div>
                            @endforeach
                        </div>
                        <div id="marked-for-deletion"></div>
                        @else
                        <p class="text-muted mb-0"><i class="fas fa-info-circle me-1"></i> لا توجد صور في المعرض حالياً</p>
                        @endif
                    </div>

                    <!-- إضافة صور جديدة -->
                    <div class="blog-field-group">
                        <div class="blog-field-group-header">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>إضافة صور جديدة</span>
                            <span class="blog-field-optional">اختياري</span>
                        </div>
                        <div class="blog-upload-zone">
                            <input type="file" name="gallery_images[]" id="gallery_images" accept="image/*" multiple
                                class="form-control @error('gallery_images') is-invalid @enderror" onchange="previewGalleryImages(this)">
                            @error('gallery_images')
                            <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                            @error('gallery_images.*')
                            <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted"><i class="fas fa-layer-group me-1"></i>يمكنك اختيار أكثر من صورة في نفس الوقت</small>
                        </div>
                        <div id="gallery-preview" class="gallery-preview mt-3">
                            @foreach($tempGalleryImages as $index => $tempGalleryImage)
                                @if($tempGalleryImage)
                                    <div class="gallery-item-container temp-gallery-item" data-temp-path="{{ $tempGalleryImage }}">
                                        <div class="gallery-item">
                                            <img src="{{ asset('storage/' . $tempGalleryImage) }}" alt="Temporary gallery image {{ $index + 1 }}">
                                            <button type="button" class="gallery-remove temp-gallery-remove" onclick="removeTempGalleryImage(this)">&times;</button>
                                        </div>
                                        <input type="hidden" name="temp_gallery_images[]" value="{{ $tempGalleryImage }}">
                                        <input type="text" name="image_alts[]" value="{{ $tempGalleryAlts[$index] ?? '' }}"
                                            class="gallery-alt form-control form-control-sm mt-2"
                                            placeholder="نص بديل (Alt Text) - للسيو وإمكانية الوصول">
                                        <input type="text" name="image_captions[]" value="{{ $tempGalleryCaptions[$index] ?? '' }}"
                                            class="gallery-caption form-control form-control-sm mt-2"
                                            placeholder="وصف الصورة (Caption)">
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- العمود الأيمن: الإعدادات الجانبية -->
                <div class="col-12 blog-aside-column mt-4">
                    <!-- صورة المقال -->
                    <div class="blog-sidebar-card">
                        <div class="blog-sidebar-card-header">
                            <i class="fas fa-camera"></i>
                            <span>صورة المقال</span>
                        </div>
                        <div class="blog-sidebar-card-body">
                            <div class="blog-image-upload-area">
                                <div class="featured-image-preview mb-2 {{ $featuredPreviewUrl ? '' : 'd-none' }}">
                                    <img src="{{ $featuredPreviewUrl ?? '' }}" id="featured-image-preview" alt="Current featured image" class="img-fluid rounded">
                                </div>
                                <input type="file" name="featured_image" id="featured_image" accept="image/*"
                                    class="form-control @error('featured_image') is-invalid @enderror" onchange="previewFeaturedImage(this)">
                                @error('featured_image')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted mt-2 d-block">
                                    <i class="fas fa-info-circle me-1"></i>
                                    ستظهر في الصفحة الرئيسية وأعلى المقال
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- التصنيف والشريك -->
                    <div class="blog-sidebar-card">
                        <div class="blog-sidebar-card-header">
                            <i class="fas fa-folder-open"></i>
                            <span>التصنيف والشريك</span>
                        </div>
                        <div class="blog-sidebar-card-body">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">التصنيف <span class="text-danger">*</span></label>
                                <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                    <option value="">اختر التصنيف...</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $blog->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- حالة النشر -->
                    <div class="blog-sidebar-card">
                        <div class="blog-sidebar-card-header">
                            <i class="fas fa-rocket"></i>
                            <span>حالة النشر</span>
                        </div>
                        <div class="blog-sidebar-card-body">
                            <div class="blog-toggle-card compact">
                                <label class="form-check form-switch mb-0">
                                    <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', $blog->is_published) ? 'checked' : '' }}
                                        class="form-check-input" onchange="togglePublishDateField()">
                                    <span class="form-check-label">
                                        <strong>منشور</strong>
                                    </span>
                                </label>
                            </div>
                            <div class="mt-3" id="publish_date_group">
                                <label for="published_at" class="form-label">تاريخ النشر</label>
                                <input type="datetime-local" name="published_at" id="published_at"
                                    value="{{ old('published_at', $blog->published_at ? $blog->published_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}"
                                    class="form-control @error('published_at') is-invalid @enderror">
                                @error('published_at')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            @if($blog->is_published && $blog->published_at)
                            <div class="mt-3">
                                <div style="padding: 8px 12px; background: rgba(16, 185, 129, 0.08); border-radius: 8px; border: 1px solid rgba(16, 185, 129, 0.15);">
                                    <small style="color: #059669; font-weight: 600;">
                                        <i class="fas fa-check-circle me-1"></i>
                                        تم النشر في {{ $blog->published_at->format('d M, Y - h:i A') }}
                                    </small>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- SEO -->
                    <div class="blog-sidebar-card">
                        <div class="blog-sidebar-card-header">
                            <i class="fas fa-search-plus"></i>
                            <span>تحسين محركات البحث</span>
                        </div>
                        <div class="blog-sidebar-card-body">
                            <div class="mb-3">
                                <label for="meta_title" class="form-label">عنوان الصفحة (Meta Title)</label>
                                <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $blog->meta_title) }}"
                                    class="form-control @error('meta_title') is-invalid @enderror"
                                    placeholder="سيُستخدم العنوان الأساسي إذا تُرك فارغاً">
                                @error('meta_title')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="meta_description" class="form-label">وصف الصفحة (Meta Description)</label>
                                <textarea name="meta_description" id="meta_description" rows="2"
                                    class="form-control @error('meta_description') is-invalid @enderror"
                                    placeholder="وصف مختصر يظهر في نتائج البحث">{{ old('meta_description', $blog->meta_description) }}</textarea>
                                @error('meta_description')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">الكلمات المفتاحية</label>
                                <input type="hidden" name="meta_keywords" id="meta_keywords_hidden" value="{{ old('meta_keywords', $blog->meta_keywords) }}">
                                <div class="tag-input-container" id="meta_keywords_taginput" data-target="meta_keywords_hidden">
                                    <input type="text" class="tag-input-field" placeholder="اكتب كلمة واضغط Enter...">
                                    <div class="tag-input-hint"><kbd>Enter</kbd> أو <kbd>,</kbd> لإضافة</div>
                                    <div class="tag-chips-area"></div>
                                </div>
                                @error('meta_keywords')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="canonical_url" class="form-label">Canonical URL</label>
                                <input type="url" name="canonical_url" id="canonical_url" value="{{ old('canonical_url', $blog->canonical_url) }}"
                                    class="form-control @error('canonical_url') is-invalid @enderror" maxlength="255"
                                    dir="ltr" placeholder="https://...">
                                @error('canonical_url')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="featured_image_alt" class="form-label">النص البديل للصورة</label>
                                <input type="text" name="featured_image_alt" id="featured_image_alt" value="{{ old('featured_image_alt', $blog->featured_image_alt) }}"
                                    class="form-control @error('featured_image_alt') is-invalid @enderror" maxlength="255"
                                    placeholder="وصف مختصر للصورة الرئيسية">
                                @error('featured_image_alt')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- معلومات إضافية -->
                    <div class="blog-sidebar-card">
                        <div class="blog-sidebar-card-header">
                            <i class="fas fa-tags"></i>
                            <span>معلومات إضافية</span>
                        </div>
                        <div class="blog-sidebar-card-body">
                            <div class="mb-3">
                                <label class="form-label">التاجات</label>
                                <input type="hidden" name="tags" id="tags_hidden"
                                    value="{{ old('tags', is_string($blog->tags) ? $blog->tags : (is_array($blog->tags) ? implode(', ', $blog->tags) : '')) }}">
                                <div class="tag-input-container" id="tags_taginput" data-target="tags_hidden">
                                    <input type="text" class="tag-input-field" placeholder="اكتب تاج واضغط Enter...">
                                    <div class="tag-input-hint"><kbd>Enter</kbd> أو <kbd>,</kbd> لإضافة</div>
                                    <div class="tag-chips-area"></div>
                                </div>
                                @error('tags')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">أبرز النقاط</label>
                                <input type="hidden" name="blog_highlights" id="blog_highlights_hidden"
                                    value="{{ old('blog_highlights', is_string($blog->blog_highlights) ? $blog->blog_highlights : (is_array($blog->blog_highlights) ? implode(', ', $blog->blog_highlights) : '')) }}">
                                <div class="tag-input-container" id="blog_highlights_taginput" data-target="blog_highlights_hidden">
                                    <input type="text" class="tag-input-field" placeholder="اكتب ميزة واضغط Enter...">
                                    <div class="tag-input-hint"><kbd>Enter</kbd> أو <kbd>,</kbd> لإضافة</div>
                                    <div class="tag-chips-area"></div>
                                </div>
                                @error('blog_highlights')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="contact_info" class="form-label">معلومات التواصل</label>
                                <textarea name="contact_info" id="contact_info" rows="2"
                                    class="form-control @error('contact_info') is-invalid @enderror"
                                    placeholder="اختياري: معلومات تواصل إضافية">{{ old('contact_info', $blog->contact_info) }}</textarea>
                                @error('contact_info')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="blogs-form-divider">

            <!-- أزرار الحفظ -->
            <div class="blogs-form-actions">
                <a href="{{ route('admin.blogs.index') }}" class="blogs-back-btn" id="cancel-btn">
                    <i class="fas fa-arrow-right"></i>
                    رجوع
                </a>
                <div class="d-flex gap-2">
                    <button type="button" class="blogs-draft-btn" onclick="saveAsDraft(event)">
                        <i class="fas fa-file-alt"></i>
                        حفظ كمسودة
                    </button>
                    <button type="submit" class="blogs-save-btn">
                        <i class="fas fa-paper-plane"></i>
                        تحديث المقال
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.umd.js"></script>
<script>
    const {
        ClassicEditor,
        Essentials,
        Paragraph,
        Bold,
        Italic,
        Underline,
        Strikethrough,
        Link,
        List,
        Table,
        TableToolbar,
        Image,
        ImageUpload,
        ImageCaption,
        ImageStyle,
        ImageToolbar,
        Heading,
        BlockQuote,
        Alignment,
        FontSize,
        FontColor,
        Highlight,
        CodeBlock,
        HtmlEmbed,
        SimpleUploadAdapter
    } = window.CKEDITOR;

    let editor;

    ClassicEditor
        .create(document.getElementById('editor'), {
            plugins: [Essentials, Paragraph, Bold, Italic, Underline, Strikethrough, Link, List, Table, TableToolbar, Image, ImageUpload, ImageCaption, ImageStyle, ImageToolbar, Heading, BlockQuote, Alignment, FontSize, FontColor, Highlight, CodeBlock, HtmlEmbed, SimpleUploadAdapter],
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'underline', 'strikethrough', '|',
                    'fontSize', 'fontColor', 'highlight', '|',
                    'alignment', '|',
                    'bulletedList', 'numberedList', '|',
                    'link', 'imageUpload', 'insertTable', 'blockQuote', 'codeBlock', 'htmlEmbed', '|',
                    'undo', 'redo'
                ]
            },
            table: {
                contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
            },
            image: {
                upload: {
                    types: ['jpeg', 'png', 'gif', 'bmp', 'webp', 'tiff']
                },
                toolbar: ['imageTextAlternative', 'imageStyle:inline', 'imageStyle:block', 'imageStyle:side']
            },
            simpleUpload: {
                uploadUrl: '{{ route("admin.blogs.upload-image") }}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            language: 'ar'
        })
        .then(newEditor => {
            editor = newEditor;
        })
        .catch(error => {
            console.error(error);
        });

    function previewFeaturedImage(input) {
        const previewContainer = document.querySelector('.featured-image-preview');
        const img = previewContainer ? previewContainer.querySelector('img') : null;

        if (!previewContainer || !img) return;

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                previewContainer.classList.remove('d-none');
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            previewContainer.classList.add('d-none');
        }
    }

    function previewGalleryImages(input) {
        const previewContainer = document.getElementById('gallery-preview');
        previewContainer.innerHTML = '';

        if (input.files && input.files.length > 0) {
            for (let i = 0; i < input.files.length; i++) {
                const file = input.files[i];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const galleryItem = document.createElement('div');
                    galleryItem.className = 'gallery-item';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = 'Gallery image ' + (i + 1);

                    const removeBtn = document.createElement('button');
                    removeBtn.className = 'gallery-remove';
                    removeBtn.innerHTML = '×';
                    removeBtn.type = 'button';

                    galleryItem.appendChild(img);
                    galleryItem.appendChild(removeBtn);

                    const altInput = document.createElement('input');
                    altInput.type = 'text';
                    altInput.name = 'image_alts[]';
                    altInput.className = 'gallery-alt form-control form-control-sm mt-2';
                    altInput.placeholder = 'نص بديل (Alt Text) - للسيو وإمكانية الوصول';

                    const captionInput = document.createElement('input');
                    captionInput.type = 'text';
                    captionInput.name = 'image_captions[]';
                    captionInput.className = 'gallery-caption form-control form-control-sm mt-2';
                    captionInput.placeholder = 'وصف الصورة (Caption)';

                    const galleryItemContainer = document.createElement('div');
                    galleryItemContainer.className = 'gallery-item-container';
                    galleryItemContainer.appendChild(galleryItem);
                    galleryItemContainer.appendChild(altInput);
                    galleryItemContainer.appendChild(captionInput);

                    previewContainer.appendChild(galleryItemContainer);
                };

                reader.readAsDataURL(file);
            }
        }
    }

    function markForDeletion(imageId) {
        const container = document.querySelector(`.gallery-item-container[data-id="${imageId}"] .gallery-item`);
        container.classList.toggle('marked-for-delete');

        let deletionField = document.getElementById(`delete_image_${imageId}`);

        if (!deletionField) {
            deletionField = document.createElement('input');
            deletionField.type = 'hidden';
            deletionField.name = 'images_to_delete[]';
            deletionField.value = imageId;
            deletionField.id = `delete_image_${imageId}`;
            document.getElementById('marked-for-deletion').appendChild(deletionField);
        } else {
            deletionField.remove();
        }
    }

    function generateSlug() {
        const title = document.getElementById('title').value;
        const slug = title
            .trim()
            .replace(/\s+/g, '-')           // استبدال المسافات بشرطات
            .replace(/[^\u0600-\u06FFa-zA-Z0-9\-_]/g, '')  // السماح بالعربي والإنجليزي والأرقام والشرطات
            .replace(/\-+/g, '-')           // إزالة الشرطات المتكررة
            .replace(/^-+|-+$/g, '');       // إزالة الشرطات من البداية والنهاية
        document.getElementById('slug').value = slug;
    }

    function togglePublishDateField() {
        const publishDateGroup = document.getElementById('publish_date_group');
        const isPublished = document.getElementById('is_published').checked;
        if (isPublished) {
            publishDateGroup.classList.add('d-none');
        } else {
            publishDateGroup.classList.remove('d-none');
        }
    }

    function toggleExternalArticle() {
        const isExternal = document.getElementById('is_external').checked;
        const externalUrlGroup = document.getElementById('external_url_group');
        const externalUrlInput = document.getElementById('external_url');

        if (isExternal) {
            externalUrlGroup.classList.remove('d-none');
            externalUrlInput.setAttribute('required', 'required');
        } else {
            externalUrlGroup.classList.add('d-none');
            externalUrlInput.removeAttribute('required');
        }
    }

    function saveAsDraft(e) {
        e.preventDefault();
        const form = document.getElementById('postForm');
        const draftInput = document.createElement('input');
        draftInput.type = 'hidden';
        draftInput.name = 'save_as_draft';
        draftInput.value = '1';
        form.appendChild(draftInput);

        const publishCheckbox = document.getElementById('is_published');
        if (publishCheckbox) publishCheckbox.checked = false;
        togglePublishDateField();

        form.submit();
    }

    // ===== Tag Input Functions =====
    function addTagChip(container, value) {
        value = value.trim();
        if (!value) return;
        var chipsArea = container.querySelector('.tag-chips-area');
        var existing = chipsArea.querySelectorAll('.tag-chip-text');
        for (var i = 0; i < existing.length; i++) {
            if (existing[i].textContent.trim() === value) return;
        }
        var chip = document.createElement('span');
        chip.className = 'tag-chip';
        var text = document.createElement('span');
        text.className = 'tag-chip-text';
        text.textContent = value;
        var removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'tag-chip-remove';
        removeBtn.innerHTML = '<i class="fas fa-times"></i>';
        removeBtn.addEventListener('click', function() {
            chip.style.transform = 'scale(0.8)';
            chip.style.opacity = '0';
            chip.style.transition = 'all 0.2s ease';
            setTimeout(function() {
                chip.remove();
                syncTagInput(container);
            }, 200);
        });
        chip.appendChild(text);
        chip.appendChild(removeBtn);
        chipsArea.appendChild(chip);
        syncTagInput(container);
    }

    function syncTagInput(container) {
        var targetId = container.dataset.target;
        var chips = container.querySelectorAll('.tag-chip-text');
        var values = [];
        chips.forEach(function(chip) {
            if (chip.textContent.trim()) values.push(chip.textContent.trim());
        });
        document.getElementById(targetId).value = values.join(',');
    }

    function initTagInput(containerId, initialValue) {
        var container = document.getElementById(containerId);
        var input = container.querySelector('.tag-input-field');
        if (initialValue && initialValue.trim()) {
            var values = initialValue.split(',').map(function(v) { return v.trim(); }).filter(function(v) { return v; });
            values.forEach(function(val) { addTagChip(container, val); });
        }
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ',') {
                e.preventDefault();
                var val = input.value.replace(/,/g, '').trim();
                if (val) {
                    addTagChip(container, val);
                    input.value = '';
                }
            }
            if (e.key === 'Backspace' && !input.value) {
                var chips = container.querySelectorAll('.tag-chip');
                if (chips.length > 0) {
                    var lastChip = chips[chips.length - 1];
                    lastChip.remove();
                    syncTagInput(container);
                }
            }
        });
        input.addEventListener('paste', function(e) {
            e.preventDefault();
            var pasteData = (e.clipboardData || window.clipboardData).getData('text');
            var values = pasteData.split(',').map(function(v) { return v.trim(); }).filter(function(v) { return v; });
            values.forEach(function(val) { addTagChip(container, val); });
        });
        input.addEventListener('blur', function() {
            var val = input.value.replace(/,/g, '').trim();
            if (val) {
                addTagChip(container, val);
                input.value = '';
            }
        });
    }

    const blogTempMediaConfig = {
        csrfToken: '{{ csrf_token() }}',
        uploadUrl: '{{ route("admin.blogs.upload-temp-media") }}',
        removeUrl: '{{ route("admin.blogs.remove-temp-media") }}',
        clearUrl: '{{ route("admin.blogs.clear-temp-images") }}'
    };

    function setFeaturedImagePreview(url) {
        document.querySelectorAll('.featured-image-preview').forEach(function(previewContainer) {
            var preview = previewContainer.querySelector('img');
            if (!preview) {
                return;
            }

            if (url) {
                preview.src = url;
                previewContainer.classList.remove('d-none');
            } else {
                preview.src = '';
                previewContainer.classList.add('d-none');
            }
        });
    }

    async function uploadTempBlogMedia(file, type) {
        var formData = new FormData();
        formData.append('image', file);
        formData.append('type', type);

        var response = await fetch(blogTempMediaConfig.uploadUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': blogTempMediaConfig.csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        });

        var payload = await response.json();
        if (!response.ok) {
            throw new Error(payload.message || payload.error || 'تعذر رفع الصورة مؤقتًا.');
        }

        return payload;
    }

    async function removeTempBlogMedia(path) {
        if (!path) {
            return;
        }

        await fetch(blogTempMediaConfig.removeUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': blogTempMediaConfig.csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ path: path })
        });
    }

    previewFeaturedImage = async function(input) {
        if (!input.files || !input.files[0]) {
            return;
        }

        try {
            var hiddenInput = document.getElementById('temp_featured_image');
            var currentTempPath = hiddenInput.value;
            var uploaded = await uploadTempBlogMedia(input.files[0], 'featured');

            if (currentTempPath) {
                await removeTempBlogMedia(currentTempPath);
            }

            hiddenInput.value = uploaded.path;
            setFeaturedImagePreview(uploaded.url);
            input.value = '';
        } catch (error) {
            console.error(error);
            alert(error.message || 'حدث خطأ أثناء رفع الصورة.');
        }
    };

    function buildTempGalleryItem(path, url, altValue, captionValue) {
        var galleryItemContainer = document.createElement('div');
        galleryItemContainer.className = 'gallery-item-container temp-gallery-item';
        galleryItemContainer.dataset.tempPath = path;
        galleryItemContainer.innerHTML =
            '<div class="gallery-item">' +
                '<img src="' + url + '" alt="Temporary gallery image">' +
                '<button type="button" class="gallery-remove temp-gallery-remove" onclick="removeTempGalleryImage(this)">&times;</button>' +
            '</div>' +
            '<input type="hidden" name="temp_gallery_images[]" value="' + path + '">' +
            '<input type="text" name="image_alts[]" value="' + (altValue || '') + '" class="gallery-alt form-control form-control-sm mt-2" placeholder="نص بديل (Alt Text) - للسيو وإمكانية الوصول">' +
            '<input type="text" name="image_captions[]" value="' + (captionValue || '') + '" class="gallery-caption form-control form-control-sm mt-2" placeholder="وصف الصورة (Caption)">';

        return galleryItemContainer;
    }

    previewGalleryImages = async function(input) {
        var previewContainer = document.getElementById('gallery-preview');
        var files = Array.from(input.files || []);

        if (!files.length) {
            return;
        }

        for (const file of files) {
            try {
                var uploaded = await uploadTempBlogMedia(file, 'gallery');
                previewContainer.appendChild(buildTempGalleryItem(uploaded.path, uploaded.url, '', ''));
            } catch (error) {
                console.error(error);
                alert(error.message || 'حدث خطأ أثناء رفع صورة من المعرض.');
            }
        }

        input.value = '';
    };

    removeTempGalleryImage = async function(button) {
        var container = button.closest('.temp-gallery-item');
        if (!container) {
            return;
        }

        var path = container.dataset.tempPath;
        container.remove();

        if (path) {
            try {
                await removeTempBlogMedia(path);
            } catch (error) {
                console.error(error);
            }
        }
    };

    function collectAllTagValues() {
        document.querySelectorAll('.tag-input-container').forEach(function(container) {
            syncTagInput(container);
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        togglePublishDateField();
        toggleExternalArticle();

        // Initialize tag input fields
        initTagInput('meta_keywords_taginput', document.getElementById('meta_keywords_hidden').value);
        initTagInput('tags_taginput', document.getElementById('tags_hidden').value);
        initTagInput('blog_highlights_taginput', document.getElementById('blog_highlights_hidden').value);

        document.getElementById('postForm').addEventListener('submit', function(e) {
            if (editor) {
                document.getElementById('editor').value = editor.getData();
            }
            collectAllTagValues();
        });

        document.getElementById('cancel-btn').addEventListener('click', function() {
            fetch(blogTempMediaConfig.clearUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': blogTempMediaConfig.csrfToken
                }
            }).catch(error => console.error('Error clearing temporary images:', error));
        });
    });
</script>
@endsection
