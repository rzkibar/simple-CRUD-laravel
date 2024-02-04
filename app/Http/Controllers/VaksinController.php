<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vaksin;
use DataTables;
use DB;
use Storage;

class VaksinController extends Controller
{
    public function index()
    {
        return view('views.vaksin');
    }

    public function getdata()
    {
        $data = Vaksin::where('status_hapus', 1)
                      ->orderBy('id', 'desc')
                      ->get();

        return DataTables::of($data)->make(true);
    }

    public function store(Request $request)
    {
      //DB::unprepared('SET IDENTITY_INSERT vaksins ON');
        $this->validate($request, [
          'vaksin'                => 'required',
        ],[
          'vaksin.required'       => 'Vaksin masih kosong!',
        ]);

        $result = Vaksin::updateOrCreate(
         [
           'id'              => $request->id
         ],
         [
           'vaksin'          => $request->vaksin,
           'status_hapus'    => 1
         ]
        );

        return response()->json($result);
        dd($result);
    }

    public function getitem($id)
    {
        $data = Vaksin::where('id', $id)->first();
        return response()->json($data);
    }

    public function destroy(Request $request)
    {
        $result = Vaksin::where('id', $request->id)->update(['status_hapus' => 0]);
        return response()->json($result);
    }

    public function storefile(Request $request)
    {
        $this->validate($request, [
          'file'        => 'required',
        ]);

        $file     = $request->file('file');
        // dd($file);
        // if($file){
        //     $nama_file = $file->getClientOriginalName();
        // }else{
        //     $nama_file = $request->nama_file;
        // }

        // $data = OksigenFile::create([
        //    'id_data'       => $request->id_data,
        //    'nama_file'     => $nama_file,
        //    'jenis'         => 1,
        //    'status_hapus'  => 0
        // ]);

        // if($file){

            // $filename = explode(".", $file->getClientOriginalName());
            // $ext      = end($filename);
            //Storage::put("/".$filename.".".$ext, file_get_contents($file->getRealPath()));
            try {
              Storage::disk("webdav")->put("/test.png", file_get_contents($file->getRealPath()));
            } catch (\Throwable $th) {
              throw $th;
            }
            //Storage::disk("webdav")->put("/test.png", file_get_contents($file->getRealPath()));
            //dd($file);
        //     if($result){
        //         OksigenFile::where('id', $data->id)->update(['status_hapus' => 1]);
        //     }
        // }else{
        //     OksigenFile::where('id', $data->id)->update(['status_hapus' => 1]);
        // }
    }
}
