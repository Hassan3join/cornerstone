@extends('admin.layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="d-flex align-items-center mb-3">
                <a href="{{ route('admin.questions.index') }}" class="btn btn-light rounded-circle me-3 border"><i
                        class="bi bi-arrow-left"></i></a>
                <h4 class="fw-bold mb-0">Edit Question</h4>
            </div>

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-body p-5">
                    <form action="{{ route('admin.questions.update', $question->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-4">
                            <div class="col-md-8">
                                <label class="form-label fw-bold">Question Title</label>
                                <input type="text" name="title" class="form-control form-control-lg"
                                    value="{{ $question->title }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Answer Type</label>
                                <select name="type" id="typeSelector" class="form-select form-select-lg"
                                    onchange="toggleOptions()">
                                    <option value="radio" {{ $question->type == 'radio' ? 'selected' : '' }}>Single Choice
                                        (Radio)</option>
                                    <option value="checkbox" {{ $question->type == 'checkbox' ? 'selected' : '' }}>Multiple
                                        Choice (Checkbox)</option>
                                    <option value="text" {{ $question->type == 'text' ? 'selected' : '' }}>Text Input</option>
                                </select>
                            </div>
                        </div>

                        <hr class="text-muted opacity-25 my-4">

                        <div id="options-area" style="{{ $question->type == 'text' ? 'display:none;' : '' }}">
                            <label class="form-label fw-bold mb-3">Answer Options</label>

                            <div id="options-container">
                                @foreach($question->options as $index => $opt)
                                    <div class="card p-3 mb-2 border border-light shadow-sm bg-light">
                                        <div class="row g-2 align-items-center">
                                            <div class="col-auto"><i class="bi bi-dot fs-3 text-muted"></i></div>
                                            <div class="col">
                                                <input type="text" name="options[{{$index}}][text]"
                                                    class="form-control border-0 bg-white" value="{{ $opt->option_text }}">
                                            </div>
                                            <div class="col-auto">
                                                <div class="input-group input-group-sm" style="width: 130px;">
                                                    <span class="input-group-text bg-white border-end-0">Pts:</span>
                                                    <input type="number" name="options[{{$index}}][score]"
                                                        class="form-control border-start-0" value="{{ $opt->score }}">
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <button type="button" class="btn btn-sm text-danger"
                                                    onclick="this.closest('.card').remove()"><i
                                                        class="bi bi-trash"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" class="btn btn-outline-primary w-100 mt-3 border-dashed"
                                onclick="addOption()">
                                <i class="bi bi-plus-circle me-1"></i> Add Option
                            </button>
                        </div>

                        <div id="text-area" style="{{ $question->type != 'text' ? 'display:none;' : '' }}">
                            <div class="alert alert-secondary border-0">
                                <strong>Text Field Logic:</strong> Assign points for completing this text field.
                            </div>
                            <div class="mb-3" style="max-width: 200px;">
                                <label class="form-label fw-bold">Points if Filled</label>
                                <input type="number" name="text_score" class="form-control form-control-lg"
                                    value="{{ $question->score }}">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-5">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5">Update Question</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleOptions() {
            const type = document.getElementById('typeSelector').value;
            const optionsArea = document.getElementById('options-area');
            const textArea = document.getElementById('text-area');

            if (type === 'text') {
                optionsArea.style.display = 'none';
                textArea.style.display = 'block';
            } else {
                optionsArea.style.display = 'block';
                textArea.style.display = 'none';
            }
        }

        // Start count from existing options count + 1 to avoid index collision
        let optionCount = {{ $question->options->count() + 1 }};

        function addOption() {
            const html = `
            <div class="card p-3 mb-2 border border-light shadow-sm bg-light">
                <div class="row g-2 align-items-center">
                    <div class="col-auto"><i class="bi bi-dot fs-3 text-muted"></i></div>
                    <div class="col">
                        <input type="text" name="options[${optionCount}][text]" class="form-control border-0 bg-white" placeholder="New Option">
                    </div>
                    <div class="col-auto">
                        <div class="input-group input-group-sm" style="width: 130px;">
                            <span class="input-group-text bg-white border-end-0">Pts:</span>
                            <input type="number" name="options[${optionCount}][score]" class="form-control border-start-0" placeholder="0">
                        </div>
                    </div>
                    <div class="col-auto">
                         <button type="button" class="btn btn-sm text-danger" onclick="this.closest('.card').remove()"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
            </div>`;
            document.getElementById('options-container').insertAdjacentHTML('beforeend', html);
            optionCount++;
        }
    </script>
@endsection