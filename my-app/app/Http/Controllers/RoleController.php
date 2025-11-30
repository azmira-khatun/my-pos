<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // List roles
    public function index()
    {
        $roles = Role::paginate(10); // paginator
        return view('pages.roles.index', compact('roles'));
    }

    // Show create form
    public function create()
    {
        return view('pages.roles.create');
    }

    // Store role
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name|max:255',
            'guard_name' => 'nullable|string|max:50',
        ]);

        Role::create([
            'name' => $request->name,
            'guard_name' => $request->guard_name ?? 'web',
        ]);

        return redirect()->route('roles.index')->with('success', 'Role created successfully!');
    }

    // Show edit form
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('pages.roles.edit', compact('role'));
    }

    // Update role
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'guard_name' => 'nullable|string|max:50',
        ]);

        $role->update([
            'name' => $request->name,
            'guard_name' => $request->guard_name ?? 'web',
        ]);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully!');
    }

    // Delete role
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully!');
    }
}
