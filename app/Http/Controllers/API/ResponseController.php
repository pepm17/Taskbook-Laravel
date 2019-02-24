<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Response;
use Validator;

class ResponseController extends BaseController{
    public function index(){
        $response = Response::all();
        return $this->sendResponse($Response->toArray(), 'Response retrieved succesfully.');
    }

    public function store(Request $request){
        $user_id = auth()->user()->id;
        $response = new Response;
        $response->content = $request->content;
        $response->creator = $user_id;
        $response->_dad = $request->_dad;
        $response->save();
        return $this->sendResponse($response->toArray(), 'Response created successfully.');
    }

    public function show($id){
        $response = Response::find($id);
        if(is_null($response)) return $this->sendError('Response not found');
        return $this->sendResponse($response->toArray(), 'Response retrieved successfully.');
    }

    public function update(Request $request, $id){
        $response = Response::find($id);
        if(is_null($response)) return $this->sendError('Response not found');
        $id_user = auth()->user()->id;
        if($response->creator == $id_user){
            $input = $request->all();
            $validator = Validator::make($input, [
                'content' => 'required',
            ]);
            if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());
            $response->content = $input['name'];
            $response->save();
            return $this->sendResponse($response->toArray(), 'Response updated succesfully.');
        }return $this->sendError('User unauthorized');
    }

    public function destroy($id){
        $response = Response::find($id);
        if(is_null($response)) return $this->sendError('Response not found');
        $id_user = auth()->user()->id;
        if($response->creator == $id_user){
            $response->delete();
            return $this->sendResponse($response->toArray(), 'Response deleted succesfully.');
        }return $this->sendError('User unauthorized');
    }
}
