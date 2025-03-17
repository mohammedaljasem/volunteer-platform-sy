<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class WalletController extends Controller
{
    /**
     * عرض رصيد المحفظة
     */
    public function index()
    {
        $user = Auth::user();
        
        // البحث عن محفظة المستخدم أو إنشاء محفظة جديدة
        $wallet = Wallet::firstOrCreate(
            ['user_id' => $user->id],
            ['balance' => 0]
        );
        
        return view('wallet.index', compact('wallet'));
    }
    
    /**
     * شحن المحفظة
     */
    public function charge(Request $request)
    {
        try {
            // التحقق من البيانات
            $validator = Validator::make($request->all(), [
                'amount' => 'required|numeric|min:1',
            ], [
                'amount.required' => 'يرجى إدخال المبلغ',
                'amount.numeric' => 'يجب أن يكون المبلغ رقماً',
                'amount.min' => 'يجب أن يكون المبلغ أكبر من صفر',
            ]);
            
            if ($validator->fails()) {
                return redirect()
                    ->route('wallet.index')
                    ->withErrors($validator)
                    ->withInput();
            }
            
            $amount = (float) $request->input('amount');
            $user = Auth::user();
            
            // البحث عن محفظة المستخدم أو إنشاء محفظة جديدة
            $wallet = Wallet::firstOrCreate(
                ['user_id' => $user->id],
                ['balance' => 0]
            );
            
            // شحن المحفظة
            if ($wallet->charge($amount)) {
                Log::info('تم شحن محفظة المستخدم ID:' . $user->id . ' بمبلغ: ' . $amount . ' ليرة سورية');
                return redirect()
                    ->route('wallet.index')
                    ->with('success', "تم شحن محفظتك بمبلغ {$amount} ليرة سورية بنجاح");
            } else {
                Log::error('فشلت عملية شحن المحفظة للمستخدم ID:' . $user->id);
                return redirect()
                    ->route('wallet.index')
                    ->with('error', 'فشلت عملية شحن المحفظة، يرجى المحاولة مرة أخرى');
            }
        } catch (ValidationException $e) {
            Log::error('خطأ في التحقق من البيانات: ' . $e->getMessage());
            return redirect()
                ->route('wallet.index')
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            Log::error('خطأ أثناء شحن المحفظة: ' . $e->getMessage());
            return redirect()
                ->route('wallet.index')
                ->with('error', 'حدث خطأ أثناء شحن المحفظة: ' . $e->getMessage());
        }
    }
}
