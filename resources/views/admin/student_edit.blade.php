@extends('admin.layouts.layouts')
@section('title', 'Edit Student')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Student</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('student.index') }}">Student List</a></li>
                            <li class="breadcrumb-item active">Edit Student</li>
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
                                <h3 class="card-title">Edit Student</h3>
                            </div>
                            <form action="{{route('student.update', $student->id)}}" enctype="multipart/form-data" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card-body row">
                                    <div class="form-group col-md-4">
                                        <label for="name">FirstName</label>
                                        <input type="name" name="name" class="form-control" id="exampleInputEmail1"
                                            placeholder="Enter first name" value="{{ $student->name }}">
                                    </div>
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="form-group col-md-4">
                                        <label for="last_name">Last Name</label>
                                        <input type="name" name="last_name" class="form-control" id="exampleInputEmail1"
                                            placeholder="Enter last name" value="{{ $student->last_name }}">
                                    </div>
                                    @error('last_name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="form-group col-md-4">
                                        <label for="gender">Gender</label>
                                        <select name="gender" class="form-control">
                                            <option value="1" @if ($student->gender == 1) selected @endif>Male
                                            </option>
                                            <option value="0" @if ($student->gender == 0) selected @endif>Female
                                            </option>
                                        </select>
                                    </div>
                                    @error('gender')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="form-group col-md-4">
                                        <label for="dob">Date of Birth</label>
                                        <input type="date" name="dob" class="form-control" id="exampleInputEmail1"
                                            placeholder="Date of Birth"
                                            value="{{ $student->dob ? \Carbon\Carbon::parse($student->dob)->format('Y-m-d') : '' }}">
                                    </div>
                                    @error('dob')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="form-group col-md-4">
                                        <label for="religion">Religion</label>
                                        <input type="name" name="religion" class="form-control" id="exampleInputEmail1"
                                            placeholder="Enter religion" value="{{ $student->religion }}">
                                    </div>
                                    @error('religion')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="form-group col-md-4">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                            placeholder="Enter email" value="{{ $student->email }}">
                                    </div>
                                    @error('email')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="form-group col-md-4">
                                        <label for="phone">Phone Number</label>
                                        <input type="number" name="phone" class="form-control" id="exampleInputEmail1"
                                            placeholder="Enter phone number" value="{{ $student->phone }}">
                                    </div>
                                    @error('phone')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="form-group col-md-4">
                                        <label for="admission_date">Admission Date</label>
                                        <input type="date" name="admission_date" class="form-control" id="exampleInputEmail1"
                                            placeholder="Enter phone admission date" value="{{ $student->admission_date }}">
                                    </div>
                                    @error('admission_date')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="form-group col-md-4">
                                        <label for="acdemi_year_id">Academic Year</label>
                                        <select name="acdemi_year_id" class="form-control">
                                            <option value="" disabled selected>Select Academic Year</option>
                                            @foreach ($academi_years as $academi_year)
                                                <option value="{{ $academi_year->id }}"
                                                    @if ($student->acdemi_year_id == $academi_year->id) selected @endif>
                                                    {{ $academi_year->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('acdemi_year_id')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="form-group col-md-4">
                                        <label for="class_id">Class</label>
                                        <select name="class_id" class="form-control">
                                            <option value="" disabled>Select class</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}"
                                                    @if ($student->class_id == $class->id) selected @endif>
                                                    {{ $class->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('class_id')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="form-group col-md-4">
                                        <label for="status">Status</label>
                                        <select name="status" id="" class="form-control">
                                            <option value="Studying" @if ($student->status == 'Studying') selected @endif>
                                                Studying</option>
                                            <option value="Drop Out" @if ($student->status == 'Drop Out') selected @endif>Drop
                                                Out</option>
                                            <option value="Graduation" @if ($student->status == 'Graduation') selected @endif>
                                                Graduation</option>
                                        </select>
                                    </div>
                                    @error('status')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="form-group col-md-2">
                                        <label for="photo">Photo</label>
                                        <div class="custom-file">
                                            <!-- Hidden file input -->
                                            <input type="file" name="photo" class="custom-file-input" id="photoInput" onchange="previewImage(event)">
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
                                            src="{{ $student->photo ? asset('storage/' . $student->photo) : '#' }}"
                                            alt="Image Preview"
                                            style="display: {{ $student->photo ? 'block' : 'none' }}; 
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
