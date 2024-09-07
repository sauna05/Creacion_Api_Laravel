<?php
// app/Http/Controllers/ComentController.php
namespace App\Http\Controllers;

use App\Models\Coment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComentController extends Controller
{
    public function index(Request $request, $post_id)
    {
        $comments = Coment::where('post_id', $post_id)
            ->where('user_id', Auth::user()->id)
            ->get();
        return response()->json($comments);
    }
    public function store(Request $request, $post_id)
    {
        $request->validate([
            'content' => 'required|string',
        ]);
        $comment = Coment::create([
            'content' => $request->input('content'),
            'user_id' => Auth::user()->id,
            'post_id' => $post_id,
        ]);
        return response()->json($comment, 201);
    }

    public function show($id)
    {
        return Coment::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $comment = Coment::findOrFail($id);

        // Validar si el usuario actual es el dueño del comentario
        if ($comment->user_id !== Auth::user()->id) {
            return response()->json(['error' => 'No tienes permiso para actualizar este comentario'], 403);
        }
        $comment->update($request->all());
        return response()->json($comment, 200);
    }
    public function destroy($id)
    {
        $comment = Coment::findOrFail($id);
        // Validar si el usuario actual es el dueño del comentario
        if ($comment->user_id !== Auth::user()->id) {
            return response()->json(['error' => 'No tienes permiso para eliminar este comentario'], 403);
        }
        $comment->delete();
        return response()->json(null, 204);
    }
}
