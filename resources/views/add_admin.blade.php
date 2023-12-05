@extends('layouts.donut')


@section('content')
<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">
<!-- CONTENT -->
<section id="content">
    <!-- NAVBAR -->
    <nav>
        <i class='bx bx-menu' ></i>
        <a href="#" class="nav-link">Reports</a>
        
        <form action="{{ route('admins.add_admin') }}" method="GET">
            <div class="form-input">
                <input type="search" name="query" value="{{ $query }}" placeholder="Search...">
                <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
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
                <h1>Register New Admin</h1>
                <ul class="breadcrumb">
                    <li>
                        <a href="{{ route('admins.add_admin') }}">Add Admin</a>
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
                    <form action="{{ route('admins.store') }}" method="POST">
                        @csrf
                        <span class="text">
                            <p>Department ID</p>
                        </span>
        
                        <select class="input" name="user_id" required>
                            <option value="" disabled selected>Select user ID</option> <!-- Placeholder option -->
                            @foreach($logins as $login)
                                <option value="{{ $login->user_id }}">{{ $login->name }} ({{ $login->user_id }})</option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

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

     




        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>Admin List</h3>
                    {{-- <i class='bx bx-search'></i>
                    <i class='bx bx-filter'></i> --}}
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Date and Time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($administrators as $administrator)
                            <tr>
                                <td>{{ $administrator->user_id }}</td>
                                <td>{{ $administrator->created_at }}</td>
                                <td>
                                    <a href="{{ route('administrators.edit', $administrator->id) }}">
                                        <i class="bx bx-edit neon-green"></i>
                                    </a>
                                    <button onclick="openConfirmationModal({{ $administrator->id }})">
                                        <i class="bx bx-trash neon-red"></i>
                                      </button>
                                      <form id="deleteForm-{{ $administrator->id }}" action="{{ route('administrators.destroy', $administrator->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: none; border: none; padding: 0;">
                                          {{-- <i class="bx bx-trash neon-red"></i> --}}
                                        </button>
                                      </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                {{ $administrators->links() }}
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