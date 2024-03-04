package com.encoreevents.local_preference

import androidx.datastore.core.DataStore
import androidx.datastore.preferences.core.Preferences
import androidx.datastore.preferences.core.edit
import androidx.datastore.preferences.core.emptyPreferences
import com.encoreevents.local_preference.UserPreference.PreferencesKey.KEY_USER_COMPANY_NAME
import com.encoreevents.local_preference.UserPreference.PreferencesKey.KEY_USER_EMAIL
import com.encoreevents.local_preference.UserPreference.PreferencesKey.KEY_USER_FIRST_NAME
import com.encoreevents.local_preference.UserPreference.PreferencesKey.KEY_USER_ID
import com.encoreevents.local_preference.UserPreference.PreferencesKey.KEY_USER_LAST_NAME
import com.encoreevents.local_preference.UserPreference.PreferencesKey.KEY_USER_LOGGED_IN
import com.encoreevents.local_preference.UserPreference.PreferencesKey.KEY_USER_LOGGED_IN_TIME
import com.encoreevents.local_preference.UserPreference.PreferencesKey.KEY_USER_LOGGED_IN_TOKEN
import com.encoreevents.local_preference.UserPreference.PreferencesKey.KEY_USER_PHONE_NO
import com.encoreevents.local_preference.UserPreference.PreferencesKey.KEY_USER_PROFILE
import com.encoreevents.local_preference.UserPreference.PreferencesKey.KEY_USER_STATUS
import com.encoreevents.local_preference.UserPreference.PreferencesKey.KEY_USER_TYPE
import kotlinx.coroutines.flow.Flow
import kotlinx.coroutines.flow.catch
import kotlinx.coroutines.flow.map
import javax.inject.Inject

class UserDataStore @Inject constructor(private val dataStore: DataStore<Preferences>) :
    UserPreference {
    override fun userLoggedIn(): Flow<Boolean> {
        return dataStore.data
            .catch {
                emit(emptyPreferences())
            }
            .map { preference ->
                preference[KEY_USER_LOGGED_IN] ?: false
            }
    }

    override suspend fun saveUserLoggedIn(loggedIn: Boolean) {
        dataStore.edit { preference ->
            preference[KEY_USER_LOGGED_IN] = loggedIn
        }
    }

    override fun userLoggedInTime(): Flow<String> {
        return dataStore.data
            .catch {
                emit(emptyPreferences())
            }
            .map { preference ->
                preference[KEY_USER_LOGGED_IN_TIME] ?: ""
            }
    }

    override suspend fun saveUserLoggedInTime(logInTime: String) {
        dataStore.edit { preference ->
            preference[KEY_USER_LOGGED_IN_TIME] = logInTime
        }
    }

    override fun userLoggedInToken(): Flow<String> {
        return dataStore.data
            .catch {
                emit(emptyPreferences())
            }
            .map { preference ->
                preference[KEY_USER_LOGGED_IN_TOKEN] ?: ""
            }
    }

    override suspend fun saveUserLoggedInToken(token: String) {
        dataStore.edit { preference ->
            preference[KEY_USER_LOGGED_IN_TOKEN] = token
        }
    }

    override fun userId(): Flow<Int> {
        return dataStore.data
            .catch {
                emit(emptyPreferences())
            }
            .map { preference ->
                preference[KEY_USER_ID] ?: 0
            }
    }

    override suspend fun saveUserId(id: Int) {
        dataStore.edit { preference ->
            preference[KEY_USER_ID] = id
        }
    }

    override fun userType(): Flow<Int> {
        return dataStore.data
            .catch {
                emit(emptyPreferences())
            }
            .map { preference ->
                preference[KEY_USER_TYPE] ?: -1
            }
    }

    override suspend fun saveUserType(userType: Int) {
        dataStore.edit { preference ->
            preference[KEY_USER_TYPE] = userType
        }
    }

    override fun userFirstName(): Flow<String> {
        return dataStore.data
            .catch {
                emit(emptyPreferences())
            }
            .map { preference ->
                preference[KEY_USER_FIRST_NAME] ?: ""
            }
    }

    override suspend fun saveUserFirstName(firstName: String) {
        dataStore.edit { preference ->
            preference[KEY_USER_FIRST_NAME] = firstName
        }
    }

    override fun userLastName(): Flow<String> {
        return dataStore.data
            .catch {
                emit(emptyPreferences())
            }
            .map { preference ->
                preference[KEY_USER_LAST_NAME] ?: ""
            }
    }

    override suspend fun saveUserLastName(lastName: String) {
        dataStore.edit { preference ->
            preference[KEY_USER_LAST_NAME] = lastName
        }
    }

    override fun userEmail(): Flow<String> {
        return dataStore.data
            .catch {
                emit(emptyPreferences())
            }
            .map { preference ->
                preference[KEY_USER_EMAIL] ?: ""
            }
    }

    override suspend fun saveUserEmail(email: String) {
        dataStore.edit { preference ->
            preference[KEY_USER_EMAIL] = email
        }
    }

    override fun userPhoneNo(): Flow<String> {
        return dataStore.data
            .catch {
                emit(emptyPreferences())
            }
            .map { preference ->
                preference[KEY_USER_PHONE_NO] ?: ""
            }
    }

    override suspend fun saveUserPhoneNo(phoneNo: String) {
        dataStore.edit { preference ->
            preference[KEY_USER_PHONE_NO] = phoneNo
        }
    }

    override fun userCompanyName(): Flow<String> {
        return dataStore.data
            .catch {
                emit(emptyPreferences())
            }
            .map { preference ->
                preference[KEY_USER_COMPANY_NAME] ?: ""
            }
    }

    override suspend fun saveUserCompanyName(companyName: String) {
        dataStore.edit { preference ->
            preference[KEY_USER_COMPANY_NAME] = companyName
        }
    }

    override fun userStatus(): Flow<Int> {
        return dataStore.data
            .catch {
                emit(emptyPreferences())
            }
            .map { preference ->
                preference[KEY_USER_STATUS] ?: 0
            }
    }

    override suspend fun saveUserStatus(status: Int) {
        dataStore.edit { preference ->
            preference[KEY_USER_STATUS] = status
        }
    }

    override fun userProfile(): Flow<String> {
        return dataStore.data
            .catch {
                emit(emptyPreferences())
            }
            .map { preference ->
                preference[KEY_USER_PROFILE] ?: ""
            }
    }

    override suspend fun saveUserProfile(userProfile: String) {
        dataStore.edit { preference ->
            preference[KEY_USER_PROFILE] = userProfile
        }
    }
}