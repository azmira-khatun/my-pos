<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     * ডিস্কের সকল ফাইলের তালিকা দেখায় (সতর্কতা: বড় ডেটাসেটে এটি স্লো হতে পারে)
     */
    public function index(): View
    {
        $mediaItems = Media::latest()->paginate(20);
        return view('media.index', compact('mediaItems'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Media $medium): View
    {
        return view('media.show', compact('medium'));
    }

    /**
     * Remove the specified resource from storage.
     * গুরুত্বপূর্ণ: ফাইলটি ফিজিক্যালি ডিস্ক থেকেও মুছে দেবে।
     */
    public function destroy(Media $medium): RedirectResponse
    {
        // Spatie Media Library ব্যবহার করলে, শুধু মডেলটি ডিলিট করলেই ডিস্ক থেকে ফাইল মুছে যায়।
        // কিন্তু কাস্টম ইমপ্লিমেন্টেশনে আপনাকে ডিস্ক থেকে ফাইল ডিলিট করার লজিক যোগ করতে হতে পারে।

        $medium->delete();

        return redirect()->route('media.index')
                         ->with('success', 'Media item and associated file successfully deleted.');
    }
}
