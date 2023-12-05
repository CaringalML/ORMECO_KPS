<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

  <div class="card">
    <div class="card-body">
      <form method="post" action="{{ route('larawan.store') }}" enctype="multipart/form-data" class="profile-upload-form">
        @csrf
        <div class="upload-wrapper">
          <input type="file" name="image" id="image" required>
          <label for="image" class="upload-button">
            <i class='bx bxs-camera-plus'></i>
          </label>
        </div>
        {{-- <button type="submit" class="lagay">Upload</button> --}}
  
        <button type="submit" class="Btn">Edit 
          <svg class="svg" viewBox="0 0 512 512">
            <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path>
          </svg>
        </button>
      </form>
    </div>
  </div>
  

  <style>
.Btn {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  width: 100px;
  height: 40px;
  border: none;
  padding: 0px 20px;
  background-color: #00A86B; /* Replaced RGB color with green color */
  color: white;
  font-weight: 500;
  cursor: pointer;
  border-radius: 10px;
  box-shadow: 5px 5px 0px #01796F; /* Replaced RGB color with green color */
  transition-duration: .3s;
}

.svg {
  width: 13px;
  position: absolute;
  right: 0;
  margin-right: 20px;
  fill: white;
  transition-duration: .3s;
}

.Btn:hover {
  color: transparent;
}

.Btn:hover svg {
  right: 43%;
  margin: 0;
  padding: 0;
  border: none;
  transition-duration: .3s;
}

.Btn:active {
  transform: translate(3px , 3px);
  transition-duration: .3s;
  box-shadow: 2px 2px 0px #01796F; /* Replaced RGB color with green color */
}

  </style>
  
  
      
    
      
      <style>
   .card {
  position: relative;
  display: block;
  margin: 100px auto; /* Added auto to center horizontally */
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 6px;
  box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
  transition: box-shadow 0.3s ease;
  max-width: 300px; /* Adjust the max-width value as needed */
}



.card:hover {
  box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.3);
}

.profile-upload-form {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
  margin-bottom: 20px;
}

.upload-wrapper {
    position: relative;
    width: 200px;
    height: 200px;
    border-radius: 50%;
    border: 2px dashed #ccc;
    background-color: #f2f2f2;
    margin-bottom: 20px;
    overflow: hidden;
    background-size: cover;
    background-position: center;
  }

  .upload-wrapper input[type="file"] {
    opacity: 0;
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
  }

.upload-button {
  display: inline-block;
  padding: 1px 10px;
  background-color: #00A86B;
  color: #fff;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.upload-button:hover {
  background-color: #00A86B;
}

.fa-camera {
  margin-right: 5px;
}




.lagay {
  display: inline-block;
  padding: 5px 20px;
  background-color:#00A86B;
  color: #fff;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.lagay:hover {
  background-color: #00A86B;
}


    
      </style>






<script>
  document.getElementById('image').addEventListener('change', function(e) {
    var file = e.target.files[0];
    var reader = new FileReader();

    reader.onload = function(event) {
      var imageUrl = event.target.result;
      var uploadWrapper = document.querySelector('.upload-wrapper');
      uploadWrapper.style.backgroundImage = 'url(' + imageUrl + ')';
    };

    reader.readAsDataURL(file);
  });
</script>

</body>
</html>