<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Scrum;
use App\User;
use DB;
use Illuminate\Support\Facades\Validator;

class ScrumController extends Controller
{

    public function index()
    {
    	try{
	        $data["count"] = Scrum::count();
	        $scrum = array();
	        $dataScrum = DB::table('scrum') ->join('users','users.id','=','scrum.id_user')
                                            ->select('users.id', 'users.firstname','users.lastname','scrum.team','scrum.activity_today','scrum.activity_yesterday', 'problem_yesterday', 'scrum.solution')
	                                        ->get();

	        foreach ($dataScrum as $p) {
	            $item = [
	                "id"          		    => $p->id,
                    "firstname"  		    => $p->firstname,
                    "team"                  => $p->team,
	                "lastname"  			=> $p->lastname,
	                "activity_today"    	=> $p->activity_today,
	                "actiity_yesterday"     => $p->activity_yesterday,
	                "problem_yesterday"  	=> $p->problem_yesterday,
	                "solution"  			=> $p->solution
	            ];

	            array_push($scrum, $item);
	        }
	        $data["scrum"] = $scrum;
	        $data["status"] = 1;
	        return response($data);

	    } catch(\Exception $e){
			return response()->json([
			  'status' => '0',
			  'message' => $e->getMessage()
			]);
      	}
    }

    public function getAll($limit = 10, $offset = 0)
    {
    	try{
	        $data["count"] = Scrum::count();
	        $scrum = array();
	        $dataScrum = DB::table('scrum') ->join('user','user.id','=','scrum.id_user')
                                            ->select('user.id', 'user.firstname','user.lastname','scrum.team','scrum.activity_today','scrum.activity_yesterday', 'scrum.solution')
                                            ->get();

	        foreach ($dataScrum as $p) {
	            $item = [
	                "id"          		    => $p->id,
	                "firstname"  		    => $p->firstname,
	                "lastname"  			=> $p->lastname,
	                "activity_today"    	=> $p->activity_today,
	                "actiity_yesterday"     => $p->activity_yesterday,
	                "problem_yesterday"  	=> $p->problem_yesterday,
	                "solution"  			=> $p->solution
	            ];

	            array_push($scrum, $item);
	        }
	        $data["scrum"] = $scrum;
	        $data["status"] = 1;
	        return response($data);

	    } catch(\Exception $e){
			return response()->json([
			  'status' => '0',
			  'message' => $e->getMessage()
			]);
      	}
    }

    public function store(Request $request)
    {
      try{
    		$validator = Validator::make($request->all(), [
    			'id_user'    		    => 'required|numeric',
				'team'	                => 'required|string',
				'activity_today'		=> 'required|string',
  				'activity_yesterday'	=> 'required|string',
                'problem_yesterday'		=> 'required|string',
                'solution'              => 'required|string'
    		]);

    		if($validator->fails()){
    			return response()->json([
    				'status'	=> 0,
    				'message'	=> $validator->errors()
    			]);
    		}

    		//cek apakah ada id user tersebut
    		if(User::where('id', $request->input('id_user'))->count() > 0){
    				$data = new Scrum();
              		$data->id_user              = $request->input('id_user');
			        $data->activity_today       = $request->input('activity_today');
			        $data->activity_yesterday   = $request->input('activity_yesterday');
			        $data->problem_yesterday    = $request->input('problem_yesterday');
			        $data->solution             = $request->input('solution');
			        $data->save();

		    		return response()->json([
		    			'status'	=> '1',
		    			'message'	=> 'Data daily scrum berhasil ditambahkan!'
		    		], 201);
    			} else {
    				return response()->json([
		                'status' => '0',
		                'message' => 'Data daily scrum gagal ditambahkan.'
		            ]);
    			}
    		

      } catch(\Exception $e){
            return response()->json([
                'status' => '0',
                'message' => $e->getMessage()
            ]);
        }
  	}


    public function update(Request $request, $id)
    {
      try {
      	$validator = Validator::make($request->all(), [
			'id_user'    		    => 'required|numeric',
			'team'	                => 'required|string',
			'activity_today'		=> 'required|string',
  			'activity_yesterday'	=> 'required|string',
            'problem_yesterday'		=> 'required|string',
            'solution'              => 'required|string'
		]);

      	if($validator->fails()){
      		return response()->json([
      			'status'	=> '0',
      			'message'	=> $validator->errors()
      		]);
      	}

      	//proses update data
      	$data = Scrum::where('id', $id)->first();
        $data->id_user              = $request->input('id_user');
        $data->activity_today       = $request->input('activity_today');
        $data->activity_yesterday   = $request->input('activity_yesterday');
        $data->problem_yesterday    = $request->input('problem_yesterday');
        $data->solution             = $request->input('solution');
        $data->save();

      	return response()->json([
      		'status'	=> '1',
      		'message'	=> 'Data daily scrum berhasil diubah'
      	]);
        
      } catch(\Exception $e){
          return response()->json([
              'status' => '0',
              'message' => $e->getMessage()
          ]);
      }
    }

    public function delete($id)
    {
        try{

            $delete = Scrum::where("id", $id)->delete();
            if($delete){
              return response([
                "status"  => 1,
                  "message"   => "Data daily scrum berhasil dihapus."
              ]);
            } else {
              return response([
                "status"  => 0,
                  "message"   => "Data daily scrum gagal dihapus."
              ]);
            }
            
        } catch(\Exception $e){
            return response([
            	"status"	=> 0,
                "message"   => $e->getMessage()
            ]);
        }
    }

}
