<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Action;

class ActionController extends Controller
{
    public function getAction()
    {
    	return response()->json([
    		'rows' => Action::all()
    	]);
    }

    public function saveAction(Request $request)
    {
    	$validator = Validator::make($request->all(), [
		        'file' => 'required|file|mimes:jpeg,jpg,bmp,png',
		        'action_id' => 'required'
       	]);
    	
       	if ($validator->fails()) {
       		return response()->json(['errors' => $validator->messages(), 'status' => 0]);
       	}   	

       	$action = Action::find($request->action_id);

       	if ($action) {
	       	$path = $request->file('file')->storeAs('photos/'.$request->action_id, $request->file->getClientOriginalName());
	       	$action->completed = 1;
	       	$action->file_name = $request->file->getClientOriginalName();
	       	$action->save();
	       	return response()->json(['status' => 1, 'file_name' => $request->file->getClientOriginalName()]);
       	}

       	return response()->json(['status' => 0, 'errors' => array('error' => 'an error occured.')]);
    }

    public function uncompleteAction($id)
    {
       	$action = Action::find($id);

       	if ($action) {
	       	$file = 'photos/'.$id.'/'.$action->file_name;
       		$action->file_name = '';
       		$action->completed = 0;
       		$action->save();
	       	Storage::delete($file);
	       	return response()->json(['status' => 1]);
       	}
       	return response()->json(['status' => 0, 'errors' => array('error' => 'an error occured.')]);
    }
}
