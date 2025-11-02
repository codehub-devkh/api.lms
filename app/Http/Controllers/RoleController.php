<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class RoleController extends Controller
{
    public function store(Request $request)
    {
        $role = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:50', 'unique:roles,name'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);
        $response = Role::create($role);
        return $this->created("Role created successfully", $response);
    }
    public function index()
    {
        $response = Role::orderBy('id', 'desc')->get();
        if ($response->isEmpty()) {
            return $this->notFound("Role not found");
        }
        return $this->success("Role retrieved successfully", $response);
    }
    public function show($id)
    {
        $response = Role::find($id);
        if (is_null($response)) {
            return $this->notFound("Role not found");
        }
        return $this->success("Role retrieved successfully", $response);
    }

    public function update(Request $request, $id)
    {
        $request->merge(['id' => $id]);
        $role = Role::find($id);
        if (is_null($role)) {
            return $this->notFound("Role not found");
        }
        $validated = $request->validate([
            'id' => ['required', 'integer', 'exists:roles,id'],
            'name' => ['required', 'string', 'min:3', 'max:50', 'unique:roles,name,' . $id],
            'description' => ['nullable', 'string', 'max:255'],
        ]);
        $role->update($validated);
        return $this->success('Role updated successfully');
    }
    public function destroy(Request $request, $id)
    {
        $request->merge(['id' => $id]);
        $role = Role::find($id);
        if (is_null($role)) {
            return $this->notFound("Role not found");
        }
        $request->validate([
            'id' => ['required', 'integer', 'exists:roles,id']
        ]);
        $role->delete();
        return $this->success('Role deleted successfully');
    }
}
