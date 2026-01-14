@extends('admin.layouts.app')

@section('content')
    <form action="{{ route('admin.forms.update', $form->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold">Edit Form: {{ $form->name }}</h4>
                <p class="text-muted small">Modify your application form settings and fields.</p>
            </div>
            <div>
                <a href="{{ route('admin.forms.index') }}" class="btn btn-outline-secondary px-4 rounded-pill me-2">
                    Cancel
                </a>
                <button type="submit" class="btn btn-success px-4 rounded-pill">
                    <i class="bi bi-check-lg me-1"></i> Update Form
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">

                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white fw-bold">1. Form Settings</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Form Name</label>
                            <input type="text" name="form_name" class="form-control" value="{{ $form->name }}" required>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label small fw-bold">Button Text</label>
                                <input type="text" name="btn_text" class="form-control"
                                    value="{{ $form->submit_btn_text }}">
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label small fw-bold">Button Color</label>
                                <input type="color" name="btn_color" class="form-control form-control-color w-100"
                                    value="{{ $form->btn_color }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Application Fee ($)</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" name="amount" class="form-control"
                                        value="{{ $form->amount }}">
                                </div>
                                <small class="text-muted" style="font-size: 10px;">Leave 0 for free forms.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-primary text-white fw-bold">2. Add Fields</div>
                    <div class="card-body">
                        <p class="text-muted small mb-3">Click to append new fields to the canvas.</p>

                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-outline-dark text-start" onclick="addField('text')">
                                <i class="bi bi-input-cursor-text me-2"></i> Text Input
                            </button>
                            <button type="button" class="btn btn-outline-dark text-start" onclick="addField('email')">
                                <i class="bi bi-envelope me-2"></i> Email Address
                            </button>
                            <button type="button" class="btn btn-outline-dark text-start" onclick="addField('textarea')">
                                <i class="bi bi-textarea-t me-2"></i> Long Text Area
                            </button>
                        </div>

                        <hr>

                        <label class="fw-bold small mb-2 text-primary">Add Scorable Question</label>
                        <div class="input-group">
                            <select id="questionSelect" class="form-select">
                                <option value="">-- Select from Bank --</option>
                                @foreach($questions as $q)
                                    <option value="{{ $q->id }}">{{ Str::limit($q->title, 30) }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-primary" onclick="addQuestion()">Add</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-4 h-100" style="min-height: 500px; background-color: #f8f9fc;">
                    <div class="card-header bg-white fw-bold border-bottom">3. Form Preview (Canvas)</div>
                    <div class="card-body" id="canvas-area">
                        <div id="empty-msg" class="text-center text-muted mt-5 pt-5" style="display: none;">
                            <i class="bi bi-layout-text-window-reverse display-4"></i>
                            <p class="mt-3">The form is empty. Add items from the left.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

    <script>
        const canvas = document.getElementById('canvas-area');
        const emptyMsg = document.getElementById('empty-msg');

        // --- 1. INITIALIZE SORTABLE (DRAG & DROP) ---
        new Sortable(canvas, {
            animation: 150, // Smooth animation
            handle: '.card-body', // Drag using the whole card body
            ghostClass: 'bg-light', // Class applied to the placeholder
            onEnd: function () {
                // When drag finishes, update the indices for the backend
                reindexFields();
            }
        });

        // --- 2. INITIALIZATION: LOAD EXISTING ITEMS ---
        const existingItems = @json($form->items);

        if (existingItems.length === 0) {
            emptyMsg.style.display = 'block';
        } else {
            // Sort items by order_index before rendering to ensure visual accuracy
            existingItems.sort((a, b) => a.order_index - b.order_index);

            existingItems.forEach(item => {
                if (item.type === 'question') {
                    renderQuestionCard(item.question_id, item.label);
                } else {
                    renderFieldCard(item.type, item.label);
                }
            });
            reindexFields(); // Ensure indices start correct
        }

        // --- 3. HELPER: RE-INDEX FIELDS ---
        // This ensures PHP receives the array in the exact order shown on screen
        function reindexFields() {
            const rows = canvas.querySelectorAll('.item-row');

            // Show/Hide empty message
            if (rows.length === 0) {
                emptyMsg.style.display = 'block';
            } else {
                emptyMsg.style.display = 'none';
            }

            rows.forEach((row, index) => {
                // Select all inputs/selects inside this row
                const inputs = row.querySelectorAll('input, select, textarea');

                inputs.forEach(input => {
                    // Get the attribute name (e.g., items[5][label])
                    let name = input.getAttribute('name');
                    if (name) {
                        // Regex to replace the number inside items[...]
                        // Replaces items[ANY_NUMBER][key] with items[CURRENT_INDEX][key]
                        let newName = name.replace(/items\[\d+\]/, `items[${index}]`);
                        input.setAttribute('name', newName);
                    }
                });
            });
        }

        // --- 4. ADD STANDARD FIELD ---
        function addField(type) {
            let labelPlaceholder = type === 'email' ? 'Email Address' : 'Field Label';
            renderFieldCard(type, labelPlaceholder);
            reindexFields(); // Update indices after adding
        }

        // --- 5. ADD QUESTION ---
        function addQuestion() {
            const select = document.getElementById('questionSelect');
            const questionId = select.value;
            const questionText = select.options[select.selectedIndex].text;

            if (!questionId) return alert('Please select a question first');

            renderQuestionCard(questionId, questionText);
            reindexFields(); // Update indices after adding
        }

        // --- 6. REMOVE FUNCTION ---
        // Using event delegation for dynamic elements
        // We attach this to the global window so the onclick in HTML works, 
        // OR we can assign it directly in the HTML generation.
        // Ideally, update the onclick HTML to call this:
        window.removeField = function (btn) {
            btn.closest('.item-row').remove();
            reindexFields(); // Update indices after removing
        };

        // --- RENDER FUNCTIONS (Updated to use window.removeField) ---

        function renderFieldCard(type, labelValue) {
            // Note: I removed the explicit [itemCount] from names here because reindexFields() will fix it immediately
            const html = `
            <div class="card mb-3 border border-secondary shadow-sm item-row" style="cursor: move;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <i class="bi bi-grip-vertical text-muted me-2"></i>
                            <span class="badge bg-secondary text-uppercase">${type} Field</span>
                        </div>
                        <button type="button" class="btn btn-sm text-danger" onclick="removeField(this)"><i class="bi bi-trash"></i></button>
                    </div>

                    <input type="hidden" name="items[999][type]" value="${type}">

                    <div class="mb-1">
                        <label class="small text-muted">Label / Question Text</label>
                        <input type="text" name="items[999][label]" class="form-control fw-bold" value="${labelValue}">
                    </div>
                </div>
            </div>`;

            canvas.insertAdjacentHTML('beforeend', html);
        }

        function renderQuestionCard(id, title) {
            const html = `
            <div class="card mb-3 border border-primary shadow-sm item-row" style="background: #f0f8ff; cursor: move;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <i class="bi bi-grip-vertical text-primary me-2"></i>
                            <span class="badge bg-primary">SCORABLE QUESTION</span>
                        </div>
                        <button type="button" class="btn btn-sm text-danger" onclick="removeField(this)"><i class="bi bi-trash"></i></button>
                    </div>

                    <input type="hidden" name="items[999][type]" value="question">
                    <input type="hidden" name="items[999][question_id]" value="${id}">

                    <div class="mb-1">
                        <label class="small text-muted">Question Title (Read Only)</label>
                        <input type="text" name="items[999][label]" class="form-control fw-bold bg-white" value="${title}" readonly>
                    </div>
                    <small class="text-success"><i class="bi bi-check-circle"></i> Linked to Question Bank ID #${id}</small>
                </div>
            </div>`;

            canvas.insertAdjacentHTML('beforeend', html);
        }
    </script>
@endsection