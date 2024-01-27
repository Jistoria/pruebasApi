<?php

namespace App\Http\Controllers;

use App\Events\CommentCreated;
use App\Models\Comment;
use App\Models\User;
use App\Notifications\NewCommentNotification;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //

    public function commentCreate(Request $request)
    {
        try {
            $request->validate([
                'content' => 'required',
                'id_issuing' => 'required|exists:users,id',
                'id_receptor' => 'required|exists:users,id',
            ]);

            $comment = Comment::create($request->all());


            // Verifica si el receptor existe
            if ($comment) {
                event(new CommentCreated($comment));
                return response()->json(['success' => true, 'message' => 'Se ha creado el comentario']);
            } else {
                return response()->json(['success' => false, 'message' => 'Usuario receptor no encontrado']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al crear el comentario', 'error' => $e->getMessage()]);
        }
    }
public function commentGet(){
    $comments = Comment::all();
    return response()->json(['comments'=>$comments]);
}
}
