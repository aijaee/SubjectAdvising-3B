<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject List</title>
    <link rel="stylesheet" href="{{ asset('css/common-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/students-style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
</head>
<body>
    @include('layouts.sidebar')

    <div id="content">
        <h2>Enrollments</h2>

        <!-- Search Bar -->
        <div class="search-bar" style="display: flex; justify-content: center; margin-bottom: 20px;">
            <form action="{{ route('enrollments.index') }}" method="GET" style="display: flex; gap: 10px; align-items: center;">
                <input type="text" name="query" placeholder="Search by Student or Subject..." value="{{ request('query') }}" style="padding: 6px 10px; border-radius: 4px; border: 1px solid #ccc;">
                <select name="status" style="padding: 6px 10px; border-radius: 4px; border: 1px solid #ccc;">
                    <option value="">-- Search by Status --</option>
                    <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="On Reservation" {{ request('status') == 'On Reservation' ? 'selected' : '' }}>On Reservation</option>
                </select>
                <button class="search-btn" type="submit" style="padding: 6px 16px; border-radius: 4px;">
                    <i class="fas fa-search"></i> Search
                </button>
            </form>
        </div>

        <!-- Add Enrollment Button -->
        <div style="text-align: center;">
            <button id="openEnrollmentModalBtn" class="enroll-student-btn" type="button">
                <i class="fas fa-plus"></i>Add Enrollment
            </button>
        </div>

        <!-- Add Enrollment Modal -->
        <div id="addEnrollmentModal" class="modal">
            <div class="modal-content">
                <span class="close" id="closeEnrollmentModalBtn">&times;</span>
                <h2 style="text-align:center;">Add Enrollment</h2>
                <form action="{{ route('enrollments.store') }}" method="POST" class="form-container" style="display: flex; flex-direction: column; align-items: center;">
                    @csrf
                    <div class="form-group" style="width: 100%; max-width: 350px;">
                        <label for="student_id">Student:</label>
                        <select name="student_id" id="student_id" required>
                            @foreach($students as $student)
                                <option value="{{ $student->student_id }}">{{ $student->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="width: 100%; max-width: 350px;">
                        <label for="course_id">Subject:</label>
                        <select name="course_id" id="course_id" required>
                            <option value="">-- Select Subject --</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->course_id }}">
                                    [{{ $course->course_id }}] {{ $course->course_name ?? $course->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="width: 100%; max-width: 350px;">
                        <label for="enrollment_date">Enrollment Date:</label>
                        <input type="date" name="enrollment_date" id="enrollment_date" required>
                    </div>
                    <div class="form-group" style="width: 100%; max-width: 350px;">
                        <label for="enrollment_status">Status:</label>
                        <select name="enrollment_status" id="enrollment_status" required>
                            <option value="Active">Active</option>
                            <option value="On Reservation">On Reservation</option>
                        </select>
                    </div>
                    <button type="submit" class="enroll-btn" style="width: 100%; max-width: 350px;">Add Enrollment</button>
                </form>
            </div>
        </div>

        <!-- Enrollment Table -->
        <table id="enrollmentTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Student Name</th>
                    <th>Subject</th>
                    <th>Enrollment Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($enrollments as $enrollment)
                    <tr>
                        <td>{{ $enrollment->enrollment_id }}</td>
                        <td>{{ $enrollment->student->full_name ?? '' }}</td>
                        <td>{{ $enrollment->course->course_name ?? '' }}</td>
                        <td>{{ $enrollment->enrollment_date }}</td>
                        <td>{{ $enrollment->enrollment_status }}</td>
                        <td>
                            <div class="action-buttons" style="display: flex; gap: 10px;">
                                <!-- Change Edit to a button for modal -->
                                <button type="button"
                                    class="edit-btn openEditEnrollmentModalBtn"
                                    style="display: inline-flex; align-items: center;"
                                    data-enrollment_id="{{ $enrollment->enrollment_id }}"
                                    data-student_id="{{ $enrollment->student_id }}"
                                    data-course_id="{{ $enrollment->course_id }}"
                                    data-enrollment_date="{{ $enrollment->enrollment_date }}"
                                    data-enrollment_status="{{ $enrollment->enrollment_status }}"
                                >
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form action="{{ route('enrollments.destroy', $enrollment->enrollment_id) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="edit-btn delete-btn"
                                            style="display: inline-flex; align-items: center; height: 32px; padding: 0 12px;">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </form>
                                <button type="button"
                                        class="edit-btn mark-btn"
                                        style="display: inline-flex; align-items: center; background: #ffd580; color: #222; border: 1px solid #ffd580;"
                                        data-enrollment="{{ $enrollment->enrollment_id }}"
                                        data-student="{{ $enrollment->student->full_name ?? '' }}"
                                        data-course="{{ $enrollment->course->course_name ?? '' }}"
                                        @if($enrollment->enrollment_status == 'On Reservation') disabled aria-disabled="true" @endif
                                >
                                    <i class="fas fa-plus-circle"></i> Grade
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Edit Enrollment Modal -->
        <div id="editEnrollmentModal" class="modal">
            <div class="modal-content">
                <span class="close" id="closeEditEnrollmentModalBtn">&times;</span>
                <h2 style="text-align:center;">Edit Enrollment</h2>
                <form id="editEnrollmentForm" method="POST" class="form-container" style="display: flex; flex-direction: column; align-items: center;">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="enrollment_id" id="edit_enrollment_id">
                    <div class="form-group" style="width: 100%; max-width: 350px;">
                        <label for="edit_student_id">Student:</label>
                        <select name="student_id" id="edit_student_id" required>
                            @foreach($students as $student)
                                <option value="{{ $student->student_id }}">{{ $student->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="width: 100%; max-width: 350px;">
                        <label for="edit_course_id">Subject:</label>
                        <select name="course_id" id="edit_course_id" required>
                            <option value="">-- Select Subject --</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->course_id }}">
                                    [{{ $course->course_id }}] {{ $course->course_name ?? $course->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="width: 100%; max-width: 350px;">
                        <label for="edit_enrollment_date">Enrollment Date:</label>
                        <input type="date" name="enrollment_date" id="edit_enrollment_date" required>
                    </div>
                    <div class="form-group" style="width: 100%; max-width: 350px;">
                        <label for="edit_enrollment_status">Status:</label>
                        <select name="enrollment_status" id="edit_enrollment_status" required>
                            <option value="Active">Active</option>
                            <option value="On Reservation">On Reservation</option>
                        </select>
                    </div>
                    <button type="submit" class="enroll-btn" style="width: 100%; max-width: 350px;">Update Enrollment</button>
                </form>
            </div>
        </div>

        <!-- Mark Modal -->
        <div id="markModal" class="modal">
            <div class="modal-content">
                <span class="close" id="closeMarkModalBtn">&times;</span>
                <h2>Add Grade</h2>
                <form id="markForm" action="{{ route('marks.store') }}" method="POST" class="form-container">
                    @csrf
                    <input type="hidden" id="mark_enrollment_id" name="enrollment_id">
                    <div class="form-group">
                        <label>Enrollment</label>
                        <input type="text" id="mark_enrollment_info" disabled>
                    </div>
                    <div class="form-group">
                        <label for="mark">Grade</label>
                        <input type="number" id="mark" name="mark" min="1" max="5" step="1" maxlength="1" oninput="if(this.value.length>1)this.value=this.value.slice(0,1);">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="">-- Select --</option>
                            <option value="Pass">Pass</option>
                            <option value="Fail">Fail</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="remark">Remark</label>
                        <textarea id="remark" name="remark"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="mark_date">Date</label>
                        <input type="date" id="mark_date" name="mark_date">
                    </div>
                    <button type="submit" class="enroll-btn">Add Grade</button>
                </form>
            </div>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            {{ $enrollments->links() }}
        </div>
    </div>

    <script>
        // Get the modal
        var modal = document.getElementById("addEnrollmentModal");

        // Get the button that opens the modal
        var btn = document.getElementById("openEnrollmentModalBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementById("closeEnrollmentModalBtn");

        // When the user clicks the button, open the modal 
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Edit Enrollment Modal logic
        var editModal = document.getElementById("editEnrollmentModal");
        var closeEditModalBtn = document.getElementById("closeEditEnrollmentModalBtn");
        var editForm = document.getElementById("editEnrollmentForm");

        // Open edit modal and populate fields
        document.querySelectorAll('.openEditEnrollmentModalBtn').forEach(function(btn) {
            btn.onclick = function(e) {
                e.preventDefault();
                // Set form action dynamically
                var enrollmentId = this.dataset.enrollment_id;
                editForm.action = "{{ url('enrollments') }}/" + enrollmentId;
                document.getElementById('edit_enrollment_id').value = enrollmentId;
                document.getElementById('edit_student_id').value = this.dataset.student_id;
                document.getElementById('edit_course_id').value = this.dataset.course_id;
                document.getElementById('edit_enrollment_date').value = this.dataset.enrollment_date;
                document.getElementById('edit_enrollment_status').value = this.dataset.enrollment_status;
                editModal.style.display = "block";
            }
        });

        closeEditModalBtn.onclick = function() {
            editModal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            // ...existing code for enrollment modal...
            if (event.target == editModal) {
                editModal.style.display = "none";
            }
            if (event.target == markModal) {
                markModal.style.display = "none";
            }
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Mark modal logic
        var markModal = document.getElementById("markModal");
        var closeMarkModalBtn = document.getElementById("closeMarkModalBtn");
        var markForm = document.getElementById("markForm");

        document.querySelectorAll('.mark-btn').forEach(function(btn) {
            btn.onclick = function(e) {
                e.preventDefault();
                var enrollmentId = this.dataset.enrollment;
                var student = this.dataset.student;
                var course = this.dataset.course;
                document.getElementById('mark_enrollment_id').value = enrollmentId;
                document.getElementById('mark_enrollment_info').value = enrollmentId + " - " + student + " / " + course;
                markModal.style.display = "block";
            }
        });

        closeMarkModalBtn.onclick = function() {
            markModal.style.display = "none";
        }

        window.onclick = function(event) {
            // ...existing code for enrollment modal...
            if (event.target == markModal) {
                markModal.style.display = "none";
            }
        }
    </script>
</body>
</html>
