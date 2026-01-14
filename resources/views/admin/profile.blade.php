@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card-custom p-4 text-center">
            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width:80px; height:80px; font-size:2rem;">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <h5 class="fw-bold">{{ Auth::user()->name }}</h5>
            <p class="text-muted">Super Administrator</p>
            <span class="badge bg-success">Active Status</span>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card-custom p-4">
            <h5 class="mb-3">Edit Profile Details</h5>
            <form method="POST" action="{{ route('admin.profile.update', 1) }}">
                @csrf
                @method('patch')
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}">
                </div>
                <button class="btn btn-dark" type="submit">Update Profile</button>
            </form>
        </div>
    </div>
</div>
@endsection