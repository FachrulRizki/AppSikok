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

        return redirect()->back()->with('success', 'Berhasil kirim komentar');
    }
}
