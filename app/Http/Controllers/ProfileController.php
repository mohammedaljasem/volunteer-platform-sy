<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        Log::info('Profile update started for user: ' . $user->id);
        
        // Handle the validated data
        $validated = $request->validated();
        Log::info('Validated data: ' . json_encode($validated));
        
        // Handle profile photo upload
        $photoUploaded = false;
        if ($request->hasFile('profile_photo')) {
            Log::info('Profile photo file detected');
            try {
                // Get the file
                $file = $request->file('profile_photo');
                
                // Make sure the file is valid
                if ($file->isValid()) {
                    Log::info('File is valid: ' . $file->getClientOriginalName() . ', size: ' . $file->getSize() . ', mime: ' . $file->getMimeType());
                    
                    // Delete the old profile photo if it exists
                    if ($user->profile_photo_path) {
                        Log::info('Deleting old profile photo: ' . $user->profile_photo_path);
                        Storage::disk('public')->delete($user->profile_photo_path);
                    }
                    
                    // Generate a unique filename
                    $filename = 'profile-' . $user->id . '-' . time() . '.' . $file->getClientOriginalExtension();
                    Log::info('Generated filename: ' . $filename);
                    
                    // Store the new profile photo - don't include 'profile-photos/' in the path as storeAs already handles this
                    $path = $file->storeAs('profile-photos', $filename, 'public');
                    Log::info('Stored profile photo at path: ' . $path);
                    
                    if ($path) {
                        $user->profile_photo_path = $path;  // Assign directly to user model
                        $photoUploaded = true;
                        Log::info('Profile photo path set to: ' . $path);
                    } else {
                        Log::error('Failed to store profile photo for user ID: ' . $user->id);
                        return Redirect::route('profile.edit')->with('error', 'فشل في تخزين الصورة. يرجى المحاولة مرة أخرى.');
                    }
                } else {
                    Log::error('Invalid profile photo uploaded by user ID: ' . $user->id);
                    return Redirect::route('profile.edit')->with('error', 'الصورة المرفوعة غير صالحة. يرجى المحاولة مرة أخرى.');
                }
            } catch (\Exception $e) {
                Log::error('Error uploading profile photo: ' . $e->getMessage() . ' for user: ' . $user->id);
                return Redirect::route('profile.edit')->with('error', 'حدث خطأ أثناء رفع الصورة: ' . $e->getMessage());
            }
        }
        
        // Fill user with validated data (except profile_photo)
        if (isset($validated['profile_photo'])) {
            unset($validated['profile_photo']);
        }
        
        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Save the user
        $saved = $user->save();
        Log::info('User saved: ' . ($saved ? 'yes' : 'no') . '. User data: ' . json_encode($user->toArray()));

        // If a photo was successfully uploaded, reflect that in the success message
        if ($photoUploaded) {
            Log::info('Photo uploaded successfully');
            return Redirect::route('profile.edit')->with('success', 'تم تحديث الملف الشخصي وتحميل الصورة بنجاح.');
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        
        // Delete profile photo if it exists
        if ($user->profile_photo_path) {
            try {
                Storage::disk('public')->delete($user->profile_photo_path);
                Log::info('Profile photo deleted for user: ' . $user->id);
            } catch (\Exception $e) {
                Log::error('Error deleting profile photo: ' . $e->getMessage() . ' for user: ' . $user->id);
            }
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Display the user's profile information for debugging.
     */
    public function debug(Request $request)
    {
        $user = $request->user();
        
        return response()->json([
            'user_id' => $user->id,
            'profile_photo_path' => $user->profile_photo_path,
            'profile_photo_url' => $user->profile_photo_url,
            'profile_photo_exists' => $user->profile_photo_path ? Storage::disk('public')->exists($user->profile_photo_path) : false,
            'storage_disk' => config('filesystems.default'),
            'public_disk' => config('filesystems.disks.public.root'),
            'storage_link_path' => public_path('storage'),
            'storage_link_exists' => file_exists(public_path('storage')),
        ]);
    }
}
