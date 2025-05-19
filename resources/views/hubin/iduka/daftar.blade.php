@extends('layout.main')
@section('content')
    <div class="container-fluid mt-4">
        <h3>Daftar User IDUKA</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIP</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $user)
                    <tr>
                    <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->nip }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
