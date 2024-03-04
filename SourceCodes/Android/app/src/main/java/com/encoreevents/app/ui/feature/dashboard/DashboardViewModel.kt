package com.encoreevents.app.ui.feature.dashboard

import android.content.Context
import android.util.Log
import androidx.compose.runtime.mutableStateOf
import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import androidx.navigation.NavHostController
import com.encoreevents.app.data.model.response.ApiResponse
import com.encoreevents.app.data.model.response.account.MyAccountResponse
import com.encoreevents.app.data.model.response.categories.CategoriesResponse
import com.encoreevents.app.data.model.response.get_banners.BannersResponse
import com.encoreevents.app.data.model.response.homepage.HomepageResponse
import com.encoreevents.app.data.model.response.logout.LogoutResponse
import com.encoreevents.app.data.repository.ApiRepository
import com.encoreevents.app.ui.Graph
import com.encoreevents.app.utils.Utils.Companion.diffStartandEndTime
import com.encoreevents.app.utils.Utils.Companion.showShortToast
import com.encoreevents.local_preference.UserPreference
import dagger.hilt.android.lifecycle.HiltViewModel
import dagger.hilt.android.qualifiers.ApplicationContext
import kotlinx.coroutines.flow.SharingStarted
import kotlinx.coroutines.flow.StateFlow
import kotlinx.coroutines.flow.first
import kotlinx.coroutines.flow.stateIn
import kotlinx.coroutines.launch
import javax.inject.Inject

private const val TAG = "DashboardViewModel"

/**
 * The [ViewModel] that is attached to the DashboardScreen
 * */
@HiltViewModel
class DashboardViewModel
@Inject
constructor(
    @ApplicationContext context: Context,
    private val apiRepository: ApiRepository,
    private val userPreference: UserPreference
) : ViewModel() {
    private val _eventDate = mutableStateOf("")
    val eventDate = _eventDate
    private val _eventSearch = mutableStateOf("")
    val eventSearch = _eventSearch
    private val _mShowLogoutConfirmDialog = MutableLiveData<Boolean>()
    var mShowLogoutConfirmDialog: LiveData<Boolean> = _mShowLogoutConfirmDialog
    private val _logoutApiResponse = MutableLiveData<ApiResponse<LogoutResponse>>()
    val logoutApiResponse = _logoutApiResponse
    private val _bannersApiResponse = MutableLiveData<ApiResponse<BannersResponse>>()
    val bannersApiResponse = _bannersApiResponse
    private val _accountApiResponse = MutableLiveData<ApiResponse<MyAccountResponse>>()
    val accountApiResponse = _accountApiResponse
    private val _homepageApiResponse = MutableLiveData<ApiResponse<HomepageResponse>>()
    val homepageApiResponse = _homepageApiResponse
    private val _categoriesApiResponse = MutableLiveData<ApiResponse<CategoriesResponse>>()
    val categoriesApiResponse = _categoriesApiResponse

    init {
        getHomepage()
        getAccount()
        getBanners()
        getCategories()
    }

    val userLoggedIn: StateFlow<Boolean> = userPreference.userLoggedIn().stateIn(
        viewModelScope,
        SharingStarted.WhileSubscribed(),
        false
    )

    private val userLoggedInTime: StateFlow<String> = userPreference.userLoggedInTime().stateIn(
        viewModelScope,
        SharingStarted.WhileSubscribed(),
        ""
    )

    val userToken: StateFlow<String> = userPreference.userLoggedInToken()
        .stateIn(
            viewModelScope,
            SharingStarted.WhileSubscribed(),
            "No token found"
        )

    val userType: StateFlow<Int> = userPreference.userType()
        .stateIn(
            viewModelScope,
            SharingStarted.WhileSubscribed(),
            -1
        )

    val userFirstName: StateFlow<String> = userPreference.userFirstName()
        .stateIn(
            viewModelScope,
            SharingStarted.WhileSubscribed(),
            ""
        )

    val userLastName: StateFlow<String> = userPreference.userLastName()
        .stateIn(
            viewModelScope,
            SharingStarted.WhileSubscribed(),
            ""
        )

    val userEmail: StateFlow<String> = userPreference.userEmail()
        .stateIn(
            viewModelScope,
            SharingStarted.WhileSubscribed(),
            ""
        )

    val userCompanyName: StateFlow<String> = userPreference.userCompanyName()
        .stateIn(
            viewModelScope,
            SharingStarted.WhileSubscribed(),
            ""
        )

    val userPhoneNo: StateFlow<String> = userPreference.userPhoneNo()
        .stateIn(
            viewModelScope,
            SharingStarted.WhileSubscribed(),
            ""
        )

    val userProfile: StateFlow<String> = userPreference.userProfile()
        .stateIn(
            viewModelScope,
            SharingStarted.WhileSubscribed(),
            ""
        )

    init {
        viewModelScope.launch {
            userLoggedInTime.first()
        }
        if (userLoggedInTime.value.isNotEmpty()) {
            try {
                if (diffStartandEndTime(userLoggedInTime.value)) {
                    showShortToast(context, "Token is Expired.")
                }
            } catch (e: Exception) {
                Log.e(TAG, "TokenTimeCheckException: ${userLoggedInTime.value}", e)
            }
        }
    }

    fun showLogoutConfirmDialog(show: Boolean) {
        _mShowLogoutConfirmDialog.value = show
    }

    fun logoutUser(userToken: String) {
        viewModelScope.launch {
            apiRepository.logoutUser(userToken).collect {
                _logoutApiResponse.postValue(it)
            }
        }
    }

    fun saveUserLoggedOut(navController: NavHostController) {
        viewModelScope.launch {
            userPreference.saveUserLoggedIn(false)
            _mShowLogoutConfirmDialog.value = false
            navController.navigate(Graph.AUTH)
        }
    }

    private fun getBanners() {
        viewModelScope.launch {
            apiRepository.getBanners().collect {
                _bannersApiResponse.postValue(it)
            }
        }
    }

    private fun getAccount() {
        viewModelScope.launch {
            apiRepository.getAccount().collect {
                _accountApiResponse.postValue(it)
            }
        }
    }

    fun saveUserData(
        id: Int,
        userType: Int,
        firstName: String,
        lastName: String,
        email: String,
        phoneNo: String,
        companyName: String?,
        status: Int,
        userProfile: String?
    ) {
        Log.d(TAG, "saveUserData: userProfile: $userProfile")

        viewModelScope.launch {
            with(userPreference) {
                saveUserProfile(userProfile ?: "")
                saveUserId(id)
                saveUserType(userType)
                saveUserFirstName(firstName)
                saveUserLastName(lastName)
                saveUserEmail(email)
                saveUserPhoneNo(phoneNo)
                saveUserCompanyName(companyName ?: "")
                saveUserStatus(status)
            }
        }
    }

    private fun getHomepage() {
        viewModelScope.launch {
            apiRepository.getHomepage().collect {
                _homepageApiResponse.postValue(it)
            }
        }
    }

    private fun getCategories() {
        viewModelScope.launch {
            apiRepository.getCategories().collect {
                _categoriesApiResponse.postValue(it)
            }
        }
    }
}