<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CommentsController extends Controller
{
    public function index()
    {
        $comments = Comments::all();

        $commentsJson = $comments->map(function ($comment) {
            return [
                'ID' => $comment->comment_id,
                'Name' => $comment->name,
                'Description' => $comment->description,
                'Image' => $comment->image ? url('storage/' . $comment->image) : null,
                'CreatedAt' => $comment->created_at,
                'UpdatedAt' => $comment->updated_at
            ];
        });

        return response()->json($commentsJson);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('images', 'public');
        }

        $comment = Comments::create($validatedData);

        return response()->json($comment, 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        $comment = Comments::find($id);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        if ($request->hasFile('image')) {
            // Remove old image if exists
            if ($comment->image) {
                Storage::disk('public')->delete($comment->image);
            }
            $validatedData['image'] = $request->file('image')->store('images', 'public');
        }

        $comment->update($validatedData);

        return response()->json($comment);
    }

    public function delete($id)
    {
        try {
            $comment = Comments::find($id);

            if (!$comment) {
                return response()->json(['message' => 'Comment not found'], 404);
            }

            if ($comment->image) {
                Storage::disk('public')->delete($comment->image);
            }

            $comment->delete();

            return response()->json(['message' => 'Comment deleted successfully']);
        } catch (\Exception $e) {
            Log::error('Error deleting comment: '.$e->getMessage());
            return response()->json(['message' => 'Error deleting comment'], 500);
        }
    }

    public function show($id)
    {
        $comment = Comments::find($id);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        return response()->json($comment);
    }
}
