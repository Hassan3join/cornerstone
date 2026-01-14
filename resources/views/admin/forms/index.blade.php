@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold">My Forms</h4>
    <a href="{{ route('admin.forms.create') }}" class="btn btn-primary rounded-pill">
        <i class="bi bi-plus-lg"></i> Create New Form
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4">Form Name</th>
                    <th>Created At</th>
                    <th>Embed Code (Copy this)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($forms as $form)
                <tr>
                    <td class="ps-4 fw-bold">{{ $form->name }}</td>
                    <td>{{ $form->created_at->format('M d, Y') }}</td>
                    <td>
                        <code class="bg-dark text-white px-2 py-1 rounded">
                            &lt;x-dynamic-form form-id="{{ $form->id }}" /&gt;
                        </code>
                    </td>
                    <td>
                        <a href="{{ route('admin.forms.edit', $form->id) }}" class="btn btn-sm btn-outline-dark">Edit</a>
                        <a class="btn btn-sm btn-outline-danger">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection