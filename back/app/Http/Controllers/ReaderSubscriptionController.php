<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReaderSubscriptionRequest;
use App\Http\Requests\UpdateReaderSubscriptionRequest;
use App\Http\Resources\ReaderSubscriptionResource;
use App\Models\ReaderSubscription;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class ReaderSubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
        return ReaderSubscriptionResource::collection($user->subscriptions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReaderSubscriptionRequest $request, User $user)
    {
        // TODO: add cannot subscribe to the same blog multiple times
        if (! Gate::inspect('create', ReaderSubscription::class)->allowed()) {
            abort(403);
        }
        $readerSubscription = $user->readerSubscriptions()->create($request->validated());

        return ReaderSubscriptionResource::make($readerSubscription);
    }

    /**
     * Display the specified resource.
     */
    public function show(ReaderSubscription $readerSubscription)
    {
        if (! Gate::inspect('view', $readerSubscription)->allowed()) {
            abort(403);
        }

        return ReaderSubscriptionResource::make($readerSubscription);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReaderSubscriptionRequest $request, ReaderSubscription $readerSubscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReaderSubscription $readerSubscription)
    {
        //
    }
}
