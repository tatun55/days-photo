@if(session('status'))
    <div class="position-relative w-100"></div>
    <div class="position-absolute top-8 start-50 translate-middle-x" style="z-index: 9999">
        <div id="toast" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <span class="fa fa-info me-2"></span>
                <span class="me-auto">システムメッセージ</span>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ session('status') }}
            </div>
        </div>
    </div>
@endif
