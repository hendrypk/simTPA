<div class="modal fade" id="modalStudent" tabindex="-1" aria-labelledby="modalStudentLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalStudentLabel">Add Entity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="modalStudentForm" method="POST" action="{{ route('student.submit') }}">
                    @csrf
                    <div class="mb-3" id="entityFields">
                        <!-- Form fields will be added dynamically here -->
                    </div>
                    <div class="modal-footer d-flex justify-content-end gap-3">
                        <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="action" class="btn btn-sm btn-primary">Simpan</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>