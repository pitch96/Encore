package com.encoreevents.app.data.repository

import android.content.Context
import android.util.Log
import androidx.compose.runtime.mutableStateOf
import com.encoreevents.app.R
import com.encoreevents.app.data.model.request.ForgotPassword
import com.encoreevents.app.data.model.request.Login
import com.encoreevents.app.data.model.request.Register
import com.encoreevents.app.data.model.request.ResetPassword
import com.encoreevents.app.data.model.response.ApiResponse
import com.encoreevents.app.data.network.ApiService
import com.encoreevents.app.utils.Utils.Companion.isInternetAvailable
import dagger.hilt.android.qualifiers.ApplicationContext
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.flow.flow
import kotlinx.coroutines.flow.flowOn
import okhttp3.MultipartBody
import okhttp3.RequestBody
import javax.inject.Inject

private const val TAG = "ApiRepository"

class ApiRepository
@Inject
constructor(@ApplicationContext private val context: Context, private val apiService: ApiService) {
    private val _mResendOtpSuccessDialog = mutableStateOf(false)
    val mResendOtpSuccessDialog = _mResendOtpSuccessDialog
    private val _mResetPasswordSuccessDialog = mutableStateOf(false)
    val mResetPasswordSuccessDialog = _mResetPasswordSuccessDialog
    private val _mEventCreatedSuccessDialog = mutableStateOf(false)
    val mEventCreatedSuccessDialog = _mEventCreatedSuccessDialog
    private val _mUpdateProfileSuccessDialog = mutableStateOf(false)
    val mUpdateProfileSuccessDialog = _mUpdateProfileSuccessDialog
    private val _mTokenExpiredDialog = mutableStateOf(false)
    val mTokenExpiredDialog = _mTokenExpiredDialog

    suspend fun loginUser(request: Login) = flow {
        if (isInternetAvailable(context)) {
            emit(ApiResponse.Loading())
            try {
                val result = apiService.checkAuthentication(request)
                if (result.code() == 400 || result.body() == null) {
                    emit(ApiResponse.Error(context.getString(R.string.login_credentials_are_invalid)))
                } else if (result.body() != null) {
                    emit(ApiResponse.Success(result.body()))
                }
            } catch (e: Exception) {
                Log.e(TAG, "loginUser: ", e)
                emit(ApiResponse.Error(e.message.toString()))
            }
        } else emit(ApiResponse.Error(context.getString(R.string.please_check_your_internet_connection)))
    }.flowOn(Dispatchers.IO)

    suspend fun registerUser(request: Register) = flow {
        if (isInternetAvailable(context)) {
            emit(ApiResponse.Loading())
            try {
                val result = apiService.registerUser(request)
                if (result.code() == 400 || result.body() == null) {
                    emit(ApiResponse.Error(context.getString(R.string.the_email_has_already_been_taken)))
                } else if (result.body() != null) {
                    emit(ApiResponse.Success(result.body()))
                }
            } catch (e: Exception) {
                Log.e(TAG, "registerUser: ", e)
                emit(ApiResponse.Error(e.message.toString()))
            }
        } else emit(ApiResponse.Error(context.getString(R.string.please_check_your_internet_connection)))
    }.flowOn(Dispatchers.IO)

    suspend fun forgotPassword(request: ForgotPassword) = flow {
        if (isInternetAvailable(context)) {
            emit(ApiResponse.Loading())
            try {
                val result = apiService.forgotPassword(request)
                if (result.code() == 400 || result.body() == null) {
                    emit(ApiResponse.Error(context.getString(R.string.the_selected_email_is_invalid)))
                } else if (result.body() != null) {
                    emit(ApiResponse.Success(result.body()))
                }
            } catch (e: Exception) {
                Log.e(TAG, "forgotPassword: ", e)
                emit(ApiResponse.Error(e.message.toString()))
            }
        } else emit(ApiResponse.Error(context.getString(R.string.please_check_your_internet_connection)))
    }.flowOn(Dispatchers.IO)

    suspend fun resetPassword(request: ResetPassword) = flow {
        if (isInternetAvailable(context)) {
            emit(ApiResponse.Loading())
            try {
                val result = apiService.resetPassword(request)
                if (result.code() == 400 || result.body() == null) {
                    emit(ApiResponse.Error(context.getString(R.string.wrong_otp_please_enter_correct_otp)))
                } else if (result.body() != null) {
                    _mResetPasswordSuccessDialog.value = true
                    emit(ApiResponse.Success(result.body()))
                }
            } catch (e: Exception) {
                Log.e(TAG, "resetPassword: ", e)
                emit(ApiResponse.Error(e.message.toString()))
            }
        } else emit(ApiResponse.Error(context.getString(R.string.please_check_your_internet_connection)))
    }.flowOn(Dispatchers.IO)

    suspend fun resendOtp(request: ForgotPassword) = flow {
        if (isInternetAvailable(context)) {
            emit(ApiResponse.Loading())
            try {
                val result = apiService.resendOtp(request)
                if (result.code() == 400 || result.body() == null) {
                    emit(ApiResponse.Error(context.getString(R.string.the_selected_email_is_invalid)))
                } else if (result.body() != null) {
                    _mResendOtpSuccessDialog.value = true
                    emit(ApiResponse.Success(result.body()))
                }
            } catch (e: Exception) {
                Log.e(TAG, "resendOtp: ", e)
                emit(ApiResponse.Error(e.message.toString()))
            }
        } else emit(ApiResponse.Error(context.getString(R.string.please_check_your_internet_connection)))
    }.flowOn(Dispatchers.IO)

    suspend fun logoutUser(token: String) = flow {
        if (isInternetAvailable(context)) {
            emit(ApiResponse.Loading())
            try {
                val result = apiService.logoutUser(token)
                if (result.code() == 400 || result.body() == null) {
                    emit(ApiResponse.Error(context.getString(R.string.token_is_invalid)))
                } else if (result.body() != null) {
                    emit(ApiResponse.Success(result.body()))
                }
            } catch (e: Exception) {
                Log.e(TAG, "logoutUser: ", e)
                emit(ApiResponse.Error(e.message.toString()))
            }
        } else emit(ApiResponse.Error(context.getString(R.string.please_check_your_internet_connection)))
    }.flowOn(Dispatchers.IO)

    suspend fun getBanners() = flow {
        if (isInternetAvailable(context)) {
            emit(ApiResponse.Loading())
            try {
                val result = apiService.getBanners()
                if (result.code() == 400 || result.body() == null) {
                    emit(ApiResponse.Error(context.getString(R.string.no_banners_found)))
                } else if (result.body() != null) {
                    emit(ApiResponse.Success(result.body()))
                }
            } catch (e: Exception) {
                Log.e(TAG, "getBanners: ", e)
                emit(ApiResponse.Error(e.message.toString()))
            }
        } else emit(ApiResponse.Error(context.getString(R.string.please_check_your_internet_connection)))
    }.flowOn(Dispatchers.IO)

    suspend fun getAccount() = flow {
        if (isInternetAvailable(context)) {
            emit(ApiResponse.Loading())
            try {
                val result = apiService.getAccount()
                if (result.code() == 400 || result.body() == null) {
                    emit(ApiResponse.Error("No Account Found"))
                } else if (result.body() != null) {
                    emit(ApiResponse.Success(result.body()))
                }
            } catch (e: Exception) {
                Log.e(TAG, "getAccount: ", e)
                emit(ApiResponse.Error(e.message.toString()))
            }
        } else emit(ApiResponse.Error(context.getString(R.string.please_check_your_internet_connection)))
    }.flowOn(Dispatchers.IO)

    suspend fun getHomepage() = flow {
        if (isInternetAvailable(context)) {
            emit(ApiResponse.Loading())
            try {
                val result = apiService.getHomepage()
                if (result.code() == 400 || result.body() == null) {
                    emit(ApiResponse.Error(context.getString(R.string.no_record_found)))
                } else if (result.body() != null) {
                    emit(ApiResponse.Success(result.body()))
                }
            } catch (e: Exception) {
                Log.e(TAG, "getHomepage: ", e)
                emit(ApiResponse.Error(e.message.toString()))
            }
        } else emit(ApiResponse.Error(context.getString(R.string.please_check_your_internet_connection)))
    }.flowOn(Dispatchers.IO)

    suspend fun getCategories() = flow {
        if (isInternetAvailable(context)) {
            emit(ApiResponse.Loading())
            try {
                val result = apiService.getCategories()
                if (result.code() == 400 || result.body() == null) {
                    emit(ApiResponse.Error(context.getString(R.string.no_record_found)))
                } else if (result.body() != null) {
                    emit(ApiResponse.Success(result.body()))
                }
            } catch (e: Exception) {
                Log.e(TAG, "getCategories: ", e)
                emit(ApiResponse.Error(e.message.toString()))
            }
        } else emit(ApiResponse.Error(context.getString(R.string.please_check_your_internet_connection)))
    }.flowOn(Dispatchers.IO)

    suspend fun updateProfile(
        user_profile: MultipartBody.Part?,
        first_name: RequestBody,
        last_name: RequestBody,
        phone_no: RequestBody,
        company_name: RequestBody
    ) = flow {
        if (isInternetAvailable(context)) {
            emit(ApiResponse.Loading())
            try {
                val result = apiService.updateProfile(
                    user_profile = user_profile,
                    first_name = first_name,
                    last_name = last_name,
                    phone_no = phone_no,
                    company_name = company_name
                )
                if (result.code() == 400 || result.body() == null) {
                    emit(ApiResponse.Error(context.getString(R.string.the_selected_email_is_invalid)))
                } else if (result.body() != null) {
                    _mUpdateProfileSuccessDialog.value = true
                    emit(ApiResponse.Success(result.body()))
                }
            } catch (e: Exception) {
                Log.e(TAG, "updateProfile: ", e)
                emit(ApiResponse.Error(e.message.toString()))
            }
        } else emit(ApiResponse.Error(context.getString(R.string.please_check_your_internet_connection)))
    }.flowOn(Dispatchers.IO)

    suspend fun createEvent(
        image: MultipartBody.Part?,
        category_id: RequestBody,
        event_title: RequestBody,
        organizer: RequestBody,
        venue: RequestBody,
        address: RequestBody,
        city: RequestBody,
        zipcode: RequestBody,
        start_date: RequestBody,
        end_date: RequestBody,
        start_time: RequestBody,
        end_time: RequestBody,
        description: RequestBody
    ) = flow {
        if (isInternetAvailable(context)) {
            emit(ApiResponse.Loading())
            try {
                Log.d(TAG, "createEvent: start_date: $start_date")
                val result = apiService.createEvent(
                    image = image,
                    category_id = category_id,
                    event_title = event_title,
                    organizer = organizer,
                    venue = venue,
                    address = address,
                    city = city,
                    zipcode = zipcode,
                    start_date = start_date,
                    end_date = end_date,
                    start_time = start_time,
                    end_time = end_time,
                    description = description
                )
                if (result.code() == 400 || result.body() == null) {
                    emit(ApiResponse.Error(context.getString(R.string.the_selected_email_is_invalid)))
                } else if (result.body() != null) {
                    if (result.body()!!.success) {
                        _mEventCreatedSuccessDialog.value = true
                        emit(ApiResponse.Success(result.body()))
                    } else if (result.body()!!.message.contains("expire", true)) {
                        _mTokenExpiredDialog.value = true
                        emit(ApiResponse.Error(result.body()!!.message + " Please login again."))
                    } else emit(ApiResponse.Error(result.body()!!.message))
                }
            } catch (e: Exception) {
                Log.e(TAG, "createEvent: ", e)
                emit(ApiResponse.Error(e.message.toString()))
            }
        } else emit(ApiResponse.Error(context.getString(R.string.please_check_your_internet_connection)))
    }.flowOn(Dispatchers.IO)
}