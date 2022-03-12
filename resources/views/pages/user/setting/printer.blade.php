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
                        <li class="breadcrumb-item active" aria-current="page">アカウントサービス</li>
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
                            </div>
                        </div>
                    @else
                        <div>

                            <div id="table-responsive-wrapper">
                                <table>
                                    <thead>
                                        <tr>
                                            <th style="width: 6%"> </th>
                                            <th style="width: 22%">このプリンタを使う</th>
                                            <th style="width: 28%">プリンタ名</th>
                                            <th style="width: 30%">Email</th>
                                            <th style="width: 14%">編集・削除</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($printers as $i => $printer)
                                            <tr class="text-center my-5">
                                                <th class="d-inline p-0 d-sm-table-cell">
                                                    <input type="radio" id="printer-{{ $i + 1 }}" class="form-check-input" name="availables" value="{{ $printer->id }}">
                                                </th>
                                                <th class="d-inline p-0 d-sm-table-cell">
                                                    <label for="printer-{{ $i + 1 }}" class="fa fa-print fa-2x position-relative mx-3"><span class="badge-num-printer">{{ $i + 1 }}</span></label>
                                                </th>
                                                <td aria-label="プリンタ名">{{ $printer->name }}</td>
                                                <td aria-label="Email">{{ $printer->email }}</td>
                                                <td aria-label="編集・削除">
                                                    <div class="d-flex justify-content-center">
                                                        <button class="btn btn-sm btn-gray-600 text-white mx-1" data-bs-toggle="modal" data-bs-target="#modal-printer-edit"><i class="fas fa-edit"></i></button>
                                                        <button class="btn btn-sm btn-danger mx-1" data-bs-toggle="modal" data-bs-target="#modal-printer-delete"><i class="fas fa-trash"></i></button>
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
                        <input id="input-name" type="text" class="form-control" name="name" placeholder="自宅プリンター">
                        <div class="form-text text-gray text-left text-sm"><span class="text-danger">*</span> 50字以内</div>
                    </div>
                    <div class="form-group">
                        <label for="input-name">プリンターのメールアドレス</label>
                        <input id="input-name" type="text" class="form-control" name="email" placeholder="xxxxxxxxxxxxxxx@print.epsonconnect.com">
                        <div class="form-text text-gray text-left text-sm"><span class="text-danger">*</span> Epson Connect 設定で取得したもの</div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning text-white">登録</button>
                    <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">キャンセル</button>
                </div>
            </form>
        </div>
    </div>

</main>
@endsection
