<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course List</title>
    <link rel="stylesheet" href="{{ asset('css/common-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/students-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
</head>
<body>
    @include('layouts.sidebar')

    <div id="content">
        <h2>Course List</h2>

        <!-- Search and Filter -->
        <div class="search-bar" style="display: flex; justify-content: center; margin-bottom: 20px;">
            <form action="{{ route('courses.index') }}" method="GET" style="display: flex; gap: 10px; align-items: center;">
                <input type="text" name="query" placeholder="Search by Course Name..." value="{{ request('query') }}" style="padding: 6px 10px; border-radius: 4px; border: 1px solid #ccc;">
                <select name="year_level" style="padding: 6px 10px; border-radius: 4px; border: 1px solid #ccc;">
                    <option value="">-- Search by Year Level --</option>
                    <option value="1" {{ request('year_level') == '1' ? 'selected' : '' }}>1</option>
                    <option value="2" {{ request('year_level') == '2' ? 'selected' : '' }}>2</option>
                    <option value="3" {{ request('year_level') == '3' ? 'selected' : '' }}>3</option>
                    <option value="4" {{ request('year_level') == '4' ? 'selected' : '' }}>4</option>
                </select>
                <button type="submit" class="search-btn" style="padding: 6px 16px; border-radius: 4px;">
                    <i class="fas fa-search"></i> Search
                </button>
            </form>
        </div>

        <!-- Add New Course Button -->
        <div class="add-student-container">
            <button id="openModalBtn" class="enroll-student-btn" type="button">Add New Course</button>
        </div>

        <!-- Add Course Modal -->
        <div id="addCourseModal" class="modal">
            <div class="modal-content">
                <span class="close" id="closeModalBtn">&times;</span>
                <h2>Add Course</h2>
                <form action="{{ route('courses.store') }}" method="POST" class="form-container">
                    @csrf
                    <div class="form-group">
                        <label for="course_name">Name</label>
                        <input type="text" name="course_name" id="course_name" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" name="description" id="description">
                    </div>
                    <div class="form-group">
                        <label for="duration">Duration</label>
                        <input type="text" name="duration" id="duration">
                    </div>
                    <div class="form-group">
                        <label for="instructor">Instructor</label>
                        <input type="text" name="instructor" id="instructor">
                    </div>
                    <div class="form-group">
                        <label for="year_level">Year Level</label>
                        <input type="number" name="year_level" id="year_level" min="1" max="4" step="1" maxlength="1" oninput="if(this.value.length>1)this.value=this.value.slice(0,1);">
                    </div>
                    <div class="form-group">
                        <label for="course_fee">Fee</label>
                        <input type="number" name="course_fee" id="course_fee" required>
                    </div>
                    <button type="submit" class="enroll-btn">Add Course</button>
                </form>
            </div>
        </div>

        <!-- Edit Course Modal -->
        <div id="editCourseModal" class="modal" style="display:none;">
            <div class="modal-content">
                <span class="close" id="closeEditModalBtn">&times;</span>
                <h2>Edit Course</h2>
                <form id="editCourseForm" method="POST" class="form-container">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="edit_course_name">Name:</label>
                        <input type="text" name="course_name" id="edit_course_name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_description">Description:</label>
                        <input type="text" name="description" id="edit_description">
                    </div>
                    <div class="form-group">
                        <label for="edit_duration">Duration:</label>
                        <input type="text" name="duration" id="edit_duration">
                    </div>
                    <div class="form-group">
                        <label for="edit_instructor">Instructor:</label>
                        <input type="text" name="instructor" id="edit_instructor">
                    </div>
                    <div class="form-group">
                        <label for="edit_year_level">Year Level:</label>
                        <input type="number" name="year_level" id="edit_year_level" min="1" max="4" step="1" maxlength="1" oninput="if(this.value.length>1)this.value=this.value.slice(0,1);">
                    </div>
                    <div class="form-group">
                        <label for="edit_course_fee">Fee:</label>
                        <input type="number" name="course_fee" id="edit_course_fee" required>
                    </div>
                    <button type="submit" class="enroll-btn">Update Course</button>
                </form>
            </div>
        </div>

        <!-- Courses Table -->
        <table id="students-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Duration (Hr)</th>
                    <th>Instructor</th>
                    <th>Year Level</th>
                    <th>Fee ($)</th>
                    <th>Enrolled Students</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $course)
                    <tr id="course-row-{{ $course->course_id }}">
                        <td class="course_id">{{ $course->course_id }}</td>
                        <td class="course_name">{{ $course->course_name }}</td>
                        <td class="description">{{ $course->description }}</td>
                        <td class="duration">{{ $course->duration }}</td>
                        <td class="instructor">{{ $course->instructor }}</td>
                        <td class="year_level">{{ $course->year_level }}</td>
                        <td class="course_fee">{{ number_format($course->course_fee, 2) }}</td>
                        <td class="enrollments_count" style="text-align:center;">{{ $course->enrollments_count ?? 0 }}</td>
                        <td>
                            <div style="display: flex; gap: 10px;">
                                <button
                                    class="edit-btn"
                                    type="button"
                                    data-id="{{ $course->course_id }}"
                                    data-name="{{ $course->course_name }}"
                                    data-description="{{ $course->description }}"
                                    data-duration="{{ $course->duration }}"
                                    data-instructor="{{ $course->instructor }}"
                                    data-year_level="{{ $course->year_level }}"
                                    data-fee="{{ $course->course_fee }}"
                                >Edit</button>
                                <form action="{{ route('courses.destroy', $course->course_id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination">
            @if(method_exists($courses, 'links'))
                {{ $courses->links() }}
            @endif
        </div>
    </div>

    <script>
        // Add Course Modal logic
        const modal = document.getElementById('addCourseModal');
        const openBtn = document.getElementById('openModalBtn');
        const closeBtn = document.getElementById('closeModalBtn');

        openBtn.onclick = function() {
            modal.style.display = "block";
        }
        closeBtn.onclick = function() {
            modal.style.display = "none";
        }

        // Edit Course Modal logic
        const editModal = document.getElementById('editCourseModal');
        const closeEditBtn = document.getElementById('closeEditModalBtn');
        const editForm = document.getElementById('editCourseForm');
        let editingCourseId = null;

        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.onclick = function() {
                editingCourseId = this.dataset.id;
                document.getElementById('edit_course_name').value = this.dataset.name;
                document.getElementById('edit_description').value = this.dataset.description;
                document.getElementById('edit_duration').value = this.dataset.duration;
                document.getElementById('edit_instructor').value = this.dataset.instructor;
                document.getElementById('edit_year_level').value = this.dataset.year_level;
                document.getElementById('edit_course_fee').value = this.dataset.fee;
                editModal.style.display = "block";
            }
        });

        closeEditBtn.onclick = function() {
            editModal.style.display = "none";
        }

        // Unified window click handler for both modals
        window.addEventListener('click', function(event) {
            if (modal.style.display === "block" && event.target === modal) {
                modal.style.display = "none";
            }
            if (editModal.style.display === "block" && event.target === editModal) {
                editModal.style.display = "none";
            }
        });

        // AJAX form submit for editing
        editForm.onsubmit = function(e) {
            e.preventDefault();
            const id = editingCourseId;
            const url = `/courses/${id}`;
            const data = {
                _token: '{{ csrf_token() }}',
                _method: 'PUT',
                course_name: document.getElementById('edit_course_name').value,
                description: document.getElementById('edit_description').value,
                duration: document.getElementById('edit_duration').value,
                instructor: document.getElementById('edit_instructor').value,
                year_level: document.getElementById('edit_year_level').value,
                course_fee: document.getElementById('edit_course_fee').value
            };

            fetch(url, {
                method: 'POST',
                headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if(result.success) {
                    // Update the table row with new values
                    const row = document.getElementById('course-row-' + id);
                    row.querySelector('.course_name').textContent = data.course_name;
                    row.querySelector('.description').textContent = data.description;
                    row.querySelector('.duration').textContent = data.duration;
                    row.querySelector('.instructor').textContent = data.instructor;
                    row.querySelector('.year_level').textContent = data.year_level;
                    row.querySelector('.course_fee').textContent = parseFloat(data.course_fee).toFixed(2);
                    editModal.style.display = "none";
                } else {
                    alert('Update failed!');
                }
            })
            .catch(() => alert('Update failed!'));
        };
    </script>
</body>
</html>
