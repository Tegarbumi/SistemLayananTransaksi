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

    <div class="row">
        <div class="col-12">
            <button type="button" class="btn btn-success mt-4" data-bs-toggle="modal" data-bs-target="#addNewUser">
                Tambah Admin
            </button>
        </div>
    </div>

    <div class="row">

        {{-- ADMIN LIST --}}
        <div class="col-lg-12 col-md-12">
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

                                   <form action="{{ route('user.delete',['id' => $item->id]) }}" method="POST">
    @csrf
    @method('DELETE')

    <button
        type="submit"
        class="btn btn-danger btn-sm"
        title="Hapus user ini"
        onclick="return confirm('Yakin ingin menghapus admin ini?')" >
        Hapus
    </button>
</form>

                                        @csrf
                                        @method('PATCH')

                                       

                                    </form>

                                    @else
                                        <span class="badge bg-primary">Anda</span>
                                    @endif

                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>
            </div>
        </div>

    </div>
</div>


{{-- MODAL TAMBAH USER --}}
<div class="modal fade" id="addNewUser" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Admin Baru</h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">

                <form action="{{ route('user.new') }}" method="POST">

                    @csrf

                    <div class="form-floating mb-2">
                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            id="floatingName"
                            placeholder="Nama"
                            required>

                        <label for="floatingName">Nama Lengkap</label>
                    </div>


                    <div class="form-floating mb-2">
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            id="floatingInput"
                            placeholder="name@example.com"
                            required>

                        <label for="floatingInput">Email</label>
                    </div>


                    <div class="form-floating mb-2">
                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            id="floatingPassword"
                            placeholder="Password"
                            required>

                        <label for="floatingPassword">Password</label>
                    </div>


                    <div class="form-floating mb-2">
                        <input
                            type="text"
                            name="telepon"
                            class="form-control"
                            id="floatingtelp"
                            placeholder="08xxxxxxxx"
                            required>

                        <label for="floatingtelp">Nomor Telepon</label>
                    </div>
                    <div>
                    <label>Pilih Role</label>
                   <select name="role" class="form-control">
                    <option value="1">Kasir</option>
                    <option value="2">Admin</option>
                    </select>
                    
                </div>


                    <button type="submit" class="btn btn-success w-100 mt-3">
                        Daftar
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection