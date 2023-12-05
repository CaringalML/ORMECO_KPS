<!DOCTYPE html>
<html>
<head>
	<title>ORMECO KPS</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>



	   <!-- Scripts -->
	   <script src="{{ asset('js/app.js') }}" defer></script>

	   <!-- Fonts -->
	   <link rel="dns-prefetch" href="//fonts.gstatic.com">
	   <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
   
	   <!-- Styles -->
	   <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	   <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
   



	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<img class="wave" src="{{ asset('img/wave.png') }}">
	<div class="container">
		<div class="img">
			<img src="{{ asset('img/bg.svg') }}">
		</div>
		<div class="login-content">

           

            <form method="POST" action="{{ action('App\Http\Controllers\Auth\ResetController@store') }}">
                @csrf
				<img src="{{ asset('img/logo.jpg') }}">
				<h2 class="title">ORMECO KPS</h2>

        @if(Session::has('message'))
        <div class="alert alert-info alert-dismissible fade show">
          {{ Session::get('message') }}
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
      @endif

      @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show">
          {{ Session::get('error') }}
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
      @endif

      @if ($errors->any())
        @foreach ($errors->all() as $error)
          <div class="alert alert-danger alert-dismissible fade show">
            {{ $error }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
          </div>
        @endforeach
      @endif

     

                   <div class="input-div one">
                    <div class="i">
                        <i class='bx bxs-envelope custom-icon'></i>
                    </div>
                    <div class="div">
                        <h5>Email</h5>
                        <input id="email" type="email" class="input" name="email" required>
                    
                    </div>
                </div>

            	<input type="submit" class="btn" value="Send Email">
             
				
				
            </form>
        </div>
    </div>
    {{-- <script type="text/javascript" src="js/main.js"></script> --}}

    <script>
      const inputs = document.querySelectorAll(".input");


function addcl(){
	let parent = this.parentNode.parentNode;
	parent.classList.add("focus");
}

function remcl(){
	let parent = this.parentNode.parentNode;
	if(this.value == ""){
		parent.classList.remove("focus");
	}
}


inputs.forEach(input => {
	input.addEventListener("focus", addcl);
	input.addEventListener("blur", remcl);
});

    </script>
</body>
</html>


<style>

.custom-icon {
        font-size: 19px; /* Adjust the size as desired */
    }


    body {
        overflow-y: auto;
        padding: 20px 0; /* Adjust the spacing as desired */
    }
    
    .container {
        height: calc(100vh - 40px); /* Subtract twice the padding value from 100vh */
        overflow-y: auto;
    }

.social-text a {
        display: inline-block;
        margin-top: -5px;
    }

button {
  max-width: 320px;
  display: flex;
  padding: 0.5rem 1.4rem;
  font-size: 0.875rem;
  line-height: 1.25rem;
  font-weight: 700;
  text-align: center;
  text-transform: uppercase;
  vertical-align: middle;
  align-items: center;
  border-radius: 0.5rem;
  border: 1px solid rgba(0, 0, 0, 0.25);
  gap: 0.75rem;
  color: rgb(65, 63, 63);
  background-color: #fff;
  cursor: pointer;
  transition: all .6s ease;
}

.button svg {
  height: 24px;
}

button:hover {
  transform: scale(1.02);
}





*{
	padding: 0;
	margin: 0;
	box-sizing: border-box;
}

body{
    font-family: 'Poppins', sans-serif;
    overflow: hidden;
}




/* Dagdag na CSS */
.social-media {
	display: flex;
	justify-content: center;
  }

  .line {
	border-bottom: 1px solid black;
	text-align: center;
	line-height: 0.1em;
	margin: 20px 0 10px; /* Adjust the top space here */
	margin-bottom: 20px;
}

.line span {
	background: white;
	padding: 0 10px;
}
/* Dagdag na CSS */









.wave{
	position: fixed;
	bottom: 0;
	left: 0;
	height: 100%;
	z-index: -1;
}

.container{
    width: 100vw;
    height: 100vh;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    grid-gap :7rem;
    padding: 0 2rem;
}

.img{
	display: flex;
	justify-content: flex-end;
	align-items: center;
}

.login-content{
	display: flex;
	justify-content: flex-start;
	align-items: center;
	text-align: center;
}

.img img{
	width: 500px;
}

form{
	width: 360px;
}

.login-content img{
    height: 100px;
}

.login-content h2{
	margin: 15px 0;
	color: #333;
	text-transform: uppercase;
	font-size: 2.9rem;
}

.login-content .input-div{
	position: relative;
    display: grid;
    grid-template-columns: 7% 93%;
    margin: 25px 0;
    padding: 5px 0;
    border-bottom: 2px solid #d9d9d9;
}

.login-content .input-div.one{
	margin-top: 0;
}

.i{
	color: #d9d9d9;
	display: flex;
	justify-content: center;
	align-items: center;
}

.i i{
	transition: .3s;
}

.input-div > div{
    position: relative;
	height: 45px;
}

.input-div > div > h5{
	position: absolute;
	left: 10px;
	top: 50%;
	transform: translateY(-50%);
	color: #999;
	font-size: 18px;
	transition: .3s;
}

.input-div:before, .input-div:after{
	content: '';
	position: absolute;
	bottom: -2px;
	width: 0%;
	height: 2px;
	background-color: #38d39f;
	transition: .4s;
}

.input-div:before{
	right: 50%;
}

.input-div:after{
	left: 50%;
}

.input-div.focus:before, .input-div.focus:after{
	width: 50%;
}

.input-div.focus > div > h5{
	top: -5px;
	font-size: 15px;
}

.input-div.focus > .i > i{
	color: #38d39f;
}

.input-div > div > input{
	position: absolute;
	left: 0;
	top: 0;
	width: 100%;
	height: 100%;
	border: none;
	outline: none;
	background: none;
	padding: 0.5rem 0.7rem;
	font-size: 1.2rem;
	color: #555;
	font-family: 'poppins', sans-serif;
}

.input-div.pass{
	margin-bottom: 4px;
}

a{
	display: block;
	text-align: right;
	text-decoration: none;
	color: #999;
	font-size: 0.9rem;
	transition: .3s;
}

a:hover{
	color: #38d39f;
}

.btn{
	display: block;
	width: 100%;
	height: 50px;
	border-radius: 25px;
	outline: none;
	border: none;
	background-image: linear-gradient(to right, #32be8f, #38d39f, #32be8f);
	background-size: 200%;
	font-size: 1.2rem;
	color: #fff;
	font-family: 'Poppins', sans-serif;
	text-transform: uppercase;
	margin: 1rem 0;
	cursor: pointer;
	transition: .5s;
}
.btn:hover{
	background-position: right;
}


@media screen and (max-width: 1050px){
	.container{
		grid-gap: 5rem;
	}
}

@media screen and (max-width: 1000px){
	form{
		width: 290px;
	}

	.login-content h2{
        font-size: 2.4rem;
        margin: 8px 0;
	}

	.img img{
		width: 400px;
	}
}

@media screen and (max-width: 900px){
	.container{
		grid-template-columns: 1fr;
	}

	.img{
		display: none;
	}

	.wave{
		display: none;
	}

	.login-content{
		justify-content: center;
	}
}

</style>
