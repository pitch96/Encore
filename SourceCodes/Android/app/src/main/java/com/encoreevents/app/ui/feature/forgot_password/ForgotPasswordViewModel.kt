package com.encoreevents.app.ui.feature.forgot_password

import android.content.Context
import androidx.compose.runtime.MutableState
import androidx.compose.runtime.mutableStateOf
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.encoreevents.app.data.repository.ApiRepository
import com.encoreevents.app.data.model.request.ForgotPassword
import com.encoreevents.app.data.model.response.ApiResponse
import com.encoreevents.app.data.model.response.forgot_password.ForgotPasswordResponse
import com.encoreevents.app.utils.Utils.Companion.isNotAValidEmail
import com.encoreevents.app.utils.Utils.Companion.showShortToast
import dagger.hilt.android.lifecycle.HiltViewModel
import kotlinx.coroutines.launch
import javax.inject.Inject

/**
 * The [ViewModel] that is attached to the ForgotPasswordScreen
 * */
@HiltViewModel
class ForgotPasswordViewModel @Inject constructor(private val apiRepository: ApiRepository) :
    ViewModel() {

    private val _mEmail = mutableStateOf("")
    val mEmail: MutableState<String> = _mEmail
    private val _mForgotPasswordResult = mutableStateOf("")
    private val _forgotPasswordApiResponse = MutableLiveData<com.encoreevents.app.data.model.response.ApiResponse<com.encoreevents.app.data.model.response.forgot_password.ForgotPasswordResponse>>()
    val forgotPasswordApiResponse = _forgotPasswordApiResponse

    fun forgotPassword(
        ctx: Context
    ) {
        if (mForgotPasswordValidation()) {
            viewModelScope.launch {
                apiRepository.forgotPassword(
                    com.encoreevents.app.data.model.request.ForgotPassword(
                        _mEmail.value.trim()
                    )
                )
                    .collect {
                        _forgotPasswordApiResponse.postValue(it)
                    }
            }
        } else showShortToast(ctx, _mForgotPasswordResult.value)
    }

    /**
     *  @user: Chetu
     *  @param : email
     *  @return : This method is used to return true if the email is valid otherwise return false.
     *  @description : This method is used to validate email address.
     */
    private fun mForgotPasswordValidation(): Boolean {
        return when {
            _mEmail.value.isEmpty() -> {
                _mForgotPasswordResult.value = "Email is required"
                false
            }

            isNotAValidEmail(_mEmail.value) -> {
                _mForgotPasswordResult.value = "Enter a valid email"
                false
            }

            else -> true
        }
    }
}