@extends('layouts.donut')


@section('content')

<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">
<!-- CONTENT -->
<section id="content">
    <!-- NAVBAR -->
    <nav>
        <i class='bx bx-menu' ></i>
        <a href="#" class="nav-link">Reports</a>
        <form action="#">
            <div class="form-input">
                <input type="search" placeholder="Search is not applicable here">
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
                <h1>Key Performance Analytics</h1>
                <ul class="breadcrumb">
                    <li>
                        <a href="{{ route('visual.graph') }}">Analytics</a>
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
                <i class='bx bxs-report'></i>
                <span class="text">
                    <h3>{{ \App\Models\Product::count() }}</h3>
                    <p>Total Reports</p>
                </span>  
            </li>
            <li>
                <i class='bx bxs-group' ></i>
                <span class="text">
                    <h3>{{ DB::table('products')->distinct()->count('user_id') }}</h3>
                    <p>Departments</p>
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
                  <h3>Add Department Analytics</h3>
              </div>
              <table>
                  <thead>
                      <tr>
                          <th>Graph No.</th>
                          <th>User ID</th>
                          <th>Modify</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($fields as $field)
                      <tr>
                          <td>{{ $field->id }}</td>
                          <td>{{ $field->department_id }}</td>
                          <td>
                          <a href="{{ route('fields.change', $field->id) }}">
                              <i class="bx bx-edit neon-green"></i>
                          </a>
                          </td>
                      </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>
      </div>

        


        <!DOCTYPE html>
        <html>
        <head>
          <style>
            .card {
              border: none; /* Remove the border */
              border-radius: 10px;
              padding: 10px;
              margin-bottom: 20px;
            }
        
            .card iframe {
              width: 775px;
              height: 260px;
              border: none; /* Remove the border */
              border-radius: 12px;
              transform: scale(1.5); /* Adjust the zoom level as desired */
              transform-origin: top left;
            }
          </style>
        </head>
        <body>
        
          <div class="table-data">
            <div class="order">
              <div class="head">
                
                <div class="card">
                  <h3>Graph 1</h3>
                  <iframe src="https://thingspeak.com/channels/2149322/charts/1?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=60&type=line&update=15"></iframe>
                </div>
              </div>
            </div>
          </div>


          <div class="table-data">
            <div class="order">
              <div class="head">
                <div class="card">
                  <h3>Graph 2</h3>
                  <iframe src="https://thingspeak.com/channels/2149322/charts/2?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=60&type=line&update=15"></iframe>
                </div>
              </div>
            </div>
          </div>

          <div class="table-data">
            <div class="order">
              <div class="head">
                <div class="card">
                  <h3>Graph 3</h3>
                  <iframe src="https://thingspeak.com/channels/2149322/charts/3?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=60&type=line&update=15"></iframe>
                </div>
              </div>
            </div>
          </div>

          <div class="table-data">
            <div class="order">
              <div class="head">
                <div class="card">
                  <h3>Graph 4</h3>
                  <iframe src="https://thingspeak.com/channels/2149322/charts/4?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=60&type=line&update=15"></iframe>
                </div>
              </div>
            </div>
          </div>

          <div class="table-data">
            <div class="order">
              <div class="head">
                <div class="card">
                  <h3>Graph 5</h3>
                  <iframe src="https://thingspeak.com/channels/2149322/charts/5?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=60&type=line&update=15"></iframe>
                </div>
              </div>
            </div>
          </div>


          <div class="table-data">
            <div class="order">
              <div class="head">
                <div class="card">
                  <h3>Graph 6</h3>
                  <iframe src="https://thingspeak.com/channels/2149322/charts/6?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=60&type=line&update=15"></iframe>
                </div>
              </div>
            </div>
          </div>


          <div class="table-data">
            <div class="order">
              <div class="head">
                <div class="card">
                  <h3>Graph 7</h3>
                  <iframe src="https://thingspeak.com/channels/2149322/charts/7?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=60&type=line&update=15"></iframe>
                </div>
              </div>
            </div>
          </div>
        
        </body>
        </html>
        





        {{-- <div class="table-data">
            <div class="order">
                <div class="head">
                    
                    
                </div>
            </div>
        </div> --}}

        

        


        <style>
            /* CSS styles for the chart container */
            #linechart_material {
                background-color: white !important;
                border-radius: 17px;
                padding: 38px;
                margin: 5px;
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