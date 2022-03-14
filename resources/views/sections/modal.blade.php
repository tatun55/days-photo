@if(session('order_completed'))
    <div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    ご注文が完了しました
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="p-3 text-center">
                        <span class="modal-icon display-1"><i class="far fa-smile"></i></span>
                        <h2 class="h4 modal-title mb-3">ご購入ありがとうございます</h2>
                        <p class="mb-4">大事なおもいでが整理されてずっと残る<br>そんな <b>小さな幸せ・安心感</b> を<br>お届けしたいと考えています</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var myModal = new bootstrap.Modal(document.getElementById('modal-notification'));
        myModal.show();

    </script>
@endif

@if(session('printer_capavility_error'))
    <div class="modal fade" id="modal-printer-error" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    プリンタ登録エラー
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="p-3 text-center">
                        <span class="modal-icon display-1"><i class="far fa-frown"></i></span>
                        <h2 class="h4 modal-title mb-3">プリンタに問題があるようです</h2>
                        <p class="mb-0 text-left">申し訳ありません。プリンタが下の機能に対応している必要があります。</p>
                        <ul class=" mt-0 text-left">
                            <li>Epson Connect</li>
                            <li>カラープリント</li>
                            <li>フチ無しプリント</li>
                            <li>L版写真印刷</li>
                            <li>高画質印刷</li>
                        </ul>
                        <p class=" text-left">別のプリンタを登録するか、ミニアルバム購入時に<b>「弊社が印刷」</b>をお選びください。</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var myModal = new bootstrap.Modal(document.getElementById('modal-printer-error'));
        myModal.show();

    </script>
@endif
