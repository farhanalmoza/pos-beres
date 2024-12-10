<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function index() {
        return view('admin.member.index');
    }

    public function getAll() {
        $results = Member::get();

        return datatables()
        ->of($results)
        ->addColumn('whatsapp', function($rows) {
            return '+62'.$rows->phone;
        })
        ->addColumn('actions', function($rows) {
            // $btn = '<button type="button" class="btn btn-success btn-sm detail" data-id="'.$rows->id.'">detail</button>'; 
            // $btn .= ' <button type="button" class="btn btn-primary btn-sm update" data-bs-toggle="modal" data-bs-target="#editModal" data-id="'.$rows->id.'">ubah</button>';
            $btn = ' <button type="button" class="btn btn-success btn-sm show-ktp" data-bs-toggle="modal" data-bs-target="#showKtpModal" data-id="'.$rows->id.'"
                data-path="'.asset($rows->ktp).'">
                    <i class="bx bx-show"></i>
                </button>';
            $btn .= ' <button type="button" class="btn btn-danger btn-sm delete" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="'.$rows->id.'"><i class="bx bx-trash"></i></button>';
            return $btn;
        })
        ->rawColumns(['actions', 'whatsapp'])
        ->make(true);
    }

    public function store(Request $request) {
        // check phone number
        if (Member::where('phone', $request->phone)->first()) {
            return response(['message' => 'Nomor Telegram sudah ada'], 400);
        }

        // check NIK
        if (Member::where('nik', $request->nik)->first()) {
            return response(['message' => 'NIK sudah ada'], 400);
        }

        $files = $request->file('files');
        $publicPath = public_path('img/ktp-member/');
        // Create directory if it doesn't exist
        if (!file_exists($publicPath)) {
            mkdir($publicPath, 0777, true);
        }
        $pathOfFile = [];
        foreach ($files as $file) {
            $optimizerChain = OptimizerChainFactory::create();
            $filename = $request->nik . '.' . $file->getClientOriginalExtension();
            $img = Image::make($file->getRealPath());
            $img->save($publicPath . $filename);
            $optimizerChain->optimize($publicPath . $filename);
            array_push($pathOfFile, 'img/ktp-member/' . $filename);
        }

        $create = Member::create([
            'phone' => $request->phone,
            'password' => bcrypt('password'),
            'nik' => $request->nik,
            'name' => $request->name,
            'born_place' => $request->born_place,
            'born_date' => $request->born_date,
            'gender' => $request->gender,
            'address' => $request->address,
            'blood_type' => $request->blood_type,
            'religion' => $request->religion,
            'is_married' => $request->is_married ?? false,
            'profession' => $request->profession,
            'ktp' => $pathOfFile[0] ?? null,
        ]);

        if ($create) {
            return response(['message' => 'Member berhasil dibuat'], 200);
        }
        return response(['message' => 'Gagal membuat member'], 400);
    }

    public function destroy($id) {
        $result = Member::findOrFail($id);
        if(!$result) return response(['message' => 'terjadi kesalahan'], 500);

        // delete file
        $path = public_path($result->ktp);
        if (file_exists($path)) {
            unlink($path);
        }

        $result->delete();
        return response(['message' => 'Member berhasil dihapus'], 200);
    }
}
