@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Soal Test BAGUS</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">

        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    </head>

    <body style="background: lightgray">

        <div class="container">
            <div class="mt-5 pt-3 text-center ">
                <h1>Repositori Arsip Lukisan Musueum Indonesia</h1>
            </div>
        </div>

        <div class="container mt-3 pt-5">
            <div class="row">
                <div class="col-md-12">

                    <div class="card border-0 shadow-sm rounded">
                        <div class="card-body">

                            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                Tambah Data
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>

                                        <form method="POST" action="{{ route('posts.store') }}"
                                            enctype="multipart/form-data">

                                            @csrf

                                            <div class="modal-body">

                                                <div class="mb-3">
                                                    <label for="gambar" class="form-label">Gambar</label>
                                                    <input class="form-control" type="file" id="gambar"
                                                        name="gambar">
                                                    <!-- error message untuk gambar -->
                                                    @error('gambar')
                                                        <div class="alert alert-danger mt-2">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="nama" class="form-label">Nama</label>
                                                    <input type='nama' class="form-control" id="nama"
                                                        name="nama">
                                                    <!-- error message untuk nama -->
                                                    @error('nama')
                                                        <div class="alert alert-danger mt-2">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>

                                                    <!-- error message untuk deskripsi -->
                                                    @error('deskripsi')
                                                        <div class="alert alert-danger mt-2">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>

                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                            <table id="" class="table table-bordered table-responsive-sm" style="width:100%">
                                <thead class="table-light">
                                    <tr>
                                        <th>GAMBAR</th>
                                        <th>NAMA</th>
                                        <th>PENGATURAN</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($posts as $post)
                                        <tr>
                                            <td class="text-center">
                                                <img src="{{ asset('/storage/posts/' . $post->gambar) }}"
                                                    class="rounded img-fluid" style="width: 150px">
                                            </td>

                                            <td>{{ $post->nama }}</td>

                                            <td class="text-center">
                                                <div class="d-grid gap-2 col-6 mx-auto">

                                                    <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                                        action="{{ route('posts.destroy', $post->id) }}" method="POST">

                                                        <a href="{{ route('posts.show', $post->id) }}"
                                                            class="btn btn-sm btn-dark mb-1">SHOW</a>

                                                        <a href="{{ route('posts.edit', $post->id) }}"
                                                            class="btn btn-sm btn-primary mb-1">EDIT</a>

                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-sm btn-danger mb-1">HAPUS</button>
                                                    </form>


                                                </div>

                                            </td>
                                        </tr>
                                    @empty
                                        <div class="alert alert-danger">
                                            Data Post belum Tersedia.
                                        </div>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="float-end">
                                {{ $posts->links() }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <script>
            //message with toastr
            @if (session()->has('success'))

                toastr.success('{{ session('success') }}', 'BERHASIL!');
            @elseif (session()->has('error'))

                toastr.error('{{ session('error') }}', 'GAGAL!');
            @endif
        </script>

        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

        <script>
            new DataTable('#example');
        </script>

    </body>

    </html>
@endsection
