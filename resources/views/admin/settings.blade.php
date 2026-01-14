@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card-custom p-4">
            <h5 class="mb-4 fw-bold">System Configuration</h5>
            <form>
                <div class="mb-3">
                    <label class="form-label">Default Interest Rate (%)</label>
                    <input type="number" class="form-control" value="12.5">
                </div>
                <div class="mb-3">
                    <label class="form-label">Auto-Reject Credit Score Below</label>
                    <input type="number" class="form-control" value="500">
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" checked>
                    <label class="form-check-label">Enable Email Notifications</label>
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
    </div>
</div>
@endsection