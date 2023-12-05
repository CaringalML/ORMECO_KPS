@extends('layouts.donut')


@section('content')

<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">
<!-- CONTENT -->
<section id="content">
    <!-- NAVBAR -->
    <nav>
        <i class='bx bx-menu' ></i>
        <a href="#" class="nav-link">Reports</a>

        <form action="{{ route('products.admin_dashboard') }}" method="GET">
            <div class="form-input">
                <input type="search" name="search" placeholder="Search..." value="{{ app('request')->input('search') }}">
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
                <h1>Dashboard</h1>
                <ul class="breadcrumb">
                    <li>
                        <a href="{{ route('products.admin_dashboard') }}">Dashboard</a>
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
                <h3>Latest Reports</h3>
                {{-- <i class='bx bx-search' ></i>
                <i class='bx bx-filter' ></i> --}}
              </div>


              <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Report Type</th>
                        <th>File</th>
                        <th>Created At</th>
                        {{-- <th>Status</th> --}}
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr onclick="window.location='{{ route('products.previewed', $product->id) }}';">
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->title }}</td>
                        <td>{{ $product->report_type }}</td>
                        <td>
                            <a class="download-link" href="{{ route('download.file', $product->id) }}">
                                <span>{{ $product->file }}</span>
                            </a>
                        </td>
                        <td>{{ $product->created_at }}</td>
                        {{-- <td>
                            @if ($product->status == 0)
                            <span class="status pending">Pending</span>
                            @elseif ($product->status == 1)
                            <span class="status completed">Approved</span>
                            @endif
                        </td> --}}
                        <td>
                            <form action="{{ route('update.status', $product->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <label class="switch">
                                    <input type="checkbox" onchange="this.form.submit()" {{ $product->status == 1 ? 'checked' : '' }}>
                                    <div class="slider">
                                        <div class="circle">
                                            <svg class="cross" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path fill="currentColor" d="M243.188 182.86 356.32 69.726c12.5-12.5 12.5-32.766 0-45.247L341.238 9.398c-12.504-12.503-32.77-12.503-45.25 0L182.86 122.528 69.727 9.374c-12.5-12.5-32.766-12.5-45.247 0L9.375 24.457c-12.5 12.504-12.5 32.77 0 45.25l113.152 113.152L9.398 295.99c-12.503 12.503-12.503 32.769 0 45.25L24.48 356.32c12.5 12.5 32.766 12.5 45.247 0l113.132-113.132L295.99 356.32c12.503 12.5 32.769 12.5 45.25 0l15.081-15.082c12.5-12.504 12.5-32.77 0-45.25zm0 0"></path>
                                            </svg>
                                            <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <path fill="currentColor" d="M9.707 19.121a.997.997 0 0 1-1.414 0l-5.646-5.647a1.5 1.5 0 0 1 0-2.121l.707-.707a1.5 1.5 0 0 1 2.121 0L9 14.171l9.525-9.525a1.5 1.5 0 0 1 2.121 0l.707.707a1.5 1.5 0 0 1 0 2.121z"></path>
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
            
            

            

            


              <div class="pagination">
                {{ $products->links() }}
              </div>
            </div>
          </div>
    </main>
    <!-- MAIN -->
</section>
<!-- CONTENT -->





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
  transition: var(--icon-transition);
  position: absolute;
  height: auto;
}

.switch .checkmark {
  width: var(--icon-checkmark-size);
  color: var(--icon-checkmark-color);
  transform: scale(0);
}

.switch .cross {
  width: var(--icon-cross-size);
  color: var(--icon-cross-color);
}

.slider {
  box-sizing: border-box;
  width: var(--switch-width);
  height: var(--switch-height);
  background: var(--switch-bg);
  border-radius: 999px;
  display: flex;
  align-items: center;
  position: relative;
  transition: var(--switch-transition);
  cursor: pointer;
}

.circle {
  width: var(--circle-diameter);
  height: var(--circle-diameter);
  background: var(--circle-bg);
  border-radius: inherit;
  box-shadow: var(--circle-shadow);
  display: flex;
  align-items: center;
  justify-content: center;
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
  transition: var(--effect-transition);
}

/* actions */

.switch input:checked + .slider {
  background: var(--switch-checked-bg);
}

.switch input:checked + .slider .checkmark {
  transform: scale(1);
}

.switch input:checked + .slider .cross {
  transform: scale(0);
}

.switch input:checked + .slider::before {
  left: calc(100% - var(--effect-width) - (var(--effect-width) / 2) - var(--switch-offset));
}

.switch input:checked + .slider .circle {
  left: calc(100% - var(--circle-diameter) - var(--switch-offset));
  box-shadow: var(--circle-checked-shadow);
}

</style>


<style>


.download-link {
    text-decoration: none;
    color: #38d39f;
}
/* 
.download-link {
    background:none !important;
    border:none !important;
    border-radius: 2px;
    display: inline-block;
    height: 45px;
    line-height: 45px;
    margin: 5px;
    position: relative;
    text-align: center;
    vertical-align: middle;
    width: 45px;
    text-decoration: none;
    color: #000000;
}

.download-link span {
    background: #f2594b;
    border-radius: 4px;
    color: #ffffff;
    display: inline-block;
    font-size: 11px;
    font-weight: 700;
    line-height: normal;
    padding: 5px 10px;
    position: relative;
    text-transform: uppercase;
    z-index: 1;
}

.download-link span:last-child {
    margin-left: -20px;
}

.download-link:before,
.download-link:after {
    background: #ffffff;
    border: solid 3px #9fb4cc;
    border-radius: 4px;
    content: '';
    display: block;
    height: 35px;
    left: 50%;
    margin: -17px 0 0 -12px;
    position: absolute;
    top: 50%;
    width: 25px;
}

.download-link:hover:before,
.download-link:hover:after {
    background: #e2e8f0;
}

.download-link:before {
    margin: -23px 0 0 -5px;
}

.download-link:hover {
    background: #e2e8f0;
    border-color: #9fb4cc;
}

.download-link:active {
    background: #dae0e8;
    box-shadow: inset 0 2px 2px rgba(0, 0, 0, .25);
}

.download-link span:first-child {
    display: none;
}

.download-link:hover span:first-child {
    display: inline-block;
}

.download-link:hover span:last-child {
    display: none;
} */
</style>


{{-- <script>
    // Loop through all the date and time elements
    const dateElements = document.querySelectorAll('[id^="datetime-"]');
    dateElements.forEach(function (element) {
        // Get the original date and time value
        const originalDateTime = element.textContent.trim();

        // Format the date and time
        const options = { 
            month: 'long', 
            day: 'numeric', 
            year: 'numeric', 
            hour: 'numeric', 
            minute: 'numeric', 
            second: 'numeric' 
        };
        const formattedDateTime = new Date(originalDateTime).toLocaleDateString('en-US', options);

        // Update the element with the formatted date and time
        element.textContent = formattedDateTime;
    });
</script> --}}

@endsection