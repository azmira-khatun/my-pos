<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /**
     * Display a listing of the uploaded files.
     */
    public function index(): View
    {
        $uploads = Upload::latest()->paginate(15);
        return view('uploads.index', compact('uploads'));
    }

    /**
     * Show the form for file upload.
     */
    public function create(): View
    {
        return view('uploads.create');
    }

    /**
     * Store a newly uploaded file and its metadata in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB limit
            'folder_name' => 'nullable|string|max:100', // আপলোডের ফোল্ডারের নাম
        ]);

        $uploadedFile = $request->file('file');
        $folder = $request->folder_name ?? 'general'; // যদি ফোল্ডার না দেওয়া হয়, তবে 'general' ফোল্ডার

        try {
            // 1. ফাইলটি ডিস্কে সেভ করা
            $filename = $uploadedFile->hashName(); // একটি ইউনিক নাম তৈরি
            $path = $uploadedFile->storeAs($folder, $filename, 'public'); // 'public' ডিস্কে স্টোর করা

            // 2. ডেটাবেসে মেটাডেটা সেভ করা
            Upload::create([
                'folder' => $folder,
                'filename' => $filename,
            ]);

            return redirect()->route('uploads.index')
                             ->with('success', 'File uploaded successfully! Path: ' . $path);

        } catch (\Exception $e) {
            return back()->with('error', 'File upload failed: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource (file and metadata) from storage.
     */
    public function destroy(Upload $upload): RedirectResponse
    {
        $filePath = $upload->file_path; // Model-এ সংজ্ঞায়িত getFilePathAttribute থেকে পাথটি নেওয়া

        try {
            // 1. ডিস্ক থেকে ফাইলটি ডিলিট করা
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            // 2. ডেটাবেস এন্ট্রি ডিলিট করা
            $upload->delete();

            return redirect()->route('uploads.index')
                             ->with('success', 'File and record successfully deleted.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting file: ' . $e->getMessage());
        }
    }

    // ... show এবং edit মেথডগুলি এখানে প্রয়োজন নেই, তাই省略 করা হলো।
}
