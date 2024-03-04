package com.encoreevents.app.ui.feature.login

import android.content.Context
import android.util.Log
import androidx.compose.runtime.MutableState
import androidx.compose.runtime.mutableStateOf
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import androidx.navigation.NavHostController
import com.encoreevents.app.data.model.response.ApiResponse
import com.encoreevents.app.data.model.response.login.LoginResponse
import com.encoreevents.app.data.repository.ApiRepository
import com.encoreevents.app.nav_graphs.AuthScreen
import com.encoreevents.app.ui.Graph
import com.encoreevents.app.utils.Utils.Companion.isNotAValidEmail
import com.encoreevents.app.utils.Utils.Companion.showShortToast
import com.encoreevents.local_preference.UserPreference
import dagger.hilt.android.lifecycle.HiltViewModel
import kotlinx.coroutines.launch
import javax.inject.Inject

private const val TAG = "LoginViewModel"

/**
 * The [ViewModel] that is attached to the LoginScreen
 * */
@HiltViewModel
class LoginViewModel @Inject constructor(
    private val apiRepository: ApiRepository,
    private val userPreference: UserPreference
) : ViewModel() {

    private val _mEmail = mutableStateOf("")
    val mEmail: MutableState<String> = _mEmail
    private val _mPassword = mutableStateOf("")
    val mPassword: MutableState<String> = _mPassword
    private val _mLogInResult = mutableStateOf("")
    private val _loginApiResponse = MutableLiveData<ApiResponse<LoginResponse>>()
    val loginApiResponse = _loginApiResponse

    fun loginUser(ctx: Context) {
        if (mLoginValidation()) {
            viewModelScope.launch {
                apiRepository.loginUser(
                    com.encoreevents.app.data.model.request.Login(
                        _mEmail.value.trim(),
                        _mPassword.value.trim()
                    )
                ).collect {
                    _loginApiResponse.postValue(it)
                }
            }
        } else showShortToast(ctx, _mLogInResult.value)
    }

    /**
     *  @user: Chetu
     *  @param : email
     *  @param : password
     *  @return : This method is used to return true if the email and password is valid otherwise return false.
     *  @description : This method is used to validate email address and password.
     */
    private fun mLoginValidation(): Boolean {
        return when {
            _mEmail.value.trim().isEmpty() -> {
                _mLogInResult.value = "Please enter email address"
                false
            }

            isNotAValidEmail(_mEmail.value.trim()) -> {
                _mLogInResult.value = "Please enter a valid email address"
                false
            }

            _mPassword.value.trim().isEmpty() -> {
                _mLogInResult.value = "The password field is required"
                false
            }

            _mPassword.value.trim().length < 6 -> {
                _mLogInResult.value = "The password must be at least 6 characters"
                false
            }

            else -> true
        }
    }

    fun saveUserData(
        token: String,
        id: Int,
        userType: Int,
        firstName: String,
        lastName: String,
        email: String,
        phoneNo: String,
        companyName: String?,
        status: Int,
        userProfile: String?,
        logInTime: String,
        navController: NavHostController
    ) {
        Log.d(TAG, "saveUserData: logInTime: $logInTime")

        viewModelScope.launch {
            with(userPreference) {
                saveUserProfile(userProfile ?: "")
                saveUserLoggedInToken(token)
                saveUserId(id)
                saveUserType(userType)
                saveUserFirstName(firstName)
                saveUserLastName(lastName)
                saveUserEmail(email)
                saveUserPhoneNo(phoneNo)
                saveUserCompanyName(companyName ?: "")
                saveUserStatus(status)

                saveUserLoggedInTime(logInTime)
                saveUserLoggedIn(true)
            }
            navController.navigate(Graph.MAIN) {
                popUpTo(AuthScreen.Welcome.route) { inclusive = true }
            }
        }
    }
}