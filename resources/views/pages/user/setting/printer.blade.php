@extends('layouts.app')

@section('content')
<main>
    <div class="section">
        <div class="container">

            <div class="row">

                <!--Breadcrumb-->
                <nav class="ms-2 mb-0 mt-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-transparent">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><span class="fas fa-home me-1"></span></span>ホーム</a></li>
                        <li class="breadcrumb-item active" aria-current="page">設定</li>
                    </ol>
                </nav>
                <!--End of Breadcrumb-->

                @include('sections.profile-card')

                <div class="col-12 col-lg-8 mt-4 mt-lg-3">

                    <nav>
                        <div class="nav nav-tabs mb-4" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active"><span class="fas fa-images me-1"></span>プリンター設定</a>
                        </div>
                    </nav>

                    <div class="ms-1 mb-4 me-2">
                        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modal-printer"><i class="fa fa-plus me-2"></i>プリンターを登録</button>
                        <div class="ms-1 mt-1">
                            <div><small><span class="text-danger">*1</span> Epson Connect 対応プリンターを登録してください</small></div>
                            <div><small><span class="text-danger">*2</span> エプソンプリンターをお持ちで Epson Connect への登録がまだの方は<a href="https://www.epsonconnect.com/guide/ja/html/p01.htm" class="text-tertiary text-decoration-underline" target="_blank" rel="noopener noreferrer">コチラ</a></small></div>
                        </div>
                    </div>

                    @if(\Auth::user()->printers()->get()->isEmpty())
                        <div class="card p-1 p-md-4 mb-4 mb-lg-0 bg-gray-100">
                            <div class="card-body">
                                <div class="icon icon-shape icon-shape-primary rounded-circle mb-4">
                                    <span class="far fa-lightbulb"></span>
                                </div>
                                <h3 class="h5 mb-3">現在、印刷可能なプリンターが登録されていません</h3>
                                <p><code class="px-2 py-1 me-1 d-inline-block bg-gray-300">Epson Connect 対応プリンター</code>を登録していただくと、アルバム収納用フォトのセルフプリントが可能です</p>
                                <p>対応プリンタがなくても、写真は<b>アルバムに同梱</b>できるので、ご心配いりません。</p>
                            </div>
                        </div>
                    @else
                        <div>

                            <div id="table-responsive-wrapper">
                                <table>
                                    <thead>
                                        <tr>
                                            <th style="width: 20%">使用するプリンタ</th>
                                            <th style="width: 36%">プリンタ名</th>
                                            <th style="width: 36%">Email</th>
                                            <th style="width: 8%">削除</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($printers as $i => $printer)
                                            <tr class="text-center my-5">
                                                <th>
                                                    <label for="{{ $printer->id }}" class="fa fa-print fa-2x position-relative mx-3 printer @if(\Auth::user()->printer_id === $printer->id) available @endif"><span class="badge-num-printer">{{ $i + 1 }}</span></label>
                                                    <input type="radio" id="{{ $printer->id }}" class="form-check-input" name="availables" value="{{ $printer->id }}" @if(\Auth::user()->printer_id === $printer->id) checked @endif>
                                                </th>
                                                <td aria-label="プリンタ名"><span style="font-size: 0.8rem">{{ $printer->name }}</span></td>
                                                <td aria-label="Email"><span style="font-size: 0.8rem">{{ $printer->email }}</span></td>
                                                <td aria-label="編集・削除">
                                                    <div class="d-flex justify-content-center">
                                                        {{-- <button class="btn btn-sm btn-gray-600 text-white mx-1" data-bs-toggle="modal" data-bs-target="#modal-printer-edit"><i class="fas fa-edit"></i></button> --}}
                                                        <button class="btn btn-sm btn-danger mx-1 printer-delete" data-bs-toggle="modal" data-bs-target="#modal-printer-delete" data-printer-id="{{ $printer->id }}"><i class="fas fa-trash"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-printer" tabindex="-1" role="dialog" aria-labelledby="modal-printer" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form method="POST" action="{{ route('printer.store') }}" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h2 class="h6 modal-title">プリンターの登録</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="input-name">プリンタ名 (管理用)</label>
                        <input id="input-name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="自宅プリンター" required>
                        <div class="invalid-feedback">50文字以内で入力してください</div>
                        <div class="form-text text-gray text-left text-sm"><span class="text-danger">*</span> 50字以内</div>
                    </div>
                    <div class="form-group">
                        <label for="input-email">Email</label>
                        <input id="input-email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="xxxxxxxxxxxxxxx@print.epsonconnect.com" required>
                        <div class="invalid-feedback">Emailを正しく入力してください</div>
                        <div class="form-text text-gray text-left text-sm"><span class="text-danger">*1</span> Epson Connect 設定で取得したもの</div>
                        <div class="form-text text-gray text-left text-sm"><span class="text-danger">*2</span> エプソンプリンターをお持ちで Epson Connect への登録がまだの方は<a href="https://www.epsonconnect.com/guide/ja/html/p01.htm" class="text-tertiary text-decoration-underline" target="_blank" rel="noopener noreferrer">コチラ</a></div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning text-white">登録</button>
                    <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">キャンセル</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modal-printer-delete" tabindex="-1" role="dialog" aria-labelledby="modal-printer-delete" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form method="POST" class="modal-content" id="delete-form">
                @csrf
                @method('delete')
                <div class="modal-header">
                    <h2 class="h6 modal-title">プリンターを削除しますか？</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning text-white">削除</button>
                    <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">キャンセル</button>
                </div>
            </form>
        </div>
    </div>

    <form method="POST" action="{{ route('user.printer.available') }}">
        @csrf
        @method('put')
        <input id="available-input" type="hidden" name="printer_id">
        <button id="available-submit" type="submit" class="d-none">
    </form>
</main>
@endsection

@section('script')
<script>
    document.querySelectorAll('input[name="availables"]').forEach(item => {
        item.addEventListener('click', event => {
            document.getElementById("available-input").value = event.target.id;
            document.getElementById("available-submit").click();
        })
    })
    document.querySelectorAll('.printer-delete').forEach(item => {
        item.addEventListener('click', event => {
            console.log(event.currentTarget);
            var printerId = event.currentTarget.getAttribute('data-printer-id');
            var actionUrl = `https://days.photo/printer/${printerId}`;
            console.log(actionUrl);
            var deleteForm = document.getElementById("delete-form");
            deleteForm.action = actionUrl;
        })
    })

</script>
@error('capavility')
@else
    @if($errors->any())
        <script>
            var myModal = new bootstrap.Modal(document.getElementById("modal-printer"));
            myModal.show();

        </script>
    @endif
@enderror
@endsection
