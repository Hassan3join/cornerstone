@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark">Question Bank</h3>
        <p class="text-muted small">Manage the questions available for your forms.</p>
    </div>
    
    <div class="d-flex gap-2">
        <button class="btn btn-success rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#importModal">
            <i class="bi bi-file-earmark-arrow-up me-1"></i> Import File
        </button>
        <a href="{{ route('admin.questions.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-plus-lg me-1"></i> Create New Question
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4 py-3">Question Title</th>
                    <th>Type</th>
                    <th>Settings</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($questions as $q)
                <tr>
                    <td class="ps-4">
                        <span class="fw-bold text-dark">{{ $q->title }}</span>
                    </td>
                    <td>
                        @if($q->type == 'text')
                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary">Text Input</span>
                        @elseif($q->type == 'radio')
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary">Single Choice</span>
                        @elseif($q->type == 'checkbox')
                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning">Multiple Choice</span>
                        @endif
                    </td>
                    <td>
                        @if($q->type == 'text')
                            <small class="text-muted">Points: <strong>{{ $q->score }}</strong></small>
                        @else
                            <small class="text-muted">{{ $q->options->count() }} Options defined</small>
                        @endif
                    </td>
                    <td class="text-end pe-4">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.questions.edit', $q->id) }}" class="btn btn-sm btn-light border text-dark" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="{{ route('admin.questions.destroy', $q->id) }}" method="POST" onsubmit="return confirm('Are you sure? This cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light border text-danger" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        No questions found. Add one manually or import a file.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="p-3">
            {{ $questions->links() }}
        </div>
    </div>
</div>

<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Questions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.questions.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info small">
                        <strong>Formatting Rules:</strong><br>
                        1. Start questions with <b>Q:</b><br>
                        2. Define type with <b>Type: radio/text/checkbox</b><br>
                        3. Start options with <b>-</b> and put score in <b>[]</b><br>
                        Example: <i>- Yes [10]</i>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Select File (PDF or DOCX)</label>
                        <input type="file" name="document" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Upload & Parse</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection