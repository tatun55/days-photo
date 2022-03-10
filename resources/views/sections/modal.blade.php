@if(session('modal'))
    <div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    ご注文が完了しました
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="py-3 px-5 text-center">
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
