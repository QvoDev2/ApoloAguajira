<div class="bs-stepper">
    <div class="bs-stepper-header">
        <div class="step {{ $step == 1 ? 'active' : '' }}">
            <a href="{{ route("{$perfil}.comisiones.edit", $id) }}" class="step-trigger">
                <span class="bs-stepper-circle">1</span>
                <span class="bs-stepper-label">Comisión</span>
            </a>
        </div>
        <div class="line"></div>
        <div class="step {{ $step == 2 ? 'active' : '' }}">
            <a href="{{ route("{$perfil}.comisiones.editPuntos", $id) }}" class="step-trigger">
                <span class="bs-stepper-circle">2</span>
                <span class="bs-stepper-label">Puntos de control</span>
            </a>
        </div>
    </div>
</div>