<?php

namespace App\Http\Controllers;

use App\Review;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ReviewRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\ReviewResource;
use Auth;
use App\Exceptions\ReviewNotBelongsToUser;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('index', 'show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        return ReviewResource::collection($product->reviews);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReviewRequest $request, Product $product)
    {
        //dd(Auth::user()->id);
        $review = new Review;
        //$review->product_id = $product->id;
        $review->user_id = Auth::user()->id;
        $review->review = $request->review;
        $review->star = $request->star;


        //dd(response()->json($review));

        $product->reviews()->save($review);
        
        //return response()->json($review);
        
        return response([
            'data' => new ReviewResource($review)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product, Review $review)
    {
        $this->validate($request, [
            'body' => 'required',
            'star' => 'required'
        ]);

        $review->review = $request->body;
        $review->star = $request->star;
        $review->save();
        /*$review->update($request->all());
        $review->save();*/
        return response([
            'data' => new ReviewResource($review)
        ]);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Review $review)
    {
        //return $review;
        $this->ReviewUserCheck($review);

        $review->delete();

        return response(null, Response::HTTP_NO_CONTENT);
        
    }

    public function ReviewUserCheck($review)
    {
        if(Auth::user()->id !== $review->user_id)
        {
            throw new ReviewNotBelongsToUser;
        }
    }
}
