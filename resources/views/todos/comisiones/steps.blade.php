<div class="bs-stepper">
    <div class="bs-stepper-header">
        <div class="step {{ $step == 1 ? 'active' : '' }}">
            <button type="button" class="step-trigger">
                <span class="bs-stepper-circle">1</span>
                <span class="bs-stepper-label">Comisión</span>
            </button>
        </div>
        <div class="line"></div>
        <div class="step {{ $step == 2 ? 'active' : '' }}">
            <button type="button" class="step-trigger">
                <span class="bs-stepper-circle">2</span>
                <span class="bs-stepper-label">Escoltas</span>
            </button>
        </div>
        <div class="line"></div>
        <div class="step {{ $step == 3 ? 'active' : '' }}">
            <button type="button" class="step-trigger">
                <span class="bs-stepper-circle">3</span>
                <span class="bs-stepper-label">Puntos de control</span>
            </button>
        </div>
    </div>
</div>