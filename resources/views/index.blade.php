@extends('main')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h3>Daftar Data Produk</h3>
            <hr class="mb-3">
            @if (session()->has('success'))
                <div class="alert alert-success align-items-center alert-dismissible fade show mb-3" role="alert">
                    <div class="text-success d-inline"><i class="mb-1" data-feather="check-circle"></i></div>
                    <span>
                        <b>
                            {{ session('success') }}
                        </b>
                    </span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="d-flex justify-content-between">
                <div class="wrap">
                    @if (!$products->count())
                        <a href="/generateData" class="btn btn-success">Generate Data</a>
                    @else
                        <a href="{{ route('home.create') }}" class="btn btn-primary"><span data-feather="plus-square"
                                class="mb-1"></span> Add Data</a>
                    @endif
                </div>
            </div>
            @if (!$products->count())
                <div class="alert alert-warning mt-5" role="alert">
                    <h3 class="text-center">Data tidak ditemukan <br> klik tombol <b>Generate Data</b></h3>
                </div>
            @else
                <table class="table mt-2 table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th style="max-width: 40%; width: 100%;">Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td style="display: table-cell; vertical-align: middle;">
                                    {{ $item->nama_produk }}</td>
                                <td>{{ $item->kategori }}</td>
                                <td>@rupiah($item->harga)</td>
                                <td>{{ $item->status }}</td>
                                <td>
                                    <a href="{{ route('home.edit', $item->id_produk) }}"
                                        class="btn btn-warning border-0 text-white btn-sm"><span data-feather="edit"
                                            class="mb-1"></a>
                                    <form action="{{ route('home.destroy', $item->id_produk) }}" method="post"
                                        class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin produk ini dihapus?')"><span
                                                data-feather="trash-2" class="mb-1"></span></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
