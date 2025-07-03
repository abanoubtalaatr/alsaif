<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ForgotPasswordRequest;
use App\Http\Requests\Api\ResetPasswordRequest;
use App\Mail\PasswordResetOtpMail;
use App\Models\PasswordResetOtp;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class PasswordResetController extends Controller
{
    use ApiResponse;

    /**
     * Send OTP to user's email for password reset
     */
    public function sendOtp(ForgotPasswordRequest $request): JsonResponse
    {
        try {
            $email = $request->validated()['email'];
            
            // Find the user by email
            $user = User::where('email', $email)->first();
            
            // Create new OTP
            $otpRecord = PasswordResetOtp::createForEmail($email);
            
            // Send OTP via email
            Mail::to($email)->send(new PasswordResetOtpMail($otpRecord, $user->name));
            
            return $this->success(
                ['message' => 'تم إرسال رمز التأكيد إلى بريدك الإلكتروني'],
                'تم إرسال رمز التأكيد بنجاح',
                200
            );
            
        } catch (\Exception $e) {
            return $this->error(
                'حدث خطأ أثناء إرسال رمز التأكيد',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }

    /**
     * Verify OTP (optional endpoint to just verify without resetting)
     */
    public function verifyOtp(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'otp' => ['required', 'string', 'size:6'],
        ]);

        try {
            $email = $request->email;
            $otp = $request->otp;

            // Find the OTP record
            $otpRecord = PasswordResetOtp::where('email', $email)
                ->where('otp', $otp)
                ->first();

            if (!$otpRecord) {
                return $this->error('رمز التأكيد غير صحيح', 400);
            }

            if (!$otpRecord->isValid()) {
                return $this->error(
                    $otpRecord->is_used ? 'تم استخدام رمز التأكيد من قبل' : 'انتهت صلاحية رمز التأكيد',
                    400
                );
            }

            return $this->success(
                ['message' => 'رمز التأكيد صحيح'],
                'تم التحقق من رمز التأكيد بنجاح',
                200
            );

        } catch (\Exception $e) {
            return $this->error(
                'حدث خطأ أثناء التحقق من رمز التأكيد',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }

    /**
     * Reset password using OTP
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $email = $validated['email'];
            $otp = $validated['otp'];
            $newPassword = $validated['password'];

            // Find the OTP record
            $otpRecord = PasswordResetOtp::where('email', $email)
                ->where('otp', $otp)
                ->first();

            if (!$otpRecord) {
                return $this->error('رمز التأكيد غير صحيح', 400);
            }

            if (!$otpRecord->isValid()) {
                return $this->error(
                    $otpRecord->is_used ? 'تم استخدام رمز التأكيد من قبل' : 'انتهت صلاحية رمز التأكيد',
                    400
                );
            }

            // Find and update user password
            $user = User::where('email', $email)->first();
            $user->update([
                'password' => Hash::make($newPassword)
            ]);

            // Mark OTP as used
            $otpRecord->markAsUsed();

            return $this->success(
                ['message' => 'تم تغيير كلمة المرور بنجاح'],
                'تم إعادة تعيين كلمة المرور بنجاح',
                200
            );

        } catch (\Exception $e) {
            return $this->error(
                'حدث خطأ أثناء إعادة تعيين كلمة المرور',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }

    /**
     * Change password for authenticated user
     */
    public function changePassword(Request $request): JsonResponse
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'كلمة المرور الحالية مطلوبة',
            'password.required' => 'كلمة المرور الجديدة مطلوبة',
            'password.min' => 'كلمة المرور يجب أن تكون على الأقل 8 أحرف',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق',
        ]);

        try {
            $user = $request->user();
            
            // Verify current password
            if (!Hash::check($request->current_password, $user->password)) {
                return $this->error('كلمة المرور الحالية غير صحيحة', 400);
            }

            // Update password
            $user->update([
                'password' => Hash::make($request->password)
            ]);

            return $this->success(
                ['message' => 'تم تغيير كلمة المرور بنجاح'],
                'تم تغيير كلمة المرور بنجاح',
                200
            );

        } catch (\Exception $e) {
            return $this->error(
                'حدث خطأ أثناء تغيير كلمة المرور',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }
}
