<table id="example3"  class="table table-bordered display" style="min-width: 750px">
    <thead>
    <tr>
        <th>Subject</th>
        <th>Teacher</th>
        <th>Time</th>
    </tr>
    </thead>
    <tbody>
    @foreach($teacherAssign as $data)
        <tr>
            <td>{{ $data->subject->name }}</td>
            <td>{{ $data->teacher->time }}</td>
            <td>{{ $data->time}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
