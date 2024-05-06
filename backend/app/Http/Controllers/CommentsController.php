<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function test()
    {
        $comments = Comments::all();

        $commentsJson = $comments->map(function ($comment) {
            return [
                'ID' => $comment->comment_id,
                'Name' => $comment->name,
                'Description' => $comment->description,
                'Image' => $comment->image,
                'CreatedAt' => $comment->created_at,
                'UpdatedAt' => $comment->updated_at
            ];
        });

        return response()->json($commentsJson);
    }
}
