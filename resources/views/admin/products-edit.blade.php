@extends('layouts.admin')

@section('title', 'Admin - Edit Product')

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
    .image-preview-item.existing {
        border-color: #28a745;
    }
    .image-preview-item.new {
        border-color: #ffc107;
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
    let maxImages = 10;
    let filesArray = [];
    let existingImages = @json($product->images->map(function($img) {
        return [
            'id' => $img->id,
            'path' => asset('storage/' . $img->path),
            'is_primary' => $img->is_primary
        ];
    }));
    let deletedImageIds = [];
    let primaryImageId = existingImages.find(img => img.is_primary)?.id || (existingImages.length > 0 ? existingImages[0].id : null);

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
        let currentTotal = existingImages.filter(img => !deletedImageIds.includes(img.id)).length + filesArray.length;
        let remainingSlots = maxImages - currentTotal;
        
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

        // Render existing images
        existingImages.forEach((img, index) => {
            if (deletedImageIds.includes(img.id)) return;
            
            let isPrimary = img.id == primaryImageId;
            let previewHtml = `
                <div class="image-preview-item existing" data-image-id="${img.id}" data-type="existing">
                    <img src="${img.path}" alt="Existing image">
                    <button type="button" class="remove-btn remove-existing" data-image-id="${img.id}" title="Remove image">
                        &times;
                    </button>
                    ${isPrimary ? '<span class="primary-badge">Primary</span>' : ''}
                </div>
            `;
            $('#imagePreviewContainer').append(previewHtml);
        });

        // Render new images
        filesArray.forEach((file, index) => {
            let reader = new FileReader();

            reader.onload = function (e) {
                let previewHtml = `
                    <div class="image-preview-item new" data-index="${index}" data-type="new">
                        <img src="${e.target.result}" alt="New image ${index + 1}">
                        <button type="button" class="remove-btn remove-new" data-index="${index}" title="Remove image">
                            &times;
                        </button>
                    </div>
                `;
                $('#imagePreviewContainer').append(previewHtml);
            };

            reader.readAsDataURL(file);
        });

        if (existingImages.filter(img => !deletedImageIds.includes(img.id)).length === 0 && filesArray.length === 0) {
            $('#imagePreviewContainer').html('<div class="col-12 text-center text-muted">No images</div>');
        }
    }

    function updateFileInput() {
        let dataTransfer = new DataTransfer();
        filesArray.forEach(file => dataTransfer.items.add(file));
        document.getElementById('imagesInput').files = dataTransfer.files;
    }

    function updateImageCount() {
        let existingCount = existingImages.filter(img => !deletedImageIds.includes(img.id)).length;
        let newCount = filesArray.length;
        let total = existingCount + newCount;
        let countHtml = `<strong>${total}</strong> image(s) total (${existingCount} existing, ${newCount} new)`;
        if (total > 0) {
            countHtml += ` (${maxImages - total} remaining)`;
        }
        $('.image-count').html(countHtml);
    }

    // Remove existing image
    $(document).on('click', '.remove-existing', function (e) {
        e.stopPropagation();
        let imageId = parseInt($(this).data('image-id'));
        
        if (confirm('Are you sure you want to remove this image?')) {
            deletedImageIds.push(imageId);
            
            // If this was primary, set first remaining as primary
            if (primaryImageId == imageId) {
                let remaining = existingImages.filter(img => !deletedImageIds.includes(img.id));
                primaryImageId = remaining.length > 0 ? remaining[0].id : null;
            }
            
            renderPreviews();
            updateImageCount();
        }
    });

    // Remove new image
    $(document).on('click', '.remove-new', function (e) {
        e.stopPropagation();
        let index = parseInt($(this).data('index'));
        
        filesArray.splice(index, 1);
        
        renderPreviews();
        updateFileInput();
        updateImageCount();
    });

    // Set primary image (click on preview)
    $(document).on('click', '.image-preview-item', function (e) {
        if ($(e.target).hasClass('remove-btn')) return;
        
        let imageId = $(this).data('image-id');
        if (imageId) {
            primaryImageId = imageId;
            renderPreviews();
        }
    });

    // Update hidden fields before form submit
    $('form').on('submit', function() {
        // Add deleted image IDs
        deletedImageIds.forEach(id => {
            $(this).append(`<input type="hidden" name="delete_images[]" value="${id}">`);
        });
        
        // Add primary image ID
        if (primaryImageId) {
            $(this).append(`<input type="hidden" name="primary_image_id" value="${primaryImageId}">`);
        }
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
        <h4 class="mb-0">Edit Product</h4>
        <a href="{{ route('admin.products.list', $product->category_id) }}" class="btn btn-secondary btn-sm">
          <i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Products
        </a>
      </div>

      <div class="card-body">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PATCH')

  
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Product Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name', $product->name) }}" required>
                @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Category <span class="text-danger">*</span></label>
                <select name="category_id" class="form-control form-control-lg @error('category_id') is-invalid @enderror" required>
                  <option value="">Select category</option>
                  @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                      {{ $cat->name }}
                    </option>
                  @endforeach
                </select>
                @error('category_id')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Description <span class="text-danger">*</span></label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                      rows="4" required>{{ old('description', $product->description) }}</textarea>
            @error('description')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Price <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text">{!! $site_settings->currency_symbol ?? '$' !!}</span>
                  <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" 
                         value="{{ old('price', $product->price) }}" min="0" required>
                  @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">

                <label class="form-label">Product Label</label>
    
<select name="product_label_id"
    class="form-control @error('product_label_id') is-invalid @enderror">

    <option value="">No Label</option>

    @foreach($labels as $label)
        <option value="{{ $label->id }}"
            {{ $product->label?->id === $label->id ? 'selected' : '' }}>
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

            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Available Sizes</label>
                @php
                    $productSizeIds = $product->sizes->pluck('id')->toArray();
                @endphp
                @foreach ($sizes as $size)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="sizes[]" value="{{ $size->id }}" id="size_{{ $size->id }}"
                            {{ (is_array(old('sizes')) ? in_array($size->id, old('sizes')) : in_array($size->id, $productSizeIds)) ? 'checked' : '' }}>
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
          </div>

          <div class="mb-3">
            <label class="form-label">Product Images</label>
            <div class="alert alert-info">
              <i class="fa fa-info-circle"></i> You can upload up to <strong>10 images</strong> total. Click on any image to set it as primary. Green border indicates existing images, yellow border indicates new images.
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
                <i class="fa fa-save" aria-hidden="true"></i> Update Product
            </button>
          </div>
        

        </form>
      </div>
    </div>

  </div>
  @include('partials.admin.footer')
</div>
@endsection
