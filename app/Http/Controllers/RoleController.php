<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index() {
        $roles = Role::get();
        $users = User::get();
        $permissions = Permission::get();
        return view('admin.role.index', compact('roles', 'users', 'permissions'));
    }

    public function create() {
        $permissions = Permission::orderBy('group_name', 'asc')->orderBy('name', 'asc')->get();
        $groupedPermissions = $permissions->groupBy('group_name');
        return view('admin.role.add', compact('permissions', 'groupedPermissions'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'role_id' => 'nullable|exists:roles,id',
            'name' => 'required|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);
    
        if (isset($data['role_id']) && !empty($data['role_id'])) {
            $role = Role::findOrFail($data['role_id']);
            $role->update(['name' => $data['name']]);
        } else {
            $role = Role::create([
                'name' => $data['name'],
                'guard_name' => 'web', 
            ]);
        }
    
        if (isset($data['permissions'])) {
            $role->permissions()->sync($data['permissions']);
        }
        
        return redirect()->route('roles.detail', $role->id)
                 ->with('success', 'Role saved successfully.');

    }

    public function detail($id) {
        $role = Role::findOrFail($id);
        $permissions = Permission::orderBy('group_name', 'asc')->orderBy('name', 'asc')->get();
        $groupedPermissions = $permissions->groupBy('group_name');
        return view('admin.role.detail', compact('role', 'permissions', 'groupedPermissions'));
    }

    public function submit (Request $request, $id) {
        $data = $request->validate([
            'role_id' => 'nullable|exists:roles,id',
            'name' => 'required|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);
    
        $role = Role::findOrFail($id);

        if (isset($data['permissions'])) {
            $role->permissions()->sync($data['permissions']);
        }
    
        if ($role) {
            $role->update(['name' => $data['name']]);
            
            return redirect()->route('roles.index', $id)->with('success', 'Role updated successfully.');

        } else {
            $role = Role::create([
                'name' => $data['name'],
                'guard_name' => 'web', 
            ]);
        }
        
        return redirect()->route('roles.index')->with('success', 'Role saved successfully.');
    }

    public function roleDelete($id) {
        $role = Role::findOrFail($id);

        if ($role->users()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Role tidak dapat dihapus karena masih digunakan oleh user.',
            ]);
        }
    
        $role->delete();
    
        return response()->json([
            'success' => true,
            'message' => 'Role berhasil dihapus.',
            'redirect' => route('roles.index')
        ]);
    }
    
    public function storeUser(Request $request)
    {
        $userId = $request->id;
    
        $rules = [
            'name' => 'required|string|max:20',
            'username' => ['required', 'string', 'regex:/^[a-z]+$/', Rule::unique('users')->ignore($userId)],
            'phone' => 'required|regex:/^[0-9]{10,15}$/|unique:users,phone',
            'email' => ['required', 'email', Rule::unique('users')->ignore($userId)],
            'role_id' => 'required|exists:roles,id',
        ];
    
        if (!$userId) {
            $rules['password'] = 'required|string|min:8';
        }
    
        $validated = $request->validate($rules);
    
        $user = User::updateOrCreate(
            ['id' => $userId],
            [
                'name' => $validated['name'],
                'username' => $validated['username'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'password' => $userId ? User::find($userId)->password : Hash::make($request->password),
            ]
        );
    
        $user->roles()->sync([$validated['role_id']]);
    
        return redirect()->back()->with('success', $userId ? 'User updated successfully.' : 'User added successfully.');
    }
    
}
