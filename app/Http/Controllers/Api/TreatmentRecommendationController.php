<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TreatmentRecommendation;
use Illuminate\Http\Request;

class TreatmentRecommendationController extends Controller
{
    // Get all active recommendations
    public function index(Request $request)
    {
        $query = TreatmentRecommendation::where('is_active', true);

        if ($request->filled('flower_species')) {
            $query->where('flower_species', $request->flower_species);
        }

        if ($request->filled('disease_name')) {
            $query->where('disease_name', $request->disease_name);
        }

        return response()->json([
            'success' => true,
            'message' => 'Treatment recommendations retrieved successfully.',
            'data' => $query->orderBy('flower_species')
                ->orderBy('disease_name')
                ->get(),
        ]);
    }

    // Get one recommendation
    public function show($id)
    {
        $recommendation = TreatmentRecommendation::where(
            'is_active',
            true
        )->find($id);

        if (!$recommendation) {
            return response()->json([
                'success' => false,
                'message' => 'Treatment recommendation not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $recommendation,
        ]);
    }

    // Create a recommendation
    public function store(Request $request)
    {
        $validated = $request->validate([
            'flower_species' => 'required|string|max:255',
            'disease_name' => 'required|string|max:255',
            'symptoms' => 'nullable|string',
            'cause' => 'nullable|string',
            'prevention' => 'nullable|string',
            'treatment' => 'nullable|string',
            'farmer_advice' => 'nullable|string',
            'treatment_type' => 'nullable|string|max:255',
            'safety_precautions' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        $recommendation = TreatmentRecommendation::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Treatment recommendation created successfully.',
            'data' => $recommendation,
        ], 201);
    }

    // Update a recommendation
    public function update(Request $request, $id)
    {
        $recommendation = TreatmentRecommendation::find($id);

        if (!$recommendation) {
            return response()->json([
                'success' => false,
                'message' => 'Treatment recommendation not found.',
            ], 404);
        }

        $validated = $request->validate([
            'flower_species' => 'sometimes|required|string|max:255',
            'disease_name' => 'sometimes|required|string|max:255',
            'symptoms' => 'sometimes|nullable|string',
            'cause' => 'sometimes|nullable|string',
            'prevention' => 'sometimes|nullable|string',
            'treatment' => 'sometimes|nullable|string',
            'farmer_advice' => 'sometimes|nullable|string',
            'treatment_type' => 'sometimes|nullable|string|max:255',
            'safety_precautions' => 'sometimes|nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        $recommendation->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Treatment recommendation updated successfully.',
            'data' => $recommendation->fresh(),
        ]);
    }

    // Delete a recommendation
    public function destroy($id)
    {
        $recommendation = TreatmentRecommendation::find($id);

        if (!$recommendation) {
            return response()->json([
                'success' => false,
                'message' => 'Treatment recommendation not found.',
            ], 404);
        }

        $recommendation->delete();

        return response()->json([
            'success' => true,
            'message' => 'Treatment recommendation deleted successfully.',
        ]);
    }
}
