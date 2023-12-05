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
                <input type="search" placeholder="Search...">
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
                <h1>Automate Notifications Report</h1>
                <ul class="breadcrumb">
                    <li>
                        <a href="{{ route('reports.automate_notifications') }}">Automate</a>
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
                    <form action="{{ route('insert_data') }}" method="POST">
                        @csrf



                        {{-- <label>Report Type</label> --}}

                        <span class="text">
                            <p>Report Type</p>
                        </span>

                        <select class="input" name="notices" required>
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

                {{-- <label>Department ID</label> --}}

                <span class="text">
                    <p>Department ID</p>
                </span>

                <select class="input" name="department_id" required>
                    <option value="" disabled selected>Select user ID</option> <!-- Placeholder option -->
                    @foreach($logins as $login)
                        <option value="{{ $login->user_id }}">{{ $login->name }} ({{ $login->user_id }})</option>
                    @endforeach
                </select>
                @error('department_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                
            </li>




            <li>
                {{-- <label>Schedule</label> --}}

                <span class="text">
                    <p>Schedule</p>
                </span>

                <select class="input" name="schedule" required>
                    <option value="" disabled selected>Select Schedule</option> <!-- Placeholder option -->
                    <option value="Every_1st_Week_Saturday_of_the_Month">Every 1st Week Saturday of the Month</option>
                    <option value="Every_5th_day_of_the_Month">Every 5th day of the Month</option>
                    <option value="Every_8th_day_of_the_Month">Every 8th day of the Month</option>
                    <option value="Every_10th_day_of_the_Month">Every 10th day of the Month</option>
                    <option value="Every_15th_day_of_the_Month">Every 15th day of the Month</option>
                    <option value="Every_20th_day_of_the_Month">Every 20th day of the Month</option>
                    <option value="Every_January_15th">Every January 15th</option>
                    <option value="Every_July_15th">Every July 15th</option>
                    <option value="Every_Week">Every Week</option>
                    <option value="Every_Month">Every Month</option>
                    <option value="Every_30th_of_the_Month">Every 30th of the Month</option>
                </select>
                @error('schedule')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror


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

     

        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>Weekly</h3>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Department Name</th>
                            <th>Report Type</th>
                            <th>Department ID</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rats as $rat)
                        <tr>
                            <td>{{ $rat->name }}</td>
                            <td>{{ $rat->notices }}</td>
                            <td>{{ $rat->department_id }}</td>
                            <td>{{ $rat->created_at }}</td>

                            <td>
                                <button onclick="openConfirmationModal({{ $rat->id }})">
                                  <i class="bx bx-trash neon-red"></i>
                                </button>
                                <form id="deleteForm-{{ $rat->id }}" action="{{ route('deleteRat.rats', $rat->id) }}" method="POST" style="display: inline;">
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
            </div>
        </div>



        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>Monthly</h3>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Department Name</th>
                            <th>Report Type</th>
                            <th>Department ID</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bats as $bat)
                        <tr>
                            <td>{{ $bat->name }}</td>
                            <td>{{ $bat->notices }}</td>
                            <td>{{ $bat->department_id }}</td>
                            <td>{{ $bat->created_at }}</td>

                            <td>
                                <button onclick="openConfirmationModal({{ $bat->id }})">
                                  <i class="bx bx-trash neon-red"></i>
                                </button>
                                <form id="deleteForm-{{ $bat->id }}" action="{{ route('deleteBat.bats', $bat->id) }}" method="POST" style="display: inline;">
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
            </div>
        </div>


        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>Every 1st Week of the Month Saturday</h3>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Department Name</th>
                            <th>Report Type</th>
                            <th>Department ID</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dogs as $dog)
                        <tr>
                            <td>{{ $dog->name }}</td>
                            <td>{{ $dog->notices }}</td>
                            <td>{{ $dog->department_id }}</td>
                            <td>{{ $dog->created_at }}</td>

                            <td>
                                <button onclick="openConfirmationModal({{ $dog->id }})">
                                  <i class="bx bx-trash neon-red"></i>
                                </button>
                                <form id="deleteForm-{{ $dog->id }}" action="{{ route('deleteDog.dogs', $dog->id) }}" method="POST" style="display: inline;">
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
            </div>
        </div>




        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>Every 5th of the Month</h3>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Department Name</th>
                            <th>Report Type</th>
                            <th>Department ID</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($houses as $house)
                        <tr>
                            <td>{{ $house->name }}</td>
                            <td>{{ $house->notices }}</td>
                            <td>{{ $house->department_id }}</td>
                            <td>{{ $house->created_at }}</td>

                            <td>
                                <button onclick="openConfirmationModal({{ $house->id }})">
                                  <i class="bx bx-trash neon-red"></i>
                                </button>
                                <form id="deleteForm-{{ $house->id }}" action="{{ route('deleteHouse.houses', $house->id) }}" method="POST" style="display: inline;">
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
            </div>
        </div>


        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>Every 8th of the Month</h3>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Department Name</th>
                            <th>Report Type</th>
                            <th>Department ID</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cars as $car)
                        <tr>
                            <td>{{ $car->name }}</td>
                            <td>{{ $car->notices }}</td>
                            <td>{{ $car->department_id }}</td>
                            <td>{{ $car->created_at }}</td>

                            <td>
                                <button onclick="openConfirmationModal({{ $car->id }})">
                                  <i class="bx bx-trash neon-red"></i>
                                </button>
                                <form id="deleteForm-{{ $car->id }}" action="{{ route('deleteCar.cars', $car->id) }}" method="POST" style="display: inline;">
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
            </div>
        </div>



        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>Every 10th of the Month</h3>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Department Name</th>
                            <th>Report Type</th>
                            <th>Department ID</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($books as $book)
                        <tr>
                            <td>{{ $book->name }}</td>
                            <td>{{ $book->notices }}</td>
                            <td>{{ $book->department_id }}</td>
                            <td>{{ $book->created_at }}</td>
                            
                            <td>
                                <button onclick="openConfirmationModal({{ $book->id }})">
                                  <i class="bx bx-trash neon-red"></i>
                                </button>
                                <form id="deleteForm-{{ $book->id }}" action="{{ route('deleteBook.books', $book->id) }}" method="POST" style="display: inline;">
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
            </div>
        </div>



        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>Every 15th of the Month</h3>
                </div>
                <table>
                    <thead>
                        <tr>
                           <th>Department Name</th>
                            <th>Report Type</th>
                            <th>Department ID</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($machines as $machine)
                        <tr>
                            <td>{{ $machine->name }}</td>
                            <td>{{ $machine->notices }}</td>
                            <td>{{ $machine->department_id }}</td>
                            <td>{{ $machine->created_at }}</td>

                            <td>
                                <button onclick="openConfirmationModal({{ $machine->id }})">
                                  <i class="bx bx-trash neon-red"></i>
                                </button>
                                <form id="deleteForm-{{ $machine->id }}" action="{{ route('deleteMachine.machines', $machine->id) }}" method="POST" style="display: inline;">
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
            </div>
        </div>



        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>Every 20th of the Month</h3>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Department Name</th>
                            <th>Report Type</th>
                            <th>Department ID</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pens as $pen)
                        <tr>
                            <td>{{ $pen->name }}</td>
                            <td>{{ $pen->notices }}</td>
                            <td>{{ $pen->department_id }}</td>
                            <td>{{ $pen->created_at }}</td>

                            
                            <td>
                                <button onclick="openConfirmationModal({{ $pen->id }})">
                                  <i class="bx bx-trash neon-red"></i>
                                </button>
                                <form id="deleteForm-{{ $pen->id }}" action="{{ route('deletePen.pens', $pen->id) }}" method="POST" style="display: inline;">
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
            </div>
        </div>



        
        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>Every 30th of the Month</h3>
                </div>
                <table>
                    <thead>
                        <tr>
                           <th>Department Name</th>
                            <th>Report Type</th>
                            <th>Department ID</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stacks as $stack)
                        <tr>
                            <td>{{ $stack->name }}</td>
                            <td>{{ $stack->notices }}</td>
                            <td>{{ $stack->department_id }}</td>
                            <td>{{ $stack->created_at }}</td>

                            <td>
                                <button onclick="openConfirmationModal({{ $stack->id }})">
                                  <i class="bx bx-trash neon-red"></i>
                                </button>
                                <form id="deleteForm-{{ $stack->id }}" action="{{ route('deleteStack.stacks', $stack->id) }}" method="POST" style="display: inline;">
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
            </div>
        </div>


        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>Every January 15th</h3>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Department Name</th>
                            <th>Report Type</th>
                            <th>Department ID</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($chairs as $chair)
                        <tr>
                            <td>{{ $chair->name }}</td>
                            <td>{{ $chair->notices }}</td>
                            <td>{{ $chair->department_id }}</td>
                            <td>{{ $chair->created_at }}</td>

                            <td>
                                <button onclick="openConfirmationModal({{ $chair->id }})">
                                  <i class="bx bx-trash neon-red"></i>
                                </button>
                                <form id="deleteForm-{{ $chair->id }}" action="{{ route('deleteChair.chairs', $chair->id) }}" method="POST" style="display: inline;">
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
            </div>
        </div>



        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>Every July 15th</h3>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Department Name</th>
                            <th>Report Type</th>
                            <th>Department ID</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($computers as $computer)
                        <tr>
                            <td>{{ $computer->name }}</td>
                            <td>{{ $computer->notices }}</td>
                            <td>{{ $computer->department_id }}</td>
                            <td>{{ $computer->created_at }}</td>

                            <td>
                                <button onclick="openConfirmationModal({{ $computer->id }})">
                                  <i class="bx bx-trash neon-red"></i>
                                </button>
                                <form id="deleteForm-{{ $computer->id }}" action="{{ route('deleteComputer.computers', $computer->id) }}" method="POST" style="display: inline;">
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