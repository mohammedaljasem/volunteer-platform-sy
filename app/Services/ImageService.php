<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageService
{
    /**
     * تخزين صورة محسنة مع تغيير حجمها وضغطها
     *
     * @param \Illuminate\Http\UploadedFile $file الملف المرفوع
     * @param string $path المسار للتخزين
     * @param int $width العرض المطلوب
     * @param int|null $height الارتفاع المطلوب (اختياري)
     * @param int $quality جودة الصورة (1-100)
     * @return string مسار الملف المخزن
     */
    public function storeOptimized($file, $path, $width = 800, $height = null, $quality = 80)
    {
        // التحقق من أن الصورة صالحة
        $image = Image::make($file);
        
        // تغيير حجم الصورة مع الحفاظ على النسبة
        $image->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        
        // ضغط الصورة بجودة محددة
        $extension = $file->getClientOriginalExtension();
        $extension = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']) 
            ? strtolower($extension) 
            : 'jpg';
        
        // تحديد اسم فريد للملف
        $filename = time() . '_' . uniqid() . '.' . $extension;
        $fullPath = $path . '/' . $filename;
        
        // تخزين الصورة بالحجم المناسب
        Storage::disk('public')->put(
            $fullPath, 
            $image->encode($extension, $quality)->stream()
        );
        
        return $fullPath;
    }
    
    /**
     * إنشاء نسخة مصغرة من الصورة
     *
     * @param \Illuminate\Http\UploadedFile $file الملف المرفوع
     * @param string $path المسار للتخزين
     * @param int $width العرض المطلوب للنسخة المصغرة
     * @return string مسار الملف المخزن
     */
    public function createThumbnail($file, $path, $width = 200)
    {
        $image = Image::make($file);
        
        // إنشاء نسخة مصغرة مربعة
        $image->fit($width, $width);
        
        // تحديد اسم للنسخة المصغرة
        $extension = $file->getClientOriginalExtension();
        $extension = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']) 
            ? strtolower($extension) 
            : 'jpg';
            
        $filename = time() . '_' . uniqid() . '_thumb.' . $extension;
        $fullPath = $path . '/' . $filename;
        
        // تخزين النسخة المصغرة
        Storage::disk('public')->put(
            $fullPath, 
            $image->encode($extension, 90)->stream()
        );
        
        return $fullPath;
    }
    
    /**
     * حذف صورة من التخزين
     *
     * @param string $path مسار الصورة
     * @return bool نجاح العملية
     */
    public function deleteImage($path)
    {
        if (empty($path)) {
            return false;
        }
        
        return Storage::disk('public')->delete($path);
    }
} 