<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <link rel="stylesheet" href="{{ asset('css/common-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/students-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
</head>
<body>
    @include('layouts.sidebar')

    <div id="content">
        <h2>Student List</h2>

        <div class="search-bar" style="display: flex; justify-content: center; margin-bottom: 20px;">
            <form action="{{ route('students.index') }}" method="GET" style="display: flex; gap: 10px; align-items: center;">
                <input type="text" name="query" placeholder="Search by Student Name..." value="{{ request('query') }}" style="padding: 6px 10px; border-radius: 4px; border: 1px solid #ccc;">
                <select name="gender" style="padding: 6px 10px; border-radius: 4px; border: 1px solid #ccc;">
                    <option value="">-- Search by Sex --</option>
                    <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
                <button type="submit" class="search-btn" style="padding: 6px 16px; border-radius: 4px;">
                    <i class="fas fa-search"></i> Search
                </button>
            </form>
        </div>
        <div style="text-align: center;">
            <button id="openStudentModalBtn" class="enroll-student-btn" type="button">
                <i class="fas fa-edit" style="margin-right: -6px;"></i>Add New Student
            </button>
        </div>
        <div id="addStudentModal" class="modal">
            <div class="modal-content">
                <span class="close" id="closeStudentModalBtn">&times;</span>
                <h2>Add New Student</h2>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data" class="form-container" id="addStudentForm">
                    @csrf
                    <div class="form-group">
                        <label for="user_email">User Email</label>
                        <select id="user_email" name="email" required>
                            <option value="">Select user student email</option>
                            @foreach($userStudents as $user)
                                <option 
                                    value="{{ $user->email }}"
                                    data-fullname="{{ $user->fullname }}"
                                    data-phone="{{ $user->phone_number }}"
                                >
                                    {{ $user->email }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" id="full_name" name="full_name" placeholder="Enter full name" required>
                    </div>
                    <div class="form-group">
                        <label for="date_of_birth">Date of Birth</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Sex</label>
                        <select id="gender" name="gender" required>
                            <option value="" disabled selected>Select sex</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="_section">Section</label>
                        <input type="text" id="_section" name="_section" placeholder="Enter section" required>
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" id="phone_number" name="phone_number" placeholder="Enter phone number" required>
                    </div>
                    <div class="form-group">
                        <label for="picture">Picture</label>
                        <input type="file" id="picture" name="picture">
                    </div>
                    <button type="submit" class="enroll-btn">Add Student</button>
                </form>
            </div>
        </div>
        <div id="editStudentModal" class="modal">
            <div class="modal-content">
                <span class="close" id="closeEditStudentModalBtn">&times;</span>
                <h2>Edit Student</h2>
                <form id="editStudentForm" method="POST" enctype="multipart/form-data" class="form-container">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_student_id">
                    <div class="form-group">
                        <label for="edit_full_name">Full Name</label>
                        <input type="text" id="edit_full_name" name="full_name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_date_of_birth">Date of Birth</label>
                        <input type="date" id="edit_date_of_birth" name="date_of_birth" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_gender">Sex</label>
                        <select id="edit_gender" name="gender" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_section">Section</label>
                        <input type="text" id="edit_section" name="_section" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_phone_number">Phone Number</label>
                        <input type="text" id="edit_phone_number" name="phone_number" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_email">Email</label>
                        <input type="email" id="edit_email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_picture">Picture</label>
                        <input type="file" id="edit_picture" name="picture">
                        <div id="edit_picture_preview" style="margin-top:10px;"></div>
                    </div>
                    <button type="submit" class="enroll-btn">Update Student</button>
                </form>
            </div>
        </div>
        <table id="students-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Birthdate</th>
                    <th>Sex</th>
                    <th>Section</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->student_id }}</td>
                        <td>
                            @if ($student->picture)
                                <img src="{{ asset('storage/' . $student->picture) }}" alt="Student Picture" width="100">
                            @else
                                <span>No Picture</span>
                            @endif
                        </td>
                        <td>{{ $student->full_name }}</td>
                        <td>{{ $student->date_of_birth }}</td>
                        <td>{{ $student->gender }}</td>
                        <td>{{ $student->_section }}</td>
                        <td>{{ $student->phone_number }}</td>
                        <td>{{ $student->email }}</td>
                        <td>
                            <div class="action-buttons" style="display: flex; gap: 10px;">
                                <a href="#" 
                                   class="edit-btn"
                                   style="display: inline-flex; align-items: center;"
                                   data-id="{{ $student->student_id }}"
                                   data-name="{{ $student->full_name }}"
                                   data-dob="{{ $student->date_of_birth }}"
                                   data-gender="{{ $student->gender }}"
                                   data-section="{{ $student->_section }}"
                                   data-phone="{{ $student->phone_number }}"
                                   data-email="{{ $student->email }}"
                                   data-picture="{{ $student->picture ? asset('storage/' . $student->picture) : '' }}"
                                >
                                    <i class="fas fa-edit" style="margin-right: -6px;"></i>Edit
                                </a>
                                <form action="{{ route('students.destroy', $student->student_id) }}" method="POST" class="delete-form">
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
            {{ $students->links() }}
        </div>
    </div>

    <script>
        const studentModal = document.getElementById('addStudentModal');
        const openStudentBtn = document.getElementById('openStudentModalBtn');
        const closeStudentBtn = document.getElementById('closeStudentModalBtn');

        openStudentBtn.onclick = function() {
            studentModal.style.display = "block";
        }
        closeStudentBtn.onclick = function() {
            studentModal.style.display = "none";
        }
        window.onclick = function(event) {
            if (event.target == studentModal) {
                studentModal.style.display = "none";
            }
        }

        const editStudentModal = document.getElementById('editStudentModal');
        const closeEditStudentBtn = document.getElementById('closeEditStudentModalBtn');
        const editStudentForm = document.getElementById('editStudentForm');
        let editingStudentId = null;

        document.querySelectorAll('.action-buttons .edit-btn').forEach(btn => {
            btn.onclick = function(e) {
                e.preventDefault();
                editingStudentId = this.dataset.id;
                document.getElementById('edit_student_id').value = this.dataset.id;
                document.getElementById('edit_full_name').value = this.dataset.name;
                document.getElementById('edit_date_of_birth').value = this.dataset.dob;
                document.getElementById('edit_gender').value = this.dataset.gender;
                document.getElementById('edit_section').value = this.dataset.section;
                document.getElementById('edit_phone_number').value = this.dataset.phone;
                document.getElementById('edit_email').value = this.dataset.email;
                const preview = document.getElementById('edit_picture_preview');
                if(this.dataset.picture) {
                    preview.innerHTML = `<img src="${this.dataset.picture}" alt="Student Picture" width="50">`;
                } else {
                    preview.innerHTML = '<span>No Picture</span>';
                }
                editStudentModal.style.display = "block";
                editStudentForm.action = `/students/${this.dataset.id}`;
            }
        });

        closeEditStudentBtn.onclick = function() {
            editStudentModal.style.display = "none";
        }
        window.onclick = function(event) {
            if (event.target == editStudentModal) {
                editStudentModal.style.display = "none";
            }
        }

        document.getElementById('edit_picture').onchange = function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const img = document.createElement('img');
                    img.src = event.target.result;
                    img.width = 100;
                    img.style.marginTop = "10px";
                    const previewDiv = document.getElementById('edit_picture_preview');
                    previewDiv.innerHTML = '';
                    previewDiv.appendChild(img);
                }
                reader.readAsDataURL(file);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var userEmailSelect = document.getElementById('user_email');
            if (userEmailSelect) {
                userEmailSelect.addEventListener('change', function() {
                    var selected = this.options[this.selectedIndex];
                    var fullname = selected.getAttribute('data-fullname') || '';
                    var phone = selected.getAttribute('data-phone') || '';
                    document.getElementById('full_name').value = fullname;
                    document.getElementById('phone_number').value = phone;
                });
            }
        });

        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Are you sure you want to delete this student?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>
