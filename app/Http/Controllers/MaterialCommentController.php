<?php

namespace App\Http\Controllers;

use App\Models\MaterialComment;
use Illuminate\Http\Request;

class MaterialCommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required|string',
            'material_id' => 'required|integer'
        ]);

        MaterialComment::create([
            'comment' => $request->comment,
            'material_id' => $request->material_id,
            'user_id' => auth()->user()->id
        ]);

        activity()
            ->event('Buat Komentar')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Membuat Komentar Materi');

        return redirect()->back()->with('success', 'Berhasil kirim komentar');
    }
}
