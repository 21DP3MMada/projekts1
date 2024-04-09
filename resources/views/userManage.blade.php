<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="{{ asset('css/navbar-style.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
  <style>

.upload-text {
  font-family: sans-serif;
  font-weight: 800;
  color: white;
  text-transform: uppercase;
  margin-bottom: 20px;
 
}

table {
  border-radius: 10px;
  border: white 1px solid;
  width: 100%;
  min-width: 600px;
}

th {
  color: white;
  font-family: sans-serif;
  font-weight: 800;
  text-transform: uppercase;
  text-align: left;
  padding: 10px 2vw;
  background-color: rgb(37, 37, 37);
}

td {
  color: white;
  text-align: left;
  padding: 10px 2vw;
}

tbody {
  background-color: #1c1a1a;
}

.filter-div {
  display: grid; 
  grid-template-columns: 1fr auto;

  @media (max-width: 768px) {
    display: block;
    margin-bottom: 10px;
  }
}

#myInput {
  width: 100%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: none;
  border-radius: 20px;
  font-size: 12px;
  outline: transparent;
  background-color:#1c1a1a;
  margin-bottom: 12px;
  color: white;
  text-transform: uppercase;
  font-family: sans-serif;
  font-weight: 800;
  align-items: center;
}

#sortButton {
  display: flex;
  width: 150px;
  padding: 10px;
  color: white;
  border: white 1px solid;
  font-family: sans-serif;
  justify-content: center;
  font-weight: 800;
  font-size: 12px;
  border-radius: 20px;
  background-color: #1c1a1a;
  cursor: pointer;
  text-transform: uppercase;
  margin-top: 0;
  height: 40px;
  margin-left: 10px; 
}

div[style*="overflow-x:auto"] { 
  overflow-x: auto;  
  -webkit-overflow-scrolling: touch; 
}

.item-container {
    background-color: rgb(37, 37, 37);
    border-radius: 10px;
    padding: 16px;
}

</style>

<div class="navbar">

  <div class="back-btn-div">
    <span id="back-btn" onclick="window.location.href='{{'/home'}}'" class='bx bxs-left-arrow-alt'></span>
  </div>

  @auth 
    <nav class="nav-btn">
        <button class="user-btn" id="dropdown-toggle">
            {{ Auth::user()->name }}
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" onclick=	" window.location.href='{{'/home'}}'">{{ __('Dashboard') }}</a> 
            <a class="dropdown-item" onclick="window.location.href='{{'/profile'}}'">{{ __('Profile') }}</a> 
            <a style="color: red;" class="dropdown-item-logout" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> 
                @csrf 
            </form>
        </div>
      </nav>
  @endauth



</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $('#dropdown-toggle').click(function () {
    $(this).next('.dropdown-menu').toggle();
  });
</script>

  <div class="main-container">

  <div class="item-container">
    <h1 class="upload-text">User Management</h1>

    <!-- Filters --> 
    <div class="filter-div"> 
      <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names..." title="Type in a name">

      <button id="sortButton" onclick="toggleSort()">Filter Name A-Z</button>
    </div>

    <div style="overflow-x:auto;">
      <table id="myTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>User Type</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
          @foreach($users as $user)
            <tr style="">
              <td>{{ $user->id }}</td>
              <td>{{ $user->name }}</td>
              <td>{{ $user->email }}</td>
              <td>
                <form action="{{ route('users.updateUserType', $user) }}" method="POST">
                  @csrf
                  @method('PUT')
                  <select name="usertype" onchange="this.form.submit()">
                    <option value="user" {{ $user->usertype == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ $user->usertype == 'admin' ? 'selected' : '' }}>Admin</option>
                  </select>
                </form>
              </td>
              <td>{{ $user->created_at }}</td>
              <td>{{ $user->updated_at }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>


    </div>
  </div>



  


    <script>  

function myFunction() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[1]; 
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  }

  var isSorted = false;

  function filterNamesAtoZ() {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("myTable");
    switching = true;
    while (switching) {
      switching = false;
      rows = table.rows;
      for (i = 1; i < (rows.length - 1); i++) {
        shouldSwitch = false;
        x = rows[i].getElementsByTagName("TD")[1];
        y = rows[i + 1].getElementsByTagName("TD")[1];
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          shouldSwitch = true;
          break;
        }
      }
      if (shouldSwitch) {
        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
        switching = true;
      }
    }
  }

  function toggleSort() {
    if (!isSorted) {
      filterNamesAtoZ();
      isSorted = true;
      document.getElementById("sortButton").innerHTML = "Clear Filter";
      document.getElementById("sortButton").style.backgroundColor = "red";
    } else {
      resetSort();
      isSorted = false;
      document.getElementById("sortButton").innerHTML = "Filter Name A-Z";
      document.getElementById("sortButton").style.backgroundColor = "";
    }
  }

  function resetSort() {
    var table, rows, i, switching, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("myTable");
    switching = true;
    dir = "asc"; 
    while (switching) {
      switching = false;
      rows = table.rows;
      for (i = 1; i < (rows.length - 1); i++) {
        shouldSwitch = false;
        if (dir == "asc") {
          if (rows[i].innerHTML.toLowerCase() > rows[i + 1].innerHTML.toLowerCase()) {
            shouldSwitch = true;
            break;
          }
        } else if (dir == "desc") {
          if (rows[i].innerHTML.toLowerCase() < rows[i + 1].innerHTML.toLowerCase()) {
            shouldSwitch = true;
            break;
          }
        }
      }
      if (shouldSwitch) {
        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
        switching = true;
        switchcount ++;
      } else {
        if (switchcount == 0 && dir == "asc") {
          dir = "desc";
          switching = true;
        }
      }
    }

  }

      </script>
</body>
</html>