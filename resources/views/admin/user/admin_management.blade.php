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
                Tambah User
            </button>
        </div>
    </div>

    <div class="row">

        {{-- USER LIST --}}
        <div class="col-lg-6 col-md-12">
            <div class="card shadow mt-4">

                <div class="card-header">
                    <b>User</b>
                </div>

                <div class="card-body">

                    <table id="dataTable" class="table table-striped">
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
                            @foreach ($user as $item)
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
                                    <form action="{{ route('user.promote', ['id' => $item->id]) }}" method="POST">
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="btn btn-success btn-sm"
                                            onclick="return confirm('Jadikan user ini sebagai admin?')"
                                        >
                                            Jadikan Admin
                                        </button>

                                    </form>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>

                    </table>

                </div>
            </div>
        </div>

        {{-- ADMIN LIST --}}
        <div class="col-lg-6 col-md-12">
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
                                </td>

                                <td>{{ $item->telepon }}</td>

                                <td>

                                    @if ($item->id != Auth::user()->id)

                                    <form action="{{ route('user.demote',['id' => $item->id]) }}" method="POST">

                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Cabut hak admin user ini?')"
                                        >
                                            Cabut Admin
                                        </button>

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
                <h5 class="modal-title">User Baru</h5>

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


                    <button type="submit" class="btn btn-success w-100 mt-3">
                        Daftar
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection