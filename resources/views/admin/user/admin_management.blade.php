@extends('admin.main')

@section('content')
<div class="container-fluid px-4">

    {{-- ALERT ERROR --}}
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
                Tambah Admin
            </button>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mt-4">

                <div class="card-header">
                    <b>Admin</b>
                </div>

                <div class="card-body">

                    <table class="table table-striped">

                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Telepon</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>

                        <tbody>

                        @foreach ($admin as $item)

                            <tr>

                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <b>{{ $item->name }}</b>
                                    ({{ $item->email }})

                                    @if($item->role == 2)
                                        <span class="badge bg-danger ms-2">Admin</span>
                                    @elseif($item->role == 1)
                                        <span class="badge bg-warning text-dark ms-2">Kasir</span>
                                    @endif
                                </td>

                                <td>{{ $item->telepon }}</td>

                                <td>

                                    @if ($item->id != Auth::user()->id)

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
                                                    onclick="return confirm('Yakin ingin menghapus admin ini?')">
                                                Hapus
                                            </button>
                                        </form>

                                    @else
                                        <span class="badge bg-primary">Anda</span>
                                    @endif

                                </td>

                            </tr>

                            {{-- MODAL EDIT --}}
                            <div class="modal fade" id="editUser{{ $item->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Admin</h5>
                                            <button class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">

                                            <form action="{{ route('user.update', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="form-floating mb-2">
                                                    <input type="text" name="name"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        value="{{ old('name', $item->name) }}" required>
                                                    <label>Nama</label>
                                                    @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-floating mb-2">
                                                    <input type="email" name="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        value="{{ old('email', $item->email) }}" required>
                                                    <label>Email</label>
                                                    @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-floating mb-2">
                                                    <input type="text" name="telepon"
                                                        class="form-control @error('telepon') is-invalid @enderror"
                                                        value="{{ old('telepon', $item->telepon) }}" required>
                                                    <label>Telepon</label>
                                                    @error('telepon')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <label class="mt-2">Role</label>
                                                <select name="role"
                                                    class="form-control @error('role') is-invalid @enderror">
                                                    <option value="1" {{ old('role', $item->role) == 1 ? 'selected' : '' }}>Kasir</option>
                                                    <option value="2" {{ old('role', $item->role) == 2 ? 'selected' : '' }}>Admin</option>
                                                </select>
                                                @error('role')
                                                <div class="text-danger small">{{ $message }}</div>
                                                @enderror

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

{{-- MODAL TAMBAH ADMIN --}}
<div class="modal fade" id="addNewUser" tabindex="-1">

    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Admin Baru</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form action="{{ route('user.new') }}" method="POST">
                    @csrf

                    <div class="form-floating mb-2">
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" required>
                        <label>Nama Lengkap</label>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-2">
                        <input type="email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" required>
                        <label>Email</label>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-2">
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            required>
                        <label>Password</label>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-2">
                        <input type="text" name="telepon"
                            class="form-control @error('telepon') is-invalid @enderror"
                            value="{{ old('telepon') }}" required>
                        <label>Nomor Telepon</label>
                        @error('telepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <label class="mt-2">Role</label>
                    <select name="role"
                        class="form-control @error('role') is-invalid @enderror">
                        <option value="1" {{ old('role') == 1 ? 'selected' : '' }}>Kasir</option>
                        <option value="2" {{ old('role') == 2 ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                    <div class="text-danger small">{{ $message }}</div>
                    @enderror

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