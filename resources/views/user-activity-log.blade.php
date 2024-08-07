<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>

  <div class="container">
    <div class="row mt-5">
        <table class="table table-responsive">
            <thead>
                <th>id</th>
                <th> TEST</th>
                <th>api_url</th>
                <th>user</th>
                <th>user_id</th>
                <th>message</th>
                <th>status_code</th>
                <th>line</th>
                <th>file</th>
                <th>fields</th>
                <th>token</th>
                <th>ip_address</th>
                <th>request_method</th>
            </thead>
            <tbody>
                @foreach ($activity_logs as $activity_log)
                <tr>
                    <tr>
                        <td>{{$activity_log->id}} </td>
                        <td><a class="btn btn-primary"  href="{{route('api-test',$activity_log->id)}}" target="_blank">TEST</a> </td>
                        <td>{{$activity_log->api_url}} </td>

    <td> @if ($activity_log->ERRuser)
        {{ ($activity_log->ERRuser->first_Name ." ". $activity_log->ERRuser->last_Name ." ". $activity_log->ERRuser->last_Name )}}
    @endif </td>
    <td>{{$activity_log->user_id}} </td>
    <td>{{$activity_log->message}} </td>
    <td>{{$activity_log->status_code}} </td>
    <td>{{$activity_log->line}} </td>
    <td>{{$activity_log->file}} </td>
    <td>{{$activity_log->fields}} </td>
    <td>{{$activity_log->token}} </td>
    <td>{{$activity_log->ip_address}} </td>
    <td>{{$activity_log->request_method}} </td>
                    </tr>
                </tr>
                @endforeach


            </tbody>

        </table>

        {{$activity_logs->links()}}

    </div>
  </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>
