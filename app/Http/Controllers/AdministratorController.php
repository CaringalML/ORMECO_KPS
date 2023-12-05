<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Auth;
use Kreait\Firebase\Exception\FirebaseException;
use Session;
use Illuminate\Support\Facades\Storage;
use App\Models\Login;

use Illuminate\Support\Facades\DB;

use App\Models\Bat;
use App\Models\Book;
use App\Models\Chair;
use App\Models\Dog;
use App\Models\Computer;
use App\Models\Stack;
use App\Models\Machine;
use App\Models\House;
use App\Models\Car;
use App\Models\Pen;
use App\Models\Rat;

use App\Models\Hog;




class AdministratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        //

         // dd($request->all());
    try {
        //validate the input
        $request->validate([
            'user_id' => 'required|string|max:255',
        ]);

        //create or insert a new product in the database
        Administrator::create($request->all());

        //redirect the user and send friendly message
        return redirect()->route('admins.add_admin')->with('success','Admin Added successfully');
    } catch (\Exception $e) {
        \Log::error($e->getMessage());
        return redirect()->back()->with('error','Unable to add admin. Please try again later.');
    }
    }


    public function add_admin(Request $request)
{
      // Retrieve logins from the logins table where the status is equal to 1
      $logins = Login::where('status', 1)->get(['user_id', 'name']);

    $query = $request->get('query');
    $administrators = Administrator::orderBy('created_at', 'desc');

    if ($query) {
        $administrators = $administrators->where('user_id', 'LIKE', "%{$query}%")
            ->orWhere('created_at', 'LIKE', "%{$query}%");
    }

    $administrators = $administrators->paginate(10)->appends(['query' => $query]);

    return view('add_admin', compact('administrators', 'query'))->with(['logins' => $logins]);
}


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Administrator  $administrator
     * @return \Illuminate\Http\Response
     */
    public function show(Administrator $administrator)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Administrator  $administrator
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $administrator = Administrator::find($id);
    
        return view('admin-modify.edit', compact('administrator'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Administrator  $administrator
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $administrator = Administrator::find($id);
        $administrator->user_id = $request->input('user_id');
        $administrator->save();

        return redirect()->route('admins.add_admin')->with('success','Admin Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Administrator  $administrator
     * @return \Illuminate\Http\Response
     */
    public function destroy(Administrator $administrator)
    {
        //
        $administrator->delete();

        return redirect()->route('admins.add_admin')
            ->with('success', 'Cat record deleted successfully');
    }



    public function userlist(Request $request)
    {
        $search = $request->input('search');
        
        $users = Login::where('user_id', 'LIKE', "%$search%")
                      ->orWhere('name', 'LIKE', "%$search%")
                      ->orWhere('email', 'LIKE', "%$search%")
                      ->orWhere('created_at', 'LIKE', "%$search%")
                      ->orderBy('id', 'desc')
                      ->get();
        
        return view('userlist', ['users' => $users]);
    }

    public function updateStatus($id)
    {
        $user = Login::find($id);
        
        if ($user) {
            $user->status = $user->status == 1 ? 0 : 1;
            $user->save();
        }
        
        return redirect()->back();
    }
    




    // public function automate_notifications(Request $request)
    // {
    //     // Retrieve logins from the logins table where the status is equal to 1
    //     $logins = Login::where('status', 1)->get(['user_id', 'name']);
    
    //     // Retrieve data from the dogs table
    //     $dogs = Dog::all();
    
    //     return view('automate_notifications', ['logins' => $logins, 'dogs' => $dogs]);
    // }




    public function automate_notifications(Request $request)
    {
        // Retrieve logins from the logins table where the status is equal to 1
        $logins = Login::where('status', 1)->get(['user_id', 'name']);

          // Retrieve data from the hogs table
    $notices = Hog::pluck('notices');
    
        // Retrieve data from the dogs table
        $dogs = Dog::all();
        $bats = Bat::all();
        $houses = House::all();
        $chairs = Chair::all();
        $books = Book::all();
        $computers = Computer::all();
        $machines = Machine::all();
        $pens = Pen::all();
        $rats = Rat::all();
        $cars = Car::all();
        $stacks = Stack::all();

        

    
        return view('automate_notifications', ['logins' => $logins,

         'dogs' => $dogs,
         'bats' => $bats,
         'houses' => $houses,
         'chairs' => $chairs,
         'books' => $books,
         'computers' => $computers,
         'machines' => $machines,
         'pens' => $pens,
         'rats' => $rats,
         'cars' => $cars,
         'stacks' => $stacks,
         'notices' => $notices,
        ]);
    }
    

public function insert_data(Request $request)
{
    // Validate the input
    $validatedData = $request->validate([
        'department_id' => 'required',
        'schedule' => 'required',
        'notices' => 'required',
    ]);

    // Retrieve the user's name based on the user_id
    $user = Login::where('user_id', $request->input('department_id'))->first();

    // Check if the selected schedule is "Every_1st_Week_Saturday_of_the_Month"
    if ($request->input('schedule') === 'Every_1st_Week_Saturday_of_the_Month') {
        // Insert data into the dogs table
        Dog::create([
            'department_id' => $request->input('department_id'),
            'name' => $user->name,
            'notices' => $request->input('notices'),
        ]);

        // Redirect or perform any other actions upon successful insertion
        // For example:
        return redirect()->back()->with('success', 'Data inserted successfully.');
    }
    elseif ($request->input('schedule') === 'Every_5th_day_of_the_Month') {
        // Insert data into the houses table
        House::create([
            'department_id' => $request->input('department_id'),
            'name' => $user->name,
            'notices' => $request->input('notices'),
        ]);

        // Redirect or perform any other actions upon successful insertion
        // For example:
        return redirect()->back()->with('success', 'Data inserted successfully.');
    }
    elseif ($request->input('schedule') === 'Every_8th_day_of_the_Month') {
        // Insert data into the cars table
        Car::create([
            'department_id' => $request->input('department_id'),
            'name' => $user->name,
            'notices' => $request->input('notices'),
        ]);

        // Redirect or perform any other actions upon successful insertion
        // For example:
        return redirect()->back()->with('success', 'Data inserted successfully.');
    }
    elseif ($request->input('schedule') === 'Every_10th_day_of_the_Month') {
        // Insert data into the books table
        Book::create([
            'department_id' => $request->input('department_id'),
            'name' => $user->name,
            'notices' => $request->input('notices'),
        ]);

        // Redirect or perform any other actions upon successful insertion
        // For example:
        return redirect()->back()->with('success', 'Data inserted successfully.');
    }
    elseif ($request->input('schedule') === 'Every_15th_day_of_the_Month') {
        // Insert data into the machines table
        Machine::create([
            'department_id' => $request->input('department_id'),
            'name' => $user->name,
            'notices' => $request->input('notices'),
        ]);

        // Redirect or perform any other actions upon successful insertion
        // For example:
        return redirect()->back()->with('success', 'Data inserted successfully.');
    }
    elseif ($request->input('schedule') === 'Every_20th_day_of_the_Month') {
        // Insert data into the pens table
        Pen::create([
            'department_id' => $request->input('department_id'),
            'name' => $user->name,
            'notices' => $request->input('notices'),
        ]);

        // Redirect or perform any other actions upon successful insertion
        // For example:
        return redirect()->back()->with('success', 'Data inserted successfully.');
    }
    elseif ($request->input('schedule') === 'Every_January_15th') {
        // Insert data into the chairs table
        Chair::create([
            'department_id' => $request->input('department_id'),
            'name' => $user->name,
            'notices' => $request->input('notices'),
        ]);

        // Redirect or perform any other actions upon successful insertion
        // For example:
        return redirect()->back()->with('success', 'Data inserted successfully.');
    }
    elseif ($request->input('schedule') === 'Every_July_15th') {
        // Insert data into the computers table
        Computer::create([
            'department_id' => $request->input('department_id'),
            'name' => $user->name,
            'notices' => $request->input('notices'),
        ]);

        // Redirect or perform any other actions upon successful insertion
        // For example:
        return redirect()->back()->with('success', 'Data inserted successfully.');
    }
    elseif ($request->input('schedule') === 'Every_Month') {
        // Insert data into the bats table
        Bat::create([
            'department_id' => $request->input('department_id'),
            'name' => $user->name,
            'notices' => $request->input('notices'),
        ]);

        // Redirect or perform any other actions upon successful insertion
        // For example:
        return redirect()->back()->with('success', 'Data inserted successfully.');
    }
    elseif ($request->input('schedule') === 'Every_30th_of_the_Month') {
        // Insert data into the stacks table
        Stack::create([
            'department_id' => $request->input('department_id'),
            'name' => $user->name,
            'notices' => $request->input('notices'),
        ]);

        // Redirect or perform any other actions upon successful insertion
        // For example:
        return redirect()->back()->with('success', 'Data inserted successfully.');
    }
    elseif ($request->input('schedule') === 'Every_Week') {
        // Insert data into the rats table
        Rat::create([
            'department_id' => $request->input('department_id'),
            'name' => $user->name,
            'notices' => $request->input('notices'),
        ]);

        // Redirect or perform any other actions upon successful insertion
        // For example:
        return redirect()->back()->with('success', 'Data inserted successfully.');
    }

    return redirect()->back()->with('error', 'Invalid schedule option.');
}



public function deleteRat(Request $request, Rat $rat)
{
    $rat->delete();
    return redirect()->route('reports.automate_notifications')->with('success', 'Rat record deleted successfully');
}

public function deleteBat(Request $request, Bat $bat)
{
    $bat->delete();
    return redirect()->route('reports.automate_notifications')->with('success', 'Bat record deleted successfully');
}

public function deleteDog(Request $request, Dog $dog)
{
    $dog->delete();
    return redirect()->route('reports.automate_notifications')->with('success', 'Dog record deleted successfully');
}

public function deleteHouse(Request $request, House $house)
{
    $house->delete();
    return redirect()->route('reports.automate_notifications')->with('success', 'House record deleted successfully');
}

public function deleteCar(Request $request, Car $car)
{
    $car->delete();
    return redirect()->route('reports.automate_notifications')->with('success', 'Car record deleted successfully');
}

public function deleteBook(Request $request, Book $book)
{
    $book->delete();
    return redirect()->route('reports.automate_notifications')->with('success', 'Book record deleted successfully');
}

public function deleteMachine(Request $request, Machine $machine)
{
    $machine->delete();
    return redirect()->route('reports.automate_notifications')->with('success', 'Machine record deleted successfully');
}

public function deletePen(Request $request, Pen $pen)
{
    $pen->delete();
    return redirect()->route('reports.automate_notifications')->with('success', 'Pen record deleted successfully');
}

public function deleteStack(Request $request, Stack $stack)
{
    $stack->delete();
    return redirect()->route('reports.automate_notifications')->with('success', 'Stack record deleted successfully');
}

public function deleteChair(Request $request, Chair $chair)
{
    $chair->delete();
    return redirect()->route('reports.automate_notifications')->with('success', 'Chair record deleted successfully');
}

public function deleteComputer(Request $request, Computer $computer)
{
    $computer->delete();
    return redirect()->route('reports.automate_notifications')->with('success', 'Computer record deleted successfully');
}




public function report_list(Request $request)
{
    $query = Hog::orderBy('created_at', 'desc');

    // Retrieve logins from the logins table where the status is equal to 1
    $logins = Login::where('status', 1)->get(['user_id', 'name']);

    // Check if a search term is provided
    if ($request->has('search')) {
        $searchTerm = $request->input('search');
        $query->where(function ($q) use ($searchTerm) {
            $q->where('name', 'like', '%' . $searchTerm . '%')
                ->orWhere('notices', 'like', '%' . $searchTerm . '%')
                ->orWhere('department_id', 'like', '%' . $searchTerm . '%')
                ->orWhere('created_at', 'like', '%' . $searchTerm . '%');
        });
    }

    $hogs = $query->paginate(10);

    return view('report_list', ['hogs' => $hogs, 'logins' => $logins]);
}





public function add_report_list(Request $request){


     // Validate the input
     $validatedData = $request->validate([
        'department_id' => 'required',
        'notices' => 'required',
    ]);

    // Retrieve the user's name based on the user_id
    $user = Login::where('user_id', $request->input('department_id'))->first();


     // Insert data into the rats table
     Hog::create([
        'department_id' => $request->input('department_id'),
        'name' => $user->name,
        'notices' => $request->input('notices'),
    ]);

    // Redirect or perform any other actions upon successful insertion
    // For example:
    return redirect()->back()->with('success', 'Data inserted successfully.');


}


public function edit_report_list($id)
    {
        $hog = Hog::find($id);
    
        return view('modify_list.edit', compact('hog'));
    }
    

    public function update_report_list(Request $request, $id)
    {
        $hog = Hog::find($id);
        $hog->department_id = $request->input('department_id');
        $hog->notices = $request->input('notices');
        $hog->save();

        return redirect()->route('dynamic.report_list')->with('success','Report Updated successfully');
    }




    public function destroy_report_list(Request $request, Hog $hog)
    {
        $hog->delete();

        return redirect()->route('dynamic.report_list')->with('success', 'Cat record deleted successfully');
    }

}