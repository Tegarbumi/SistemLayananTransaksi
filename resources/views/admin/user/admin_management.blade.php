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

                                        {{-- EDIT --}}
                                        <button class="btn btn-warning btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editUser{{ $item->id }}">
                                            Edit
                                        </button>

                                        {{-- HAPUS --}}
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

                            {{-- ================= MODAL EDIT ================= --}}
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
                                                    <input type="text"
                                                           name="name"
                                                           class="form-control"
                                                           value="{{ $item->name }}"
                                                           required>
                                                    <label>Nama</label>
                                                </div>

                                                <div class="form-floating mb-2">
                                                    <input type="email"
                                                           name="email"
                                                           class="form-control"
                                                           value="{{ $item->email }}"
                                                           required>
                                                    <label>Email</label>
                                                </div>

                                                <div class="form-floating mb-2">
                                                    <input type="text"
                                                           name="telepon"
                                                           class="form-control"
                                                           value="{{ $item->telepon }}"
                                                           required>
                                                    <label>Telepon</label>
                                                </div>

                                                <label class="mt-2">Role</label>
                                                <select name="role" class="form-control">
                                                    <option value="1" {{ $item->role == 1 ? 'selected' : '' }}>Kasir</option>
                                                    <option value="2" {{ $item->role == 2 ? 'selected' : '' }}>Admin</option>
                                                </select>

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


{{-- ================= MODAL TAMBAH ADMIN ================= --}}
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
                        <input type="text" name="name" class="form-control" required>
                        <label>Nama Lengkap</label>
                    </div>

                    <div class="form-floating mb-2">
                        <input type="email" name="email" class="form-control" required>
                        <label>Email</label>
                    </div>

                    <div class="form-floating mb-2">
                        <input type="password" name="password" class="form-control" required>
                        <label>Password</label>
                    </div>

                    <div class="form-floating mb-2">
                        <input type="text" name="telepon" class="form-control" required>
                        <label>Nomor Telepon</label>
                    </div>

                    <label class="mt-2">Role</label>
                    <select name="role" class="form-control">
                        <option value="1">Kasir</option>
                        <option value="2">Admin</option>
                    </select>

                    <button type="submit" class="btn btn-success w-100 mt-3">
                        Daftar
                    </button>

                </form>

            </div>

        </div>
    </div>

</div>

@endsection