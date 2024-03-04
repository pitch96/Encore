package com.encoreevents.local_preference

import androidx.datastore.preferences.core.booleanPreferencesKey
import androidx.datastore.preferences.core.intPreferencesKey
import androidx.datastore.preferences.core.stringPreferencesKey
import kotlinx.coroutines.flow.Flow

interface UserPreference {

    object PreferencesKey {
        val KEY_USER_LOGGED_IN = booleanPreferencesKey("user_logged_in")
        val KEY_USER_LOGGED_IN_TIME = stringPreferencesKey("user_logged_in_time")
        val KEY_USER_LOGGED_IN_TOKEN = stringPreferencesKey("user_logged_in_token")
        val KEY_USER_ID = intPreferencesKey("user_id")
        val KEY_USER_TYPE = intPreferencesKey("user_type")
        val KEY_USER_FIRST_NAME = stringPreferencesKey("user_first_name")
        val KEY_USER_LAST_NAME = stringPreferencesKey("user_last_name")
        val KEY_USER_EMAIL = stringPreferencesKey("user_email")
        val KEY_USER_PHONE_NO = stringPreferencesKey("user_phone_no")
        val KEY_USER_COMPANY_NAME = stringPreferencesKey("user_company_name")
        val KEY_USER_STATUS = intPreferencesKey("user_status")
        val KEY_USER_PROFILE = stringPreferencesKey("user_profile")
    }

    /**
     * returns if user is logged in or not flow
     * */
    fun userLoggedIn(): Flow<Boolean>

    /**
     * saves if user is logged in or not in data store
     * */
    suspend fun saveUserLoggedIn(loggedIn: Boolean)

    /**
     * returns if user is logged in or not flow
     * */
    fun userLoggedInTime(): Flow<String>

    /**
     * saves if user is logged in or not in data store
     * */
    suspend fun saveUserLoggedInTime(logInTime: String)

    /**
     * returns user logged in token flow
     * */
    fun userLoggedInToken(): Flow<String>

    /**
     * saves user logged in token in data store
     * */
    suspend fun saveUserLoggedInToken(token: String)

    /**
     * returns user id flow
     * */
    fun userId(): Flow<Int>

    /**
     * saves user id in data store
     * */
    suspend fun saveUserId(id: Int)

    /**
     * returns user type flow
     * */
    fun userType(): Flow<Int>

    /**
     * saves user type in data store
     * */
    suspend fun saveUserType(userType: Int)

    /**
     * returns user first name flow
     * */
    fun userFirstName(): Flow<String>

    /**
     * saves user first name in data store
     * */
    suspend fun saveUserFirstName(firstName: String)

    /**
     * returns user last name flow
     * */
    fun userLastName(): Flow<String>

    /**
     * saves user last name in data store
     * */
    suspend fun saveUserLastName(lastName: String)

    /**
     * returns user email flow
     * */
    fun userEmail(): Flow<String>

    /**
     * saves user email in data store
     * */
    suspend fun saveUserEmail(email: String)

    /**
     * returns user phone no flow
     * */
    fun userPhoneNo(): Flow<String>

    /**
     * saves user phone no in data store
     * */
    suspend fun saveUserPhoneNo(phoneNo: String)

    /**
     * returns user email flow
     * */
    fun userCompanyName(): Flow<String>

    /**
     * saves user email in data store
     * */
    suspend fun saveUserCompanyName(email: String)

    /**
     * returns user type flow
     * */
    fun userStatus(): Flow<Int>

    /**
     * saves user type in data store
     * */
    suspend fun saveUserStatus(status: Int)

    /**
     * returns user phone no flow
     * */
    fun userProfile(): Flow<String>

    /**
     * saves user phone no in data store
     * */
    suspend fun saveUserProfile(userProfile: String)
}