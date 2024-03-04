package com.encoreevents.app.ui.feature.register

import android.content.Context
import androidx.compose.runtime.MutableState
import androidx.compose.runtime.mutableStateOf
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.encoreevents.app.data.repository.ApiRepository
import com.encoreevents.app.data.model.request.Register
import com.encoreevents.app.data.model.response.ApiResponse
import com.encoreevents.app.data.model.response.register.RegisterResponse
import com.encoreevents.app.utils.Utils.Companion.isNotAValidEmail
import com.encoreevents.app.utils.Utils.Companion.showShortToast
import dagger.hilt.android.lifecycle.HiltViewModel
import kotlinx.coroutines.launch
import javax.inject.Inject

/**
 * The [ViewModel] that is attached to the RegisterScreen
 * */
@HiltViewModel
class RegisterViewModel @Inject constructor(private val apiRepository: ApiRepository) :
    ViewModel() {

    private val _mUserType = mutableStateOf(0)
    val mUserType: MutableState<Int> = _mUserType
    private val _mFirstName = mutableStateOf("")
    val mFirstName: MutableState<String> = _mFirstName
    private val _mLastName = mutableStateOf("")
    val mLastName: MutableState<String> = _mLastName
    private val _mEmail = mutableStateOf("")
    val mEmail: MutableState<String> = _mEmail
    private val _mPhone = mutableStateOf("")
    val mPhone: MutableState<String> = _mPhone
    private val _mCompanyName = mutableStateOf("")
    val mCompanyName: MutableState<String> = _mCompanyName
    private val _mPassword = mutableStateOf("")
    val mPassword: MutableState<String> = _mPassword
    private val _mConfirmPassword = mutableStateOf("")
    val mConfirmPassword: MutableState<String> = _mConfirmPassword
    private val _mSignUpResult = mutableStateOf("")
    private val _registerApiResponse = MutableLiveData<com.encoreevents.app.data.model.response.ApiResponse<com.encoreevents.app.data.model.response.register.RegisterResponse>>()
    val registerApiResponse = _registerApiResponse

    fun registerUser(
        ctx: Context
    ) {
        if (mRegisterValidation()) {
            viewModelScope.launch {
                apiRepository.registerUser(
                    com.encoreevents.app.data.model.request.Register(
                        _mUserType.value + 2,
                        _mFirstName.value.trim(),
                        _mLastName.value.trim(),
                        _mEmail.value.trim(),
                        _mPhone.value.trim(),
                        _mCompanyName.value.trim(),
                        _mPassword.value.trim(),
                        _mConfirmPassword.value.trim()
                    )
                ).collect {
                    _registerApiResponse.postValue(it)
                }
            }
        } else showShortToast(ctx, _mSignUpResult.value)
    }

    /**
     *  @user: Chetu
     *  @param : User type
     *  @param : First name
     *  @param : Last name
     *  @param : Email
     *  @param : Phone
     *  @param : Company name
     *  @param : Password
     *  @param : Confirm Password
     *  @return : This method is used to return true if all sign up fields are valid otherwise return false.
     *  @description : This method is used to validate sign up fields.
     */
    private fun mRegisterValidation(): Boolean {
        return when {
            // First name check
            _mFirstName.value.isEmpty() -> {
                _mSignUpResult.value = "First Name is required"
                false
            }

            // Last name check
            _mLastName.value.isEmpty() -> {
                _mSignUpResult.value = "Last Name is required"
                false
            }

            // Email check
            _mEmail.value.isEmpty() -> {
                _mSignUpResult.value = "Email is required"
                false
            }

            isNotAValidEmail(_mEmail.value) -> {
                _mSignUpResult.value = "Enter a valid email"
                false
            }

            // Phone number check
            _mPhone.value.isEmpty() -> {
                _mSignUpResult.value = "Phone number is required"
                false
            }

            _mPhone.value.length < 10 -> {
                _mSignUpResult.value = "The phone no must be at least 10 characters"
                false
            }

            _mPhone.value.length > 14 -> {
                _mSignUpResult.value = "The phone no must not be greater than 14 characters"
                false
            }

            // Company name check
            _mCompanyName.value.isEmpty() -> {
                _mSignUpResult.value = "Company name is required"
                false
            }

            // Password check
            _mPassword.value.isEmpty() -> {
                _mSignUpResult.value = "Password is required"
                false
            }

            //TODO: ADD A PROPER REGEX FOR PASSWORD VALIDATION
            _mPassword.value.length < 8 -> {
                _mSignUpResult.value = "Password must be at least 8 characters and should contain at least one uppercase, lowercase, special character and a number."
                false
            }

            // Confirm Password check
            _mConfirmPassword.value.isEmpty() -> {
                _mSignUpResult.value = "Confirm Password is required"
                false
            }

            // Password and confirm password match check
            _mPassword.value != _mConfirmPassword.value -> {
                _mSignUpResult.value = "Password and confirm password must be same"
                false
            }

            else -> true
        }
    }
}