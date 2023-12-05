@extends('layouts.jellybean')

@section('content')
   
<div class="card">
    <h3 class="card__title">Add Department ID</h3>
    <form action="{{ route('fields.transform', $field->id) }}" method="POST">
        @method('PUT')
        @csrf

        <div class="form-group">
            <label for="department_id">User ID</label>
            <input type="text" class="input" name="department_id" id="user_id" value="{{ $field->department_id }}" required>
        </div>

        <button type="submit" class="Btn">Edit 
            <svg class="svg" viewBox="0 0 512 512">
              <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path>
            </svg>
          </button>
    </form>
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
    
    
    
    
            .card {
                --border-radius: 0.75rem;
                --primary-color: #006000;
                --secondary-color: #3c3852;
                width: 500px;
                font-family: "Arial";
                padding: 1rem;
                cursor: pointer;
                border-radius: var(--border-radius);
                background: #f1f1f3;
                box-shadow: 0px 8px 16px 0px rgb(0 0 0 / 3%);
                position: relative;
                margin: 0 auto;
                transition: 0.2s;
            }
        
            .card > * + * {
                margin-top: 1.1em;
            }
        
            .card .card__content {
                color: var(--secondary-color);
                font-size: 0.86rem;
            }
        
            .card .card__title {
                padding: 0;
                font-size: 1.3rem;
                font-weight: bold;
            }
        
            .card .card__date {
                color: #6e6b80;
                font-size: 0.8rem;
            }
        
            .card .card__arrow {
                position: absolute;
                background: var(--primary-color);
                padding: 0.4rem;
                border-top-left-radius: var(--border-radius);
                border-bottom-right-radius: var(--border-radius);
                bottom: 0;
                right: 0;
                transition: 0.2s;
                display: flex;
                justify-content: center;
                align-items: center;
            }
        
            .card svg {
                transition: 0.2s;
            }
        
            /* hover */
            .card:hover {
                transform: translateY(-5px);
                box-shadow: 0px 12px 20px 0px rgb(0 0 0 / 6%);
            }
        
            .card:hover .card__title {
                color: var(--primary-color);
                text-decoration: underline;
            }
        
            .card:hover .card__arrow {
                background: #111;
            }
        
            .card:hover .card__arrow svg {
                transform: translateX(3px);
            }
        
            /* Additional styling for the form inside the card */
            .card form {
                margin-top: 1.5rem;
            }
        
            .card form label {
                display: block;
                font-size: 0.9rem;
                font-weight: bold;
                color: var(--secondary-color);
            }
        
            .card form input[type="text"] {
                width: 100%;
                padding: 5px;
                margin-bottom: 10px;
            }
        
            /* .card form button[type="submit"] {
                padding: 10px 20px;
                background-color: var(--primary-color);
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            } */
            .input {
            background-color: white;
            width: 100%;
            max-width: 500px; /* Adjust the value as per your requirement */
            height: 40px;
            padding: 10px;
            border: 2px solid white;
            border-radius: 5px;
        }
    
        .input:focus {
            color: black;
            background-color: mintcream;
            outline-color: rgb(0, 255, 255);
            box-shadow: -3px -3px 15px rgb(0, 255, 255);
            transition: .1s;
            transition-property: box-shadow;
        }
        </style>
    

@endsection
