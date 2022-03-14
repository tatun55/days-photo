@extends('layouts.lp')

@section('content')

<div class="section padding-page-top padding-bottom-big">
    <div class="container">
        <div class="row">
            <div class="col-md-12 parallax-fade-top">
                <h2 class="page-title text-center">Contact</h2>
                <p class="page-title text-center">お問い合わせ</p>
            </div>
        </div>
    </div>
</div>

<div class="section padding-bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if(session('contact_completed'))<div id="ajaxsuccess">お問い合わせありがとうございました</div>@endif
                    <form name="ajax-form" id="ajax-form" action="{{ route('message') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="name">
                                    <span class="error" id="err-name">please enter name</span>
                                </label>
                                <input name="name" id="name" type="text" placeholder="お名前: *" required />
                            </div>
                            <div class="col-lg-6 mt-4 mt-lg-0">
                                <label for="email">
                                    <span class="error" id="err-email">please enter e-mail</span>
                                    <span class="error" id="err-emailvld">e-mail is not a valid format</span>
                                </label>
                                <input name="email" id="email" type="email" placeholder="メールアドレス: *" required />
                            </div>
                            <div class="col-lg-12 mt-4">
                                <label for="message"></label>
                                <textarea name="message" id="message" placeholder="お問い合わせ内容"></textarea>
                            </div>
                            <div class="col-lg-12 mt-4">
                                <div id="button-con"><button class="send_message js-tilt"><span>お問い合わせを送信</span></button></div>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>

@endsection
