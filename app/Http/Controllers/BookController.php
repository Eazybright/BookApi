<?php

namespace App\Http\Controllers;

use App\Book;
use App\User;
use App\Http\Resources\BookResource;
use Auth;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth')->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BookResource::collection(Book::paginate(25));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::check()){
            $book = new Book;
        
            $this->validate($request, array(
                'title' => 'required|max:255',
                'description' => 'required|min:30',
                'image' => 'image|max:1999|mimes:jpeg,jpg,bmp,png,gif'
            ));
            if($request->hasFile('image')){
                $image = $request->file('image');
                $name = $request->file('image')->getClientOriginalName();
                $image_name = $request->file('image')->getRealPath();
                $image->move(public_path("uploads"), $name);

                $book->image = $name;
            }

            $book->title = $request->title;
            $book->description = $request->description;
            $book->user_id = auth()->user()->id;
            
            $book->save();
        
            return new BookResource($book);
        }
        return response()->json('user not authenticated', 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return new BookResource($book);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        // check if currently authenticated user is the owner of the book
        if ($request->user()->id !== $book->user_id) {
            return response()->json(['error' => 'You can only edit your own books.'], 403);
        }

        $book->update($request->only(['title', 'description']));

        return new BookResource($book);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json(null, 204);
    }
}
