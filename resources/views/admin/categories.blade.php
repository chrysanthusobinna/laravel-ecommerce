@extends('layouts.admin')

@push('styles')
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
<script src="/admin_resources/vendors/progressbar.js/progressbar.min.js"></script>
<script src="/admin_resources/vendors/chart.js/Chart.min.js"></script>
<script src="/admin_resources/js/dashboard.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function () {
  $('.edit-btn').on('click', function () {
    let categoryId = $(this).data('id');
    let categoryName = $(this).data('name');
    let categoryImage = $(this).data('image');

    $('#editName').val(categoryName);

    let actionUrl = "{{ route('admin.categories.update', ':id') }}".replace(':id', categoryId);
    $('#editForm').attr('action', actionUrl);

    if (categoryImage) {
      $('#editImagePreview').attr('src', categoryImage).removeClass('d-none');
    } else {
      $('#editImagePreview').attr('src', '').addClass('d-none');
    }

    $('#editImage').val('');
  });

  $('.delete-btn').on('click', function() {
    let id = $(this).data('id');
    let name = $(this).data('name');
    let actionUrl = "{{ route('admin.categories.destroy', ':id') }}".replace(':id', id);
    $('#deleteForm').attr('action', actionUrl);
    $('#deleteCategoryName').text(name);
  });

  $('#createImage').on('change', function(e){
    const file = e.target.files && e.target.files[0];
    if (!file) { $('#createImagePreview').attr('src','').addClass('d-none'); return; }
    const url = URL.createObjectURL(file);
    $('#createImagePreview').attr('src', url).removeClass('d-none');
  });

  $('#editImage').on('change', function(e){
    const file = e.target.files && e.target.files[0];
    if (!file) { return; }
    const url = URL.createObjectURL(file);
    $('#editImagePreview').attr('src', url).removeClass('d-none');
  });
});
</script>
@endpush

@section('title', 'Admin - Settings - Categories')

@section('content')
<div class="main-panel">
  <div class="content-wrapper">
    @include('partials.message-bag')

    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <span>Categories ({{ $categories->count() }})</span>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">Add New Category</button>
      </div>
      <div class="card-body">
        <table class="table">
          <thead>
            <tr>
              <th style="width:55%;">Name</th>
              <th style="width:25%;">Image</th>
              <th style="width:20%;">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($categories as $category)
              <tr>
                <td><i class="typcn typcn-th-large mr-0"></i> <a class="text-decoration-none text-dark" href="{{ route('admin.products.list', $category->id) }}">{{ $category->name }}</a></td>
                <td>
                  @if(!empty($category->image))
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" style="width:50px;height:50px;object-fit:cover;border-radius:8px;">
                  @else
                    <span class="text-muted">No image</span>
                  @endif
                </td>
                <td>
                  <button class="m-2 btn btn-success btn-sm edit-btn"
                          data-id="{{ $category->id }}"
                          data-name="{{ $category->name }}"
                          data-image="{{ !empty($category->image) ? asset('storage/' . $category->image) : '' }}"
                          data-bs-toggle="modal"
                          data-bs-target="#editModal"><i class="fa fa-edit"></i></button>

                  <button class="m-2 btn btn-danger btn-sm delete-btn"
                          data-id="{{ $category->id }}"
                          data-name="{{ $category->name }}"
                          data-bs-toggle="modal"
                          data-bs-target="#deleteModal"><i class="fa fa-trash"></i></button>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="3" class="text-center">No categories available.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
          @csrf
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="createModalLabel">Add New Category</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="name">Category Name</label>
                <input type="text" name="name" class="form-control" id="name" required>
              </div>
              <div class="form-group mt-3">
                <label for="createImage">Category Image</label>
                <input type="file" name="image" class="form-control" id="createImage" accept="image/*">
                <img id="createImagePreview" class="d-none mt-2" src="" style="width:80px;height:80px;object-fit:cover;border-radius:10px;">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Create</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="POST" id="editForm" enctype="multipart/form-data">
          @csrf
           <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editModalLabel">Edit Category</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="editName">Category Name</label>
                <input type="text" name="name" class="form-control" id="editName" required>
              </div>
              <div class="form-group mt-3">
                <label for="editImage">Category Image</label>
                <input type="file" name="image" class="form-control" id="editImage" accept="image/*">
                <img id="editImagePreview" class="d-none mt-2" src="" style="width:80px;height:80px;object-fit:cover;border-radius:10px;">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="POST" id="deleteForm">
          @csrf
          @method('DELETE')
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="deleteModalLabel">Delete Category</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
              <p>Are you sure you want to delete <strong id="deleteCategoryName"></strong>?</p>
              <p class="text-warning">Warning: Deleting this category will also delete all related Products and orders. This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-danger">Delete</button>
            </div>
          </div>
        </form>
      </div>
    </div>

  </div>
  @include('partials.admin.footer')
</div>
@endsection
