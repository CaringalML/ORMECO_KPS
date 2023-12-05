<?php

namespace App\Http\Controllers;

use App\Models\Login;
use App\Models\Cat;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Auth;
use Kreait\Firebase\Exception\FirebaseException;
use Session;
use Illuminate\Support\Facades\Storage;

class CatController extends Controller
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
    // dd($request->all());
    try {
        //validate the input
        $request->validate([
            'notices' => 'required|string|max:255',
            'department_id' => 'required|string|max:255',
        ]);

        //create or insert a new product in the database
        Cat::create($request->all());

        //redirect the user and send friendly message
        return redirect()->route('request.add_report')->with('success','Product created successfully');
    } catch (\Exception $e) {
        \Log::error($e->getMessage());
        return redirect()->back()->with('error','Unable to create product. Please try again later.');
    }
}

    

public function add_report(Request $request)
{
    // Retrieve logins from the logins table where the status is equal to 1
    $logins = Login::where('status', 1)->get(['user_id', 'name']);

    $query = $request->get('query');
    $cats = Cat::orderBy('created_at', 'desc');

    if ($query) {
        $cats = $cats->where('department_id', 'LIKE', "%{$query}%")
            ->orWhere('notices', 'LIKE', "%{$query}%")
            ->orWhere('created_at', 'LIKE', "%{$query}%");
    }

    $cats = $cats->paginate(10)->appends(['query' => $query]);

    return view('request', compact('cats', 'query'))->with(['logins' => $logins]);

}



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cat  $cat
     * @return \Illuminate\Http\Response
     */
    public function show(Cat $cat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cat  $cat
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cat = Cat::find($id);
    
        return view('modify.edit', compact('cat'));
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cat  $cat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cat = Cat::find($id);
        $cat->department_id = $request->input('department_id');
        $cat->notices = $request->input('notices');
        $cat->save();

        return redirect()->route('request.add_report')->with('success','Report Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cat  $cat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Cat $cat)
    {
        $cat->delete();

        return redirect()->route('request.add_report')
            ->with('success', 'Cat record deleted successfully');
    }
}
