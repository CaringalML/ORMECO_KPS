@extends('layouts.donut')


@section('content')

<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">
<!-- CONTENT -->
<section id="content">
    <!-- NAVBAR -->
    <nav>
        <i class='bx bx-menu' ></i>
        <a href="#" class="nav-link">Reports</a>


        <form action="{{ route('users.userlist') }}" method="GET">
            <div class="form-input">
                <input type="search" name="search" placeholder="Search..." value="{{ request('search') }}">
                <button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
            </div>
        </form>
        
        <input type="checkbox" id="switch-mode" hidden>
        <label for="switch-mode" class="switch-mode"></label>
        <a href="#" class="notification">
            <i class='bx bxs-bell' ></i>
            <span class="num">8</span>
        </a>
        
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
                <h1>List of Users</h1>
                <ul class="breadcrumb">
                    <li>
                        <a href="{{ route('users.userlist') }}">List of Users</a>
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
                <i class='bx bxs-group' ></i>
                <span class="text">
                    <h3>{{ \App\Models\Login::count() }}</h3>
                    <p>List of Users</p>
                </span>
            </li>
            <li>
                <i class='bx bx-cog'></i>
                <span class="text">
                    <h3>{{ \App\Models\Administrator::count() }}</h3>
                    <p>Total Admin</p>
                </span>
            </li>
            
        </ul>

     




        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>User List of Request</h3>
                </div>


                <table>
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Date and Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->user_id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>
                                    @if ($user->status == 1)
                                    <span class="status completed">Approved</span>
                                    @else
                                    <span class="status pending">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('users.updateStatus', $user->id) }}" method="POST">
                                        @csrf
                                        <label class="switch">
                                            <input type="checkbox" name="status" onchange="this.form.submit()" {{ $user->status == 1 ? 'checked' : '' }}>
                                            <div class="slider">
                                                <div class="circle">
                                                    <svg class="cross" xml:space="preserve" style="enable-background:new 0 0 512 512" viewBox="0 0 365.696 365.696" y="0" x="0" height="6" width="6" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                                        <g>
                                                            <path data-original="#000000" fill="currentColor" d="M243.188 182.86 356.32 69.726c12.5-12.5 12.5-32.766 0-45.247L341.238 9.398c-12.504-12.503-32.77-12.503-45.25 0L182.86 122.528 69.727 9.374c-12.5-12.5-32.766-12.5-45.247 0L9.375 24.457c-12.5 12.504-12.5 32.77 0 45.25l113.152 113.152L9.398 295.99c-12.503 12.503-12.503 32.769 0 45.25L24.48 356.32c12.5 12.5 32.766 12.5 45.247 0l113.132-113.132L295.99 356.32c12.503 12.5 32.769 12.5 45.25 0l15.081-15.082c12.5-12.504 12.5-32.77 0-45.25zm0 0"></path>
                                                        </g>
                                                    </svg>
                                                    <svg class="checkmark" xml:space="preserve" style="enable-background:new 0 0 512 512" viewBox="0 0 24 24" y="0" x="0" height="10" width="10" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                                        <g>
                                                            <path class="" data-original="#000000" fill="currentColor" d="M9.707 19.121a.997.997 0 0 1-1.414 0l-5.646-5.647a1.5 1.5 0 0 1 0-2.121l.707-.707a1.5 1.5 0 0 1 2.121 0L9 14.171l9.525-9.525a1.5 1.5 0 0 1 2.121 0l.707.707a1.5 1.5 0 0 1 0 2.121z"></path>
                                                        </g>
                                                    </svg>
                                                </div>
                                            </div>
                                        </label>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                


            </div>
        </div>

        <style>
            .switch {
  /* switch */
  --switch-width: 46px;
  --switch-height: 24px;
  --switch-bg: rgb(131, 131, 131);
  --switch-checked-bg: rgb(0, 218, 80);
  --switch-offset: calc((var(--switch-height) - var(--circle-diameter)) / 2);
  --switch-transition: all .2s cubic-bezier(0.27, 0.2, 0.25, 1.51);
  /* circle */
  --circle-diameter: 18px;
  --circle-bg: #fff;
  --circle-shadow: 1px 1px 2px rgba(146, 146, 146, 0.45);
  --circle-checked-shadow: -1px 1px 2px rgba(163, 163, 163, 0.45);
  --circle-transition: var(--switch-transition);
  /* icon */
  --icon-transition: all .2s cubic-bezier(0.27, 0.2, 0.25, 1.51);
  --icon-cross-color: var(--switch-bg);
  --icon-cross-size: 6px;
  --icon-checkmark-color: var(--switch-checked-bg);
  --icon-checkmark-size: 10px;
  /* effect line */
  --effect-width: calc(var(--circle-diameter) / 2);
  --effect-height: calc(var(--effect-width) / 2 - 1px);
  --effect-bg: var(--circle-bg);
  --effect-border-radius: 1px;
  --effect-transition: all .2s ease-in-out;
}

.switch input {
  display: none;
}

.switch {
  display: inline-block;
}

.switch svg {
  -webkit-transition: var(--icon-transition);
  -o-transition: var(--icon-transition);
  transition: var(--icon-transition);
  position: absolute;
  height: auto;
}

.switch .checkmark {
  width: var(--icon-checkmark-size);
  color: var(--icon-checkmark-color);
  -webkit-transform: scale(0);
  -ms-transform: scale(0);
  transform: scale(0);
}

.switch .cross {
  width: var(--icon-cross-size);
  color: var(--icon-cross-color);
}

.slider {
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  width: var(--switch-width);
  height: var(--switch-height);
  background: var(--switch-bg);
  border-radius: 999px;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  position: relative;
  -webkit-transition: var(--switch-transition);
  -o-transition: var(--switch-transition);
  transition: var(--switch-transition);
  cursor: pointer;
}

.circle {
  width: var(--circle-diameter);
  height: var(--circle-diameter);
  background: var(--circle-bg);
  border-radius: inherit;
  -webkit-box-shadow: var(--circle-shadow);
  box-shadow: var(--circle-shadow);
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
  -webkit-transition: var(--circle-transition);
  -o-transition: var(--circle-transition);
  transition: var(--circle-transition);
  z-index: 1;
  position: absolute;
  left: var(--switch-offset);
}

.slider::before {
  content: "";
  position: absolute;
  width: var(--effect-width);
  height: var(--effect-height);
  left: calc(var(--switch-offset) + (var(--effect-width) / 2));
  background: var(--effect-bg);
  border-radius: var(--effect-border-radius);
  -webkit-transition: var(--effect-transition);
  -o-transition: var(--effect-transition);
  transition: var(--effect-transition);
}

/* actions */

.switch input:checked + .slider {
  background: var(--switch-checked-bg);
}

.switch input:checked + .slider .checkmark {
  -webkit-transform: scale(1);
  -ms-transform: scale(1);
  transform: scale(1);
}

.switch input:checked + .slider .cross {
  -webkit-transform: scale(0);
  -ms-transform: scale(0);
  transform: scale(0);
}

.switch input:checked + .slider::before {
  left: calc(100% - var(--effect-width) - (var(--effect-width) / 2) - var(--switch-offset));
}

.switch input:checked + .slider .circle {
  left: calc(100% - var(--circle-diameter) - var(--switch-offset));
  -webkit-box-shadow: var(--circle-checked-shadow);
  box-shadow: var(--circle-checked-shadow);
}

        </style>
        


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
  color: rgb(0, 255, 255);
  background-color: #FFFFFF;
  outline-color: rgb(0, 255, 255);
  box-shadow: -3px -3px 15px rgb(0, 255, 255);
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