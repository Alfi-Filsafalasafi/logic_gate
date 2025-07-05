@extends('layouts.master')
@section('title', 'Jobsheet')
@section('subtitle', 'Daftar')

@section('dashboard', 'collapsed')
@section('materi', 'collapsed')
@section('jobsheet', '')
@section('add', 'collapsed')
@section('log-jobsheet', 'collapsed')
@section('user', 'collapsed')

@section('content')
    <div class="col-lg-12">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <strong>Sukses!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body pt-4">
                <a href="{{ route('admin.jobsheet.create') }}" class="btn btn-sm btn-success my-3">
                    <i class="bi bi-plus"></i> Tambah
                </a>
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Durasi</th>
                            <th><i class="bi bi-gear"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->title }}</td>
                                <td>{{ Str::limit($item->description, 50) }}</td>
                                <td>{{ $item->duration }}</td>
                                <td>
                                    <a href="{{ route('admin.jobsheet.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.jobsheet.destroy', $item->id) }}"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger btn-delete"
                                            data-id="{{ $item->id }}">
                                            <i class="bi bi-trash"></i>
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
@endsection
