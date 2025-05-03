@extends('admin._layout.main')
@section('title', __('TPQ At-Taqwa'))
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Role Detail</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="card-body">
                <form id="form_role_edit" action="{{ route('roles.store') }}" method="POST">
                    @csrf
                    @method('POST')

                    <!-- Role Name Input -->
                    <div class="form-group">
                        <label class="font-weight-bold">Role Name:</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <!-- Permissions Table -->
                    <div class="form-group">
                        <label class="font-weight-bold">Role Permission</label>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td>Root Access</td>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="select_all_permissions">
                                                <label class="custom-control-label" for="select_all_permissions">Select All</label></label>
                                            </div>
                                        </td>
                                    </tr>
                                    @foreach($groupedPermissions as $group => $permissions)
                                    <tr>
                                        <td class="text-muted font-weight-bold">{{ ucfirst($group) }}</td>
                                        <td>
                                            <div class="row">
                                                @foreach($permissions as $permission)
                                                    <div class="col-lg-3 col-md-4">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="perm_{{ $permission->id }}"
                                                                name="permissions[]" value="{{ $permission->id }}"
                                                                {{ isset($role) && $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                            <label class="custom-control-label" for="perm_{{ $permission->id }}">
                                                                {{ ucfirst(explode(' ', $permission->name)[0]) }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="form-group d-flex justify-content-end">
                        <a href="{{ route('roles.index') }}" class="btn btn-danger mr-3">Kembali</a>
                        <button type="submit" name="action" class="btn btn-info">Simpan</button>
                    </div>

                    
                </form>
            </div>
        </div>
    </div>

@include('components.modal')

@endsection