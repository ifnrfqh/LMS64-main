@extends('layout.main')

@section('content')
    <style>
        .styled-number {
            background: #0DDBB9;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            text-align: center;
            line-height: 30px;
            color: #fff;
            font-weight: bold;
            margin: 0;
        }

        .card-active,
        .card-active p {
            color: #fff !important;
            background-color: #0DDBB9;
            font-weight: bold;
        }

        .card-list {
            transition: all 0.3s ease-in-out;
            transform-style: preserve-3d;
        }

        .card-list:hover {
            transform: translate(0, -10px) rotateX(5deg);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        }

        .card-list-body {
            transition: all 0.3s ease-in-out;
        }

        .card-list:hover .card-list-body {
            transform: translate(0, 5px);
        }

        .list-materi {
            overflow-y: auto;
            height: 100%;
        }
    </style>
    <div class="row">
        <div class="col-lg-3 grid-margin stretch-card d-flex flex-column gap-3 list-materi">
            @foreach ($tugass as $i => $tugas)
                <a href="{{ route('siswa.tugas.show', [$pelajaran->id, $tugas->id]) }}" style=" text-decoration: none;">
                    <div class="card card-list">
                        <div class="card-body card-list-body">
                            <div class="row">
                                <div class="col-lg-2">
                                    <p class="styled-number">{{ $i + 1 }}</p>
                                </div>
                                <div class="col-lg-10">
                                    <h3 class="card-title mb-1 mx-0 mt-0 fs-4">{{ $tugas->judul }}</h3>
                                    <p class="m-0 text-muted">{{ $tugas->deskripsi }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3 class="card-title mb-3 fs-3">{{ $tugas->judul }}</h3>
                            <p class="mb-0 mt-0">{{ $tugas->deskripsi }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
