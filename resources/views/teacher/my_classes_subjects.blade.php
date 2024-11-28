@extends('teacher.layouts.layouts')
@section('title', 'My Classes and Subjects')

@section('content')
    <div class="content-wrapper">
        <!-- Page Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>My Classes and Subjects</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('teacher.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Classes and Subjects</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Classes and Subjects Section -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @forelse ($classes as $class)
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">{{ $class->name }}</h3>
                                </div>
                                <div class="card-body">
                                    @if ($class->subjects->isNotEmpty())
                                        <ul class="list-group">
                                            @foreach ($class->subjects as $subject)
                                                <li class="list-group-item">{{ $subject->name }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p>No subjects assigned to this class.</p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="card">
                                <div class="card-body">
                                    <p>No classes assigned to you.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
