<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalTitle"></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="userForm" action="" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="userId">

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Name</label>
                        <div class="col-sm-8">
                            <input type="text" id="inputName" name="name" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Username</label>
                        <div class="col-sm-8">
                            <input type="text" id="username" name="username" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Phone</label>
                        <div class="col-sm-8">
                            <input type="text" id="phone" name="phone" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Email</label>
                        <div class="col-sm-8">
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Password</label>
                        <div class="col-sm-8">
                            <input type="text" id="password" name="password" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Role</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="role_id" id="selectRole" required>
                                <option selected>Select Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-sm btn-danger mr-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="action" class="btn btn-success">Save</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
