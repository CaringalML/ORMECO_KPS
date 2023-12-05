<?php

namespace App\Http\Controllers;

use App\Models\Hog;
use App\Models\Login;
use App\Models\Cat;
use App\Models\Product;
use App\Models\Administrator;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Auth;
use Kreait\Firebase\Exception\FirebaseException;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
{
    try {
        $uid = Session::get('uid');
        $user = app('firebase.auth')->getUser($uid);

        $isAdmin = Administrator::where('user_id', $uid)->exists();

        if ($isAdmin) {
            $products = Product::orderBy('created_at', 'desc')->paginate(10);
            return view('admin', compact('products'));
        } else {

            $uid = Session::get('uid');
            $user = app('firebase.auth')->getUser($uid);
            $user_id = $user->uid;

             // Retrieve data from the hogs table where department_id matches the user_id
             $notices = Hog::where('department_id', $user_id)->pluck('notices');
            
            // Check if the current UID or user_id exists in the logins table
            $login = Login::where('user_id', $user_id)->first();
            
            if ($login) {
                // Check the status column value
                if ($login->status == 1) {
                    $query = $request->get('query');
                    $products = Product::where('user_id', $user_id)->orderBy('created_at', 'desc');
                    $notifications = Cat::where('department_id', $user_id)
                        ->orderBy('created_at', 'desc')
                        ->get();
            
                    if ($query) {
                        $products = $products->where(function ($queryBuilder) use ($query) {
                            $queryBuilder->where('title', 'LIKE', "%{$query}%")
                                ->orWhere('file', 'LIKE', "%{$query}%")
                                ->orWhere('created_at', 'LIKE', "%{$query}%");
                        });
                    }
            
                    $products = $products->paginate(10)->appends(['query' => $query]);
            
                    return view('home', [
                        'products' => $products,
                        'query' => $query,
                        'notifications' => $notifications,
                        'user_id' => $user_id,
                        'notices' => $notices,
                    ]);
                    
                } else {
                    // Logout the user
                    auth()->logout();
            
                    // Redirect to the login page with an error message
                    return redirect()->route('login')->with('error', 'Please contact the admin for the approval of your account!');
                }
            } else {
                // Logout the user
                auth()->logout();
            
                // Redirect to the login page with an error message
                return redirect()->route('login')->with('error', 'Please contact the admin for the approval of your account!');
            }
            
            



            // return view('home');
        }
    } catch (\Exception $e) {
        return $e;
    }
}

    

    public function customer()
    {
      $userid = Session::get('uid');
      return view('customers',compact('userid'));
    }
}
