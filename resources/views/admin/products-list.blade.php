
@extends('layouts.admin')

@push('styles')
    <!-- base:css -->
    <link rel="stylesheet" href="/admin_resources/vendors/typicons.font/font/typicons.css">
    <link rel="stylesheet" href="/admin_resources/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="/admin_resources/css/vertical-layout-light/style.css">

@endpush

@push('scripts')
 
<script src="/admin_resources/vendors/js/vendor.bundle.base.js"></script>
<script src="/admin_resources/js/off-canvas.js"></script>
<script src="/admin_resources/js/hoverable-collapse.js"></script>
<script src="/admin_resources/js/template.js"></script>
<script src="/admin_resources/js/settings.js"></script>
<script src="/admin_resources/js/todolist.js"></script>
<!-- plugin js for this page -->
<script src="/admin_resources/vendors/progressbar.js/progressbar.min.js"></script>
<script src="/admin_resources/vendors/chart.js/Chart.min.js"></script>
<!-- Custom js for this page-->
<script src="/admin_resources/js/dashboard.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

 

<script>
    $(document).ready(function() {
        // Delete Modal
        $('.delete-btn').on('click', function() {
            let id = $(this).data('id');
            let actionUrl = "{{ route('admin.products.destroy', ':id') }}".replace(':id', id);

            $('#deleteForm').attr('action', actionUrl);
        });
        
        // Search functionality enhancements
        $('#search').on('keypress', function(e) {
            if (e.which === 13) { // Enter key
                $(this).closest('form').submit();
            }
        });
        
        // Auto-focus search field if search parameter exists
        @if(request()->filled('search'))
            $('#search').focus();
        @endif
    });
</script>
 

<script>
    $(document).ready(function() {
        // When a thumbnail image is clicked
        $('.trigger-lightbox').click(function() {
            // Get the image URL from the data-image attribute
            var imageUrl = $(this).data('image');
            
            // Set the source of the modal image to the clicked image's URL
            $('#modalImage').attr('src', imageUrl);
        });
    });
</script>

@endpush


@section('title', 'Admin - Product')




@section('content')

<div class="main-panel">
    <div class="content-wrapper">
 
      @include('partials.message-bag')

      <!-- Search Card -->
      <div class="card">
          <div class="card-body">



            <div class="row">
                <div class="col-md-6">
              <form method="GET" action="{{ $category ? route('admin.products.list', $category->id) : route('admin.products.list') }}">
                  <div class="form-group">
                      <label for="search" class="form-label">Search Products</label>
                      <div class="input-group" style="border-radius: 0.375rem; overflow: hidden;">
                          <input type="text" name="search" id="search" class="form-control form-control-sm" placeholder="Search by name or description..." value="{{ request('search') }}" style="border-right: 2px solid #dee2e6; border-radius: 0.375rem 0 0 0.375rem; height: 31px;">
                          <button type="submit" class="btn btn-primary btn-sm" style="border-radius: 0; border-left: 1px solid #0d6efd;">
                              <i class="fa fa-search"></i> Search
                          </button>
                          @if(request()->filled('search'))
                              <a href="{{ $category ? route('admin.products.list', $category->id) : route('admin.products.list') }}" class="btn btn-secondary btn-sm" style="border-radius: 0 0.375rem 0.375rem 0; border-left: 1px solid #6c757d;">
                                  <i class="fa fa-times"></i> Clear
                              </a>
                          @endif
                      </div>
                  </div>
              </form>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="categorySelect" class="form-label">Switch Category</label>
                        <select name="category" id="categorySelect" class="form-control form-control-sm" onchange="window.location.href = this.value ? '/admin/product/list/' + this.value : '/admin/product/list/';" style="height: 31px;">
                            <option value="">All Categories</option>
                            @if($categories)
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ ($category && $category->id == $cat->id) ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>






          </div>
      </div>

    <div class="card mt-2">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Products{{ $category ? ' - ' . $category->name : ' - All Categories' }} ({{ $products->total() }})</span>
            <button class="btn btn-primary btn-sm" onclick="window.location.href='{{ $category ? route('admin.products.create', $category->id) : route('admin.categories.index') }}'">
                <i class="fa fa-plus" aria-hidden="true"></i>
                Add Product
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width:20%">Name</th>
                            <th style="width:50%">Description</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td>
                                    <!-- Trigger for Lightbox Modal -->
                                    @php
                                        $productImage = $product->primaryImage ? asset('storage/' . $product->primaryImage->path) : (count($product->images) > 0 ? asset('storage/' . $product->images->first()->path) : '/assets/images/products/no-image.png');
                                    @endphp
                                    <img src="{{ $productImage }}" alt="Product Image" width="50" class="img-thumbnail trigger-lightbox" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="{{ $productImage }}">  {{ $product->name }}
                                </td>
                                <td>{{ $product->description }}</td>
                                <td>{!! $site_settings->currency_symbol !!}{{ $product->price }}</td>
                                <td>
                                    <button class="m-1 btn btn-primary btn-sm edit-btn" onclick="window.location.href='{{ route('admin.products.edit', $product->id) }}'">
                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                    </button>
                                    <button class="m-1 btn btn-danger btn-sm delete-btn" onclick="window.location.href='{{ route('admin.products.destroy', $product->id) }}'">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No products Found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            @if($products->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} entries
                        @if(request()->filled('search'))
                            <span class="badge badge-info ml-2">Search: "{{ request('search') }}"</span>
                        @endif
                    </div>
                    <div>
                        {{ $products->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            @endif
        </div>

        <div class="card-footer d-flex justify-content-between align-items-center">
            <button type="button" onclick="window.location.href='{{ route('admin.dashboard') }}'" class="btn btn-primary">Dashboard</button>

            <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('admin.categories.index') }}'">Back to Categories</button>
        </div>
    </div>
    
  


<!-- Lightbox Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Product Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="product image" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        @if($category)
        <form action="{{ route('admin.products.store', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <i class="fas fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control" id="description" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" step="0.01" name="price" class="form-control" id="price" required>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" name="image" class="form-control" id="image" required>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select name="category_id" class="form-control" id="category_id" required>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $cat->id == $category->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
        @else
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i> Please select a category first before adding a product.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('admin.categories.index') }}'">Select Category</button>
            </div>
        </div>
        @endif
    </div>
</div>

 
<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <i class="fas fa-times"></i></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this product?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>

   
    </div>
    <!-- content-wrapper ends -->
    @include('partials.admin.footer')
  </div>
  <!-- main-panel ends -->
@endsection



 