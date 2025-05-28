<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Users::all();
        return view('users.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Logic to show the form for creating a new user
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Logic to store a new user
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Logic to display a specific user
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Logic to show the form for editing a user
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Logic to update a user
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Logic to delete a user
    }
}
