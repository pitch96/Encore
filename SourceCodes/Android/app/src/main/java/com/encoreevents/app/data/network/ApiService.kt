package com.encoreevents.app.data.network

import com.encoreevents.app.data.model.request.ForgotPassword
import com.encoreevents.app.data.model.request.Login
import com.encoreevents.app.data.model.request.Register
import com.encoreevents.app.data.model.request.ResetPassword
import com.encoreevents.app.data.model.response.account.MyAccountResponse
import com.encoreevents.app.data.model.response.categories.CategoriesResponse
import com.encoreevents.app.data.model.response.create_event.CreateEventResponse
import com.encoreevents.app.data.model.response.forgot_password.ForgotPasswordResponse
import com.encoreevents.app.data.model.response.get_banners.BannersResponse
import com.encoreevents.app.data.model.response.homepage.HomepageResponse
import com.encoreevents.app.data.model.response.login.LoginResponse
import com.encoreevents.app.data.model.response.logout.LogoutResponse
import com.encoreevents.app.data.model.response.register.RegisterResponse
import com.encoreevents.app.data.model.response.resend_otp.ResendOtpResponse
import com.encoreevents.app.data.model.response.reset_password.ResetPasswordResponse
import com.encoreevents.app.data.model.response.update_profile.UpdateProfileResponse
import com.encoreevents.app.utils.Utils.Companion.BANNERS_URL
import com.encoreevents.app.utils.Utils.Companion.CATEGORIES_URL
import com.encoreevents.app.utils.Utils.Companion.CREATE_EVENT_URL
import com.encoreevents.app.utils.Utils.Companion.FORGOT_PASSWORD_URL
import com.encoreevents.app.utils.Utils.Companion.HOMEPAGE_URL
import com.encoreevents.app.utils.Utils.Companion.LOGIN_URL
import com.encoreevents.app.utils.Utils.Companion.LOGOUT_URL
import com.encoreevents.app.utils.Utils.Companion.MY_ACCOUNT_URL
import com.encoreevents.app.utils.Utils.Companion.REGISTER_URL
import com.encoreevents.app.utils.Utils.Companion.RESEND_OTP_URL
import com.encoreevents.app.utils.Utils.Companion.RESET_PASSWORD_URL
import com.encoreevents.app.utils.Utils.Companion.UPDATE_PROFILE_URL
import okhttp3.MultipartBody
import okhttp3.RequestBody
import retrofit2.Response
import retrofit2.http.Body
import retrofit2.http.GET
import retrofit2.http.Multipart
import retrofit2.http.POST
import retrofit2.http.Part
import retrofit2.http.Query

interface ApiService {

    @POST(LOGIN_URL)
    suspend fun checkAuthentication(@Body request: Login): Response<LoginResponse>

    @POST(REGISTER_URL)
    suspend fun registerUser(@Body request: Register): Response<RegisterResponse>

    @POST(FORGOT_PASSWORD_URL)
    suspend fun forgotPassword(@Body request: ForgotPassword): Response<ForgotPasswordResponse>

    @POST(RESET_PASSWORD_URL)
    suspend fun resetPassword(@Body request: ResetPassword): Response<ResetPasswordResponse>

    @POST(RESEND_OTP_URL)
    suspend fun resendOtp(@Body request: ForgotPassword): Response<ResendOtpResponse>

    @GET(LOGOUT_URL)
    suspend fun logoutUser(@Query("token") token: String): Response<LogoutResponse>

    @GET(BANNERS_URL)
    suspend fun getBanners(): Response<BannersResponse>

    @GET(HOMEPAGE_URL)
    suspend fun getHomepage(): Response<HomepageResponse>

    @GET(CATEGORIES_URL)
    suspend fun getCategories(): Response<CategoriesResponse>

    @GET(MY_ACCOUNT_URL)
    suspend fun getAccount(): Response<MyAccountResponse>

    @Multipart
    @POST(UPDATE_PROFILE_URL)
    suspend fun updateProfile(
        @Part user_profile: MultipartBody.Part?,
        @Part("first_name") first_name: RequestBody,
        @Part("last_name") last_name: RequestBody,
        @Part("phone_no") phone_no: RequestBody,
        @Part("company_name") company_name: RequestBody
    ): Response<UpdateProfileResponse>

    @Multipart
    @POST(CREATE_EVENT_URL)
    suspend fun createEvent(
        @Part image: MultipartBody.Part?,
        @Part("category_id") category_id: RequestBody,
        @Part("event_title") event_title: RequestBody,
        @Part("organizer") organizer: RequestBody,
        @Part("venue") venue: RequestBody,
        @Part("address") address: RequestBody,
        @Part("city") city: RequestBody,
        @Part("zipcode") zipcode: RequestBody,
        @Part("start_date") start_date: RequestBody,
        @Part("end_date") end_date: RequestBody,
        @Part("start_time") start_time: RequestBody,
        @Part("end_time") end_time: RequestBody,
        @Part("description") description: RequestBody
    ): Response<CreateEventResponse>
}