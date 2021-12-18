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
        <h1 class="display-5 text-primary fw-bolder">Company Information Form</h1>

        @if(@$_GET['id']=='' && @$_GET['name']=='' && @$_GET['email']=='')
        <form action="{{ route('companyv1') }}" method="POST">
            <div class="row g-3 my-2">
                <div class="col-12 col-md-6">
                    <label>Name</label>​ <input type="text" class="form-control" name="com_name"
                        placeholder="Company Name" required />
                </div>
                <div class="col-12 col-md-6">
                    <label>Email Address</label>
                    <input type="text" class="form-control" name="email" placeholder="Email Address" required />
                </div>
                <div class="col-12 col-md-6">
                    <label for="address">Address</label>
                    <textarea class="form-control" name="address" placeholder="Address"></textarea>
                </div>
                <div class="col-12 col-md-6">
                    <input class="btn btn-primary my-2 text-white" type="submit" value="Create" name="submit" />
                </div>
            </div>
        </form>
        @else
        <form action="{{ route('companyedit') }}" method="POST">
            <input type="hidden" name="id" value="{{ @$_GET['id'] }}">
            <div class="row g-3 my-2">
                <div class="col-12 col-md-6">
                    <label>Name</label>​
                    @php $name = $_GET['name']; @endphp
                    <input type="text" class="form-control" name="com_name" placeholder="Company Name"
                        value="{{ $name }}" />

                </div>
                <div class="col-12 col-md-6">
                    <label>Email Address</label>
                    @php $email = $_GET['email']; @endphp
                    <input type="text" class="form-control" name="email" placeholder="Email Address"
                        value="{{ $email }}" />
                </div>
                <div class="col-12 col-md-6">
                    <label for="address">Address</label>
                    <textarea class="form-control" name="address"
                        placeholder="Address">{{ @$_GET['address'] }}</textarea>
                </div>
                <div class="col-12 col-md-6">
                    <input class="btn btn-primary my-2 text-white" type="submit" value="Update" name="submit" />
                </div>
            </div>
        </form>
        @endif
    </div>
    <div class="form-group pull-right mt-5">
        <input class="form-control" id="myInput" type="text" placeholder="Search Company Details">
    </div>
    <div style="overflow: auto;max-width:100%;max-height:600px;padding:0.5rem;">
        <table id="spreadSheet" class="table table-striped my-4 tableFixHead results p-0">
            <thead>
                <tr class="tr-2">
                    <th scope="col" style="border-top-left-radius: 0.8rem;">No.</th>
                    <th scope="col">Company Name</th>
                    <th scope="col">Email Address</th>
                    <th scope="col">Address</th>
                    <th scope="col">Create Date</th>
                    <th scope="col">Update Date</th>
                    <th scope="col">Edit</th>
                    <th scope="col" style="border-top-right-radius: 0.8rem;">Delete</th>
                </tr>
            </thead>
            <tbody id="myTable">
                @for ($i = 0; $i < count($array); $i++) @php $id=$array[$i]['id']; $name=$array[$i]['name'];
                    $email=$array[$i]['email_address']; $address=$array[$i]['address'] @endphp <tr>
                    <td>{{$id}}</td>
                    <td>{{$name }}</td>
                    <td>{{ $email }}</td>
                    <td>{{ $address }}</td>
                    <td>{{ $array[$i]['created_at'] }}</td>
                    <td>{{ $array[$i]['updated_at'] }}</td>
                    <td>
                        <a class='btn btn-primary text-white' href='/company?id={{$id}}&name={{$name
                            }}&email={{$email}}&address={{ $address }}'><i class='fas fa-pencil-alt'></i></a>
                    </td>
                    <td>
                        <form action="{{ route('companydelete') }}" method="POST">
                            <input type="hidden" name="id" value="{{ $array[$i]['id'] }}" />
                            <button type="submit" class="btn btn-danger text-white"
                                onclick="return confirm('Confirm deleting company information?')"><i
                                    class="fas fa-trash-alt"></i>
                        </form>
                    </td>
                    </tr>
                    @endfor
            </tbody>
        </table>
        @for ($j = 1; $j <= $total_pages; $j++) <a class='btn btn-secondary p-2 mx-2' href='/company?page={{$j}}'>
            {{$j}}</a>
            @endfor
            <a class="nav nav-link p-2" href="#" id="csv">
                <i class="fas fa-download fa-2x"></i><br />
                <span class='text-dark' style="font-size: 0.8rem; font-weight:bold;">Export</span>
            </a>
    </div>
    @else
    <h1 class="display-5 text-primary fw-bolder">Company Information</h1>
    <div class="form-group pull-right mt-3">
        <input class="form-control" id="myInput" type="text" placeholder="Search Company Details">
    </div>
    <div style="overflow: auto;max-width:100%;max-height:600px;padding:0.5rem;">
        <table id="spreadSheet" class="table table-striped my-4 tableFixHead results p-0">
            <thead>
                <tr class="tr-2">
                    <th scope="col" style="border-top-left-radius: 0.8rem;">No.</th>
                    <th scope="col">Company Name</th>
                    <th scope="col">Email Address</th>
                    <th scope="col">Address</th>
                    <th scope="col">Create Date</th>
                    <th scope="col" style="border-top-right-radius: 0.8rem;">Update Date</th>
                </tr>
            </thead>
            <tbody id="myTable">
                @for ($i = 0; $i < count($array); $i++) @php $id=$array[$i]['id']; $name=$array[$i]['name'];
                    $email=$array[$i]['email_address'];$address=$array[$i]['address']; @endphp <tr>
                    <td>{{$id}}</td>
                    <td>{{$name }}</td>
                    <td>{{ $email }}</td>
                    <td>{{ $address }}</td>
                    <td>{{ $array[$i]['created_at'] }}</td>
                    <td>{{ $array[$i]['updated_at'] }}</td>
                    </tr>
                    @endfor
            </tbody>
        </table>
        @for ($j = 1; $j <= $total_pages; $j++) <a class='btn btn-secondary p-2 mx-2' href='/company?page={{$j}}'>
            {{$j}}</a>
            @endfor
            <a class="nav nav-link p-2" href="#" id="csv">
                <i class="fas fa-download fa-2x"></i><br />
                <span class='text-dark' style="font-size: 0.8rem; font-weight:bold;">Export</span>
            </a>
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

  var filename = "company_list_" + today + ".csv";

  // This must be a hyperlink
  $("#csv").on("click", function (event) {
    exportTableToCSV.apply(this, [$("#spreadSheet"), filename]);

    // IF CSV, don't do event.preventDefault() or return false
    // We actually need this to be a typical hyperlink
  });
});
</script>
