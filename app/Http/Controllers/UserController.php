<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('departments')
            ->where('id', '!=', auth()->id())
            ->get();
        $departments_all = Department::all();
        return view('pages.customer.user', compact('users', 'departments_all'));
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
        if ($request->has('id_user') && !empty($request->input('id_user'))) {
            $this->validate($request, [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'email',
                'salary' => 'required',
                'password' => 'confirmed',

            ], [
                'first_name.required' => 'กรุณาระบุชื่อ',
                'last_name.required' => 'กรุณาระบุนามสกุล',
                'email.required' => 'กรุณาระบุอีเมลล์',
                'salary.required' => 'กรุณาระบุเงินเดือน',
                'password.confirmed' => 'รหัสผ่านไม่ตรงกัน',
            ]);

            $user = User::find($request->input('id_user'));
        } else {
            $this->validate($request, [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users,email',
                'salary' => 'required',
                'password' => 'required|confirmed',
                'department'=>'required'
            ], [
                'first_name.required' => 'กรุณาระบุชื่อ',
                'last_name.required' => 'กรุณาระบุนามสกุล',
                'email.required' => 'กรุณาระบุอีเมลล์',
                'department.required' => 'กรุณาระบุตำแหน่ง',
                'email.email' => 'กรุณาระบุเป็นอีเมลล์',
                'email.unique' => 'อีเมลล์นี้มีผู้ใช้งานแล้ว',
                'salary.required' => 'กรุณาระบุเงินเดือน',
                'password.required' => 'กรุณาระบุรหัสผ่าน',
                'password.confirmed' => 'รหัสผ่านไม่ตรงกัน',
            ]);

            $user = new User;
        }

        $user->department_id = $request->input('department');
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->salary = $request->input('salary');
        $user->phone = $request->input('phone');
        if ($request->has('password') && !empty($request->input('password'))) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();
     
        // return response()->json(['status' => 'create User successfully'], 200);
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
        $user = User::find($id);
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        return view('pages.category');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            if ($user->delete()) {
                if ($user->img !== null) {
                    Storage::delete('public/uploads/' . $user->img);
                }
            }

            return redirect()->back()->with('message', 'ลบผู้ใช้งานสำเร็จ');
        } catch (\Exception $e) {
            // . $e->getMessage()
            return redirect()->back()->with('error', 'ไม่สามารถลบผู้ใช้งานนี้ได้');
        }
    }

    public function updatestatus($id){
        $user = User::find($id);
        if ($user->status != 1) {
            $user->status = 1;
        } else {
            $user->status = 0;
        }
        $user->save();
        return redirect()->back()->with('message', 'อัพเดตสถานะเข้าสำเร็จ');
    }
}
