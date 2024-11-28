@extends('student.layouts.layouts')
@section('title', 'My Subject')

@section('content')
    <div class="content-wrapper">
        <!-- Page Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Your Subject</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Subject</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Subjects Section -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Subjects</h3>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    @forelse ($subjects as $subject)
                                        <li class="list-group-item">{{ $subject->name }}</li>
                                    @empty
                                        <li class="list-group-item">No subjects available for your class.</li>
                                    @endforelse
                                </ul>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
