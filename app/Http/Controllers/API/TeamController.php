<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Team;
use Validator;

class TeamController extends BaseController{
    public function index(){
        $team = Team::all();
        return $this->sendResponse($team->toArray(), 'Team retrieved succesfully.');
    }

    public function store(Request $request){
        /*$input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required',
        ]);
        if($validator->fails()) return $this->sendError('Validation error.', $validator->errors());
        $team = Team::create($input);*/
        $user_id = auth()->user()->id;
        $team = new Team;
        $team->name = $request->name;
        $team->description = $request->description;
        $team->creator = $user_id;
        $team->save();
        $team->users()->attach($user_id);
        return $this->sendResponse($team->toArray(), 'Team created successfully.');
    }

    public function show($id){
        $team = Team::find($id);
        if(is_null($team)) return $this->sendError('Team not found');
        return $this->sendResponse($team->toArray(), 'Team retrieved successfully.');
    }

    public function update(Request $request, $id){
        $team = Team::find($id);
        if(is_null($team)) return $this->sendError('Team not found');
        $id_user = auth()->user()->id;
        if($team->creator == $id_user){
            $input = $request->all();
            $validator = Validator::make($input, [
                'name' => 'required',
                'description' => 'required',
            ]);
            if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());
            $team->name = $input['name'];
            $team->description = $input['description'];
            $team->save();
            return $this->sendResponse($team->toArray(), 'Team updated succesfully.');
        }return $this->sendError('User unauthorized');
    }

    public function destroy($id){
        $team = Team::find($id);
        if(is_null($team)) return $this->sendError('Team not found');
        $id_user = auth()->user()->id;
        if($team->creator == $id_user){
            $team->delete();
            return $this->sendResponse($team->toArray(), 'Team deleted succesfully.');
        }return $this->sendError('User unauthorized');
    }
}
