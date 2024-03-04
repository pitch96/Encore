package com.encoreevents.app.di

import android.util.Log
import androidx.datastore.core.DataStore
import androidx.datastore.preferences.core.Preferences
import androidx.datastore.preferences.core.emptyPreferences
import com.encoreevents.app.data.network.ApiService
import com.encoreevents.app.utils.Utils
import com.encoreevents.app.utils.Utils.Companion.BASE_URL
import com.encoreevents.local_preference.UserPreference
import dagger.Module
import dagger.Provides
import dagger.hilt.InstallIn
import dagger.hilt.components.SingletonComponent
import kotlinx.coroutines.flow.catch
import kotlinx.coroutines.flow.first
import kotlinx.coroutines.flow.map
import kotlinx.coroutines.runBlocking
import okhttp3.OkHttpClient
import okhttp3.logging.HttpLoggingInterceptor
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory
import java.util.concurrent.TimeUnit
import javax.inject.Singleton

private const val TAG = "AppModule"

@Module
@InstallIn(SingletonComponent::class)
object AppModule {

    @Provides
    @Singleton
    fun provideAuthInspectorOkHttpClient(dataStore: DataStore<Preferences>): OkHttpClient {
        val userToken: String

        runBlocking {
            userToken = dataStore.data
                .catch {
                    emit(emptyPreferences())
                }
                .map { preference ->
                    preference[UserPreference.PreferencesKey.KEY_USER_LOGGED_IN_TOKEN] ?: ""
                }.first()
        }

        Log.i(TAG, "provideAuthInspectorOkHttpClient: $userToken")

        return OkHttpClient.Builder()
            .addInterceptor(HttpLoggingInterceptor().setLevel(HttpLoggingInterceptor.Level.BODY))
            .addInterceptor { chain ->
                val newRequest = chain.request().newBuilder()
                    .header("Authorization", "Bearer $userToken")
                    .build()
                chain.proceed(newRequest)
            }
            .connectTimeout(Utils.TIMEOUT, TimeUnit.SECONDS)
            .readTimeout(Utils.TIMEOUT, TimeUnit.SECONDS)
            .writeTimeout(Utils.TIMEOUT, TimeUnit.SECONDS)
            .build()
    }

    @Provides
    @Singleton
    fun provideRetrofit(
        okHttpClient: OkHttpClient
    ): Retrofit {
        return Retrofit
            .Builder()
            .client(okHttpClient)
            .addConverterFactory(GsonConverterFactory.create())
            .baseUrl(BASE_URL)
            .build()
    }

    @Provides
    @Singleton
    fun provideApiService(retrofit: Retrofit): ApiService {
        return retrofit.create(ApiService::class.java)
    }
}