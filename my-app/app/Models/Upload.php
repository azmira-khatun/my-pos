<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Upload extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'folder',
        'filename',
    ];

    /**
     * Get the full path of the uploaded file on the disk.
     */
    public function getFilePathAttribute(): string
    {
        // ডিফল্টভাবে 'public' ডিস্ক ব্যবহার করা হচ্ছে ধরে নেওয়া হচ্ছে
        return $this->folder ? $this->folder . '/' . $this->filename : $this->filename;
    }

    /**
     * Get the public URL of the uploaded file.
     */
    public function getFileUrlAttribute(): string
    {
        // এটি নিশ্চিত করবে যে URLটি সঠিকভাবে তৈরি হয়েছে
        return Storage::disk('public')->url($this->file_path);
    }
}
