<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCardRequest;
use App\Http\Resources\CardResource;
use App\Models\Card;

class CardController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cards.card');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCardRequest $request)
    {
        $data = $request->validated();

        // Handle image upload if present
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('cards', 'public'); // Store in /storage/app/public/cards
        }

        $card = Card::create($data);

        return new CardResource($card);
    }

    /**
     * Display the specified resource.
     */
    public function show(Card $card)
    {
        return new CardResource($card);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCardRequest $request, Card $card)
    {
        $data = $request->validated();

        // Handle image upload if present
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('cards', 'public'); // Store in /storage/app/public/cards
        }

        $card->update($data);

        return new CardResource($card);
    }

}
