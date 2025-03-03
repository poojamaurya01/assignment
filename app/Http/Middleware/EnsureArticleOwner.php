<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Article;
use Illuminate\Http\Request;

class EnsureArticleOwner
{
    public function handle(Request $request, Closure $next)
    {
        $articleId = $request->route('article');
        $article = Article::find($articleId);

        if (!$article || $article->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized ativity.'], 403);
        }

        return $next($request);
    }
}
