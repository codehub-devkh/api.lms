<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class RoleController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required','string','min:3','max:50','unique:roles,name'],
            'description' => ['nullable','string','max:255'],
        ]);
        $role = Role::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return response()->json([
            'result' => true,
            'message' => 'Role created successfully',
            'data' => $role,
        ],200);
    }
    public function index(){
        $role = new Role();
        $role = $role->orderBy('id','desc')->get();
        if(is_null($role) ){
            return response()->json([
                'result' => false,
                'message' => "No roles found",
                'data' => []
            ],404);
        }
        return response()->json([
            'result' => true,
            'message' => "Role get all successfully",
            'data' => $role
        ]);
    }
    public function show($id){
        $role = new Role();
        $role = $role->find($id);
        if(is_null($role) ){
            return response()->json([
                'result' => false,
                'message' => "Role not found",
                'data' => []
            ],404);
        }
        return response()->json([
            'result' => true,
            'message' => "Role get successfully",
            'data' => $role
        ]);
    }

    public function update(Request $request, $id){
        $role = new Role();
        $request->merge(['id' => $id]);
        $request->validate([
            'id' => ['required', 'integer', 'exists:roles,id'],
            'name' => ['required', 'string','min:3', 'max:50', 'unique:roles,name'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);
        $role = $role->where('id',$id)->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);
        return response()->json([
            'result' => true,
            'message' => "Role updated successfully",
            'data' => $role
        ]);
    }
    public function destroy(Request $request , $id){
        $request->merge(['id' => $id]);
        $request->validate([
            'id' => ['required', 'integer', 'exists:roles,id']
        ]);
        $role = new Role();
        $role = $role->where('id', $id)->delete();
        return response()->json(
            [
                'result' => true,
                'message' => "Role deleted successfully",
            ]
        );
    }
}
