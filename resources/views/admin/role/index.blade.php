@extends('admin._layout.main')
@section('title', __('TPQ At-Taqwa'))
@section('content')
    <div class="row">
        <div class="col">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Role</h1>
            </div>
            <div class="card mb-4">
                <div class="card-header py-3">

                    @auth
                    @if(auth()->user()->hasRole('admin') || auth()->user()->can('create role'))
                        <div class="d-sm-flex align-items-center justify-content-end">
                            <a href="{{ route('roles.create') }}" class="btn btn-sm btn-primary"> Tambah Role Baru</a>
                        </div>
                    @endif
                    @endauth
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Edit</th>
                                    <th>Hapus</th>
                                </tr>
                            </thead>
                            @foreach($roles as $no=>$data)
                                <tbody>
                                    <td>{{ $no+1 }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td>

                                        @auth
                                        @if(auth()->user()->hasRole('admin') || auth()->user()->can('update role'))
                                            <a href="{{ route('roles.detail', $data->id) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="ri-pencil-fill"></i>
                                            </a>
                                        @endif
                                        @endauth
                                    <td>
                                        @auth
                                        @if(auth()->user()->hasRole('admin') || auth()->user()->can('delete role'))
                                            <button type="button" class="btn btn-sm btn-danger" 
                                                onclick="confirmDelete({{ $data->id }}, '{{ $data->name }}', 'role')">
                                                <i class="ri-delete-bin-fill"></i>
                                            </button>
                                        @endif
                                        @endauth
                                    </td>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">User</h1>
            </div>
            <div class="card mb-4">
                <div class="card-header py-3">
                    @auth
                    @if(auth()->user()->hasRole('admin') || auth()->user()->can('create user'))
                        <div class="d-sm-flex align-items-center justify-content-end">
                            <button type="button" class="btn btn-sm btn-primary formModalBtn" onclick="openUserModal('add')">Add User</button>
                        </div>
                    @endif
                    @endauth
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Edit</th>
                                    <th>Hapus</th>
                                </tr>
                            </thead>
                            @foreach($users as $no=>$data)
                                <tbody>
                                    <td>{{ $no+1 }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->username }}</td>
                                    <td>{{ $data->phone }}</td>
                                    <td>{{ $data->email }}</td>
                                    <td>{{ $data->roles->first()->name ?? '' }}</td>
                                    <td>
                                        @auth
                                        @if(auth()->user()->hasRole('admin') || auth()->user()->can('update user'))
                                            <button type="button"
                                                class="btn btn-sm btn-primary"
                                                onclick="openUserModal('edit', {
                                                    id: '{{ $data->id }}',
                                                    name: '{{ $data->name }}',
                                                    username: '{{ $data->username }}',
                                                    phone: '{{ $data->phone }}',
                                                    email: '{{ $data->email }}',
                                                    role_id: '{{ $data->roles->first()->id ?? '' }}',                                        
                                                })">
                                                <i class="ri-pencil-fill"></i>
                                            </button>
                                        @endif
                                        @endauth
                                    
                                    <td>
                                        @auth
                                        @if(auth()->user()->hasRole('admin') || auth()->user()->can('delete user'))
                                            <button type="button" class="btn btn-sm btn-danger" 
                                                onclick="confirmDelete({{ $data->id }}, '{{ $data->name }}', 'user')">
                                                <i class="ri-delete-bin-fill"></i>
                                            </button>
                                        @endif
                                        @endauth
                                    </td>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
function openUserModal(action, data = {}) {
    if (action === 'add') {
        $('#userForm').attr('action', "{{ route('user.submit') }}");
        $('#userModalTitle').text('Add User');
        $('#userId').val('');
        $('#inputName').val('');
        $('#phone').val('');
        $('#username').val('');
        $('#email').val('');
        $('#password').val('');
        $('#selectRole').val('');
    } else if (action === 'edit') {
        $('#userForm').attr('action', "{{ route('user.submit') }}");
        $('#userModalTitle').text('Edit User');
        $('#userId').val(data.id);
        $('#inputName').val(data.name);
        $('#phone').val(data.phone);
        $('#username').val(data.username);
        $('#email').val(data.email);
        $('#password').val(''); // kosongkan password untuk edit
        $('#selectRole').val(data.role_id);
    }

    $('#userModal').modal('show');

}
</script>
    

@include('components.modal')
@include('admin.role.modal')

@endsection