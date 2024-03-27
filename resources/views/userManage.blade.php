<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
  <style>

    * {
      padding: 0;
      margin: 0;
      font-family: sans-serif;
      box-sizing: border-box;
    }
  
    body {
      background-color: rgb(0, 0, 0);
        min-width: 375px;
        align-items: center;
        justify-content: center;
        font-family: sans-serif;
  
    }
  
    .back-btn-div {
        display: flex;
        margin-left: 20px;
        margin-top: 20px;
      }
  
      #back-btn {
        position: absolute;
        height: 40px;
        width: 40px;
        background: white;
        text-align: center;
        color: black;
        line-height: 40px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 1.25rem;
      }
  
    .container {
      display: flex;
      padding: 10px 100px;
      width: 100%;
    }

  
  .alert-danger {
    color: red;
    font-size: 14px;
    margin-top: 5px;
    width: 450px;
    background-color: #2b0909;
    height: 46px;
    border-radius: 20px;
    padding-left: 20px;
    padding-top: 12px;
    margin-bottom: 10px;
  }
  
  .alert-success {
    color: green;
    font-size: 14px;
    margin-top: 5px;
    width: 450px;
    background-color: #072907;
    height: 46px;
    border-radius: 20px;
    padding-left: 20px;
    display: flex;
    padding-top: 12px;
    margin-bottom: 10px;
  }

.upload-text {
  font-family: sans-serif;
  font-weight: 800;
  color: white;
  text-transform: uppercase;
  margin-bottom: 20px;
 
}

table {
  
  border: white 1px solid;
  padding: 10px;
  width: 100%;
  border-radius: 20px;
  border-collapse: collapse;
  min-width: 600px;
}


th {
  color: white;
  font-family: sans-serif;
  font-weight: 800;
  text-transform: uppercase;
  text-align: left;
  padding: 10px 2vw;
  background-color: rgb(36, 35, 35);
}

td {
  color: white;
  text-align: left;
  padding: 10px 2vw;
}

tbody {
  background-color: rgb(0, 0, 0);
}

.filter-div {
  display: grid; /* Enable grid layout */
  grid-template-columns: 1fr auto;
}

#myInput {
  width: 300px;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: none;
  border-radius: 20px;
  font-size: 12px;
  outline: transparent;
  background-color:rgb(36, 35, 35);
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
  background-color: rgb(36, 35, 35);
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


  </style>

  <div class="back-btn-div">
    <span id="back-btn" onclick="window.location.href='{{'/home'}}'" class='bx bxs-left-arrow-alt'></span>
  </div>

  <div style="flex-direction: column;" class=container>

    <h1 style="margin-top: 20px" class="upload-text">User Management</h1>

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