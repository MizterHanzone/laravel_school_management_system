@extends('admin.layouts.layouts')
@section('title', 'Edit Teacher')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add Teacher</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('teacher.index') }}">Teacher List</a></li>
                            <li class="breadcrumb-item active">Edit Teacher</li>
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
                                <h3 class="card-title">Edit Teacher</h3>
                            </div>
                            <form action="{{ route('teacher.update', $teacher->id) }}" enctype="multipart/form-data" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card-body row">
                                    <div class="form-group col-md-4">
                                        <label for="name">FirstName</label>
                                        <input type="name" name="name" class="form-control" id="exampleInputEmail1"
                                            placeholder="Enter first name" value="{{ $teacher->name }}">
                                    </div>
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="form-group col-md-4">
                                        <label for="last_name">Last Name</label>
                                        <input type="name" name="last_name" class="form-control" id="exampleInputEmail1"
                                            placeholder="Enter last name" value="{{ $teacher->last_name }}">
                                    </div>
                                    @error('last_name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="form-group col-md-4">
                                        <label for="gender">Gender</label>
                                        <select name="gender" id="" class="form-control">
                                            <option value="1" @if ($teacher->gender == 1) selected @endif>Male</option>
                                            <option value="0" @if ($teacher->gender == 0) selected @endif>Female</option>
                                        </select>
                                    </div>
                                    @error('gender')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="form-group col-md-4">
                                        <label for="dob">Date of Birth</label>
                                        <input type="date" name="dob" class="form-control" id="exampleInputEmail1"
                                            placeholder="Date of Birth" value="{{ $teacher->dob ? \Carbon\Carbon::parse($teacher->dob)->format('Y-m-d') : '' }}">
                                    </div>
                                    @error('dob')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="form-group col-md-4">
                                        <label for="religion">Religion</label>
                                        <input type="name" name="religion" class="form-control" id="exampleInputEmail1"
                                            placeholder="Enter religion" value="{{ $teacher->religion }}">
                                    </div>
                                    @error('religion')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="form-group col-md-4">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                            placeholder="Enter email" value="{{ $teacher->email }}">
                                    </div>
                                    @error('email')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="form-group col-md-4">
                                        <label for="phone">Phone Number</label>
                                        <input type="number" name="phone" class="form-control" id="exampleInputEmail1"
                                            placeholder="Enter phone number" value="{{ $teacher->phone }}">
                                    </div>
                                    @error('phone')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="form-group col-md-4">
                                        <label for="date_of_join">Date Join</label>
                                        <input type="date" name="date_of_join" class="form-control" id="exampleInputEmail1"
                                            placeholder="Date of Birth" value="{{ $teacher->dob ? \Carbon\Carbon::parse($teacher->date_of_join)->format('Y-m-d') : '' }}">
                                    </div>
                                    @error('date_of_join')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="form-group col-md-4">
                                        <label for="marital_status">Marital Status</label>
                                        <select name="marital_status" id="" class="form-control">
                                            <option value="" disabled selected>Select Status</option>
                                            <option value="single" @if ($teacher->marital_status == 'single') selected @endif>Single</option>
                                            <option value="married" @if ($teacher->marital_status == 'married') selected @endif>Married</option>
                                            <option value="divorced" @if ($teacher->marital_status == 'divorced') selected @endif>Divorced</option>
                                            <option value="widowed" @if ($teacher->marital_status == 'widowed') selected @endif>Widowed</option>
                                        </select>
                                    </div>
                                    @error('marital_status')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="form-group col-md-4">
                                        <label for="current_address">Current Address</label>
                                        <input type="name" name="current_address" class="form-control" id="exampleInputEmail1"
                                            placeholder="Enter curren address" value="{{ $teacher->current_address }}">
                                    </div>
                                    @error('current_address')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="form-group col-md-4">
                                        <label for="qualification">Qualification</label>
                                        <input type="name" name="qualification" class="form-control" id="exampleInputEmail1"
                                            placeholder="Enter qualification" value="{{ $teacher->qualification }}">
                                    </div>
                                    @error('qualification')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="form-group col-md-4">
                                        <label for="experience">Experience</label>
                                        <input type="name" name="experience" class="form-control" id="exampleInputEmail1"
                                            placeholder="Enter experience" value="{{ $teacher->experience }}">
                                    </div>
                                    @error('experience')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="form-group col-md-4">
                                        <label for="teacher_status">Status</label>
                                        <select name="teacher_status" id="" class="form-control">
                                            <option value="1" @if ($teacher->teacher_status == 1) selected @endif>Active</option>
                                            <option value="0" @if ($teacher->teacher_status == 0) selected @endif>Inactive</option>
                                        </select>
                                    </div>
                                    @error('status')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="form-group col-md-2">
                                        <label for="photo">Photo</label>
                                        <div class="custom-file">
                                            <!-- Hidden file input -->
                                            <input 
                                                type="file" 
                                                name="photo" 
                                                class="custom-file-input" 
                                                id="photoInput" 
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
                                            src="{{ $teacher->photo ? asset('storage/' . $teacher->photo) : '#' }}"
                                            alt="Image Preview"
                                            style="display: {{ $teacher->photo ? 'block' : 'none' }}; 
                                                    width: 100px; 
                                                    height: 100px; 
                                                    object-fit: cover; 
                                                    border: 1px solid #ddd; 
                                                    border-radius: 5px;">
                                    </div>                                   
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
