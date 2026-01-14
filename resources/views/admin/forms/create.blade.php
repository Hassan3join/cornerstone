@extends('admin.layouts.app')

@section('content')
    <form action="{{ route('admin.forms.store') }}" method="POST">
        @csrf

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold">Form Builder</h4>
                <p class="text-muted small">Assemble your application form.</p>
            </div>
            <button type="submit" class="btn btn-success px-4 rounded-pill">
                <i class="bi bi-save me-1"></i> Save Form
            </button>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white fw-bold">1. Form Settings</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Form Name</label>
                            <input type="text" name="form_name" class="form-control"
                                placeholder="e.g. Loan Application 2025" required>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label small fw-bold">Button Text</label>
                                <input type="text" name="btn_text" class="form-control" value="Submit Application">
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label small fw-bold">Button Color</label>
                                <input type="color" name="btn_color" class="form-control form-control-color w-100"
                                    value="#4e73df">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Application Fee ($)</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" name="amount" class="form-control" placeholder="0.00"
                                        value="0">
                                </div>
                                <small class="text-muted" style="font-size: 10px;">Leave 0 for free forms.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-primary text-white fw-bold">2. Add Fields</div>
                    <div class="card-body">
                        <p class="text-muted small mb-3">Click to add to the canvas.</p>

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
                        <small class="text-muted" style="font-size: 10px;">Questions must be created in Bank first.</small>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-4 h-100" style="min-height: 500px; background-color: #f8f9fc;">
                    <div class="card-header bg-white fw-bold border-bottom">3. Form Preview (Canvas)</div>
                    <div class="card-body" id="canvas-area">
                        <div id="empty-msg" class="text-center text-muted mt-5 pt-5">
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

        // --- 1. INITIALIZE SORTABLE ---
        new Sortable(canvas, {
            animation: 150,
            handle: '.card-body', // Allows dragging by clicking anywhere on the card
            ghostClass: 'bg-light', // Styling for the shadow of the moved item
            onEnd: function () {
                // Whenever a drag finishes, recalculate the array indices (0, 1, 2...)
                reindexFields();
            }
        });

        // --- 2. RE-INDEX FUNCTION ---
        // This makes sure that if you drag Item #3 to Position #1, 
        // it actually submits as item[0] to the server.
        function reindexFields() {
            const rows = canvas.querySelectorAll('.item-row');
            
            // Toggle Empty Message
            if (rows.length === 0) {
                emptyMsg.style.display = 'block';
            } else {
                emptyMsg.style.display = 'none';
            }

            rows.forEach((row, index) => {
                // Find all form inputs inside this row
                const inputs = row.querySelectorAll('input, select, textarea');
                
                inputs.forEach(input => {
                    let name = input.getAttribute('name');
                    if (name) {
                        // Replace the old index number with the new current index
                        // Regex looks for "items[ANY_NUMBER]" and replaces with "items[CURRENT_INDEX]"
                        let newName = name.replace(/items\[\d+\]/, `items[${index}]`);
                        input.setAttribute('name', newName);
                    }
                });
            });
        }

        // --- 3. ADD STANDARD FIELD ---
        function addField(type) {
            let labelPlaceholder = type === 'email' ? 'Email Address' : 'Field Label';
            
            // We use '999' as a placeholder index. 
            // The reindexFields() function will immediately fix it to the correct number.
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
                        <input type="text" name="items[999][label]" class="form-control fw-bold" value="${labelPlaceholder}">
                    </div>
                </div>
            </div>`;

            canvas.insertAdjacentHTML('beforeend', html);
            reindexFields(); // Update indices immediately
        }

        // --- 4. ADD QUESTION ---
        function addQuestion() {
            const select = document.getElementById('questionSelect');
            const questionId = select.value;
            const questionText = select.options[select.selectedIndex].text;

            if (!questionId) return alert('Please select a question first');

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
                    <input type="hidden" name="items[999][question_id]" value="${questionId}">

                    <div class="mb-1">
                        <label class="small text-muted">Question Title (Read Only)</label>
                        <input type="text" name="items[999][label]" class="form-control fw-bold bg-white" value="${questionText}" readonly>
                    </div>
                    <small class="text-success"><i class="bi bi-check-circle"></i> Linked to Question Bank ID #${questionId}</small>
                </div>
            </div>`;

            canvas.insertAdjacentHTML('beforeend', html);
            reindexFields(); // Update indices immediately
        }

        // --- 5. REMOVE FIELD ---
        window.removeField = function(btn) {
            btn.closest('.item-row').remove();
            reindexFields(); // Recalculate indices so there are no gaps
        };

    </script>
@endsection