@extends('layouts.donut')


@section('content')

<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">
<!-- CONTENT -->
<section id="content">
    <nav>
        <i class='bx bx-menu' ></i>
        <a href="#" class="nav-link">Reports</a>
        
        <form action="#">
            <div class="form-input">
              <input type="search" placeholder="Search..." name="search" value="{{ $search }}">
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

    <main>
        <div class="head-title">
            <div class="left">
                <h1>Department Reports</h1>
                <ul class="breadcrumb">
                    <li>
                        <a href="{{ route('products.team') }}">Team</a>
                    </li>
                    <li><i class='bx bx-chevron-right' ></i></li>
                    <li>
                        <a class="active" href="{{ route('products.admin_dashboard') }}">Home</a>
                    </li>
                </ul>
            </div>
        </div>

        <ul class="box-info">
          <li class="dropdown">
            <div class="dropdown-container">
              <a href="#" class="dropbtn">
                <span class="text">
                  <h3>Department</h3>
                </span>
              </a>
              <div class="dropdown-content">
                <form action="{{ route('products.team') }}" method="GET">
                  @csrf
                  <select name="user_id" id="user_id" onchange="this.form.submit()">
                    <option value="">Select User ID</option>
                    @foreach ($userIds as $userId)
                      <option value="{{ $userId }}" {{ $selectedUserId == $userId ? 'selected' : '' }}>{{ $userId }}</option>
                    @endforeach
                  </select>
                </form>
              </div>
            </div>
          </li>
        
          <li>
            <i class='bx bxs-report'></i>
            <span class="text">
                <h3>{{ $totalReports }}</h3>
                <p>Total Reports</p>
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
                <h3>List of Reports</h3>
                {{-- <i class='bx bx-search' ></i>
                <i class='bx bx-filter' ></i> --}}
              </div>
              @if ($products instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
              <table>
                <thead>
                    <tr>
                      <th>Name</th>
                        <th>Category</th>
                        <th>Report Type</th>
                        <th>Submitted Files</th>
                        <th>Date and Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                          <td>{{ $product->name }}</td>
                            <td>{{ $product->title }}</td>
                            <td>{{ $product->report_type }}</td>
                            <td>
                                <a class="download-link" href="{{ route('download.file', $product->id) }}">
                                    <span>{{ $product->file }}</span>
                                </a>
                            </td>
                            <td>{{ $product->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $products->links() }}
        @endif
        </div>
      </div>
    </div>
</main>

</section>
<!-- CONTENT -->

<style>
.download-link {
    text-decoration: none;
    color: #38d39f;

    .box-info {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    padding: 20px 0;
  }

  .dropdown {
    position: relative;
  }

  .dropdown .dropdown-content {
    display: none;
    position: absolute;
    z-index: 1;
    min-width: 160px;
    padding: 12px 16px;
    background-color: white;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    border-radius: 4px;
    top: 100%;
    left: 0;
  }

  .dropdown:hover .dropdown-content {
    display: block;
  }

  .dropdown-container {
    position: relative;
    display: inline-block;
    width: 100%;
    height: 100%;
    text-align: center;
  }

  .dropbtn {
    background-color: transparent;
    color: #222;
    padding: 0;
    border: none;
    cursor: pointer;
  }

  .dropdown-content form {
    display: flex;
    align-items: center;
  }

  .dropdown-content select {
    margin-left: 10px;
  }
}
</style>


@endsection