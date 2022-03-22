<div class="modal-header">
    <h5 class="modal-title">
        <b>@yield('header')</b>
    </h5>
    <button type="button" class="close" onclick="$('#ventana').modal('hide')">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body" id="ventana-body">
    <div class="row">
        <div class="col-sm-12">
            @yield('title')
        </div>
    </div>
    @yield('content')
</div>
<div class="modal-footer">
    @yield('footer')
</div>
@stack('scripts')