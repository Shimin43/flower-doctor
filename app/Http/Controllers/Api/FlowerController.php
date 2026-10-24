<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Flower;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FlowerController extends Controller
{
    public function index()
    {
        $flowers = Flower::where('is_active', true)
            ->orderBy('name')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'message' => 'Flower information retrieved successfully.',
            'data' => $flowers,
        ]);
    }

    public function show($id)
    {
        $flower = Flower::where('is_active', true)
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Flower details retrieved successfully.',
            'data' => $flower,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:flowers,name',
            'scientific_name' => 'nullable|string|max:255',
            'local_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'characteristics' => 'nullable|string',
            'colors' => 'nullable|string',
            'growing_conditions' => 'nullable|string',
            'care_guide' => 'nullable|string',
            'uses' => 'nullable|string',
            'image_path' => 'nullable|string|max:2048',
            'is_active' => 'sometimes|boolean',

            // Market value information
            'market_value' => 'nullable|numeric|min:0',
            'market_value_unit' => 'nullable|string|max:100',
            'market_value_location' => 'nullable|string|max:255',
            'market_value_updated_at' => 'nullable|date_format:Y-m-d',
        ]);

        $flower = Flower::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Flower information created successfully.',
            'data' => $flower,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $flower = Flower::findOrFail($id);

        $validated = $request->validate([
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('flowers', 'name')->ignore($flower->id),
            ],
            'scientific_name' => 'sometimes|nullable|string|max:255',
            'local_name' => 'sometimes|nullable|string|max:255',
            'description' => 'sometimes|nullable|string',
            'characteristics' => 'sometimes|nullable|string',
            'colors' => 'sometimes|nullable|string',
            'growing_conditions' => 'sometimes|nullable|string',
            'care_guide' => 'sometimes|nullable|string',
            'uses' => 'sometimes|nullable|string',
            'image_path' => 'sometimes|nullable|string|max:2048',
            'is_active' => 'sometimes|boolean',

            // Market value information
            'market_value' => 'sometimes|nullable|numeric|min:0',
            'market_value_unit' => 'sometimes|nullable|string|max:100',
            'market_value_location' => 'sometimes|nullable|string|max:255',
            'market_value_updated_at' => 'sometimes|nullable|date_format:Y-m-d',
        ]);

        $flower->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Flower information updated successfully.',
            'data' => $flower->fresh(),
        ]);
    }

    public function destroy($id)
    {
        $flower = Flower::findOrFail($id);

        $flower->delete();

        return response()->json([
            'success' => true,
            'message' => 'Flower information deleted successfully.',
        ]);
    }
}
