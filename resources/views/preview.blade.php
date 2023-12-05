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

        {{-- <a href="#" class="notification">
            <i class='bx bxs-bell' ></i>
            <span class="num">8</span>
        </a> --}}
        
        <a class="profile" href="home/profile">
            {{ auth()->user()->displayName }}
            @php
                $uid = Session::get('uid');
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
                <h1>Report Feedback</h1>
                <ul class="breadcrumb">
                    <li>
                        <a href="#">Feedback</a>
                    </li>
                    <li><i class='bx bx-chevron-right' ></i></li>
                    <li>
                        <a class="active" href="{{ route('products.admin_dashboard') }}">Home</a>
                    </li>
                </ul>
            </div>
        </div>
          

       
     
        <style>
  /* Table */
  .table-data {
    margin-bottom: 20px;
  }

  .order {
    background-color: #fff;
    padding: 20px;
    border-radius: 4px;
  }

  .head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
  }

  /* Card styles */
  .card {
    width: 268px;
    border: 1px solid #ccc;
    padding: 10px;
    border-radius: 10px;
  }

  /* Chat box styles */
  .chat-box {
    height: 320px;
    overflow-y: scroll;
    border: none;
    padding: 10px;
    border-radius: 5px;
    background-color: #F9F9F9;
  }

  .message {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    margin-bottom: 10px;
  }

  .message.right {
    align-items: flex-end;
  }

  .sender {
    font-weight: bold;
    margin-bottom: 5px;
  }

  .content {
    background-color: #e5e5ea;
    padding: 8px 12px;
    border-radius: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    max-width: 70%;
    word-wrap: break-word;
  }

  .message.right .content {
    background-color: #38d39f;
    color: #F9F9F9;
  }

  .timestamp {
    font-size: 12px;
    color: #888;
  }

/* Input area styles */
.input-area {
  display: flex;
  align-items: center;
  justify-content: space-between; /* Center the items with space in between */
  margin-top: 10px;
  margin-bottom: 15px;
  margin-left: 10px;
}


  /* Input styles */
  textarea {
    border: none;
    background-color: #f0f0f0;
    padding: 5px;
    border-radius: 20px;
    outline: none;
    flex: 1;
    margin-right: 10px;
    resize: none; /* Disable textarea resizing */
    height: 37px;
    width: 246px;
    overflow: hidden; /* Hide overflowing content */
  }

  /* Button styles */
  .send-btn {
    background-color: #38d39f;
    border: none;
    color: #fff;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
  }

  /* Custom scrollbar styles */
  ::-webkit-scrollbar {
    width: 6px;
  }

  ::-webkit-scrollbar-thumb {
    background-color: rgba(0, 0, 0, 0.3);
    border-radius: 3px;
  }

  /* Chat box pop-up styles */
  .chat-box-popup {
    display: none;
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 300px;
    max-height: 500px;
    background-color: #F9F9F9;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    z-index: 9999;
    overflow: hidden;
  }

  /* Show the chat box popup */
  .chat-box-popup.show {
    display: block;
    border-radius: 11px;
  }

  /* Comment Icon */
  .bx-comment-detail {
    font-size: 24px;
    cursor: pointer;
    color: #000;
    transition: color 0.3s ease-in-out;
  }

  .bx-comment-detail:hover {
    color: #38d39f;
  }


  .send-icon {
  font-size: 18px;
  color: #333;
  cursor: pointer;
  background-color: transparent;
  border: none;
  padding: 0;
  margin: 0;
  margin-left: 1px;
}


.input-container {
  display: flex;
  align-items: center;
  justify-content: space-between;
}
</style>

<div class="table-data">
  <div class="order">
    <div class="head">
      <h3>Latest Reports</h3>
      <i class="bx bx-comment-detail" id="comment-icon"></i>
    </div>
    <table>
      <thead>
        <tr>
          <th>Title</th>
          <th>Report Type</th>
          <th>File</th>
          <th>Created At</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>{{ $product->title }}</td>
          <td>{{ $product->report_type }}</td>
          <td>{{ $product->file }}</td>
          <td>{{ $product->created_at }}</td>

          <td>
            @if ($product->status == 1)
            <span class="status pending">Disabled</span>
            @else
              <a href="{{ route('products.edit', $product->id) }}">
                <i class="bx bx-edit neon-green"></i>
              </a>
              <button onclick="openConfirmationModal({{ $product->id }})">
                <i class="bx bx-trash neon-red"></i>
              </button>
            @endif
            <form id="deleteForm-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;">
              @csrf
              @method('DELETE')
              <button type="submit" style="background: none; border: none; padding: 0;"></button>
            </form>
          </td>

        </tr>
      </tbody>
    </table>
  </div>
</div>

<div class="chat-box-popup" id="chat-box-popup">
  <div class="chat-box" id="chatBox">
    @php
      $previousDate = null;
    @endphp
    @foreach($chats as $chat)
      @if($chat->product_id == $product->id)
        @php
          $currentDate = $chat->created_at->format('Y-m-d');
          $formattedDate = $chat->created_at->format('F j, Y');
          $formattedTime = $chat->created_at->format('h:i A');
          $isToday = $currentDate === now()->format('Y-m-d');
          $isYesterday = $currentDate === now()->subDay()->format('Y-m-d');
        @endphp

        @if($previousDate !== $currentDate)
          <div class="message">
            <div class="timestamp">
              @if($isToday)
                Today
              @elseif($isYesterday)
                Yesterday
              @else
                {{ $formattedDate }}
              @endif
            </div>
          </div>
          @php
            $previousDate = $currentDate;
          @endphp
        @endif

        <div class="message {{ $chat->user_id === $user_id ? 'right' : 'left' }}">
          <div class="sender">{{ $chat->user_id === $user_id ? 'You' : $chat->name }}</div>
          <div class="content">{{ $chat->conversation }}</div>
          <div class="timestamp">{{ $formattedTime }}</div>
        </div>
      @endif
    @endforeach
  </div>

  <div class="input-area">
    <form action="{{ route('convo.save-message') }}" method="POST">
      @csrf
      <input type="hidden" name="product_id" value="{{ $product->id }}">
      <input type="hidden" name="user_id" value="{{ $user_id }}">
      <input type="hidden" name="name" value="{{ auth()->user()->displayName }}">
      <div class="input-container">
        <textarea id="inputMessage" name="conversation" placeholder="Type your message" oninput="adjustInputHeight()"></textarea>
        <button type="submit" class="send-icon">
          <i class="bx bxs-send"></i>
        </button>
      </div>
    </form>
  </div>
  
</div>

<script>
  // JavaScript to handle the comment icon click event and toggle the chat box popup
  document.addEventListener('DOMContentLoaded', function() {
    var commentIcon = document.getElementById('comment-icon');
    var chatBoxPopup = document.getElementById('chat-box-popup');
    var closeBtn = chatBoxPopup.querySelector('.close-btn');

    commentIcon.addEventListener('click', function() {
      chatBoxPopup.classList.toggle('show');
      // Scroll to the bottom of the chat box
      var chatBox = chatBoxPopup.querySelector('.chat-box');
      chatBox.scrollTop = chatBox.scrollHeight;
    });

    closeBtn.addEventListener('click', function() {
      chatBoxPopup.classList.remove('show');
    });
  });


  function adjustInputHeight() {
    var input = document.getElementById("inputMessage");
    var textLength = input.value.length;
    var maxWidth = 268; // Width of the input field

    // Reset the height to calculate the new height based on content
    input.style.height = "auto";

    // Check if the text length exceeds the width of the input field
    if (textLength * 10 >= maxWidth) {
      input.style.height = input.scrollHeight + "px"; // Set the height to match the content
    } else {
      input.style.height = "37px"; // Set default height if there is no input
    }

    // Scroll to the bottom of the chat box
    var chatBox = document.getElementById("chatBox");
    chatBox.scrollTop = chatBox.scrollHeight;
  }
</script>

        
        
        
        
        
        
        
        








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