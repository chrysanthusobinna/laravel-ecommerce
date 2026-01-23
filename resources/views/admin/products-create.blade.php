@extends('layouts.admin')

@section('title', 'Admin - Create Product')

@push('styles')
<link rel="stylesheet" href="/admin_resources/vendors/typicons.font/font/typicons.css">
<link rel="stylesheet" href="/admin_resources/vendors/css/vendor.bundle.base.css">
<link rel="stylesheet" href="/admin_resources/css/vertical-layout-light/style.css">
<style>
    .image-preview-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 15px;
        margin-top: 15px;
    }
    .image-preview-item {
        position: relative;
        border: 2px solid #dee2e6;
        border-radius: 8px;
        overflow: hidden;
        background: #f8f9fa;
    }
    .image-preview-item img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        display: block;
    }
    .image-preview-item .remove-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(220, 53, 69, 0.9);
        color: white;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        transition: all 0.3s;
    }
    .image-preview-item .remove-btn:hover {
        background: rgba(220, 53, 69, 1);
        transform: scale(1.1);
    }
    .image-preview-item .primary-badge {
        position: absolute;
        bottom: 5px;
        left: 5px;
        background: rgba(0, 123, 255, 0.9);
        color: white;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: bold;
    }
    .upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 40px;
        text-align: center;
        background: #f8f9fa;
        cursor: pointer;
        transition: all 0.3s;
    }
    .upload-area:hover {
        border-color: #007bff;
        background: #e7f3ff;
    }
    .upload-area.dragover {
        border-color: #007bff;
        background: #cfe2ff;
    }
    .image-count {
        margin-top: 10px;
        color: #6c757d;
        font-size: 14px;
    }
    .image-count strong {
        color: #007bff;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    let maxImages = 4;
    let filesArray = [];
    let primaryIndex = 0;

    // File input change
    $('#imagesInput').on('change', function (e) {
        handleFiles(Array.from(e.target.files));
    });

    // Drag and drop
    let uploadArea = $('#uploadArea');
    
    uploadArea.on('dragover', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).addClass('dragover');
    });

    uploadArea.on('dragleave', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('dragover');
    });

    uploadArea.on('drop', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('dragover');
        
        let files = Array.from(e.originalEvent.dataTransfer.files);
        handleFiles(files);
    });

    uploadArea.on('click', function () {
        $('#imagesInput').click();
    });

    function handleFiles(files) {
        let remainingSlots = maxImages - filesArray.length;
        
        if (remainingSlots <= 0) {
            alert('You can upload a maximum of ' + maxImages + ' images.');
            return;
        }

        let filesToAdd = files.slice(0, remainingSlots);
        
        filesToAdd.forEach(file => {
            if (file.type.startsWith('image/')) {
                filesArray.push(file);
            }
        });

        if (files.length > remainingSlots) {
            alert('Only ' + remainingSlots + ' more image(s) can be added. Maximum is ' + maxImages + ' images.');
        }

        renderPreviews();
        updateFileInput();
        updateImageCount();
    }

    function renderPreviews() {
        $('#imagePreviewContainer').html('');

        if (filesArray.length === 0) {
            $('#imagePreviewContainer').html('<div class="col-12 text-center text-muted">No images selected</div>');
            return;
        }

        filesArray.forEach((file, index) => {
            let reader = new FileReader();

            reader.onload = function (e) {
                let isPrimary = index === primaryIndex;
                let previewHtml = `
                    <div class="image-preview-item" data-index="${index}">
                        <img src="${e.target.result}" alt="Preview ${index + 1}">
                        <button type="button" class="remove-btn" data-index="${index}" title="Remove image">
                            &times;
                        </button>
                        ${isPrimary ? '<span class="primary-badge">Primary</span>' : ''}
                    </div>
                `;
                $('#imagePreviewContainer').append(previewHtml);
            };

            reader.readAsDataURL(file);
        });
    }

    function updateFileInput() {
        let dataTransfer = new DataTransfer();
        filesArray.forEach(file => dataTransfer.items.add(file));
        document.getElementById('imagesInput').files = dataTransfer.files;
    }

    function updateImageCount() {
        let count = filesArray.length;
        let countHtml = `<strong>${count}</strong> image(s) selected`;
        if (count > 0) {
            countHtml += ` (${maxImages - count} remaining)`;
        }
        $('.image-count').html(countHtml);
    }

    // Remove image
    $(document).on('click', '.remove-btn', function (e) {
        e.stopPropagation();
        let index = parseInt($(this).data('index'));
        
        filesArray.splice(index, 1);
        
        // Adjust primary index if needed
        if (primaryIndex >= filesArray.length && filesArray.length > 0) {
            primaryIndex = 0;
        } else if (primaryIndex > index) {
            primaryIndex--;
        }
        
        renderPreviews();
        updateFileInput();
        updateImageCount();
    });

    // Set primary image (click on preview)
    $(document).on('click', '.image-preview-item', function (e) {
        if ($(e.target).hasClass('remove-btn')) return;
        
        let index = parseInt($(this).data('index'));
        primaryIndex = index;
        renderPreviews();
    });

    // Initialize
    updateImageCount();
    renderPreviews();
});
</script>
@endpush

@section('content')
<div class="main-panel">
  <div class="content-wrapper">

    @include('partials.message-bag')

    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Create Product</h4>
        <a href="{{ route('admin.products.list', $category->id) }}" class="btn btn-secondary btn-sm">
          <i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Products
        </a>
      </div>

      <div class="card-body">
        <form action="{{ route('admin.products.store', $category->id) }}" method="POST" enctype="multipart/form-data">
          @csrf

          @if ($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Category <span class="text-danger">*</span></label>
                <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                  <option value="">Select category</option>
                  @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $category->id) == $cat->id ? 'selected' : '' }}>
                      {{ $cat->name }}
                    </option>
                  @endforeach
                </select>
                @error('category_id')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Description <span class="text-danger">*</span></label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                          rows="4" required>{{ old('description') }}</textarea>
                @error('description')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Price <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text">{!! $site_settings->currency_symbol ?? '$' !!}</span>
                  <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" 
                        value="{{ old('price') }}" min="0" required>
                  @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Available Sizes</label>
                @foreach ($sizes as $size)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="sizes[]" value="{{ $size->id }}" id="size_{{ $size->id }}"
                            {{ (is_array(old('sizes')) && in_array($size->id, old('sizes'))) ? 'checked' : '' }}>
                        <label class="form-check-label" for="size_{{ $size->id }}">
                            {{ $size->name }} ({{ $size->short_name }})
                        </label>
                    </div>
                @endforeach
                <small class="form-text text-muted">Leave all unchecked if product does not have size variations.</small>
                @error('sizes.*')
                    <div class="text-danger mt-1" style="font-size: 14px;">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Product Label</label>
                <select name="product_label_id" class="form-control @error('product_label_id') is-invalid @enderror">
                    <option value="">Select a label (optional)</option>
                    @foreach ($labels as $label)
                        <option value="{{ $label->id }}" {{ old('product_label_id') == $label->id ? 'selected' : '' }}>
                            {{ $label->name }}
                        </option>
                    @endforeach
                </select>
                <small class="form-text text-muted">Leave unselected if no label needed.</small>
                @error('product_label_id')
                  <div class="text-danger mt-1" style="font-size: 14px;">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Product Images <span class="text-danger">*</span></label>
            <div class="alert alert-info">
              <i class="fa fa-info-circle"></i> You can upload up to <strong>4 images</strong>. The first image will be set as the primary image. Click on any image to set it as primary.
            </div>
            
            <div id="uploadArea" class="upload-area">
              <i class="fa fa-cloud-upload" style="font-size: 48px; color: #6c757d; margin-bottom: 10px;"></i>
              <p class="mb-1"><strong>Click to upload</strong> or drag and drop</p>
              <p class="text-muted mb-0" style="font-size: 12px;">PNG, JPG, GIF up to 2MB each</p>
            </div>
            
            <input type="file" name="images[]" id="imagesInput" class="d-none" multiple accept="image/*">
            
            <div class="image-count"></div>
            
            @error('images')
              <div class="text-danger mt-1" style="font-size: 14px;">{{ $message }}</div>
            @enderror
            @error('images.*')
              <div class="text-danger mt-1" style="font-size: 14px;">{{ $message }}</div>
            @enderror

            <div id="imagePreviewContainer" class="image-preview-container"></div>
          </div>
          <hr class="my-4">
          <div class="d-flex justify-content-end mt-4">

  
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save" aria-hidden="true"></i> Create Product
            </button>
          </div>
        
        

        </form>
      </div>
    </div>

  </div>
  @include('partials.admin.footer')
</div>
@endsection
