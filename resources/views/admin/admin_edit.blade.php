@extends('admin.layouts.layouts')
@section('title', 'Admin Edit')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Admin</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('admin.list') }}">Admin List</a></li>
                            <li class="breadcrumb-item active">Edit Admin</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Edit Admin</h3>
                            </div>
                            <form action="{{route('admin.update', $admin->id)}}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name</label>
                                        <input type="name" name="name" class="form-control" id="exampleInputEmail1"
                                            placeholder="Enter name" value="{{$admin->name}}">
                                    </div>
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                            placeholder="Enter email" value="{{$admin->email}}">
                                    </div>
                                    @error('email')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="form-group col-md-2">
                                        <label for="photo">Photo</label>
                                        <div class="custom-file">
                                            <!-- Hidden file input -->
                                            <input type="file" name="photo" class="custom-file-input" id="photoInput"
                                                onchange="previewImage(event)">
                                            <!-- Custom label acting as a button -->
                                            <label class="custom-file-label" for="photoInput">
                                                <i class="fas fa-camera"></i> Upload
                                            </label>
                                        </div>
                                        @error('photo')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <!-- Image preview -->
                                    <div class="form-group col-md-2">
                                        <img id="photoPreview"
                                            src="{{ $admin->photo ? asset('storage/' . $admin->photo) : '#' }}"
                                            alt="Image Preview"
                                            style="display: {{ $admin->photo ? 'block' : 'none' }}; 
                                                    width: 100px; 
                                                    height: 100px; 
                                                    object-fit: cover; 
                                                    border: 1px solid #ddd; 
                                                    border-radius: 5px;">
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            const image = document.getElementById('photoPreview');
            image.src = e.target.result; // Set image preview
            image.style.display = 'block'; // Show the image element
        };

        if (file) {
            reader.readAsDataURL(file); // Read the selected file
        }
    }
</script>