@props(['form'])

@php
    $amount = $form->amount ?? 0;
    $isPaid = ($form && $amount > 0);
    $formId = $form->id;
    
    // Fallback color if none set
    $themeColor = $form->btn_color ?? '#4f46e5';
@endphp

@if($isPaid)
    <script src="https://js.stripe.com/v3/"></script>
@endif

@if($form)
<style>
    /* 1. Animations */
    @keyframes slideUpFade {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .animate-entry { animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }

    /* 2. Modern Inputs */
    .modern-input {
        background-color: #f8fafc;
        border: 2px solid #f1f5f9;
        transition: all 0.2s ease;
        font-size: 1rem;
    }
    .modern-input:focus {
        background-color: #fff;
        border-color: {{ $themeColor }} !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    /* 3. Selection Cards (Radio/Checkbox) */
    .selection-card {
        border: 2px solid #f1f5f9;
        background: #fff;
        transition: all 0.2s ease;
    }
    .selection-card:hover {
        border-color: #cbd5e1;
        background: #f8fafc;
    }
    .selection-card input:checked + div {
        color: {{ $themeColor }} !important;
        font-weight: 700;
    }
    .selection-card.selected {
        border-color: {{ $themeColor }} !important;
        background-color: #fdfeff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    /* 4. Payment Receipt Look */
    .receipt-card {
        background-image: radial-gradient(circle at top left, #f8fafc, #fff);
        border: 1px solid #e2e8f0;
        position: relative;
    }
    .receipt-top-border {
        height: 6px;
        background: repeating-linear-gradient(45deg, #e2e8f0, #e2e8f0 10px, #fff 10px, #fff 20px);
    }
</style>

<div class="dynamic-form-container mx-auto animate-entry" style="max-width: 720px;">
    
    <div class="position-relative overflow-hidden rounded-top-5 shadow-sm" 
         style="background: {{ $themeColor }}; background: linear-gradient(135deg, {{ $themeColor }} 0%, #1e1b4b 120%);">
        
        <div class="position-absolute top-0 end-0 bg-black opacity-10 rounded-circle" style="width: 250px; height: 250px; filter: blur(60px); transform: translate(30%, -30%);"></div>
        
        <div class="position-absolute bottom-0 start-0 bg-white opacity-10 rounded-circle" style="width: 150px; height: 150px; filter: blur(40px); transform: translate(-30%, 30%);"></div>

        <div class="p-5 text-center position-relative text-white">
            <h1 class="fw-bold mb-2 display-6">{{ $form->name }}</h1>
            
            <div class="d-inline-flex align-items-center bg-white shadow-sm rounded-pill px-4 py-1 mt-3">
                <span class="small fw-bold" style="color: {{ $themeColor }}">Application Form</span>
                @if($isPaid)
                    <span class="mx-2 text-muted">|</span>
                    <span class="small fw-bold text-dark">Fee: ${{ number_format($amount, 2) }}</span>
                @endif
            </div>
        </div>
    </div>

    <form id="mainForm-{{ $formId }}" action="{{ route('form.submit', $formId) }}" method="POST" class="bg-white rounded-bottom-5 shadow-lg position-relative" style="top: -10px;">
        @csrf
        <input type="hidden" name="payment_intent_id" id="payment_intent_id-{{ $formId }}">

        <div class="p-4 p-md-5">
            
            @foreach($form->items as $item)
                <div class="mb-5 group-container">
                    <div class="d-flex align-items-center mb-3">
                        <label class="form-label fw-bold text-dark mb-0 fs-5">{{ $item->label }}</label>
                        @if($item->type !== 'checkbox') <span class="text-danger ms-1 small">*</span> @endif
                    </div>

                    {{-- TYPE 1: QUESTION FROM BANK --}}
                    @if($item->type === 'question' && $item->question)
                        
                        @if($item->question->type === 'text')
                            <input type="text" name="field_{{ $item->id }}" class="form-control form-control-lg modern-input rounded-3 px-3 py-3" placeholder="Your answer here..." required>

                        @elseif($item->question->type === 'radio')
                            <div class="d-flex flex-column gap-2">
                                @foreach($item->question->options as $option)
                                    <label class="selection-card rounded-3 p-3 cursor-pointer d-flex align-items-center">
                                        <input class="form-check-input me-3 mt-0 fs-5" type="radio" 
                                               name="field_{{ $item->id }}" 
                                               value="{{ $option->id }}" 
                                               onchange="highlightCard(this)"
                                               required>
                                        <div class="text-dark">{{ $option->option_text }}</div>
                                    </label>
                                @endforeach
                            </div>

                        @elseif($item->question->type === 'checkbox')
                            <div class="d-flex flex-column gap-2">
                                @foreach($item->question->options as $option)
                                    <label class="selection-card rounded-3 p-3 cursor-pointer d-flex align-items-center">
                                        <input class="form-check-input me-3 mt-0 fs-5" type="checkbox" 
                                               name="field_{{ $item->id }}[]" 
                                               value="{{ $option->id }}"
                                               onchange="highlightCard(this)">
                                        <div class="text-dark">{{ $option->option_text }}</div>
                                    </label>
                                @endforeach
                            </div>
                        @endif

                    {{-- TYPE 2: STANDARD FIELDS --}}
                    @elseif($item->type === 'text')
                        <input type="text" name="field_{{ $item->id }}" class="form-control form-control-lg modern-input rounded-3 px-3 py-3" required>
                    @elseif($item->type === 'email')
                        <div class="position-relative">
                            <i class="bi bi-envelope position-absolute text-muted" style="top: 18px; left: 15px;"></i>
                            <input type="email" name="field_{{ $item->id }}" class="form-control form-control-lg modern-input rounded-3 py-3" style="padding-left: 45px;" placeholder="name@company.com" required>
                        </div>
                    @elseif($item->type === 'textarea')
                        <textarea name="field_{{ $item->id }}" class="form-control form-control-lg modern-input rounded-3 px-3 py-3" rows="4"></textarea>
                    @endif
                </div>
            @endforeach

            @if($isPaid)
                <div class="receipt-card rounded-3 overflow-hidden mt-5 mb-4">
                    <div class="receipt-top-border"></div>
                    <div class="p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold mb-0 text-dark">
                                <i class="bi bi-shield-lock-fill text-success me-2"></i>Secure Payment
                            </h5>
                            <img src="https://upload.wikimedia.org/wikipedia/commons/b/ba/Stripe_Logo%2C_revised_2016.svg" alt="Stripe" style="height: 25px; opacity: 0.7;">
                        </div>
                        
                        <div class="bg-white border rounded-3 p-3 mb-3">
                            <div id="card-element-{{ $formId }}"></div>
                        </div>
                        
                        <div id="payment-message-{{ $formId }}" class="text-danger small fw-bold text-center"></div>

                        <div class="d-flex justify-content-between text-muted small mt-3 pt-3 border-top">
                            <span>Processing Fee</span>
                            <span>$0.00</span>
                        </div>
                        <div class="d-flex justify-content-between fw-bold text-dark fs-5 mt-1">
                            <span>Total Due</span>
                            <span>${{ number_format($amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            @endif

            <button type="button" 
                    id="submitBtn-{{ $formId }}" 
                    class="btn w-100 py-3 rounded-3 shadow-sm fw-bold fs-5 text-white position-relative overflow-hidden"
                    style="background-color: {{ $themeColor }}; letter-spacing: 0.5px;"
                    onmouseover="this.style.opacity='0.9'"
                    onmouseout="this.style.opacity='1'"
                    onclick="handlePaymentAndSubmit_{{ $formId }}()">
                <span id="btn-text-{{ $formId }}">
                    {{ $form->submit_btn_text }} {{ $isPaid ? ' & Pay' : '' }}
                </span>
            </button>
            
            <div class="text-center mt-3">
                <small class="text-muted"><i class="bi bi-lock"></i> 100% Secure SSL Form</small>
            </div>

        </div>
    </form>
</div>

<script>
    // 1. Helper for UI (Selection Highlights)
    function highlightCard(input) {
        const isRadio = input.type === 'radio';
        const parentLabel = input.closest('label');
        
        // If radio, clear siblings first
        if (isRadio) {
            const name = input.name;
            const allRadios = document.querySelectorAll(`input[name="${name}"]`);
            allRadios.forEach(r => {
                r.closest('label').classList.remove('selected');
            });
        }
        
        // Toggle current
        if (input.checked) {
            parentLabel.classList.add('selected');
        } else {
            parentLabel.classList.remove('selected');
        }
    }

    // 2. Main Logic Scope
    async function handlePaymentAndSubmit_{{ $formId }}() {
        const formId = "{{ $formId }}";
        const isPaid = @json($isPaid);
        
        const form = document.getElementById(`mainForm-${formId}`);
        const btn = document.getElementById(`submitBtn-${formId}`);
        const btnText = document.getElementById(`btn-text-${formId}`);
        const msgDiv = document.getElementById(`payment-message-${formId}`);
        const hiddenInput = document.getElementById(`payment_intent_id-${formId}`);

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const originalHtml = btnText.innerHTML;
        btn.disabled = true;
        btnText.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Processing...';

        if (!isPaid) {
            form.submit();
            return;
        }

        try {
            if(msgDiv) msgDiv.innerText = "";
            
            const stripeObj = window[`stripe_${formId}`];
            const cardObj = window[`card_${formId}`];

            if (!stripeObj || !cardObj) throw new Error("Payment system not loaded.");

            const response = await fetch("{{ route('form.payment_init', $formId) }}", {
                headers: { "Content-Type": "application/json" }
            });
            const data = await response.json();

            if (!data.client_secret) throw new Error("Could not initialize payment.");

            const result = await stripeObj.confirmCardPayment(data.client_secret, {
                payment_method: { card: cardObj }
            });

            if (result.error) {
                throw new Error(result.error.message);
            } 
            
            if (result.paymentIntent && result.paymentIntent.status === 'succeeded') {
                hiddenInput.value = result.paymentIntent.id;
                btnText.innerHTML = '<i class="bi bi-check-lg me-1"></i> Paid! Redirecting...';
                form.submit();
            }

        } catch (error) {
            console.error(error);
            if(msgDiv) msgDiv.innerText = error.message;
            btn.disabled = false;
            btnText.innerHTML = originalHtml;
        }
    }

    (function() {
        const isPaid = @json($isPaid);
        const formId = "{{ $formId }}";
        
        if (isPaid) {
            document.addEventListener("DOMContentLoaded", () => {
                if (!window.Stripe) return;
                
                const stripe = Stripe("{{ config('services.stripe.public_key') }}");
                const elements = stripe.elements();
                const card = elements.create('card', { 
                    style: { 
                        base: { 
                            fontSize: '16px', 
                            color: '#334155',
                            fontFamily: 'system-ui, -apple-system, sans-serif',
                            '::placeholder': { color: '#94a3b8' }
                        } 
                    },
                    hidePostalCode: true 
                });

                const mountPoint = document.getElementById(`card-element-${formId}`);
                if (mountPoint) {
                    card.mount(`#card-element-${formId}`);
                    window[`stripe_${formId}`] = stripe;
                    window[`card_${formId}`] = card;
                }
            });
        }
    })();
</script>

@else
    <div class="alert alert-danger text-center shadow-sm p-4">
        <i class="bi bi-exclamation-triangle fs-1 text-danger mb-3 d-block"></i>
        <h4 class="fw-bold">Form Unavailable</h4>
        <p class="mb-0">This form cannot be loaded at this time.</p>
    </div>
@endif