@extends('admin.main')

@section('content')
<div class="container-fluid px-4">

    {{-- ERROR ALERT --}}
    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- BUTTON TAMBAH --}}
    <div class="row">
        <div class="col-12">
            <button class="btn btn-success mt-4" data-bs-toggle="modal" data-bs-target="#addNewUser">
                Tambah User
            </button>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="row">
        <div class="col">
            <div class="card shadow mt-4">

                <div class="card-header">
                    <b>Customer</b>
                </div>

                <div class="card-body">

                    <table class="table table-striped">

                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>

                        <tbody>

                        @foreach ($penyewa as $item)

                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    {{ $item->name }}
                                    <span class="badge bg-secondary">
                                        {{ $item->payment->count() }} Transaksi
                                    </span>
                                </td>

                                <td>{{ $item->email }}</td>
                                <td>{{ $item->telepon }}</td>

                                <td>

                                    <a class="btn btn-success btn-sm"
                                       href="{{ route('admin.buatreservasi',['userId' => $item->id]) }}">
                                        Buat Reservasi
                                    </a>

                                    <button class="btn btn-warning btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editUser{{ $item->id }}">
                                        Edit
                                    </button>

                                    <form action="{{ route('user.delete',['id' => $item->id]) }}"
                                          method="POST"
                                          style="display:inline;">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin ingin menghapus user ini?')">
                                            Hapus
                                        </button>
                                    </form>

                                </td>
                            </tr>

                            {{-- MODAL EDIT --}}
                            <div class="modal fade" id="editUser{{ $item->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit User</h5>
                                            <button class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">

                                            <form action="{{ route('user.update', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <input type="hidden" name="role" value="0">

                                                <div class="form-floating mb-2">
                                                    <input type="text"
                                                           name="name"
                                                           class="form-control @error('name') is-invalid @enderror"
                                                           value="{{ old('name', $item->name) }}"
                                                           required>
                                                    <label>Nama</label>
                                                </div>

                                                <div class="form-floating mb-2">
                                                    <input type="email"
                                                           name="email"
                                                           class="form-control @error('email') is-invalid @enderror"
                                                           value="{{ old('email', $item->email) }}"
                                                           required>
                                                    <label>Email</label>
                                                </div>

                                                <div class="form-floating mb-2">
                                                    <input type="text"
                                                           name="telepon"
                                                           class="form-control @error('telepon') is-invalid @enderror"
                                                           value="{{ old('telepon', $item->telepon) }}"
                                                           required>
                                                    <label>Telepon</label>
                                                </div>

                                                <button class="btn btn-warning w-100 mt-3">
                                                    Update
                                                </button>

                                            </form>

                                        </div>

                                    </div>
                                </div>
                            </div>

                        @endforeach

                        </tbody>

                    </table>

                </div>
            </div>
        </div>
    </div>

</div>

{{-- MODAL TAMBAH USER --}}
<div class="modal fade" id="addNewUser">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">User Baru</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form action="{{ route('user.new') }}" method="POST">
                    @csrf

                    <input type="hidden" name="role" value="0">

                    <div class="form-floating mb-2">
                        <input type="text"
                               name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}"
                               required>
                        <label>Nama Lengkap</label>
                    </div>

                    <div class="form-floating mb-2">
                        <input type="email"
                               name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}"
                               required>
                        <label>Email</label>
                    </div>

                    <div class="form-floating mb-2">
                        <input type="password"
                               name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               required>
                        <label>Password</label>
                    </div>

                    <div class="form-floating mb-2">
                        <input type="text"
                               name="telepon"
                               class="form-control @error('telepon') is-invalid @enderror"
                               value="{{ old('telepon') }}"
                               required>
                        <label>No Telepon</label>
                    </div>

                    <button type="submit" class="btn btn-success w-100 mt-3">
                        Tambah
                    </button>

                </form>

            </div>

        </div>
    </div>
</div>

@if ($errors->any())
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var modal = new bootstrap.Modal(document.getElementById('addNewUser'));
        modal.show();
    });
</script>
@endif

@endsection