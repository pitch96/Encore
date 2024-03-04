package com.encoreevents.app.ui.feature.reset_password

import android.content.Context
import android.util.Log
import androidx.compose.runtime.MutableState
import androidx.compose.runtime.mutableStateOf
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.encoreevents.app.data.repository.ApiRepository
import com.encoreevents.app.data.model.request.ForgotPassword
import com.encoreevents.app.data.model.request.ResetPassword
import com.encoreevents.app.data.model.response.ApiResponse
import com.encoreevents.app.data.model.response.resend_otp.ResendOtpResponse
import com.encoreevents.app.data.model.response.reset_password.ResetPasswordResponse
import com.encoreevents.app.utils.Utils.Companion.isNotAValidEmail
import com.encoreevents.app.utils.Utils.Companion.showShortToast
import dagger.hilt.android.lifecycle.HiltViewModel
import kotlinx.coroutines.flow.catch
import kotlinx.coroutines.launch
import javax.inject.Inject

private const val TAG = "ResetPasswordViewModel"

@HiltViewModel
class ResetPasswordViewModel @Inject constructor(private val apiRepository: ApiRepository) :
    ViewModel() {

    private val _mOTP = mutableStateOf("")
    val mOTP: MutableState<String> = _mOTP
    private val _mEmail = mutableStateOf("")
    val mEmail: MutableState<String> = _mEmail
    private val _mPassword = mutableStateOf("")
    val mPassword: MutableState<String> = _mPassword
    private val _mConfirmPassword = mutableStateOf("")
    val mConfirmPassword: MutableState<String> = _mConfirmPassword
    val mResetPasswordSuccessDialog: MutableState<Boolean> =
        apiRepository.mResetPasswordSuccessDialog
    val mResendOtpSuccessDialog: MutableState<Boolean> = apiRepository.mResendOtpSuccessDialog
    private val _mResetPasswordResult = mutableStateOf("")
    private val _resetPasswordApiResponse = MutableLiveData<com.encoreevents.app.data.model.response.ApiResponse<com.encoreevents.app.data.model.response.reset_password.ResetPasswordResponse>>()
    val resetPasswordApiResponse = _resetPasswordApiResponse
    private val _resendOtpApiResponse = MutableLiveData<com.encoreevents.app.data.model.response.ApiResponse<com.encoreevents.app.data.model.response.resend_otp.ResendOtpResponse>>()
    val resendOtpApiResponse = _resendOtpApiResponse

    /**
     *  @description : This method is used to reset user password.
     * */
    fun resetPassword(
        ctx: Context
    ) {
        if (mResetPasswordValidation()) {
            viewModelScope.launch {
                apiRepository.resetPassword(
                    com.encoreevents.app.data.model.request.ResetPassword(
                        _mOTP.value.trim(),
                        _mEmail.value.trim(),
                        _mPassword.value.trim(),
                        _mConfirmPassword.value.trim()
                    )
                ).catch { e ->
                    Log.e(TAG, "resetPassword: ${e.message}")
                }.collect {
                    _resetPasswordApiResponse.postValue(it)
                }
            }
        } else showShortToast(ctx, _mResetPasswordResult.value)
    }

    /**
     *  @description : This method is used to resend otp.
     * */
    fun resendOtp() {
        viewModelScope.launch {
            apiRepository.resendOtp(com.encoreevents.app.data.model.request.ForgotPassword(_mEmail.value))
                .catch { e ->
                    Log.e(TAG, "resendOtp: ${e.message}")
                }.collect {
                    _resendOtpApiResponse.postValue(it)
                }
        }
    }

    /**
     *  @user: Chetu
     *  @param : OTP
     *  @param : Email
     *  @param : Password
     *  @param : Confirm Password
     *  @return : This method is used to return true if all reset password fields are valid otherwise return false.
     *  @description : This method is used to validate reset password fields.
     */
    private fun mResetPasswordValidation(): Boolean {
        return when {

            // OTP check
            _mOTP.value.isEmpty() -> {
                _mResetPasswordResult.value = "OTP is required"
                false
            }

            // Email check
            _mEmail.value.isEmpty() -> {
                _mResetPasswordResult.value = "Email is required"
                false
            }

            isNotAValidEmail(_mEmail.value) -> {
                _mResetPasswordResult.value = "Enter a valid email"
                false
            }

            // Password check
            _mPassword.value.isEmpty() -> {
                _mResetPasswordResult.value = "Password is required"
                false
            }

            _mPassword.value.length < 6 -> {
                _mResetPasswordResult.value = "Password must be at least 6 characters"
                false
            }

            // Confirm Password check
            _mConfirmPassword.value.isEmpty() -> {
                _mResetPasswordResult.value = "Confirm Password is required"
                false
            }
            // Password and confirm password match check
            _mPassword.value != _mConfirmPassword.value -> {
                _mResetPasswordResult.value = "Your password and confirm password does not match"
                false
            }

            else -> true
        }
    }
}