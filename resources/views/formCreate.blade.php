@extends('main')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3>Tambah Data Produk</h3>
            <hr class="mb-3">
            <form action="{{ route('home.store') }}" method="post">
                @csrf
                <div class="form-floating mb-3">
                    <input type="text"
                        class="form-control @error('nama_produk')
                        is-invalid
                    @enderror"
                        id="nama_produk" required value="{{ old('nama_produk') }}" name="nama_produk">
                    <label for="nama_produk">Nama Produk</label>
                    @error('nama_produk')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input type="text"
                        class="form-control @error('kategori')
                        is-invalid
                    @enderror"
                        id="kategori" required value="{{ old('kategori') }}" name="kategori">
                    <label for="kategori">Kategori</label>
                    @error('kategori')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input type="number"
                        class="form-control @error('harga')
                        is-invalid
                    @enderror"
                        id="harga" required value="{{ old('harga') }}" name="harga">
                    <label for="harga">Harga</label>
                    @error('harga')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" aria-label="Default select" name="status">
                        <option id="bisa" value="bisa dijual">bisa dijual</option>
                        <option id="tidak" value="tidak bisa dijual">tidak bisa dijual</option>
                    </select>
                    <label for="status">Status</label>
                </div>
                <a href="/" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection
