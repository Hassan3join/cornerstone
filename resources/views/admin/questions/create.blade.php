@extends('admin.layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="d-flex align-items-center mb-3">
            <a href="{{ route('admin.questions.index') }}" class="btn btn-light rounded-circle me-3 border"><i class="bi bi-arrow-left"></i></a>
            <h4 class="fw-bold mb-0">Add New Question</h4>
        </div>

        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-header bg-primary text-white py-3">
                <div class="d-flex align-items-center">
                    <div class="bg-white bg-opacity-25 rounded-circle p-2 me-2">
                        <i class="bi bi-patch-question-fill fs-5"></i>
                    </div>
                    <h5 class="mb-0">Question Configuration</h5>
                </div>
            </div>
            
            <div class="card-body p-5">
                <form action="{{ route('admin.questions.store') }}" method="POST">
                    @csrf
                    
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <label class="form-label fw-bold text-dark">Question Title</label>
                            <input type="text" name="title" class="form-control form-control-lg bg-light" placeholder="e.g., What is your employment status?" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark">Answer Type</label>
                            <select name="type" id="typeSelector" class="form-select form-select-lg" onchange="toggleOptions()">
                                <option value="radio">Single Choice (Radio)</option>
                                <option value="checkbox">Multiple Choice (Checkbox)</option>
                                <option value="text">Text Input (User Types)</option>
                            </select>
                        </div>
                    </div>

                    <hr class="text-muted opacity-25 my-4">

                    <div id="options-area">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <label class="form-label fw-bold text-dark mb-0">Define Answers & Points</label>
                            <span class="badge bg-info bg-opacity-10 text-info border border-info">Auto-Calculated</span>
                        </div>
                        
                        <div id="options-container">
                            <div class="card p-3 mb-2 border border-light shadow-sm bg-light">
                                <div class="row g-2 align-items-center">
                                    <div class="col-auto"><i class="bi bi-dot fs-3 text-muted"></i></div>
                                    <div class="col">
                                        <input type="text" name="options[0][text]" class="form-control border-0 bg-white" placeholder="Answer Option (e.g., Employed)">
                                    </div>
                                    <div class="col-auto">
                                        <div class="input-group input-group-sm" style="width: 130px;">
                                            <span class="input-group-text bg-white border-end-0">Pts:</span>
                                            <input type="number" name="options[0][score]" class="form-control border-start-0" placeholder="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card p-3 mb-2 border border-light shadow-sm bg-light">
                                <div class="row g-2 align-items-center">
                                    <div class="col-auto"><i class="bi bi-dot fs-3 text-muted"></i></div>
                                    <div class="col">
                                        <input type="text" name="options[1][text]" class="form-control border-0 bg-white" placeholder="Answer Option (e.g., Unemployed)">
                                    </div>
                                    <div class="col-auto">
                                        <div class="input-group input-group-sm" style="width: 130px;">
                                            <span class="input-group-text bg-white border-end-0">Pts:</span>
                                            <input type="number" name="options[1][score]" class="form-control border-start-0" placeholder="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-outline-primary w-100 mt-3 border-dashed" onclick="addOption()">
                            <i class="bi bi-plus-circle me-1"></i> Add Another Option
                        </button>
                    </div>

                    <div id="text-area" style="display: none;">
                        <div class="alert alert-secondary border-0 d-flex align-items-center" role="alert">
                            <i class="bi bi-info-circle-fill me-3 fs-4"></i>
                            <div>
                                <strong>Text Field Logic:</strong><br>
                                Users will type their answer. You can assign a fixed score simply for completing this field.
                            </div>
                        </div>
                        <div class="mb-3" style="max-width: 200px;">
                            <label class="form-label fw-bold">Points if Filled</label>
                            <input type="number" name="text_score" class="form-control form-control-lg" value="0">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-5">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm">Save to Bank</button>
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

        if(type === 'text') {
            optionsArea.style.display = 'none';
            textArea.style.display = 'block';
        } else {
            optionsArea.style.display = 'block';
            textArea.style.display = 'none';
        }
    }

    let optionCount = 2;
    function addOption() {
        const html = `
        <div class="card p-3 mb-2 border border-light shadow-sm bg-light fade-in">
            <div class="row g-2 align-items-center">
                <div class="col-auto"><i class="bi bi-dot fs-3 text-muted"></i></div>
                <div class="col">
                    <input type="text" name="options[${optionCount}][text]" class="form-control border-0 bg-white" placeholder="Answer Option">
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

<style>
    .border-dashed { border-style: dashed !important; }
    .fade-in { animation: fadeIn 0.3s; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection