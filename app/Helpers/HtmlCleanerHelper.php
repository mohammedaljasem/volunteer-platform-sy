<?php

namespace App\Helpers;

class HtmlCleanerHelper
{
    /**
     * تنظيف المحتوى HTML من الأكواد الضارة
     * 
     * @param string $html النص المراد تنظيفه
     * @param array $allowedTags العلامات المسموح بها
     * @return string
     */
    public static function clean($html, $allowedTags = null)
    {
        if ($allowedTags === null) {
            $allowedTags = [
                'p', 'br', 'strong', 'em', 'u', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 
                'ul', 'ol', 'li', 'span', 'a', 'blockquote', 'pre', 'code'
            ];
        }
        
        // في حالة وجود مكتبة HTMLPurifier يفضل استخدامها هنا
        // حالياً سنستخدم strip_tags مع السماح ببعض العلامات
        
        $allowedTagsStr = '<' . implode('><', $allowedTags) . '>';
        $cleanHtml = strip_tags($html, $allowedTagsStr);
        
        // يمكن إضافة تنظيف إضافي هنا مثل إزالة السكريبت من العلامات
        // أو أي معالجة أخرى
        
        // إزالة سمات مثل onclick و onerror من العلامات
        $cleanHtml = preg_replace('/(<[^>]+) on\w+=".*?"/i', '$1', $cleanHtml);
        $cleanHtml = preg_replace('/(<[^>]+) on\w+=\'.*?\'/i', '$1', $cleanHtml);
        
        // إزالة javascript: من الروابط
        $cleanHtml = preg_replace('/href=["|\']javascript:.*?["|\']/', 'href="#"', $cleanHtml);
        
        return $cleanHtml;
    }
} 