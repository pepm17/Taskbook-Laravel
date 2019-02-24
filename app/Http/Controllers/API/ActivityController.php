<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Activity;
use Validator;

class ActivityController extends BaseController{
    public function index(){
        $activity = Activity::all();
        return $this->sendResponse($activity->toArray(), 'Activity retrieved succesfully.');
    }

    public function store(Request $request){
        $user_id = auth()->user()->id;
        $activity = new Activity;
        $activity->title = $request->title;
        $activity->description = $request->description;
        $activity->creator = $user_id;
        $activity->_dad = $request->_dad;
        $activity->save();
        return $this->sendResponse($activity->toArray(), 'Activity created successfully.');
    }

    public function show($id){
        $activity = Activity::find($id);
        if(is_null($activity)) return $this->sendError('Activity not found');
        return $this->sendResponse($activity->toArray(), 'Activity retrieved successfully.');
    }

    public function update(Request $request, $id){
        $activity = Activity::find($id);
        if(is_null($activity)) return $this->sendError('Activity not found');
        $id_user = auth()->user()->id;
        if($activity->creator == $id_user){
            $input = $request->all();
            $validator = Validator::make($input, [
                'title' => 'required',
                'description' => 'required',
            ]);
            if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());
            $activity->title = $input['title'];
            $activity->description = $input['description'];
            $activity->save();
            return $this->sendResponse($activity->toArray(), 'Activity updated succesfully.');
        }return $this->sendError('User unauthorized');
    }

    public function destroy($id){
        $activity = Activity::find($id);
        if(is_null($activity)) return $this->sendError('Activity not found');
        $id_user = auth()->user()->id;
        if($activity->creator == $id_user){
            $activity->delete();
            return $this->sendResponse($activity->toArray(), 'Activity deleted succesfully.');
        }return $this->sendError('User unauthorized');
    }
}
