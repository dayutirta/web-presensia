@extends('layouts.user_type.auth')

@section('content')
<div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Users</h5>
                        </div>
                        <a href="#" class="btn bg-gradient-primary btn-sm mb-0" type="button">+ New User</a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table id="userTable" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Creation Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be dynamically populated by DataTables -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        $('#userTable').DataTable({
            ajax: 'path/to/your/api/users', // Ganti dengan URL API untuk mengambil data pengguna
            columns: [
                { data: 'id' },
                {
                    data: 'photo',
                    render: function(data) {
                        return `<img src="${data}" class="avatar avatar-sm me-3">`;
                    }
                },
                { data: 'name' },
                { data: 'email' },
                { data: 'role' },
                { data: 'creation_date' },
                {
                    data: null,
                    render: function(data) {
                        return `
                            <a href="#" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit user" onclick="editUser(${data.id})">
                                <i class="fas fa-user-edit text-secondary"></i>
                            </a>
                            <span>
                                <i class="cursor-pointer fas fa-trash text-secondary" onclick="deleteUser(${data.id})"></i>
                            </span>`;
                    }
                }
            ]
        });
    });

    function editUser(id) {
        // Logic to edit user
    }

    function deleteUser(id) {
        // Logic to delete user
    }
</script>
@endsection
@endsection
