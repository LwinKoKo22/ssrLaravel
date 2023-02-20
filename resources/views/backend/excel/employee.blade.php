<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
    <table class="table table-responsive" width="100%">
        <tr>
            <th class="col" style="width:150px;font-weight:bold;text-align:right;">No</th>
            <th class="col" style="width:150px;font-weight:bold;">Name</th>
            <th class="col" style="width:190px;font-weight:bold;">Email</th>
            <th class="col" style="width:150px;font-weight:bold;">Phone</th>
            <th class="col" style="width:150px;font-weight:bold;">Company</th>
            <th class="col" style="width:180px;font-weight:bold;">Created At</th>
            <th class="col" style="width:180px;font-weight:bold;">Updated At</th>
        </tr>
        @foreach ($employees as $employee)
            <tr>
                <td style="width:150px;">{{ $loop->iteration }}</td>
                <td style="width:150px">{{ $employee->fname . " " . $employee->lname}}</td>
                <td style="width:190px;">{{ $employee->email }}</td>
                <td style="width:150px;">{{ $employee->phone }}</td>
                <td style="width:150px;">{{ $employee->company ? $employee->company->name : '-' }}</td>
                <td style="width:180px;">{{ $employee->created_at->format('Y-m-d H:i:s') }}</td>
                <td style="width:180px;">{{ $employee->updated_at->format('Y-m-d H:i:s') }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>