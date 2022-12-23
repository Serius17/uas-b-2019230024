@extends('layouts.master')
@section('title', 'Item List')
@push('css_after')
    <style>
        td {
            max-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
@endpush
@section('content')

    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session()->get('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-10">
                        <h2>Item List</h2>
                    </div>
                    <div class="col-sm-2">
                        <a href="{{ route('items.create') }}" class="btn btn-success">
                            <i class="fa fa-plus fa-fw" aria-hidden="true"></i>
                            <span>Add New Item</span>
                        </a>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover text-center">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Stok</th>
                        <th colspan="2">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->id }}</td>
                            <td><a href="{{ route('items.show', $item->id) }}"> {{ $item->nama }}</a></td>
                            <td>{{ $item->stok }}</td>
                            <td colspan="2">{{ $item->harga }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="6">No data yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


@endsection
