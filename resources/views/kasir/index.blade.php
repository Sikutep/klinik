@extends('template.index')

@section('title', 'Kasir')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="heading-antrian">Laporan Transaksi Pembayaran</h1>

            <div class="box-antrian">
                <div class="box-antrian-header">

                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <a href="/tambah-pasien" class="btn-tambah-pasien">+ Transaksi</a>


                        <div class="form-pencarian">
                            <input type="text" placeholder="Cari Dokter Pemeriksa" class="input-pencarian nama" />
                            <input type="text" placeholder="Cari Nama Pasien" class="input-pencarian nomor-antrian" />
                            <input type="text" placeholder="Cari Nomor Rekam Medis" class="input-pencarian nomor-rekam-medis" />
                            <button class="btn-cari">Cari</button>
                        </div>
                    </div>

                    <div>
                        <button class="btn-export-excel">Export Excel</button>
                    </div>
                </div>


                <table class="table table-striped">
                    <thead>
                        <tr>
                            <td>No Transaksi</td>
                            <td>Nama Pasien</td>
                            <td>Tindakan</td>
                            <td>Nama Kasir</td>
                            <td>Jumlah</td>
                            <td>Keterangan</td>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>TR-20-20-2023-029</td>
                            <td>Atep</td>
                            <td>Pemeriksaan</td>
                            <td>Brian Kurniawan</td>
                            <td>100.000</td>
                            <td>
                                <div class="action-buttons d-none d-md-flex">
                                    <!-- Desktop View -->
                                    <button class="btn-view" title="View">
                                        <i class="fa-solid fa-eye" style="color: white;"></i>
                                    </button>

                                </div>

                                <!-- Mobile View: Hamburger Dropdown -->
                                <!-- <div class="dropdown d-md-none">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fa-solid fa-bars"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="#"><i class="fa-solid fa-eye me-2"></i>View</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#"><i class="fa-solid fa-pencil-alt me-2"></i>Edit</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#"><i class="fa-solid fa-trash me-2"></i>Delete</a>
                                        </li>
                                    </ul>
                                </div> -->
                            </td>
                        </tr>
                    </tbody>
                </table>

                <nav aria-label="...">
                    <div class="pagination-wrapper">
                        <ul class="pagination" style="display: inline-flex;">
                            <li class="page-item disabled">
                                <a class="page-link">Previous</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection
