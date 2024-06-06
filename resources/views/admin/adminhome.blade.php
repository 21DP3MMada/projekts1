@include('navbar')

    <style>
        .item-container {
            background-color: rgb(37, 37, 37);
            border-bottom-right-radius: 10px;
            border-bottom-left-radius: 10px;
            padding: 16px;
        }

        #dropdown-1 {
            background-color: rgb(56, 56, 56);
        }
        
        .back-btn-div {
            display: none;
        }

        #back-btn {
            display: none;
        }

        .logo {
            display: flex;
            margin: 0;
            padding: 0;
        }
    </style>


    <div class="main-container">

        <div class="text-container">
            <h1 style="color: white; text-transform:uppercase; font-family: sans-serif; font-weight: 800;">Dashbaord</h1>
            <p>test</p>
        </div>

        <div class="item-container">

            

            
            <a class="btn-dashboard" href="{{'/uploadpage'}}"><i id="dashboardIcon" class='bx bx-cog' ></i> Manage Books</a>

            <a class="btn-dashboard" href="{{'/managepage'}}"><i id="dashboardIcon" class='bx bx-user'></i> Manage Users</a>
            
            <a class="btn-dashboard" href="{{'/bookpage'}}"><i id="dashboardIcon" class='bx bx-book'></i> View All Books</a>

        </div>
        
    </div>
</div>





