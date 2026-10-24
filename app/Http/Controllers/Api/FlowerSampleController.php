<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FlowerImage;
use App\Models\FlowerSample;
use Illuminate\Http\Request;

class FlowerSampleController extends Controller
{
    // Get all flower samples
    public function index()
    {
        $samples = FlowerSample::with('images')
            ->latest()
            ->paginate(20);

        return response()->json([
            'success' => true,
            'message' => 'Flower samples retrieved successfully.',
            'data' => $samples,
        ]);
    }

    // Get a single flower sample with its images
    public function show($id)
    {
        $sample = FlowerSample::with('images')->findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Flower sample retrieved successfully.',
            'data' => $sample,
        ]);
    }

    // Create a new flower sample
    public function store(Request $request)
    {
        $request->validate([
            'sample_id' => 'required|string|max:255|unique:flower_samples,sample_id',
            'flower_species' => 'required|string|max:255',
            'sample_date' => 'nullable|date',
        ]);

        $data = $request->only(
            (new FlowerSample())->getFillable()
        );

        $sample = FlowerSample::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Flower sample created successfully.',
            'data' => $sample,
        ], 201);
    }

    // Update an existing flower sample
    public function update(Request $request, $id)
    {
        $sample = FlowerSample::findOrFail($id);

        $request->validate([
            'flower_species' => 'sometimes|required|string|max:255',
            'sample_date' => 'sometimes|nullable|date',
            'color' => 'sometimes|nullable|string|max:255',
            'health_status' => 'sometimes|nullable|string|max:255',
        ]);

        $data = $request->only(
            (new FlowerSample())->getFillable()
        );

        $sample->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Flower sample updated successfully.',
            'data' => $sample,
        ]);
    }

    // Delete a flower sample
    public function destroy($id)
    {
        $sample = FlowerSample::findOrFail($id);

        $sample->delete();

        return response()->json([
            'success' => true,
            'message' => 'Flower sample deleted successfully.',
        ]);
    }

    // Upload an image and save its information
    public function uploadImage(Request $request)
    {
        $validated = $request->validate([
            'flower_sample_id' => 'required|integer|exists:flower_samples,id',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'image_angle' => 'nullable|string|max:255',
            'lighting_condition' => 'nullable|string|max:255',
            'plant_part' => 'nullable|string|max:255',
            'image_quality' => 'nullable|string|max:255',
        ]);

        $path = $request->file('image')
            ->store('flower-uploads', 'public');

        // Generate image URL using APP_URL configuration
        $url = asset('storage/' . $path);

        $flowerImage = FlowerImage::create([
            'flower_sample_id' => $validated['flower_sample_id'],
            'image_path' => $path,
            'image_url' => $url,
            'image_angle' => $validated['image_angle'] ?? null,
            'lighting_condition' => $validated['lighting_condition'] ?? null,
            'plant_part' => $validated['plant_part'] ?? null,
            'image_quality' => $validated['image_quality'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Flower image uploaded and saved successfully.',
            'data' => $flowerImage,
        ], 201);
    }
}
