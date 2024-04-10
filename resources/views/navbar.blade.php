<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('css/navbar-style.css') }}">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


<div class="navbar">

  <h1 class="logo" style="font-family: sans-serif; color: white; cursor: pointer; font-weight: 800">LOGO</h1>

  <div class="back-btn-div">
    <span id="back-btn" onclick="window.location.href='{{'/home'}}'" class='bx bxs-left-arrow-alt'></span>
  </div>

  @auth 

    <nav class="nav-btn">
      <button id="notification-btn">
        <i class='bx bx-bell'></i>
        @if($unreadNotifications->count())
            <span class="badge">{{ $unreadNotifications->count() }}</span>
        @endif
    </button>

    <div id="notifications-dropdown" style="display: none;">
      @if($unreadNotifications->isEmpty())
        <p class="no-notifications">You have no notifications</p> 
    @else
      @foreach($unreadNotifications as $notification)
          <div class="notification-item">
              {{ $notification->message }}
              <button class="mark-read" data-id="{{ $notification->id }}" onclick="markAsRead(this)"><i class='bx bx-check'></i></button>
          </div>
      @endforeach
      @endif
  </div>

        <button class="user-btn" id="dropdown-toggle">
            {{ Auth::user()->name }}
        </button>
        <div class="dropdown-menu">
            <a id="dropdown-1" class="dropdown-item" onclick=	" window.location.href='{{'/home'}}'">{{ __('Dashboard') }}</a> 
            <a id="dropdown-2" class="dropdown-item" onclick="window.location.href='{{'/profile'}}'">{{ __('Profile') }}</a> 
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

<script>
  document.getElementById('notification-btn').addEventListener('click', function () {
  let dropdown = document.getElementById('notifications-dropdown');
  if (dropdown.style.display === 'none') {
      dropdown.style.display = 'block'; 
  } else {
      dropdown.style.display = 'none';
  }
});

function markAsRead(buttonElement) {
      let notificationId = buttonElement.dataset.id;

      fetch('/notifications/' + notificationId + '/mark-read', {
          method: 'POST',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
              'Content-Type': 'application/json'
          }
      })
      .then(response => response.json())
      .then(data => {
          if (data.success) {
              buttonElement.parentElement.remove();

              let badge = document.querySelector('.badge');
              if (badge) {
                  let currentCount = parseInt(badge.textContent);
                  let newCount = currentCount - 1;
                  badge.textContent = newCount > 0 ? newCount : '';
                  if (newCount === 0) {
                      badge.style.display = 'none';
                  }
              }
          }
      })
      .catch(error => {
          console.error('Error marking notification as read:', error);
      });
  }

</script>