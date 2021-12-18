@extends('layouts.app')

@php
$json = '{"qqq" : ' . $responseBody . '}';
$jsonarray = json_decode($json, true);
// arsort($jsonarray);
// print_r($jsonarray);
$page = !isset($_GET['page']) ? 1 : $_GET['page'];
$limit = 10;
$offset = ($page - 1) * $limit;
$total_items = count($jsonarray['qqq']);
$total_pages = ceil($total_items / $limit);
$array = array_splice($jsonarray['qqq'], $offset, $limit);
@endphp
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <ul class="list-group list-group-horizontal" style="width: 100%; overflow: auto">
                <li class="list-group-item">
                    <a href="{{ route('company') }}" class="btn text-primary">Companies</a>
                </li>
                <li class="list-group-item">
                    <a href="{{ route('employee') }}" class="btn text-primary">Employees</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="container text-center my-3">

        @if(@$_GET['status'] == "created")
        @include('layouts.create')
        @endif
        @if(@$_GET['status'] == "updated")
        @include('layouts.update')
        @endif
        @if(@$_GET['status'] == "deleted")
        @include('layouts.delete')
        @endif

    </div>

    @if(Auth::user()->role == 0)
    <div class="container-fluid mt-3 p-5 rounded-3" style="background-color: #ececec;">
        <h1 class="display-5 text-primary fw-bolder">Employee Information Form</h1>

        @if(@$_GET['id']=='' && @$_GET['name']=='' && @$_GET['email']=='')
        <form action="{{ route('employeev1') }}" method="POST">
            <div class="row g-3 my-2">
                <div class="col-12 col-md-6">
                    <label for="first_name">First Name</label>​ <input type="text" class="form-control"
                        name="first_name" placeholder="First Name" required />
                </div>
                <div class="col-12 col-md-6">
                    <label for="last_name">Last Name</label>​ <input type="text" class="form-control" name="last_name"
                        placeholder="Last Name" required />
                </div>
                <div class="col-12 col-md-6">
                    <label for="company">Company</label>​

                    <select class="form-control" name="company" required>
                        <option></option>
                        @foreach (json_decode($responseBody2,true) as $data)
                        @php $company_id = $data['id'];$company_name = $data['name']; @endphp
                        <option value="{{ $company_id }}">
                            {{ $company_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-6">
                    <label for="department">Department Name</label>​ <input type="text" class="form-control"
                        name="department" placeholder="Department Name" required />
                </div>
                <div class="col-12 col-md-6">
                    <label for="email">Email Address</label>
                    <input type="text" class="form-control" name="email" placeholder="Email Address" required />
                </div>
                <div class="col-12 col-md-6">
                    <label for="phone">Phone</label>
                    <input type="number" class="form-control" name="phone" placeholder="Phone No." required />
                </div>
                <div class="col-12 col-md-6">
                    <label for="address">Address</label>
                    <textarea class="form-control" name="address" placeholder="Address"></textarea>
                </div>
                <div class="col-12 col-md-6">
                    <br />
                    <input class="btn btn-primary my-2 text-white" type="submit" value="Create" name="submit" />
                </div>
            </div>
        </form>
        @else
        <form action="{{ route('employeeedit') }}" method="POST">
            <input type="hidden" name="id" value="{{ @$_GET['id'] }}">
            <div class="row g-3 my-2">
                <div class="col-12 col-md-6">
                    <label for="first_name">First Name</label>​ <input type="text" class="form-control"
                        name="first_name" placeholder="First Name" value="{{ @$_GET['first_name'] }}" />
                </div>
                <div class="col-12 col-md-6">
                    <label for="last_name">Last Name</label>​ <input type="text" class="form-control" name="last_name"
                        placeholder="Last Name" value="{{ @$_GET['last_name'] }}" />
                </div>
                <div class="col-12 col-md-6">
                    <label for="company">Company</label>​

                    <select class="form-control" name="company" required>
                        @php
                        $resp = json_decode($responseBody2);
                        @endphp
                        @foreach($resp as $r)
                        @php
                        $c_id = $r->id;
                        $c_name = $r->name;
                        @endphp
                        @if($c_id==@$_GET['id'])
                        <option value="{{ @$_GET['id'] }}">
                            {{ $c_name }}
                        </option>
                        @endif
                        @endforeach
                        @foreach (json_decode($responseBody2,true) as $data)
                        @php $company_id = $data['id'];$company_name = $data['name']; @endphp
                        <option value="{{ $company_id }}">
                            {{ $company_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-6">
                    <label for="department">Department Name</label>​ <input type="text" class="form-control"
                        name="department" placeholder="Department Name" value="{{ @$_GET['department'] }}" />
                </div>
                <div class="col-12 col-md-6">
                    <label for="email">Email Address</label>
                    <input type="text" class="form-control" name="email" placeholder="Email Address"
                        value="{{ @$_GET['email'] }}" />
                </div>
                <div class="col-12 col-md-6">
                    <label for="phone">Phone</label>
                    <input type="number" class="form-control" name="phone" placeholder="Phone No."
                        value="{{ @$_GET['phone'] }}" />
                </div>
                <div class="col-12 col-md-6">
                    <label for="address">Address</label>
                    <textarea class="form-control" name="address"
                        placeholder="Address">{{ @$_GET['address'] }}</textarea>
                </div>
                <div class="col-12 col-md-6">
                    <br />
                    <input class="btn btn-primary my-2 text-white" type="submit" value="Update" name="submit" />
                </div>
        </form>
        @endif
    </div><a class="nav nav-link p-2 mt-3" href="#" id="csv">
        <i class="fas fa-download fa-2x"></i><br />
        <span class='text-dark' style="font-size: 0.8rem; font-weight:bold;">Export</span>
    </a>
    <div class="form-group pull-right mt-3">
        <input class="form-control" id="myInput" type="text" placeholder="Search Employee Details">
    </div>
    <div style="overflow: auto;max-width:100%;max-height:600px;padding:0.5rem;">
        <table id="spreadSheet" class="table table-striped my-4 tableFixHead results p-0">
            <thead>
                <tr class="tr-2">
                    <th scope="col" style="border-top-left-radius: 0.8rem;">No.</th>
                    <th scope="col">Name</th>
                    <th scope="col">Company</th>
                    <th scope="col">Department</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Address</th>
                    <th scope="col">Create Date</th>
                    <th scope="col">Update Date</th>
                    <th scope="col">Edit</th>
                    <th scope="col" style="border-top-right-radius: 0.8rem;">Delete</th>
                </tr>
            </thead>
            <tbody id="myTable">
                @for ($i = 0; $i < count($array); $i++) @php $id=$array[$i]['staff_id'];
                    $first_name=$array[$i]['first_name'];$last_name=$array[$i]['last_name']; $email=$array[$i]['email'];
                    $company=$array[$i]['company']; $department=$array[$i]['department']; $phone=$array[$i]['phone'];
                    $address=$array[$i]['address']; $created_at=$array[$i]['created_at'];
                    $updated_at=$array[$i]['updated_at']; @endphp <tr>
                    <td>{{$id}}</td>
                    <td>{{$first_name}} {{ $last_name }}</td>
                    <td>
                        @php
                        $resp = json_decode($responseBody2);
                        @endphp
                        @foreach($resp as $r)
                        @php
                        $c_id = $r->id;
                        $c_name = $r->name;
                        @endphp
                        @if($c_id==$company)
                        {{ $c_name }}
                        @endif
                        @endforeach</td>
                    <td>{{$department }}</td>
                    <td>{{$email }}</td>
                    <td>{{ $phone }}</td>
                    <td>{{$address }}</td>
                    <td>{{ $created_at }}</td>
                    <td>{{ $updated_at }}</td>
                    <td>
                        <a class='btn btn-primary text-white'
                            href='/employee?id={{$id}}&first_name={{$first_name
                            }}&last_name={{ $last_name }}&company={{ $company }}&department={{ $department }}&email={{ $email }}&phone={{ $phone }}&address={{ $address }}'><i
                                class='fas fa-pencil-alt'></i></a>
                    </td>
                    <td>
                        <form action="{{ route('employeedelete') }}" method="POST">
                            <input type="hidden" name="id" value="{{ $id }}" />
                            <button type="submit" class="btn btn-danger text-white"
                                onclick="return confirm('Confirm deleting company information?')"><i
                                    class="fas fa-trash-alt"></i>
                        </form>
                    </td>
                    </tr>
                    @endfor
            </tbody>
        </table>
        @for ($j = 1; $j <= $total_pages; $j++) <a class='btn btn-secondary p-2 mx-2' href='/employee?page={{$j}}'>
            {{$j}}</a>
            @endfor
    </div>
    @else
    <h1 class="display-5 text-primary fw-bolder">Employee Information</h1>
    <a class="nav nav-link p-2 mt-3" href="#" id="csv">
        <i class="fas fa-download fa-2x"></i><br />
        <span class='text-dark' style="font-size: 0.8rem; font-weight:bold;">Export</span>
    </a>
    <div class="form-group pull-right mt-3">
        <input class="form-control" id="myInput" type="text" placeholder="Search Employee Details">
    </div>
    <div style="overflow: auto;max-width:100%;max-height:600px;padding:0.5rem;">
        <table id="spreadSheet" class="table table-striped my-4 tableFixHead results p-0">
            <thead>
                <tr class="tr-2">
                    <th scope="col" style="border-top-left-radius: 0.8rem;">No.</th>
                    <th scope="col">Name</th>
                    <th scope="col">Company</th>
                    <th scope="col">Department</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Address</th>
                    <th scope="col">Create Date</th>
                    <th scope="col" style="border-top-right-radius: 0.8rem;">Update Date</th>
                </tr>
            </thead>
            <tbody id="myTable">
                @for ($i = 0; $i < count($array); $i++) @php $id=$array[$i]['staff_id'];
                    $first_name=$array[$i]['first_name'];$last_name=$array[$i]['last_name']; $email=$array[$i]['email'];
                    $company=$array[$i]['company']; $department=$array[$i]['department']; $phone=$array[$i]['phone'];
                    $address=$array[$i]['address']; $created_at=$array[$i]['created_at'];
                    $updated_at=$array[$i]['updated_at']; @endphp <tr>
                    <td>{{$id}}</td>
                    <td>{{$first_name}} {{ $last_name }}</td>
                    <td>{{$company }}</td>
                    <td>{{$department }}</td>
                    <td>{{$email }}</td>
                    <td>{{ $phone }}</td>
                    <td>{{$address }}</td>
                    <td>{{ $created_at }}</td>
                    <td>{{ $updated_at }}</td>
                    </tr>
                    @endfor
            </tbody>
        </table>
        @for ($j = 1; $j <= $total_pages; $j++) <a class='btn btn-secondary p-2 mx-2' href='/employee?page={{$j}}'>
            {{$j}}</a>
            @endfor

    </div>
    @endif
</div>
@endsection


<script src="https://code.jquery.com/jquery-2.2.4.min.js"
    integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () { $("#myInput").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function () {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
      });});

</script>
<script>
    $(document).ready(function () {
  function exportTableToCSV($table, filename) {
    var $rows = $table.find("tr:has(td),tr:has(th)"),
      // Temporary delimiter characters unlikely to be typed by keyboard
      // This is to avoid accidentally splitting the actual contents
      tmpColDelim = String.fromCharCode(11), // vertical tab character
      tmpRowDelim = String.fromCharCode(0), // null character
      // actual delimiter characters for CSV format
      colDelim = '","',
      rowDelim = '"\r\n"',
      // Grab text from table into CSV formatted string
      csv =
        '"' +
        $rows
          .map(function (i, row) {
            var $row = $(row),
              $cols = $row.find("td,th");

            return $cols
              .map(function (j, col) {
                var $col = $(col),
                  text = $col.text();

                return text.replace(/"/g, '""'); // escape double quotes
              })
              .get()
              .join(tmpColDelim);
          })
          .get()
          .join(tmpRowDelim)
          .split(tmpRowDelim)
          .join(rowDelim)
          .split(tmpColDelim)
          .join(colDelim) +
        '"',
      // Data URI
      csvData = "data:application/csv;charset=utf-8," + encodeURIComponent(csv);

    // console.log(csv);

    if (window.navigator.msSaveBlob) {
      // IE 10+
      //alert('IE' + csv);
      window.navigator.msSaveOrOpenBlob(
        new Blob([csv], { type: "text/plain;charset=utf-8;" }),
        "csvname.csv"
      );
    } else {
      $(this).attr({ download: filename, href: csvData, target: "_blank" });
    }
  }

  var today = new Date();
  var dd = String(today.getDate()).padStart(2, "0");
  var mm = String(today.getMonth() + 1).padStart(2, "0");
  var yyyy = today.getFullYear();

  today = dd + "-" + mm + "-" + yyyy;

  var filename = "employee_list_" + today + ".csv";

  // This must be a hyperlink
  $("#csv").on("click", function (event) {
    exportTableToCSV.apply(this, [$("#spreadSheet"), filename]);

    // IF CSV, don't do event.preventDefault() or return false
    // We actually need this to be a typical hyperlink
  });
});
</script>
