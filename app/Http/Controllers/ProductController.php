<?php

namespace App\Http\Controllers;

use App\Models\Hog;
use App\Models\Chat;
use App\Models\Image;
use App\Models\Product;
use App\Models\Field;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Auth;
use Kreait\Firebase\Exception\FirebaseException;
use Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // Get the current user UID
    $uid = Session::get('uid');
    $user = app('firebase.auth')->getUser($uid);
    $user_id = $user->uid;

    // Fetch the products data for the current user
    $products = Product::where('user_id', $user_id)->latest()->paginate(10);

    return view('index', compact('products'))->with(request()->input('page'));


    }




    public function task_a()
    {
        //
        // Get the current user UID
    $uid = Session::get('uid');
    $user = app('firebase.auth')->getUser($uid);
    $user_id = $user->uid;

    // Fetch the products data for the current user
    $products = Product::where('user_id', $user_id)->latest();

    return view('upload', compact('products'))->with(request()->input('page'));


    }

   
    public function admin_dashboard(Request $request)
{
    $search = $request->input('search');
    $query = Product::query();

    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', '%' . $search . '%')
              ->orWhere('title', 'LIKE', '%' . $search . '%')
              ->orWhere('user_id', 'LIKE', '%' . $search . '%')
              ->orWhere('file', 'LIKE', '%' . $search . '%')
              ->orWhere('created_at', 'LIKE', '%' . $search . '%');
        });
    }

    $products = $query->orderBy('created_at', 'desc')->paginate(10);
    return view('admin', compact('products'));
}


    

    public function downloadFile($id)
{
    $product = Product::findOrFail($id);
    $pathToFile = storage_path('app/documents/' . $product->file);

    return response()->download($pathToFile);
}




public function team(Request $request)
{
    $userIds = Product::distinct()->pluck('user_id');
    $selectedUserId = $request->input('user_id');

    if ($selectedUserId) {
        $query = Product::where('user_id', $selectedUserId);
    } else {
        $query = Product::query();
    }

    $search = $request->input('search');
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', '%'.$search.'%')
              ->orWhere('title', 'like', '%'.$search.'%')
              ->orWhere('user_id', 'like', '%'.$search.'%')
              ->orWhere('file', 'like', '%'.$search.'%')
              ->orWhere('created_at', 'like', '%'.$search.'%');
        });
    }

    $products = $query->orderBy('created_at', 'desc')->paginate(10);
    $totalReports = $products->total();

    return view('team', compact('products', 'userIds', 'selectedUserId', 'totalReports', 'search'));
}






public function request_report(Request $request)
{
   
    $request->validate([
        'notice' => 'required',
        'user_id' => 'required',
    ]);
      
    Cat::create([
        'notice' => $request->input('notice'),
        'user_id' => $request->input('user_id'),
    ]);

        return view('request');

}


public function graph(Request $request){

    

    $fields = Field::all(); // Retrieve all the data from the "user_graphs" table

    return view('graph', compact('fields'));
}

public function user_graph(Request $request){
   

    $fields = Field::all(); // Retrieve all the data from the "user_graphs" table

    return view('user_graph', compact('fields'));
}

public function add_user_analytics(Request $request){


    $department_id = $request->input('department_id');
    
    // Validate the input if necessary

    // Assuming you have a Field model
    $field = new Field();
    $field->department_id = $department_id;
    $field->save();

    // You can add additional logic or redirection here

    return redirect()->back()->with('success', 'Room added successfully.');
}


public function change($id){

    $field = Field::find($id);
    
    return view('edit-user-analytics.change', compact('field'));
}



public function transform(Request $request, $id)
    {
        //
        $field = Field::find($id);
        $field->department_id = $request->input('department_id');
        $field->save();

        return redirect()->route('visual.graph')->with('success','User Analytics Updated Successfully');
    }







    // public function task_b()
    // {
    //     //
    //     // Get the current user UID
    // $uid = Session::get('uid');
    // $user = app('firebase.auth')->getUser($uid);
    // $user_id = $user->uid;

    // // Fetch the products data for the current user
    // $products = Product::where('user_id', $user_id)->latest()->paginate(100);

    // return view('index', compact('products'))->with(request()->input('page'));


    // }



    // public function task_c()
    // {
    //     //
    //     // Get the current user UID
    // $uid = Session::get('uid');
    // $user = app('firebase.auth')->getUser($uid);
    // $user_id = $user->uid;

    // // Fetch the products data for the current user
    // $products = Product::where('user_id', $user_id)->latest()->paginate(100);

    // return view('index', compact('products'))->with(request()->input('page'));


    // }








    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
     {
         $this->middleware('auth');
     }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    // Get the current user UID
    $uid = Session::get('uid');
    $user = app('firebase.auth')->getUser($uid);
    $user_id = $user->uid;

    $request->validate([
        'title' => 'required',
        'file' => 'nullable|mimes:docx,doc,xlsx,pptx,pst,accdb,pdf|max:2048'
    ]);

    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $path = $file->storeAs('documents', $filename, 'local');

        // Check if file already exists in database
        $fileExists = Product::where('file', $filename)->exists();
        if ($fileExists) {
            return back()->withErrors(['file' => 'File already exists!']);
        }
    }

    $product = Product::create([
        'name' => $request->input('name'),
        'title' => $request->input('title'),
        'report_type' => $request->input('report_type'),
        'user_id' => $user_id,
        'file' => isset($path) ? $filename : null,
    ]);





   $field1 = Field::where('department_id', $user_id)
    ->where('id', 1)
    ->first();

    $field2 = Field::where('department_id', $user_id)
    ->where('id',2)
    ->first();

    $field3 = Field::where('department_id', $user_id)
    ->where('id', 3)
    ->first();

    $field4 = Field::where('department_id', $user_id)
    ->where('id', 4)
    ->first();

    $field5 = Field::where('department_id', $user_id)
    ->where('id', 5)
    ->first();

    $field6 = Field::where('department_id', $user_id)
    ->where('id', 6)
    ->first();

    $field7 = Field::where('department_id', $user_id)
    ->where('id', 7)
    ->first();

if ($field1) {
    $count = Product::whereHas('field', function ($query) use ($user_id) {
        $query->where('department_id', $user_id);
    })->count();
    
    // Make a GET request to the specified URL with the count
    $response = Http::get('https://api.thingspeak.com/update', [
        'api_key' => 'UN9W9Y963YU2V182',
        'field1' => $count,
    ]);
    // You can add error handling or check the response if needed

}else if($field2) {
    $count = Product::whereHas('field', function ($query) use ($user_id) {
        $query->where('department_id', $user_id);
    })->count();
    
    // Make a GET request to the specified URL with the count
    $response = Http::get('https://api.thingspeak.com/update', [
        'api_key' => 'UN9W9Y963YU2V182',
        'field2' => $count,
    ]);
    // You can add error handling or check the response if needed
}

else if($field3) {
    $count = Product::whereHas('field', function ($query) use ($user_id) {
        $query->where('department_id', $user_id);
    })->count();
    
    // Make a GET request to the specified URL with the count
    $response = Http::get('https://api.thingspeak.com/update', [
        'api_key' => 'UN9W9Y963YU2V182',
        'field3' => $count,
    ]);
    // You can add error handling or check the response if needed
}

else if($field4) {
    $count = Product::whereHas('field', function ($query) use ($user_id) {
        $query->where('department_id', $user_id);
    })->count();
    
    // Make a GET request to the specified URL with the count
    $response = Http::get('https://api.thingspeak.com/update', [
        'api_key' => 'UN9W9Y963YU2V182',
        'field4' => $count,
    ]);
    // You can add error handling or check the response if needed
}

else if($field5) {
    $count = Product::whereHas('field', function ($query) use ($user_id) {
        $query->where('department_id', $user_id);
    })->count();
    
    // Make a GET request to the specified URL with the count
    $response = Http::get('https://api.thingspeak.com/update', [
        'api_key' => 'UN9W9Y963YU2V182',
        'field5' => $count,
    ]);
    // You can add error handling or check the response if needed
}



else if($field6) {
    $count = Product::whereHas('field', function ($query) use ($user_id) {
        $query->where('department_id', $user_id);
    })->count();
    
    // Make a GET request to the specified URL with the count
    $response = Http::get('https://api.thingspeak.com/update', [
        'api_key' => 'UN9W9Y963YU2V182',
        'field6' => $count,
    ]);
    // You can add error handling or check the response if needed
}


else if($field7) {
    $count = Product::whereHas('field', function ($query) use ($user_id) {
        $query->where('department_id', $user_id);
    })->count();
    
    // Make a GET request to the specified URL with the count
    $response = Http::get('https://api.thingspeak.com/update', [
        'api_key' => 'UN9W9Y963YU2V182',
        'field7' => $count,
    ]);
    // You can add error handling or check the response if needed
}



else {
        return redirect()->back()->with('success', 'Report created successfully!');
    }





// // Check if the user's UID matches the department_id in the Field table with additional conditions
// $field1 = Field::where('department_id', $user_id)
//     ->where('id', 1)
//     ->first();

// $field2 = Field::where('department_id', $user_id)
//     ->where('id', 2)
//     ->first();

// $field3 = Field::where('department_id', $user_id)
//     ->where('id', 3)
//     ->first();

// $field4 = Field::where('department_id', $user_id)
//     ->where('id', 4)
//     ->first();

// $field5 = Field::where('department_id', $user_id)
//     ->where('id', 5)
//     ->first();

// if ($field1) {
//     // Make a GET request to the specified URL
//     $response = Http::get('https://api.thingspeak.com/update?api_key=UN9W9Y963YU2V182&field1=1');
//     // You can add error handling or check the response if needed
// } else if ($field2) {
//     // Make a GET request to the specified URL
//     $response = Http::get('https://api.thingspeak.com/update?api_key=UN9W9Y963YU2V182&field2=10');
//     // You can add error handling or check the response if needed
// } else if ($field3) {
//     // Make a GET request to the specified URL
//     $response = Http::get('https://api.thingspeak.com/update?api_key=UN9W9Y963YU2V182&field3=1');
//     // You can add error handling or check the response if needed
// } else if ($field4) {
//     // Make a GET request to the specified URL
//     $response = Http::get('https://api.thingspeak.com/update?api_key=UN9W9Y963YU2V182&field4=1');
//     // You can add error handling or check the response if needed
// } else if ($field5) {
//     // Make a GET request to the specified URL
//     $response = Http::get('https://api.thingspeak.com/update?api_key=UN9W9Y963YU2V182&field5=1');
//     // You can add error handling or check the response if needed
// } else {
//     return redirect()->back()->with('success', 'Report created successfully!');
// }

    return redirect()->back()->with('success', 'Report created successfully!');
}
    


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    // public function edit(Product $product)
    // {
    //     //
    //     return view('edit', compact('product'));
    // }


    public function edit($id)
    {
        $product = Product::find($id);

        $uid = Session::get('uid');
        $user = app('firebase.auth')->getUser($uid);
        $user_id = $user->uid;

          // Retrieve data from the hogs table where department_id matches the user_id
          $notices = Hog::where('department_id', $user_id)->pluck('notices');
    
          return view('edit', compact('product', 'notices'));
    }




    public function admin_page_edit($id)
    {
        $product = Product::find($id);

        // Retrieve logins from the logins table where the status is equal to 1
        // $logins = Login::where('status', 1)->get(['user_id', 'name']);

          // Retrieve data from the hogs table
    $notices = Hog::pluck('notices');
    
          return view('admin_page_update.edit', compact('product', 'notices'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */



     public function update(Request $request, $id)
     {
         $request->validate([
             'title' => 'required',
             'file' => 'nullable|mimes:docx,doc,xlsx,pptx,pst,accdb,pdf|max:2048',
             'report_type' => 'required'
         ]);
     
         $product = Product::findOrFail($id);
     
         // Check if the file already exists
         if ($request->hasFile('file')) {
             $file = $request->file('file');
             $filename = $file->getClientOriginalName();
             $exists = Product::where('file', $filename)->where('id', '!=', $id)->exists();
             if ($exists) {
                 return redirect()->back()->withErrors(['file' => 'File already exists, please upload a new file!']);
             }
         }
     
         $product->title = $request->title;
         $product->report_type = $request->report_type;
     
         if ($request->hasFile('file')) {
             // Delete the current file
             Storage::delete('documents/'.$product->file);
     
             // Upload the new file with original name
             $file = $request->file('file');
             $filename = $file->getClientOriginalName();
             $path = $file->storeAs('documents', $filename, 'local');
             $product->file = $filename;
         }
     
         $product->save();
     
         return redirect()->route('home')->with('success', 'Product updated successfully.');
     }
     
     
     
    
    









    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    // public function destroy(Product $product)
    // {
    //     //

    //     //delete the data or the product
    //     $product->delete();

    //     //redirect the user and display friendly success message
    //     return redirect()->route('products.index')->with('success','Product deleted successfully');

    // }



    public function destroy(Request $request, Product $product)
    {
        $product->delete();

        return redirect()->route('home')
            ->with('success', 'Cat record deleted successfully');
    }




    public function updateStatus($id)
    {
        $product = Product::findOrFail($id);
        
        // Toggle the status between 0 and 1
        $product->status = ($product->status == 0) ? 1 : 0;
        
        $product->save();

        return redirect()->back()->with('status', 'Product status updated successfully.');
    }



    public function preview($id)
{
    $product = Product::findOrFail($id);
    $chats = Chat::where('product_id', $id)->orderBy('created_at')->get();

    return view('preview', compact('product', 'chats'));
}


public function previewed($id)
{
    $product = Product::findOrFail($id);
    $chats = Chat::where('product_id', $id)->orderBy('created_at')->get();

    return view('previewed', compact('product', 'chats'));
}



public function saveMessage(Request $request)
{
    $productId = $request->input('product_id');
    $userId = $request->input('user_id');
    $message = $request->input('conversation');
    $name = $request->input('name');

    // Save the message using the Chat model
    $chat = new Chat();
    $chat->product_id = $productId;
    $chat->user_id = $userId;
    $chat->conversation = $message;
    $chat->name = $name; // Save the name in the 'name' column
    $chat->save();

    // Redirect back or return a response if needed
    return redirect()->back();
}


    
}
