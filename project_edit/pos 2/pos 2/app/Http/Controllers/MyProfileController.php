<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MyProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user()->load('departments');
        // i need department where table user department_id = id in table department
        return view('pages.user.myProfile',compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrfail($id);
        if ($request->hasFile('image')) {
            Storage::delete('public/uploads/' . $user->img);
            $imageFile = $request->file('image');
            $fileName = time() . '.' . $imageFile->extension();
            $imageFile->storeAs('public/uploads', $fileName);
            $user->img = $fileName;
        }
        

        if(!$user){
            return redirect()->route('myprofile.index')->with('error', 'ไม่พบไอดีที่ต้องการอัพเดต');
        }
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->phone = $request->input('phone');

        $user->save();
        return redirect()->route('myprofile.index')->with('message', 'อัพเดตโปรไฟล์สำเร็จ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
