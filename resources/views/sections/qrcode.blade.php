<div class="section mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12" style="font-size: 1rem">
                @guest
                    <div class="d-md-flex d-block justify-content-center align-items-center">
                        <div class="text-center">
                            <img class="qrcode" src="https://qr-official.line.me/sid/L/645yuzex.png">
                            {{-- <img class="qrcode m-2" src="https://dummyimage.com/640x640/cccccc/ffffff&text=現在準備中"> --}}
                        </div>
                        <div class="text-center text-md-left">
                            <h5><span class="d-none d-md-inline">👈 </span>コチラからLINE公式アカウントを登録</h5>
                            <div class="ml-2 lead">友だち登録で、”ずっと残る保存” が無料！</div>
                            {{-- <small class="ml-2"><span class="text-danger">*</span> 現在はβ版のため、機能に一部制限があります</small> --}}
                        </div>
                    </div>
                    <div>
                        <div class="my-2 text-center">OR</div>
                        <div class="mt-2 text-center">登録済みユーザーは、<a class="link" href="/login/line">コチラからログイン</a></div>
                    </div>

                @else
                    <div class="text-center">
                        <p>こんにちわ、{{ Auth::user()->name }}さん</p>
                        <a class="link" href="/home">フォト管理画面に進む</a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</div>
</div>
