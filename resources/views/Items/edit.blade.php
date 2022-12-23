@extends('layouts.master')
@section('title', 'Edit Items')
@section('content')
    <h2>Update Item</h2>
    <form action="{{ route('items.update', ['item' => $item->id]) }}" method="POST"> {{-- action buat ke update; method secara HTML tetap POST --}}
        @csrf
        @method('PATCH') {{-- Untuk update --}}
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="id">Item Type</label>
                <select class="form-control @error('id') is-invalid @enderror" name="id" id="id">
                    <option value="none" disabled selected>Item Type</option>
                    <option value="sepatu"
                        @if (old('id') == null) @if (substr($item->id, 0, 2) == 'SP')
                            selected @endif
                    @else {{ old('id') == 'baju' ? 'selected' : '' }} @endif>Baju</option>
                    <option value="baju"
                        @if (old('id') == null) @if (substr($item->id, 0, 2) == 'BJ')
                            selected @endif
                    @else {{ old('id') == 'baju' ? 'selected' : '' }} @endif>Baju</option>
                    <option value="tast"
                        @if (old('id') == null) @if (substr($item->id, 0, 2) == 'TS')
                            selected @endif
                    @else {{ old('id') == 'tas' ? 'selected' : '' }} @endif>Tas</option>
                </select>
                @error('id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-8 mb-3">
                <label for="nama">Nama</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama"
                    value="{{ old('nama') ?? $item->nama }}">
                @error('nama')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="harga">Harga</label>
                <input type="number" class="form-control @error('harga') is-invalid @enderror" name="harga"
                    id="harga" value="{{ old('harga') ?? $item->harga }}" min="0">
                @error('harga')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label for="harga">Stok</label>
                <input type="number" class="form-control @error('stok') is-invalid @enderror" name="stok" id="stok"
                    value="{{ old('stok') }}" min="1">
                @error('stok')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <button class="btn btn-primary btn-lg btn-block" type="submit">Update</button>
</form> @endsection
