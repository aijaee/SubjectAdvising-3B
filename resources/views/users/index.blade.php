<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <link rel="stylesheet" href="{{ asset('css/common-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/students-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
</head>
<body>
    @include('layouts.sidebar')

    <div id="content">
        <h2>User List</h2>

        @if(session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert error">
                <ul style="margin:0;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="search-bar" style="display: flex; justify-content: center; margin-bottom: 20px;">
            <form action="{{ route('users.index') }}" method="GET" style="display: flex; gap: 10px; align-items: center;">
                <input type="text" name="query" placeholder="Search by Name..." value="{{ request('query') }}" style="padding: 6px 10px; border-radius: 4px; border: 1px solid #ccc;">
                <select name="user_role" style="padding: 6px 10px; border-radius: 4px; border: 1px solid #ccc;">
                    <option value="">-- Search by Role --</option>
                    <option value="Student" {{ request('user_role') == 'Student' ? 'selected' : '' }}>Student</option>
                    <option value="Admin" {{ request('user_role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                </select>
                <button type="submit" class="search-btn" style="padding: 6px 16px; border-radius: 4px;">
                    <i class="fas fa-search"></i> Search
                </button>
            </form>
        </div>

        <div style="text-align: center;">
            <button id="openUserModalBtn" class="enroll-student-btn" type="button">
                <i class="fas fa-edit" style="margin-right: 10px;"></i>Add New User
            </button>
        </div>

        <div id="addUserModal" class="modal">
            <div class="modal-content">
                <span class="close" id="closeUserModalBtn">&times;</span>
                <h2 style="text-align:center;">Add New User</h2>
                <form id="addUserForm" action="{{ route('users.store') }}" method="POST" class="form-container" style="display: flex; flex-direction: column; align-items: center;" autocomplete="off">
                    @csrf
                    <div class="form-group" style="width: 100%; max-width: 350px;">
                        <label for="fullname">Full Name</label>
                        <input type="text" id="fullname" name="fullname" required>
                    </div>
                    <div class="form-group" style="width: 100%; max-width: 350px;">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group" style="width: 100%; max-width: 350px;">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" id="phone_number" name="phone_number">
                    </div>
                    <div class="form-group" style="width: 100%; max-width: 350px;">
                        <label for="user_role">User Role</label>
                        <select id="user_role" name="user_role" required>
                            <option value="Student">Student</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                    <div class="form-group" style="width: 100%; max-width: 350px;">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required autocomplete="new-password">
                        <small style="color:#888; margin-bottom:10px; display:block;">
                            Password must be at least 8 characters, include a number and a special symbol.
                        </small>
                    </div>
                    <div class="form-group" style="width: 100%; max-width: 350px;">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
                    </div>
                    <button type="submit" class="enroll-btn" style="width: 100%; max-width: 350px;">Add User</button>
                </form>
            </div>
        </div>

        <div id="editUserModal" class="modal">
            <div class="modal-content">
                <span class="close" id="closeEditUserModalBtn">&times;</span>
                <h2 style="text-align:center;">Edit User</h2>
                <form id="editUserForm" method="POST" class="form-container" style="display: flex; flex-direction: column; align-items: center;">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_user_id" name="user_id">
                    <div class="form-group" style="width: 100%; max-width: 350px;">
                        <label for="edit_fullname">Full Name</label>
                        <input type="text" id="edit_fullname" name="fullname" required>
                    </div>
                    <div class="form-group" style="width: 100%; max-width: 350px;">
                        <label for="edit_email">Email</label>
                        <input type="email" id="edit_email" name="email" required>
                    </div>
                    <div class="form-group" style="width: 100%; max-width: 350px;">
                        <label for="edit_phone_number">Phone Number</label>
                        <input type="text" id="edit_phone_number" name="phone_number">
                    </div>
                    <div class="form-group" style="width: 100%; max-width: 350px;">
                        <label for="edit_user_role">User Role</label>
                        <select id="edit_user_role" name="user_role" required>
                            <option value="Student">Student</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                    <div class="form-group" style="width: 100%; max-width: 350px;">
                        <label for="current_password">Current Password</label>
                        <input type="password" id="current_password" name="current_password" required>
                    </div>
                    <div class="form-group" style="width: 100%; max-width: 350px;">
                        <label for="edit_password">New Password</label>
                        <input type="password" id="edit_password" name="password" placeholder="New Password">
                        <small style="color:#888; margin-bottom:10px; display:block;">
                            Password must be at least 8 characters, include a number and a special symbol.
                        </small>
                    </div>
                    <div class="form-group" style="width: 100%; max-width: 350px;">
                        <label for="edit_password_confirmation">Confirm New Password</label>
                        <input type="password" id="edit_password_confirmation" name="password_confirmation" placeholder="Confirm New Password">
                    </div>
                    <button type="submit" class="enroll-btn" style="width: 100%; max-width: 350px;">Update User</button>
                </form>
            </div>
        </div>

        <table id="users-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Phone Number</th>
                    <th>User Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->fullname }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span style="letter-spacing:2px;">••••••••</span>
                        </td>
                        <td>{{ $user->phone_number }}</td>
                        <td>{{ $user->user_role }}</td>
                        <td>
                            <div class="action-buttons" style="display: flex; gap: 10px;">
                                <button type="button"
                                    class="edit-btn edit-user-btn"
                                    style="display: inline-flex; align-items: center;"
                                    data-id="{{ $user->id }}"
                                    data-fullname="{{ $user->fullname }}"
                                    data-email="{{ $user->email }}"
                                    data-phone="{{ $user->phone_number }}"
                                    data-role="{{ $user->user_role }}"
                                >
                                    <i class="fas fa-edit" style="margin-right: -6px;"></i>Edit
                                </button>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="margin: 0;" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination">
            {{ $users->links() }}
        </div>
    </div>

    <script>
        const userModal = document.getElementById('addUserModal');
        const openUserBtn = document.getElementById('openUserModalBtn');
        const closeUserBtn = document.getElementById('closeUserModalBtn');
        const addUserForm = document.getElementById('addUserForm');

        if (openUserBtn && userModal) {
            openUserBtn.onclick = function() {
                if (addUserForm) addUserForm.reset();
                userModal.style.display = "block";
            }
        }
        if (closeUserBtn && userModal) {
            closeUserBtn.onclick = function() {
                userModal.style.display = "none";
            }
        }

        const editUserModal = document.getElementById('editUserModal');
        const closeEditUserBtn = document.getElementById('closeEditUserModalBtn');
        const editUserForm = document.getElementById('editUserForm');

        if (editUserModal && closeEditUserBtn) {
            closeEditUserBtn.onclick = function() {
                editUserModal.style.display = "none";
            }
        }

        document.querySelectorAll('.edit-user-btn').forEach(btn => {
            btn.onclick = function(e) {
                e.preventDefault();
                document.getElementById('edit_user_id').value = this.dataset.id;
                document.getElementById('edit_fullname').value = this.dataset.fullname;
                document.getElementById('edit_email').value = this.dataset.email;
                document.getElementById('edit_phone_number').value = this.dataset.phone;
                document.getElementById('edit_user_role').value = this.dataset.role;
                document.getElementById('edit_password').value = '';
                document.getElementById('edit_password_confirmation').value = '';
                document.getElementById('current_password').value = '';
                if (editUserModal && editUserForm) {
                    editUserModal.style.display = "block";
                    editUserForm.action = window.location.origin + "/users/" + this.dataset.id;
                }
            }
        });

        if (addUserForm) {
            addUserForm.onsubmit = function(e) {
                var pwd = this.password.value;
                var hasLength = pwd.length >= 8;
                var hasNumber = /[0-9]/.test(pwd);
                var hasSpecial = /[^A-Za-z0-9]/.test(pwd);
                if (!(hasLength && hasNumber && hasSpecial)) {
                    alert('Password must be at least 8 characters, include a number and a special symbol.');
                    e.preventDefault();
                }
            };
        }

        if (editUserForm) {
            editUserForm.onsubmit = function(e) {
                var pwd = this.password.value;
                if (pwd.length > 0) {
                    var hasLength = pwd.length >= 8;
                    var hasNumber = /[0-9]/.test(pwd);
                    var hasSpecial = /[^A-Za-z0-9]/.test(pwd);
                    if (!(hasLength && hasNumber && hasSpecial)) {
                        alert('Password must be at least 8 characters, include a number and a special symbol.');
                        e.preventDefault();
                    }
                }
            };
        }

        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Are you sure you want to delete this user?')) {
                    e.preventDefault();
                }
            });
        });

        window.onclick = function(event) {
            if (event.target == userModal) {
                userModal.style.display = "none";
            }
            if (event.target == editUserModal) {
                editUserModal.style.display = "none";
            }
        }
    </script>
</body>
</html>
