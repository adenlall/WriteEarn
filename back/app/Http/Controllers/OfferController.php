<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use App\Http\Resources\OfferResource;
use App\Models\Blog;
use App\Models\Offer;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Blog $blog, SubscriptionPlan $subscriptionPlan)
    {
        return OfferResource::collection($subscriptionPlan->offers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOfferRequest $request, Blog $blog, SubscriptionPlan $subscriptionPlan)
    {
        if (! Gate::inspect('create', [Offer::class, $blog, $subscriptionPlan])->allowed()) {
            abort(403);
        }
        $offer = $subscriptionPlan->offers()->create($request->validated());

        return OfferResource::make($offer);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog, SubscriptionPlan $subscriptionPlan, Offer $offer)
    {
        if (! Gate::inspect('view', [$offer, $subscriptionPlan])->allowed()) {
            abort(403);
        }

        return OfferResource::make($offer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOfferRequest $request, Blog $blog, SubscriptionPlan $subscriptionPlan, Offer $offer)
    {
        if (! Gate::inspect('update', [$offer, $blog, $subscriptionPlan])->allowed()) {
            abort(403);
        }
        $offer->update($request->validated());

        return OfferResource::make($offer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog, SubscriptionPlan $subscriptionPlan, Offer $offer)
    {
        if (! Gate::inspect('delete', [$offer, $blog, $subscriptionPlan])->allowed()) {
            abort(403);
        }
        $offer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully.',
            'data' => $offer,
        ], Response::HTTP_ACCEPTED);

    }
}
