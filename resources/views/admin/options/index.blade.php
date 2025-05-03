@extends('admin._layout.main')
@section('title', __('Pengaturan -  TPQ At-Taqwa'))
@section('heading', __('Pengaturan'))
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4 flex-wrap">
        <h1 class="h3 mb-2 text-gray-800">Pengaturan</h1>                                         
    </div>
    <div class="row">
        <div class="col-6">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Paket Donatur</h6>
                        <button id="addPackage" class="btn d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Tambah</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama Paket</th>
                                    <th>Nominal</th>
                                    <th>Edit</th>
                                    <th>Hapus</th>
                                </tr>
                            </thead>
                            @foreach ($donatePackage as $data)
                                <tbody>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->amount }}</td>
                                    <td>
                                        <button type="button" id="editPackage" class="btn btn-sm btn-primary btn-edit-entity"
                                            data-id="{{ $data->id }}"
                                            data-name="{{ $data->name }}"
                                            data-amount="{{ $data->amount }}"
                                            data-type="package"
                                            data-url="{{ route('options.update', $data->id) }}">
                                            Edit
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="confirmDelete({{ $data->id }}, '{{ $data->name }}', 'options')">
                                            <i class="ri-delete-bin-fill"></i>
                                        </button>
                                    </td>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Kategori Pegawai</h6>
                        <button id="addEmployeeCategory" class="btn d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Tambah</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Edit</th>
                                    <th>Hapus</th>
                                </tr>
                            </thead>

                            @foreach ($employeeCategory as $data)
                                <tbody>
                                    <td>{{ $data->name }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary btn-edit-entity"
                                            data-id="{{ $data->id }}"
                                            data-name="{{ $data->name }}"
                                            data-type="employee category"
                                            data-url="{{ route('options.update', $data->id) }}">
                                            Edit
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="confirmDelete({{ $data->id }}, '{{ $data->name }}', 'options')">
                                            <i class="ri-delete-bin-fill"></i>
                                        </button>
                                    </td>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-6">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Status Donatur</h6>
                        <button id="addDonaturStatus" class="btn d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Tambah</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Edit</th>
                                    <th>Hapus</th>
                                </tr>
                            </thead>
                            @foreach ($donaturStatus as $data)
                                <tbody>
                                    <td>{{ $data->name }}</td>
                                    <td>
                                        <button type="button" id="editDonaturStatus" class="btn btn-sm btn-primary btn-edit-entity"
                                            data-id="{{ $data->id }}"
                                            data-name="{{ $data->name }}"
                                            data-type="donatur status"
                                            data-url="{{ route('options.update', $data->id) }}">
                                            Edit
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="confirmDelete({{ $data->id }}, '{{ $data->name }}', 'options')">
                                            <i class="ri-delete-bin-fill"></i>
                                        </button>
                                    </td>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>

    <div class="row">
        {{-- <div class="col-6">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Status Santri</h6>
                        <button id="addStudentStatus" class="btn d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Tambah</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Edit</th>
                                    <th>Hapus</th>
                                </tr>
                            </thead>
                            @foreach ($studentStatus as $data)
                                <tbody>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->amount }}</td>
                                    <td>
                                        <button type="button" id="editStudentStatus" class="btn btn-sm btn-primary btn-edit-entity"
                                            data-id="{{ $data->id }}"
                                            data-name="{{ $data->name }}"
                                            data-type="student status"
                                            data-url="{{ route('options.update', $data->id) }}">
                                            Edit
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="confirmDelete({{ $data->id }}, '{{ $data->name }}', 'options')">
                                            <i class="ri-delete-bin-fill"></i>
                                        </button>
                                    </td>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="col-6">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Sekolah</h6>
                        <button id="addSchool" class="btn d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Tambah</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama Sekolah</th>
                                    <th>Edit</th>
                                    <th>Hapus</th>
                                </tr>
                            </thead>

                            @foreach ($school as $data)
                                <tbody>
                                    <td>{{ $data->name }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary btn-edit-entity"
                                            data-id="{{ $data->id }}"
                                            data-name="{{ $data->name }}"
                                            data-type="school"
                                            data-url="{{ route('options.update', $data->id) }}">
                                            Edit
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="confirmDelete({{ $data->id }}, '{{ $data->name }}', 'options')">
                                            <i class="ri-delete-bin-fill"></i>
                                        </button>
                                    </td>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Kategori Kelas</h6>
                        <button id="addClass" class="btn d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Tambah</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama Kelas</th>
                                    <th>Edit</th>
                                    <th>Hapus</th>
                                </tr>
                            </thead>
                            @foreach ($class as $data)
                                <tbody>
                                    <td>{{ $data->name }}</td>
                                    <td>
                                        <button type="button" id="editClass" class="btn btn-sm btn-primary btn-edit-entity"
                                            data-id="{{ $data->id }}"
                                            data-name="{{ $data->name }}"
                                            data-type="class"
                                            data-url="{{ route('options.update', $data->id) }}">
                                            Edit
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="confirmDelete({{ $data->id }}, '{{ $data->name }}', 'options')">
                                            <i class="ri-delete-bin-fill"></i>
                                        </button>
                                    </td>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Kategori Pemasukan</h6>
                        <button id="addIncomeCategory" class="btn d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Tambah</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Edit</th>
                                    <th>Hapus</th>
                                </tr>
                            </thead>

                            @foreach ($debit as $data)
                                <tbody>
                                    <td>{{ $data->name }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary btn-edit-entity"
                                            data-id="{{ $data->id }}"
                                            data-name="{{ $data->name }}"
                                            data-type="debet"
                                            data-url="{{ route('options.update', $data->id) }}">
                                            Edit
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="confirmDelete({{ $data->id }}, '{{ $data->name }}', 'options')">
                                            <i class="ri-delete-bin-fill"></i>
                                        </button>
                                    </td>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Kategori Pengeluaran</h6>
                        <button id="addOutcomeCategory" class="btn d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Tambah</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Edit</th>
                                    <th>Hapus</th>
                                </tr>
                            </thead>

                            @foreach ($credit as $data)
                                <tbody>
                                    <td>{{ $data->name }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary btn-edit-entity"
                                            data-id="{{ $data->id }}"
                                            data-name="{{ $data->name }}"
                                            data-type="credit"
                                            data-url="{{ route('options.update', $data->id) }}">
                                            Edit
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="confirmDelete({{ $data->id }}, '{{ $data->name }}', 'options')">
                                            <i class="ri-delete-bin-fill"></i>
                                        </button>
                                    </td>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-6">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Dompet</h6>
                        <button id="addWallet" class="btn d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Tambah</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama Dompet</th>
                                    <th>Jenis</th>
                                    <th>Edit</th>
                                    <th>Hapus</th>
                                </tr>
                            </thead>

                            @foreach ($wallet as $data)
                                <tbody>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->wallet_type }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary btn-edit-entity"
                                            data-id="{{ $data->id }}"
                                            data-name="{{ $data->name }}"
                                            data-wallet_type="{{ $data->wallet_type }}"
                                            data-type="wallet"
                                            data-url="{{ route('options.update', $data->id) }}">
                                            Edit
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="confirmDelete({{ $data->id }}, '{{ $data->name }}', 'options')">
                                            <i class="ri-delete-bin-fill"></i>
                                        </button>
                                    </td>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Status</h6>
                        <button id="addStatus" class="btn d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Tambah</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama Status</th>
                                    <th>Edit</th>
                                    <th>Hapus</th>
                                </tr>
                            </thead>

                            @foreach ($status as $data)
                                <tbody>
                                    <td>{{ $data->name }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary btn-edit-entity"
                                            data-id="{{ $data->id }}"
                                            data-name="{{ $data->name }}"
                                            data-type="status"
                                            data-url="{{ route('options.update', $data->id) }}">
                                            Edit
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="confirmDelete({{ $data->id }}, '{{ $data->name }}', 'options')">
                                            <i class="ri-delete-bin-fill"></i>
                                        </button>
                                    </td>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="row">
        <div class="col-6">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Status Pegawai</h6>
                        <button id="addEmployeeStatus" class="btn d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Tambah</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Edit</th>
                                    <th>Hapus</th>
                                </tr>
                            </thead>

                            @foreach ($employeeStatus as $data)
                                <tbody>
                                    <td>{{ $data->name }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary btn-edit-entity"
                                            data-id="{{ $data->id }}"
                                            data-name="{{ $data->name }}"
                                            data-type="employee status"
                                            data-url="{{ route('options.update', $data->id) }}">
                                            Edit
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="confirmDelete({{ $data->id }}, '{{ $data->name }}', 'options')">
                                            <i class="ri-delete-bin-fill"></i>
                                        </button>
                                    </td>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

@section('script')
<script>
document.addEventListener("DOMContentLoaded", function () {
    function openModal(title, actionUrl, fieldsHtml) {
        document.getElementById("modalEntityLabel").textContent = title;
        document.getElementById("entityForm").action = actionUrl;
        document.getElementById("entityFields").innerHTML = fieldsHtml;
        new bootstrap.Modal(document.getElementById("addEntityModal")).show();
    }

    function getFieldsHtml(type) {
        let extraField = "";

        if (type === "package") {
            extraField = `
                <div class="row mb-3 align-items-center">
                    <div class="col-4">
                        <label for="amount" class="form-label mb-0">Nominal</label>
                    </div>
                    <div class="col-8">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 rounded-start">Rp</span>
                            <input type="number" class="form-control border-start-0" id="amount" name="amount" min="0" required>
                        </div>
                    </div>
                </div>
            `;
        }

        if (type === "wallet") {
            extraField = `
                <div class="row mb-3 align-items-center">
                    <div class="col-4">
                        <label for="wallet_type" class="form-label mb-0">Jenis</label>
                    </div>
                    <div class="col-8">
                        <select class="form-control" name="wallet_type" aria-label="Default select example" required>
                            <option selected disabled>Pilih Jenis</option>
                            <option value="cash">Kas</option>
                            <option value="bank">Bank</option>
                        </select>
                    </div>
                </div>
            `;
        }

        return `
            <input type="hidden" id="type" name="type" value="${type}">
            <div class="row mb-3 align-items-center">
                <div class="col-4">
                    <label for="name" class="form-label mb-0">Nama</label>
                </div>
                <div class="col-8">
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
            </div>
            ${extraField}
        `;
    }

    // Tambah Kelas
    document.getElementById("addClass")?.addEventListener("click", function () {
        openModal("Tambah Kelas", "{{ route('options.submit') }}", getFieldsHtml("class"));
    });

    // Tambah Sekolah
    document.getElementById("addSchool")?.addEventListener("click", function () {
        openModal("Tambah Sekolah", "{{ route('options.submit') }}", getFieldsHtml("school"));
    });

    // Tambah Paket
    document.getElementById("addPackage")?.addEventListener("click", function () {
        openModal("Tambah Paket Donatur", "{{ route('options.submit') }}", getFieldsHtml("package"));
    });

    // Tambah Dompet
    document.getElementById("addWallet")?.addEventListener("click", function () {
        openModal("Tambah Dompet", "{{ route('options.submit') }}", getFieldsHtml("wallet"));
    });

    // Tambah Pemasukan
    document.getElementById("addIncomeCategory")?.addEventListener("click", function () {
        openModal("Tambah Pemasukan", "{{ route('options.submit') }}", getFieldsHtml("debet"));
    });

    // Tambah Pengeluaran
    document.getElementById("addOutcomeCategory")?.addEventListener("click", function () {
        openModal("Tambah Pengeluaran", "{{ route('options.submit') }}", getFieldsHtml("credit"));
    });

    // Tambah Pengeluaran
    document.getElementById("addStudentStatus")?.addEventListener("click", function () {
        openModal("Tambah Status Santri", "{{ route('options.submit') }}", getFieldsHtml("student status"));
    });

    // Tambah Pengeluaran
    document.getElementById("addDonaturStatus")?.addEventListener("click", function () {
        openModal("Tambah Status Donatur", "{{ route('options.submit') }}", getFieldsHtml("donatur status"));
    });

    // Tambah Employee Status
    document.getElementById("addEmployeeStatus")?.addEventListener("click", function () {
        openModal("Tambah Status Pegawai", "{{ route('options.submit') }}", getFieldsHtml("employee status"));
    });

    // Tambah Employee Category
    document.getElementById("addEmployeeCategory")?.addEventListener("click", function () {
        openModal("Tambah Kategori Pegawai", "{{ route('options.submit') }}", getFieldsHtml("employee category"));
    });

    // Tambah Status
    document.getElementById("addStatus")?.addEventListener("click", function () {
        openModal("Tambah Status", "{{ route('options.submit') }}", getFieldsHtml("status"));
    });


    document.querySelectorAll(".btn-edit-entity").forEach(button => {
    button.addEventListener("click", function () {
        console.log("Dataset:", this.dataset);

        const id = this.dataset.id;
        const name = this.dataset.name;
        const type = this.dataset.type;
        const url = this.dataset.url;
        const amount = this.dataset.amount || "";
        const wallet_type = this.dataset.wallet_type || "";

        let extraField = "";

        if (type === "package") {
            extraField = `
                <div class="row mb-3 align-items-center">
                    <div class="col-4">
                        <label for="amount" class="form-label mb-0">Nominal</label>
                    </div>
                    <div class="col-8">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 rounded-start">Rp</span>
                            <input type="number" class="form-control border-start-0" id="amount" name="amount" min="0" value="${amount}" required>
                        </div>
                    </div>
                </div>
            `;
        }

        if (type === "wallet") {
            extraField = `
                <div class="row mb-3 align-items-center">
                    <div class="col-4">
                        <label for="wallet_type" class="form-label mb-0">Jenis</label>
                    </div>
                    <div class="col-8">
                        <select class="form-control" name="wallet_type" required>
                            <option disabled ${wallet_type === "" ? "selected" : ""}>Pilih Jenis</option>
                            <option value="cash" ${wallet_type === "cash" ? "selected" : ""}>Kas</option>
                            <option value="bank" ${wallet_type === "bank" ? "selected" : ""}>Bank</option>
                        </select>
                    </div>
                </div>
            `;
        }

        const fieldsHtml = `
            <input type="hidden" name="_method" value="POST">
            <input type="hidden" name="id" value="${id}">
            <input type="hidden" id="type" name="type" value="${type}">
            <div class="row mb-3 align-items-center">
                <div class="col-4">
                    <label for="name" class="form-label mb-0">Nama</label>
                </div>
                <div class="col-8">
                    <input type="text" class="form-control" id="name" name="name" value="${name}" required>
                </div>
            </div>
            ${extraField}
        `;

        openModal(`Edit ${capitalizeFirstLetter(type)}`, url, fieldsHtml);
    });
});

function capitalizeFirstLetter(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

});

</script>
@endsection

@include('admin.options.modal')
@include('components.modal.delete')
@endsection