<table cellspacing='0'> <!-- cellspacing='0' is important, must stay -->

    <!-- Table Header -->
    <thead>
    <tr>
        <th>ID</th>
        <th>task ID</th>
        <th>Job type</th>
        <th>Last tried at:</th>
    </tr>
    </thead>
    <!-- Table Header -->

    <!-- Table Body -->
    <tbody>
        @foreach($unfinishedList as $li){
        <tr>
            <td>{{$li->id}}</td>
            <td>{{$li->task_id}}</td>
            <td>{{$li->job_type}}</td>
            <td>{{$li->run_at}}</td>

        </tr><!-- Table Row -->
        }@endforeach


    </tbody>
    <!-- Table Body -->