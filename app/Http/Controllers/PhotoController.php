<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Auth;
use Kreait\Firebase\Exception\FirebaseException;
use Session;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
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


//    public function store(Request $request)
// {
//     // Get the current user UID
//     $uid = Session::get('uid');
//     $user = app('firebase.auth')->getUser($uid);
//     $user_id = $user->uid;

//     $request->validate([
//         'file' => 'nullable|mimes:jpeg,png,gif,bmp,tiff,raw|max:1048576'
//     ]);

//     $photo = Photo::where('user_id', $user_id)->first();

//     if ($request->hasFile('file')) {
//         $file = $request->file('file');
//         $filename = $file->getClientOriginalName();
//         $path = $file->storeAs('images', $filename, 'local');

//         // Delete the current file if it exists
//         if ($photo) {
//             Storage::disk('local')->delete('images/' . $photo->file);
//         }

//         $photoData = [
//             'user_id' => $user_id,
//             'file' => $filename,
//         ];

//         if ($photo) {
//             $photo->update($photoData);
//         } else {
//             Photo::create($photoData);
//         }

//         return redirect()->back()->with('success', 'File uploaded successfully!');
//     } else {
//         return redirect()->back()->withErrors(['file' => 'Please choose a file to upload.']);
//     }
// }

     






     public function admin_image(Request $request)
{
   

        return view('larawan');

}



public function store(Request $request)
{
    // Get the current user UID
    $uid = Session::get('uid');
    $user = app('firebase.auth')->getUser($uid);
    $user_id = $user->uid;

    $image = $request->file('image');

    // Check if the user uploaded a new image
    if ($image) {
        $filename = $user_id . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('/images');

        // Delete the current image if it exists
        if (file_exists($destinationPath . '/' . $filename)) {
            unlink($destinationPath . '/' . $filename);
        }

        $image->move($destinationPath, $filename);

        return redirect()->route('home');

    }

    return redirect()->back()->withErrors(['image' => 'Please choose a file to upload.']);
}




    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function edit(Photo $photo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photo $photo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        //
    }
}
