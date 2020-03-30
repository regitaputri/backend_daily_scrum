<?php

namespace App\Http\Controllers;
use App\Scrum;
use Auth;
use Illuminate\Http\Request;

class ScrumController extends Controller
{
    public function index()
    {
        $data = Scrum::all();
        return response($data);
    }
    public function show($id)
    {
        $data = Scrum::where('id', $id)->get();
        return response ($data);
    }

    public function store(Request $request)
    {
        try{
            $data = new Scrum();
            $data->title = $request->input('title');
            $data->description = $request->input('description');
            $data->save();
            return response()->json([
                'status' => '1',
                'message' => 'Tambah data scrum berhasil'
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => '0',
                'message' => 'Tambah data scrum gagal'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $data = Scrum::where('id', $id)->first();
            $data->title = $request->input('title');
            $data->description = $request->input('description');
            $data->save();

            return response()->json([
                'status' => '1',
                'message' => 'Ubah data scrum berhasil'
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => '0',
                'message' => 'Ubah data scrum gagal'
            ]);
        }
    }

    public function destroy($id)
    {
        try{
            $data = Scrum::where('id', $id)->first();
            $data->delete();

            return response()->json([
                'status' => '1',
                'message' => 'Hapus data scrum berhasil'
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => '0',
                'message' => 'Hapus data scrum gagal'
            ]);
        }
    }
}