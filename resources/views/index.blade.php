@extends('layouts.app')

@section('content')



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('All Reports') }}</div>
                <a class="btn btn-primary" href="{{ route('home') }}">Submit New Report </a>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                    <br><br>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <table class="table table-bordered">
                        <tr>
                            <th>Reports</th>
                            <th>Files</th>
                            <th>Date and Time</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->title }}</td>
                            <td>{{ $product->file }}</td>
                            <td><span id="datetime-{{ $product->id }}">{{ $product->created_at }}</span></td>
                            <td>
                                <form action="{{ route('products.destroy',$product->id) }}" method="POST">
                                    {{-- <a class="btn btn-info" href="{{ route('products.show',$product->id) }}">Show</a> --}}
                                    <a class="btn btn-primary" href="{{ route('products.edit',$product->id) }}">Edit</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    
                    </table>
                    
                    {{ $products->links() }}
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>




<script>
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
</script>


@endsection