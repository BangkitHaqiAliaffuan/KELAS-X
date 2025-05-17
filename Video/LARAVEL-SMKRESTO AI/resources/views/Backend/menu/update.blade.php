@extends('backend.back')


@section('admincontent')
    <div class="">
        <h2>Update Data</h2>
    </div>
    <div class="row">
        <div class="col-6">
            <form action="{{ url('admin/postmenu/' . $menu->idmenu) }}" method="post" enctype="multipart/form-data">
                @csrf
                <select class="form-select" name="idkategori" id="">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategoris as $kategori)
                        <option @selected($kategori->idkategori == $menu->idkategori) value="{{ $kategori->idkategori }}">{{ $kategori->kategori }}
                        </option>
                    @endforeach
                </select>

                <div class="mt-2">
                    <label class="form-label" for="">Menu</label>
                    <input class="form-control" value="{{ $menu->menu }}" type="text" name="menu">
                    <span class="text-danger">
                        @error('menu')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="mt-2">
                    <label class="form-label" for="">Deskripsi</label>
                    <input class="form-control" value="{{ $menu->deskripsi }}" type="text" name="deskripsi">
                    <span class="text-danger">
                        @error('deskripsi')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="mt-2">
                    <label class="form-label" for="">Harga</label>
                    <input class="form-control" value="{{ $menu->harga }}" type="number" name="harga">
                    <span class="text-danger">
                        @error('menu')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="mt-2">
                    <label class="form-label" for="">Gambar</label>
                    <input class="form-control" type="file" name="gambar">
                    <span class="text-danger">
                        @error('menu')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="mt-4">
                    <button class="btn btn-primary" type="submit">Upload</button>
                </div>
            </form>
        </div>
    </div>
@endsection
