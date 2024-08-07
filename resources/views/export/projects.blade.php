<!DOCTYPE html>
<html>
<head>
    <title>Project List</title>

    <!--ALL CUSTOM FUNCTIONS -->
    @php
        // Define a function within the Blade file
        function processString($inputString) {
            // Remove underscore
            $withoutUnderscore = str_replace('_', '', $inputString);

            // Remove everything from the pound sign (#) and onwards
            $finalString = explode('#', $withoutUnderscore)[0];

            // Capitalize the string
            $capitalizedString = ucwords($finalString);

            return $capitalizedString;
        }
    @endphp

    @php
        $business = auth()->user()->business;
    @endphp
  @php
   $color  = env("FRONT_END_VERSION") == "red"?"#dc2b28" : "#335ff0";
 @endphp

    <style>
        /* Add any additional styling for your PDF */
        body {
            font-family: Arial, sans-serif;
            margin:0;
            padding:0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size:10px;


        }
        .table_head_row{
            color:#fff;
            background-color:{{$color}};
            font-weight:600;
        }
        .table_head_row td{
            color:#fff;
        }
        .table_head_row th, tbody tr td {
            text-align: left;
            padding:10px 0px;
        }
        .table_row {
            background-color:#ffffff;
        }
        .table_row td{
            padding:10px 0px;
            border-bottom:0.2px solid #ddd;
        }

        .employee_index{

        }
        .employee{
            color:{{$color}};
            /*font-weight:600;*/
        }
        .employee_name{

        }
        .role{

        }
    .logo{
        width:75px;
        height:75px;
    }
    .file_title{
        font-size:1.3rem;
        font-weight:bold;
        text-align:right;
    }
    .business_name{
        font-size:1.2rem;
        font-weight:bold;
        display:block;
    }
    .business_address{

    }
    </style>

</head>
<body>

    <table style="margin-top:-30px">
       <tbody>
          <tr>
            @if ($business->logo)
            <td rowspan="2">
                <img class="logo" src="{{public_path($business->logo)}}" >
            </td>
            @endif
            <td></td>
          </tr>
          <tr>
            <td class="file_title">Project List </td>
          </tr>
          <tr>
            <td>
                <span class="business_name">{{$business->name}}</span>

            </td>


          </tr>
          <tr>
            <td>
                <address class="business_address">{{$business->address_line_1}}</address>
            </td>
          </tr>
        </tbody>
    </table>


    <table>
        <thead>
            <tr class="table_head_row">
                <th></th>
                <th>Name</th>
                <th>Status</th>

            </tr>
        </thead>
        <tbody>
            @foreach($projects as $index=>$project)
                <tr class="table_row">
                    <td class="employee_index" style="padding:0px 10px">{{ $index+1 }}</td>

                    <td class="name">
                        {{ $project->name }}
                    </td>

                    <td class="status">
                        {{ $project->status }}
                    </td>


                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>

