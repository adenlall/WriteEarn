<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubscriptionPlanRequest;
use App\Http\Requests\UpdateSubscriptionPlanRequest;
use App\Http\Resources\SubscriptionPlanResource;
use App\Models\Blog;
use App\Models\SubscriptionPlan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Blog $blog): AnonymousResourceCollection
    {
        return SubscriptionPlanResource::collection($blog->subscriptionPlans);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubscriptionPlanRequest $request, Blog $blog)
    {
        if (! Gate::inspect('create', [SubscriptionPlan::class, $blog])->allowed()) {
            abort(403);
        }
        $subscriptionPlan = $blog->subscriptionPlans()->create($request->validated());

        return SubscriptionPlanResource::make($subscriptionPlan);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog, SubscriptionPlan $subscriptionPlan)
    {
        if (! Gate::inspect('view', [$subscriptionPlan, $blog])->allowed()) {
            abort(403);
        }

        return SubscriptionPlanResource::make($subscriptionPlan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubscriptionPlanRequest $request, Blog $blog, SubscriptionPlan $subscriptionPlan)
    {
        if (! Gate::inspect('update', [$subscriptionPlan, $blog])->allowed()) {
            abort(403);
        }
        $subscriptionPlan->update($request->validated());

        return SubscriptionPlanResource::make($subscriptionPlan);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog, SubscriptionPlan $subscriptionPlan): JsonResponse
    {
        if (! Gate::inspect('delete', [$subscriptionPlan, $blog])->allowed()) {
            abort(403);
        }
        $subscriptionPlan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Subscription plan deleted successfully.',
            'data' => $subscriptionPlan,
        ], Response::HTTP_ACCEPTED);
    }
}
