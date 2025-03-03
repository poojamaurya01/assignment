<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{

    public function index()
    {
        try
        {
            $articles = Article::where('user_id',auth()->user()->id)->paginate(10);
            return response()->json([
                'success' => true,
                'message' => 'Articles retrieved successfully',
                'data' => $articles
            ], 200);
        } catch (\Exception $e) {
            logger()->error("Error: " . $e->getMessage() . " on line " . $e->getLine() . " in file " . $e->getFile());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while fetching articles.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        try {
            $article = Article::create([
                'title' => $request->title,
                'content' => $request->content,
                'user_id' => auth()->user()->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Article created successfully',
                'data' => $article
            ], 201);
        } catch (\Exception $e) {
            logger()->error("Error: " . $e->getMessage() . " on line " . $e->getLine() . " in file " . $e->getFile());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while creating the article.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $article = Article::where('id', $id)->where('user_id',auth()->user()->id)->first();
            if (!$article) {
                return response()->json(['success' => false, 'message' => 'Article not found'], 404);
            }
            return response()->json(['success' => true, 'data' => $article], 200);
        } catch (\Exception $e) {
            logger()->error("Error: " . $e->getMessage() . " on line " . $e->getLine() . " in file " . $e->getFile());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while fetching the article.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        try {
            $article = Article::where('id', $id)->where('user_id',auth()->user()->id)->first();
            if (!$article) {
                return response()->json(['success' => false, 'message' => 'Article not found'], 404);
            }

            $article->update($request->only(['title', 'content']));

            return response()->json([
                'success' => true,
                'message' => 'Article updated successfully',
                'data' => $article
            ], 200);
        } catch (\Exception $e) {
            logger()->error("Error: " . $e->getMessage() . " on line " . $e->getLine() . " in file " . $e->getFile());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while updating the article.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $article = Article::where('id', $id)->where('user_id',auth()->user()->id)->first();
            if (!$article) {
                return response()->json(['success' => false, 'message' => 'Article not found'], 404);
            }

            $article->delete();
            return response()->json(['success' => true, 'message' => 'Article deleted successfully'], 200);
        } catch (\Exception $e) {
            logger()->error("Error: " . $e->getMessage() . " on line " . $e->getLine() . " in file " . $e->getFile());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while deleting the article.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
