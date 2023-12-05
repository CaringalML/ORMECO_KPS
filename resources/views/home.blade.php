@extends('layouts.nougat')


@section('content')

<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">
<!-- CONTENT -->
<section id="content">
    <!-- NAVBAR -->
    <nav>
        <i class='bx bx-menu' ></i>
        <a href="#" class="nav-link">Reports</a>

        <form action="{{ route('home') }}" method="GET">
            <div class="form-input">
                <input type="search" name="query" value="{{ $query }}" placeholder="Search...">
                <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
            </div>
        </form>
        
        <input type="checkbox" id="switch-mode" hidden>
        <label for="switch-mode" class="switch-mode"></label>






        <style>
          .dark .dropdown-menu {
            background-color: #040720;
            color: #fff;
            width: 448px; /* Adjust the width as needed */
            overflow-y: auto; /* Add scrollbars when content exceeds the height */
            transition: box-shadow 0.3s ease; /* Add transition for the box shadow */
            border-radius: 11px; /* Add border radius to make sides round */
          }
        
          .dropdown-menu {
            background-color: #f8f9fa; /* Adjust the background color for light mode */
            color: #333; /* Adjust the text color for light mode */
            width: 448px; /* Adjust the width as needed */
            overflow-y: auto; /* Add scrollbars when content exceeds the height */
            transition: box-shadow 0.3s ease; /* Add transition for the box shadow */
            border-radius: 11px; /* Add border radius to make sides round */
          }
        
          .dropdown-menu:hover,
          .dropdown-menu.hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Add box shadow on hover */
          }
        
          .dropdown-menu .dropdown-header {
            font-size: 22px; /* Adjust the font size as desired */
            font-weight: bold; /* Add font weight if desired */
            padding: 10px; /* Adjust the padding as desired */
          }
        
          .dropdown-menu .dropdown-item {
            padding: 8px 16px; /* Adjust the padding as desired */
          }
        
          .dark .dropdown-menu a.dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.2);
          }
        
          .dropdown-menu.show {
            display: block;
          }
          
          .dropdown-menu a.dropdown-item:hover {
            background-color: rgba(0, 0, 0, 0.1); /* Adjust the hover color for light mode */
          }
        </style>
        
        
        
        
        
        @php
  $today = date('Y-m-d');
  $yesterday = date('Y-m-d', strtotime('-1 day'));
  $lastSevenDays = date('Y-m-d', strtotime('-7 days'));

  // Convert $notifications collection to an array
  $notificationsArray = $notifications ? $notifications->toArray() : [];

  $todayNotifications = array_filter($notificationsArray, function($notification) use ($user_id, $today) {
    return $notification['department_id'] == $user_id && date('Y-m-d', strtotime($notification['created_at'])) == $today;
  });

  $yesterdayNotifications = array_filter($notificationsArray, function($notification) use ($user_id, $yesterday) {
    return $notification['department_id'] == $user_id && date('Y-m-d', strtotime($notification['created_at'])) == $yesterday;
  });

  $lastSevenDaysNotifications = array_filter($notificationsArray, function($notification) use ($user_id, $lastSevenDays, $today) {
    $notificationDate = date('Y-m-d', strtotime($notification['created_at']));
    return $notification['department_id'] == $user_id && $notificationDate > $lastSevenDays && $notificationDate < $today;
  });

  $olderNotifications = array_filter($notificationsArray, function($notification) use ($user_id, $lastSevenDays) {
    return $notification['department_id'] == $user_id && date('Y-m-d', strtotime($notification['created_at'])) < $lastSevenDays;
  });

  $hasNotifications = !empty($todayNotifications) || !empty($yesterdayNotifications) || !empty($lastSevenDaysNotifications) || !empty($olderNotifications);
@endphp

<div class="dropdown">
  <i class="bx bxs-bell notification" onclick="toggleDropdown()">
    <span class="num">
      {{ !empty($todayNotifications) ? count($todayNotifications) : 0 }}
    </span>
  </i>
  <div class="dropdown-menu" id="dropdownMenu">
    <div class="dropdown-header">Notifications</div>

    @if(!empty($todayNotifications) || !empty($yesterdayNotifications) || !empty($lastSevenDaysNotifications) || !empty($olderNotifications))
      @if(!empty($todayNotifications))
        <div class="dropdown-item-category">
          <div class="category-header">Today</div>
          @foreach($todayNotifications as $notification)
            <a class="dropdown-item" href="#">
              <strong>{{ $notification['notices'] }}</strong>
              <br>
              <span class="created-at" id="datetime-{{ $loop->index }}">{{ date('M d, Y H:i:s', strtotime($notification['created_at'])) }}</span>
            </a>
          @endforeach
        </div>
      @endif

      @if(!empty($yesterdayNotifications))
        <div class="dropdown-item-category">
          <div class="category-header">Yesterday</div>
          @foreach($yesterdayNotifications as $notification)
            <a class="dropdown-item" href="#">
              <strong>{{ $notification['notices'] }}</strong>
              <br>
              <span class="created-at" id="datetime-{{ $loop->index }}">{{ date('M d, Y H:i:s', strtotime($notification['created_at'])) }}</span>
            </a>
          @endforeach
        </div>
      @endif

      @if(!empty($lastSevenDaysNotifications))
        <div class="dropdown-item-category">
          <div class="category-header">Last 7 Days</div>
          @foreach($lastSevenDaysNotifications as $notification)
            <a class="dropdown-item" href="#">
              <strong>{{ $notification['notices'] }}</strong>
              <br>
              <span class="created-at" id="datetime-{{ $loop->index }}">{{ date('M d, Y H:i:s', strtotime($notification['created_at'])) }}</span>
            </a>
          @endforeach
        </div>
      @endif

      @if(!empty($olderNotifications))
        <div class="dropdown-item-category">
          <div class="category-header">Older</div>
          @foreach($olderNotifications as $notification)
            <a class="dropdown-item" href="#">
              <strong>{{ $notification['notices'] }}</strong>
              <br>
              <span class="created-at" id="datetime-{{ $loop->index }}">{{ date('M d, Y H:i:s', strtotime($notification['created_at'])) }}</span>
            </a>
          @endforeach
        </div>
      @endif
    @else
      <div class="dropdown-footer text-center">
        No notifications
      </div>
    @endif
  </div>
</div>

<script>
  // Loop through all the date and time elements
  const dateElements = document.querySelectorAll('[id^="datetime-"]');
  dateElements.forEach(function (element) {
    // Get the original date and time value
    const originalDateTime = element.textContent.trim();

    // Format the date and time
    const formattedDateTime = new Date(originalDateTime).toLocaleString('en-US', { month: 'long', day: 'numeric', year: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' });

    // Update the element with the formatted date and time
    element.textContent = formattedDateTime;
  });
</script>

        
        
        
        
        
        
      
      
      
        
          
          <script>
            function toggleDropdown() {
              var dropdownMenu = document.getElementById("dropdownMenu");
              dropdownMenu.classList.toggle("show");
          
              // Adjust the left position of the dropdown menu
              dropdownMenu.style.left = "-415px"; // Replace with your desired left value
          
              // Adjust the height of the dropdown menu
              dropdownMenu.style.height = "auto"; // Reset height to auto
          
              // Check if the height exceeds 700px and set it to the maximum
              if (dropdownMenu.offsetHeight > 608) {
                dropdownMenu.style.height = "608px";
              }
            }
          
            document.addEventListener("click", function(event) {
              var dropdownMenu = document.getElementById("dropdownMenu");
              var notification = document.querySelector(".notification");
          
              if (!dropdownMenu.contains(event.target) && !notification.contains(event.target)) {
                dropdownMenu.classList.remove("show");
              }
            });
          </script>
          
          
          
          
          




        
        
          <a class="profile" href="home/profile">
            {{ auth()->user()->displayName }}
        
            @php
                use Kreait\Firebase\Exception\Auth\ExpiredIdToken;
        
                try {
                    // Get the UID from the session
                    $uid = Session::get('uid');
                    
                    // Retrieve the user from Firebase
                    $user = app('firebase.auth')->getUser($uid);
                    $user_id = $user->uid;
                    $filename = $user_id . '.'; // Start the filename with UID
                    $validExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'svg', 'webp', 'ico', 'psd', 'ai'];
                    $imagePath = '';
        
                    foreach ($validExtensions as $extension) {
                        $tempPath = public_path('images/' . $filename . $extension);
                        if (file_exists($tempPath)) {
                            $imagePath = $tempPath;
                            break;
                        }
                    }
                } catch (ExpiredIdToken $e) {
                    // Log out the user if the token has expired
                    auth()->logout();
                    
                    // Redirect to the login page or any other appropriate action
                    return redirect()->to('/login');
                }
            @endphp
        
            @if (!empty($imagePath))
                <img src="{{ asset('images/' . $filename . pathinfo($imagePath, PATHINFO_EXTENSION)) }}">
            @else
                <img src="{{ asset('images/default.jpg') }}">
            @endif
        </a>
        
        
    </nav>
    <!-- NAVBAR -->

    <!-- MAIN -->
    <main>
        <div class="head-title">
            <div class="left">
                <h1>Dashboard</h1>
                <ul class="breadcrumb">
                    <li>
                        <a href="{{ route('products.team') }}">Submit Report</a>
                    </li>
                    <li><i class='bx bx-chevron-right' ></i></li>
                    <li>
                        <a class="active" href="{{ route('products.admin_dashboard') }}">Home</a>
                    </li>
                </ul>
            </div>
        </div>
          

        <ul class="box-info">
            
          <li>
            <div class="input-container">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label>Category</label>
                    <input type="hidden" name="name" value="{{ auth()->user()->displayName }}">
                    
                    <select class="input" name="title" required>
                        <option value="Department of Energy">Department of Energy</option>
                        <option value="Energy Regulatory Commission">Energy Regulatory Commission</option>
                        <option value="National Electrification Administration">National Electrification Administration</option>
                        <option value="PSALM">PSALM</option>
                    </select>
                    
                    
                    {{-- @error('department_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror --}}
                    
        </li>



        <li>
          <span class="text">
              <p>Report Type</p>
          </span>
      
          <select class="input" name="report_type" required>
              <option value="" disabled selected>Select Report</option>
              @foreach($notices as $notice)
                  <option value="{{ $notice }}">{{ $notice }}</option>
              @endforeach
          </select>                        
          @error('notices')
              <div class="alert alert-danger">{{ $message }}</div>
          @enderror
      </li>
      
        



            <li>
                        <h5>Upload a file:</h5>
                        <input type="file" name="file" class="input" id="file" required>
                        {{-- @error('notices')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror --}}
                        {{-- <button type="submit">Add</button> --}}
                        <button type="submit">
                            <span class="shadow"></span>
                            <span class="edge"></span>
                            <span class="front text"> Add
                            </span>
                          </button>
                    </form>
                    
                </div>
            </li>
            

        </ul>

     


        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>Submitted Reports</h3>
                    {{-- <i class='bx bx-search'></i>
                    <i class='bx bx-filter'></i> --}}
                </div>


                <table>
                    <thead>
                      <tr>
                        <th>Category</th>
                        <th>Report Type</th>
                        <th>Files</th>
                        <th>Date and Time</th>
                        
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($products as $product)
                        <tr onclick="window.location='{{ route('products.preview', $product->id) }}';">
                          <td>{{ $product->title }}</td>
                          <td>{{ $product->report_type }}</td>
                          <td>{{ $product->file }}</td>
                          <td><span id="datetime-{{ $product->id }}">{{ $product->created_at }}</span></td>
                         
                          <td>
                            @if ($product->status == 1)
                            <span class="status completed">Approved</span>
                            @else
                            <span class="status pending">Pending</span>
                            @endif
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                  
                  
                  
                  
                

                
                  {{ $products->links() }}
            </div>
        </div>


        <div id="confirmationModal" class="confirmation-modal">
            <h2>Are you sure you want to delete this?</h2>
            <p><span id="itemId"></span></p>
            <div class="btn-container">
              <button onclick="deleteItem()">Yes</button>
              <button onclick="closeConfirmationModal()">Cancel</button>
            </div>
          </div>
          
          <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
          <script>
            var deleteItemId;
          
            function openConfirmationModal(itemId) {
              deleteItemId = itemId;
              document.getElementById('itemId').textContent = itemId; // Display the item ID
              document.getElementById('confirmationModal').style.display = 'block';
            }
          
            function closeConfirmationModal() {
              deleteItemId = null;
              document.getElementById('confirmationModal').style.display = 'none';
            }
          
            function deleteItem() {
              if (deleteItemId) {
                var form = document.getElementById('deleteForm-' + deleteItemId);
                form.submit();
              }
            }
          </script>


<style>
    #itemId {
      display: none;
    }
  </style>
  
        
<style>

.confirmation-modal {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: white;
    border: 1px solid #ccc;
    padding: 20px;
    z-index: 9999;
}

.confirmation-modal:hover {
    display: block;
}

.confirmation-modal h2 {
    margin-top: 0;
}

.confirmation-modal .btn-container {
    text-align: right;
    margin-top: 20px;
}

.confirmation-modal .btn-container button {
    margin-left: 10px;
}

</style>

        <style>

.neon-green {
    color: green; /* Replace with your desired neon green color code */
}

.neon-red {
    color: red; /* Replace with your desired neon green color code */
}


            .input {
  background-color: #FFFFFF;
  max-width: 190px;
  height: 40px;
  padding: 10px;
  /* text-align: center; */
  border: 2px solid white;
  border-radius: 5px;
  /* box-shadow: 3px 3px 2px rgb(249, 255, 85); */
}

.input:focus {
  color: #38d39f;
  background-color: #FFFFFF;
  outline-color: #38d39f;
  box-shadow: -3px -3px 15px #38d39f;
  transition: .1s;
  transition-property: box-shadow;
}




button {
 position: relative;
 border: none;
 background: transparent;
 padding: 0;
 cursor: pointer;
 outline-offset: 4px;
 transition: filter 250ms;
 user-select: none;
 touch-action: manipulation;
}

.shadow {
 position: absolute;
 top: 0;
 left: 0;
 width: 100%;
 height: 100%;
 border-radius: 12px;
 background: hsl(0deg 0% 0% / 0.25);
 will-change: transform;
 transform: translateY(2px);
 transition: transform
    600ms
    cubic-bezier(.3, .7, .4, 1);
}

.edge {
 position: absolute;
 top: 0;
 left: 0;
 width: 100%;
 height: 100%;
 border-radius: 12px;
 background: linear-gradient(
    to left,
    hsl(340deg 100% 16%) 0%,
    hsl(340deg 100% 32%) 8%,
    hsl(340deg 100% 32%) 92%,
    hsl(340deg 100% 16%) 100%
  );
}

.front {
 display: block;
 position: relative;
 padding: 12px 27px;
 border-radius: 12px;
 font-size: 1.1rem;
 color: white;
 background: hsl(345deg 100% 47%);
 will-change: transform;
 transform: translateY(-4px);
 transition: transform
    600ms
    cubic-bezier(.3, .7, .4, 1);
}

button:hover {
 filter: brightness(110%);
}

button:hover .front {
 transform: translateY(-6px);
 transition: transform
    250ms
    cubic-bezier(.3, .7, .4, 1.5);
}

button:active .front {
 transform: translateY(-2px);
 transition: transform 34ms;
}

button:hover .shadow {
 transform: translateY(4px);
 transition: transform
    250ms
    cubic-bezier(.3, .7, .4, 1.5);
}

button:active .shadow {
 transform: translateY(1px);
 transition: transform 34ms;
}

button:focus:not(:focus-visible) {
 outline: none;
}
        </style>
          

    </main>
    <!-- MAIN -->
</section>
<!-- CONTENT -->



@endsection