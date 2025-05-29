<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Grades</title>
    <link rel="stylesheet" href="{{ asset('css/common-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/students-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
</head>
<body>
    @include('layouts.sidebar')

    <div id="content">
        <h2>Your Grades</h2>
        @if(isset($student) && $student)
            <div style="margin-bottom: 15px; color: #333; background: #f8f9fa; padding: 10px; border-radius: 5px;">
                <strong>Student ID:</strong> {{ $student->student_id }}<br>
                <strong>Name:</strong> {{ $student->full_name }}<br>
                <strong>Email:</strong> {{ $student->email }}
            </div>
        @endif
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

        <table id="marks-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Subject</th>
                    <th>Grade</th>
                    <th>Status</th>
                    <th>Remark</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @php $marks = $marks ?? collect(); @endphp
                @forelse($marks as $mark)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $mark->enrollment->course->course_name ?? 'N/A' }}</td>
                        <td>{{ $mark->mark ?? 'N/A' }}</td>
                        <td>{{ $mark->status ?? 'N/A' }}</td>
                        <td>{{ $mark->remark ?? '' }}</td>
                        <td>{{ $mark->mark_date ?? '' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;">No grades found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>


