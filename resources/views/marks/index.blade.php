<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grades List</title>
    <link rel="stylesheet" href="{{ asset('css/common-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/students-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
    <style>
        #students-table a {
            color: #000 !important;
            text-decoration: none !important;
        }
    </style>
</head>
<body>
    @include('layouts.sidebar')

    <div id="content">
        <h2>Grades List</h2>

        <div class="search-bar" style="display: flex; justify-content: center; margin-bottom: 20px;">
            <form action="{{ route('marks.index') }}" method="GET" style="display: flex; gap: 10px; align-items: center;">
                <select name="student_id" style="padding: 6px 10px; border-radius: 4px; border: 1px solid #ccc;">
                    <option value="">-- Filter by Student --</option>
                    @foreach(\App\Models\Student::all() as $student)
                        <option value="{{ $student->student_id }}" {{ request('student_id') == $student->student_id ? 'selected' : '' }}>
                            {{ $student->full_name }}
                        </option>
                    @endforeach
                </select>
                <select name="course_id" style="padding: 6px 10px; border-radius: 4px; border: 1px solid #ccc;">
                    <option value="">-- Filter by Subject --</option>
                    @foreach(\App\Models\Course::all() as $course)
                        <option value="{{ $course->course_id }}" {{ request('course_id') == $course->course_id ? 'selected' : '' }}>
                            [{{ $course->course_id }}] {{ $course->course_name ?? $course->name }}
                        </option>
                    @endforeach
                </select>
                <select name="status" style="padding: 6px 10px; border-radius: 4px; border: 1px solid #ccc;">
                    <option value="">-- Pass/Fail --</option>
                    <option value="Pass" {{ request('status') == 'Pass' ? 'selected' : '' }}>Pass</option>
                    <option value="Fail" {{ request('status') == 'Fail' ? 'selected' : '' }}>Fail</option>
                </select>
                <button class="search-btn" type="submit" style="padding: 6px 16px; border-radius: 4px;">
                    <i class="fas fa-search"></i> Search
                </button>
            </form>
        </div>
        <div style="text-align: center;">
            <button id="openMarkModalBtn" class="enroll-student-btn" type="button">
                <i class="fas fa-edit" style="margin-right: -6px;"></i>Add New Grade
            </button>
        </div>
        <div id="addMarkModal" class="modal">
            <div class="modal-content">
                <span class="close" id="closeMarkModalBtn">&times;</span>
                <h2>Add New Grade</h2>
                <form action="{{ route('marks.store') }}" method="POST" class="form-container">
                    @csrf
                    <div class="form-group">
                        <label for="enrollment_id">Enrollment</label>
                        <select id="enrollment_id" name="enrollment_id" required>
                            <option value="" disabled selected>Select enrollment</option>
                            @foreach(\App\Models\Enrollment::with('student', 'course')->get() as $enrollment)
                                <option value="{{ $enrollment->enrollment_id }}">
                                    {{ $enrollment->enrollment_id }} - 
                                    {{ $enrollment->student->full_name ?? 'N/A' }} / 
                                    {{ $enrollment->course->course_name ?? 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="mark">Grade</label>
                        <select id="mark" name="mark" required>
                            <option value="">-- Select Grade --</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="" disabled selected>Select status</option>
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
                        <input type="date" id="mark_date" name="mark_date" value="{{ date('Y-m-d') }}">
                    </div>
                    <button type="submit" class="enroll-btn">Add Grade</button>
                </form>
            </div>
        </div>
        <div id="editMarkModal" class="modal">
            <div class="modal-content">
                <span class="close" id="closeEditMarkModalBtn">&times;</span>
                <h2>Edit Grade</h2>
                <form id="editMarkForm" method="POST" class="form-container">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_mark_id">
                    <div class="form-group">
                        <label for="edit_enrollment_id">Enrollment</label>
                        <select id="edit_enrollment_id" name="enrollment_id" required>
                            @foreach(\App\Models\Enrollment::with('student', 'course')->get() as $enrollment)
                                <option value="{{ $enrollment->enrollment_id }}">
                                    {{ $enrollment->enrollment_id }} - 
                                    {{ $enrollment->student->full_name ?? 'N/A' }} / 
                                    {{ $enrollment->course->course_name ?? 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_mark">Grade</label>
                        <select id="edit_mark" name="mark" required>
                            <option value="">-- Select Grade --</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_status">Status</label>
                        <select id="edit_status" name="status">
                            <option value="">-- Select --</option>
                            <option value="Pass">Pass</option>
                            <option value="Fail">Fail</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_remark">Remark</label>
                        <textarea id="edit_remark" name="remark"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_mark_date">Date</label>
                        <input type="date" id="edit_mark_date" name="mark_date" value="{{ date('Y-m-d') }}">
                    </div>
                    <button type="submit" class="enroll-btn">Update Grade</button>
                </form>
            </div>
        </div>
        <table id="students-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Enrollment</th>
                    <th>Student</th>
                    <th>Subject</th>
                    <th>Grade</th>
                    <th>Status</th>
                    <th>Remark</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($marks as $mark)
                    <tr>
                        <td>{{ $mark->mark_id }}</td>
                        <td>
                            @if($mark->enrollment)
                                {{ $mark->enrollment->enrollment_id }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if($mark->enrollment && $mark->enrollment->student)
                                {{ $mark->enrollment->student->full_name }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if($mark->enrollment && $mark->enrollment->course)
                                {{ $mark->enrollment->course->course_name }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $mark->mark }}</td>
                        <td>{{ $mark->status }}</td>
                        <td>{{ $mark->remark }}</td>
                        <td>{{ $mark->mark_date }}</td>
                        <td>
                            <div class="action-buttons" style="display: flex; gap: 10px;">
                                <a href="#" 
                                   class="edit-btn edit-mark-btn"
                                   style="display: inline-flex; align-items: center;"
                                   data-id="{{ $mark->mark_id }}"
                                   data-enrollment="{{ $mark->enrollment_id }}"
                                   data-mark="{{ $mark->mark }}"
                                   data-status="{{ $mark->status }}"
                                   data-remark="{{ $mark->remark }}"
                                   data-date="{{ $mark->mark_date }}"
                                >
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('marks.destroy', $mark->mark_id) }}" method="POST" style="margin: 0;" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="edit-btn delete-btn" 
                                            style="display: inline-flex; align-items: center; height: 32px; padding: 0 12px;">
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
            {{ $marks->links() }}
        </div>
    </div>

    <script>
        const markModal = document.getElementById('addMarkModal');
        markModal.style.display = "none";
        const openMarkBtn = document.getElementById('openMarkModalBtn');
        const closeMarkBtn = document.getElementById('closeMarkModalBtn');

        openMarkBtn.onclick = function() {
            markModal.style.display = "block";
        }

        closeMarkBtn.onclick = function() {
            markModal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == markModal) {
                markModal.style.display = "none";
            }
        }

        const editMarkModal = document.getElementById('editMarkModal');
        editMarkModal.style.display = "none";
        const closeEditMarkBtn = document.getElementById('closeEditMarkModalBtn');
        const editMarkForm = document.getElementById('editMarkForm');

        document.querySelectorAll('.edit-mark-btn').forEach(btn => {
            btn.onclick = function(e) {
                e.preventDefault();
                document.getElementById('edit_mark_id').value = this.dataset.id;
                document.getElementById('edit_enrollment_id').value = this.dataset.enrollment;
                document.getElementById('edit_mark').value = this.dataset.mark;
                document.getElementById('edit_status').value = this.dataset.status;
                document.getElementById('edit_remark').value = this.dataset.remark;
                document.getElementById('edit_mark_date').value = this.dataset.date;
                editMarkModal.style.display = "block";
                editMarkForm.action = `/marks/${this.dataset.id}`;
            }
        });

        closeEditMarkBtn.onclick = function() {
            editMarkModal.style.display = "none";
        }

        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Are you sure you want to delete this grade?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>