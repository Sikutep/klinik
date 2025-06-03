@extends('template.index')

@section('title', 'Pendaftaran Pasien')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="heading-antrian">Data Pasien</h1>

            <div class="box-antrian">
                <div class="box-antrian-header">

                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <button class="btn-tambah-pasien">+ Tambah Pasien</button>

                        <div class="form-pencarian">
                            <input type="text" placeholder="Cari nama" class="input-pencarian nama" />
                            <input type="text" placeholder="Cari Nomor Rekam Medis" class="input-pencarian nomor-antrian" />
                            <select class="select-pencarian">
                                <option value="">Jenis Kelamin</option>
                                <option value="Laki-Laki">Laki-Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
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
                            <td>No</td>
                            <td>Nomor Rekam Medis</td>
                            <td>Nama Pasien</td>
                            <td>Jenis Kelamin</td>
                            <td>Nomor Telepon</td>
                            <td>Action</td>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>RM-20-20-2023-029</td>
                            <td>Atep</td>
                            <td>
                                L
                            </td>
                            <td>088912341234</td>
                            <td>
                                <div class="action-buttons d-none d-md-flex">
                                    <!-- Desktop View -->
                                    <button class="btn-view" title="View">
                                        <i class="fa-solid fa-eye" style="color: white;"></i>
                                    </button>
                                    <button class="btn-edit" title="Edit">
                                        <i class="fa-solid fa-pencil-alt" style="color: white;"></i>
                                    </button>
                                    <button class="btn-delete" title="Delete">
                                        <i class="fa-solid fa-trash" style="color: white;"></i>
                                    </button>
                                </div>

                                <!-- Mobile View: Hamburger Dropdown -->
                                <div class="dropdown d-md-none">
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
                                </div>
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