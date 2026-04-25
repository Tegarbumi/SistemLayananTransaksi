@extends('admin.main')
@section('content')
<main>
    <div class="container-fluid px-4">
        <div class="row mt-4">
            <div class="col">
                <div class="card mb-4">

                    <div class="card-header">
                        <a class="link-dark" href="{{ route('alat.index') }}">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a> 
                        | Detail untuk Alat "{{ $alat->nama_alat }}"
                    </div>

                    <div class="card-body">
                        <form action="{{ route('alat.update',['id' => $alat->id]) }}" method="POST" enctype="multipart/form-data">
                            @method('PATCH')
                            @csrf

                            <input class="form-control form-control-lg mb-4"
                                type="text"
                                name="nama"
                                value="{{ $alat->nama_alat }}"
                                required>

                            <select name="kategori" class="form-select mb-4">
                                @foreach ($kategori as $cat)
                                <option value="{{ $cat->id }}"
                                    @if ($cat->id == $alat->category->id)
                                        selected
                                    @endif>
                                    {{ $cat->nama_kategori }}
                                </option>
                                @endforeach
                            </select>

                            <div class="mb-3">
                                <textarea class="form-control"
                                    name="deskripsi"
                                    placeholder="Deskripsi singkat"
                                    rows="3">{{ $alat->deskripsi }}</textarea>
                            </div>

                            <div class="mb-3">

                                <span class="form-text mb-2">
                                    Harga ditulis angka saja, tidak perlu tanda titik
                                </span>

                                <div class="row d-flex w-100 justify-content-start">

                                    <!-- 24 JAM -->
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Rp</span>

                                        <input type="number"
                                            value="{{ $alat->harga24 }}"
                                            name="harga24"
                                            class="form-control"
                                            placeholder="Harga 24 jam"
                                            required>

                                        <span class="input-group-text">
                                            <b>/24 jam</b>
                                        </span>
                                    </div>

                                    <!-- 48 JAM -->
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Rp</span>

                                        <input type="number"
                                            value="{{ $alat->harga48 }}"
                                            name="harga48"
                                            class="form-control"
                                            placeholder="Harga 48 jam">

                                        <span class="input-group-text">
                                            <b>/48 jam</b>
                                        </span>
                                    </div>

                                    <!-- 72 JAM -->
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Rp</span>

                                        <input type="number"
                                            value="{{ $alat->harga72 }}"
                                            name="harga72"
                                            class="form-control"
                                            placeholder="Harga 72 jam">

                                        <span class="input-group-text">
                                            <b>/72 jam</b>
                                        </span>
                                    </div>

                                </div>

                                <div class="mt-3">
                                    <span class="form-text">Upload Gambar Alat</span>
                                    <input type="file" name="gambar" class="form-control">
                                </div>

                                <div class="row mt-4">
                                    <div class="col-lg-8"></div>
                                    <div class="col-lg-4">
                                        <button class="btn btn-success"
                                            type="submit"
                                            style="float: right">
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </div>

                            </div>

                        </form>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('alat.destroy',['id'=>$alat->id]) }}" method="POST">
                            @method('DELETE')
                            @csrf

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>
@endsection