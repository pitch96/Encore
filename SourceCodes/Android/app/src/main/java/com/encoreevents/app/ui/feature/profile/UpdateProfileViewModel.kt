package com.encoreevents.app.ui.feature.profile

import android.content.Context
import android.net.Uri
import android.util.Log
import androidx.compose.runtime.MutableState
import androidx.compose.runtime.mutableStateOf
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.encoreevents.app.data.model.response.ApiResponse
import com.encoreevents.app.data.model.response.update_profile.UpdateProfileResponse
import com.encoreevents.app.data.repository.ApiRepository
import com.encoreevents.app.ui.feature.dashboard.DashboardViewModel
import com.encoreevents.app.utils.Utils.Companion.getRequestBody
import com.encoreevents.app.utils.Utils.Companion.showShortToast
import com.encoreevents.local_preference.UserPreference
import dagger.hilt.android.lifecycle.HiltViewModel
import dagger.hilt.android.qualifiers.ApplicationContext
import kotlinx.coroutines.flow.catch
import kotlinx.coroutines.flow.first
import kotlinx.coroutines.launch
import okhttp3.MediaType.Companion.toMediaTypeOrNull
import okhttp3.MultipartBody
import okhttp3.RequestBody.Companion.asRequestBody
import java.io.File
import java.io.FileOutputStream
import javax.inject.Inject

private const val TAG = "UpdateProfileViewModel"

/**
 * The [ViewModel] that is attached to the RegisterScreen
 * */
@HiltViewModel
class UpdateProfileViewModel @Inject constructor(
    @ApplicationContext private val context: Context,
    private val apiRepository: ApiRepository,
    private val userPreference: UserPreference
) :
    ViewModel() {

    private val _profileImage = mutableStateOf<MultipartBody.Part?>(null)
    private val _mProfileImageModel = mutableStateOf("")
    val mProfileImageModel: MutableState<String> = _mProfileImageModel
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
    private val _mUpdateProfileResult = mutableStateOf("")
    val mUpdateProfileSuccessDialog: MutableState<Boolean> =
        apiRepository.mUpdateProfileSuccessDialog
    private val _updateProfileApiResponse = MutableLiveData<ApiResponse<UpdateProfileResponse>>()
    val updateProfileApiResponse = _updateProfileApiResponse

    fun getProfileData(dashboardViewModel: DashboardViewModel) {
        viewModelScope.launch {
            with(dashboardViewModel) {
                userFirstName.first()
                userLastName.first()
                userEmail.first()
                userProfile.first()
                userCompanyName.first()
                userPhoneNo.first()
            }
        }
        _mFirstName.value = dashboardViewModel.userFirstName.value
        _mLastName.value = dashboardViewModel.userLastName.value
        _mEmail.value = dashboardViewModel.userEmail.value
        _mProfileImageModel.value = dashboardViewModel.userProfile.value
        _mCompanyName.value = dashboardViewModel.userCompanyName.value
        _mPhone.value = dashboardViewModel.userPhoneNo.value
    }

    fun updateUserProfile(
        ctx: Context,
        profileImageUri: Uri?
    ) {
        profileImageUri?.let { imgUri ->
            val file = File(context.filesDir, "profile_image")

            val inputStream = context.contentResolver.openInputStream(imgUri)
            val outputStream = FileOutputStream(file)
            if (inputStream != null) {
                inputStream.copyTo(outputStream)
                inputStream.close()
            }

            val requestBody = file.asRequestBody("image/*".toMediaTypeOrNull())
            _profileImage.value =
                MultipartBody.Part.createFormData("user_profile", file.name, requestBody)
        }

        if (updateProfileValidation()) {
            viewModelScope.launch {
                apiRepository.updateProfile(
                    user_profile = _profileImage.value,
                    first_name = getRequestBody(_mFirstName.value.trim()),
                    last_name = getRequestBody(_mLastName.value.trim()),
                    phone_no = getRequestBody(_mPhone.value.trim()),
                    company_name = getRequestBody(_mCompanyName.value.trim())
                ).catch { e ->
                    Log.e(TAG, "updateUserProfile: ${e.message}")
                }.collect {
                    _updateProfileApiResponse.postValue(it)
                }
            }
        } else showShortToast(ctx, _mUpdateProfileResult.value)
    }

    fun saveUserData(dashViewModel: DashboardViewModel) {
        viewModelScope.launch {
            with(userPreference) {
                saveUserFirstName(_mFirstName.value)
                saveUserLastName(_mLastName.value)
                saveUserPhoneNo(_mPhone.value)
                saveUserCompanyName(_mCompanyName.value)
                saveUserProfile(_mProfileImageModel.value)
            }
            getProfileData(dashViewModel)
        }
    }

    /**
     *  @user: Chetu
     *  @param : First name
     *  @param : Last name
     *  @param : Phone
     *  @param : Company name
     *  @return : This method is used to return true if all update profile fields are valid otherwise return false.
     *  @description : This method is used to validate update profile fields.
     */
    private fun updateProfileValidation(): Boolean {
        return when {
            // First name check
            _mFirstName.value.isEmpty() -> {
                _mUpdateProfileResult.value = "First Name is required"
                false
            }

            // Last name check
            _mLastName.value.isEmpty() -> {
                _mUpdateProfileResult.value = "Last Name is required"
                false
            }

            // Phone number check
            _mPhone.value.isEmpty() -> {
                _mUpdateProfileResult.value = "Phone number is required"
                false
            }

            _mPhone.value.length < 10 -> {
                _mUpdateProfileResult.value = "The phone no must be at least 10 characters"
                false
            }

            _mPhone.value.length > 14 -> {
                _mUpdateProfileResult.value = "The phone no must not be greater than 14 characters"
                false
            }

            // Company name check
            _mCompanyName.value.isEmpty() -> {
                _mUpdateProfileResult.value = "Company name is required"
                false
            }

            else -> true
        }
    }
}