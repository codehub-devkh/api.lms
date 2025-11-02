<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class StatusController extends Controller
{
    public function store(Request $request){
        $status = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:50', 'unique:statuses,name'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);
        $response = Status::create($status);
        return $this->created('Status created successfully', $response);
    }
    public function index(){
        $response = Status::orderBy('id', 'desc')->get();
        if($response->isEmpty()){
            return $this->notFound("Status not found");
        }
        return $this->success("Status retrieved successfully", $response);
    }
    public function show($id){
        $response = Status::find($id);
        if(is_null($response)){
            return $this->notFound("Status not found");
        }
        return $this->success("Status retrieved successfully", $response);
    }
    public function update(Request $request, $id){
        $request->merge(['id' => $id]);
        $status = Status::find($id);
        if(is_null($status)){
            return $this->notFound("Status not found");
        }
        $validated = $request->validate([
            'id' => ['required', 'integer', 'exists:statuses,id'],
            'name' => ['required','string','min:3','max:50','unique:statuses,name,' . $id],
            'description' => ['nullable','string','max:255'],
        ]);
        $status->update($validated);
        return $this->success('Status updated successfully');
    }
    public function destroy(Request $request, $id){
        $request->merge(['id' => $id]);
        $status = Status::find($id);
        if (is_null($status)) {
            return $this->notFound("Status not found");
        }
        $request->validate([
            'id' => ['required', 'integer', 'exists:statuses,id'],
        ]);
        $status->delete();
        return $this->success('Status deleted successfully');
    }
}
