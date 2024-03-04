package com.encoreevents.app.utils

import android.app.DatePickerDialog
import android.app.TimePickerDialog
import android.content.Context
import android.net.ConnectivityManager
import android.net.NetworkCapabilities
import android.os.Build
import android.widget.DatePicker
import android.widget.Toast
import androidx.annotation.RequiresApi
import androidx.compose.runtime.MutableState
import androidx.core.util.PatternsCompat
import okhttp3.MediaType.Companion.toMediaTypeOrNull
import okhttp3.RequestBody
import okhttp3.RequestBody.Companion.toRequestBody
import java.text.SimpleDateFormat
import java.time.LocalDate
import java.util.Calendar
import java.util.Date

class Utils {

    companion object {
        // API
        const val TIMEOUT: Long = 120

        //private const val ROOT_URL = "https://5starglobalentertainment-qa.chetu.com"
        private const val ROOT_URL = "https://encoreevents.live/"
        const val BASE_URL = "${ROOT_URL}/api/"
        const val USER_IMAGES_URL = "${ROOT_URL}/user-images/"

        // Auth API End Points
        const val LOGIN_URL = "login"
        const val REGISTER_URL = "register"
        const val FORGOT_PASSWORD_URL = "forgot/password"
        const val RESET_PASSWORD_URL = "reset/password"
        const val RESEND_OTP_URL = "resend/otp"
        const val LOGOUT_URL = "logout"
        const val BANNERS_URL = "banners"
        const val HOMEPAGE_URL = "homepage"
        const val CATEGORIES_URL = "categories"
        const val UPDATE_PROFILE_URL = "update/profile"
        const val MY_ACCOUNT_URL = "account"
        const val CREATE_EVENT_URL = "admin/event"

        @Suppress("BooleanMethodIsAlwaysInverted")
        fun isNotAValidEmail(email: String): Boolean {
            return !PatternsCompat.EMAIL_ADDRESS.matcher(email).matches()
        }

        fun showShortToast(ctx: Context, msg: String) {
            Toast.makeText(ctx, msg, Toast.LENGTH_SHORT).show()
        }

        @Suppress("BooleanMethodIsAlwaysInverted")
        fun isInternetAvailable(context: Context): Boolean {
            (context.getSystemService(Context.CONNECTIVITY_SERVICE) as ConnectivityManager).run {
                return this.getNetworkCapabilities(this.activeNetwork)?.hasCapability(
                    NetworkCapabilities.NET_CAPABILITY_INTERNET
                ) ?: false
            }
        }

        @RequiresApi(Build.VERSION_CODES.O)
        fun timeInterval(StartDate: String, EndDate: String): String {

            val startDate = LocalDate.parse(StartDate)
            val endDay = LocalDate.parse(EndDate).dayOfMonth

            val startDay = startDate.dayOfMonth
            val month = (startDate.month).toString()
            val startMonth = month[0] + month.substring(1..2).lowercase()

            return "$startMonth $startDay-$endDay"
        }

        fun pickDate(datePicked: MutableState<String>, context: Context) {
            val year: Int
            val month: Int
            val day: Int

            val calendar = Calendar.getInstance()
            year = calendar.get(Calendar.YEAR)
            month = calendar.get(Calendar.MONTH)
            day = calendar.get(Calendar.DAY_OF_MONTH)
            calendar.time = Date()


            DatePickerDialog(
                context,
                { _: DatePicker?, year: Int, month: Int, dayOfMonth: Int ->
                    datePicked.value = "$year-$month-$dayOfMonth"
                }, year, month, day
            ).show()
        }

        fun pickTime(timePicked: MutableState<String>, context: Context) {
            val mHour = currentHour()
            val mMinute = currentMinute()

            TimePickerDialog(
                context,
                { _, mHour: Int, mMinute: Int ->
                    timePicked.value = "$mHour:$mMinute"
                }, mHour, mMinute, true
            ).show()
        }

        fun currentHour(): Int = Calendar.getInstance()[Calendar.HOUR_OF_DAY]

        fun currentMinute(): Int = Calendar.getInstance()[Calendar.MINUTE]

        fun getRequestBody(text: String): RequestBody {
            return text.toRequestBody("text/plain".toMediaTypeOrNull())
        }

        fun diffStartandEndTime(loginTime: String): Boolean {
            val simpleDateFormat = SimpleDateFormat("hh:mm")

            val startTime = simpleDateFormat.parse(loginTime)
            val currentTime = simpleDateFormat.parse("${currentHour()}:${currentMinute()}")

            val difference: Long = currentTime.time - startTime.time
            var days = (difference / (1000 * 60 * 60 * 24)).toInt()
            var hours = (difference - 1000 * 60 * 60 * 24 * days) / (1000 * 60 * 60)
            var min =
                (difference - 1000 * 60 * 60 * 24 * days - 1000 * 60 * 60 * hours) / (1000 * 60)
            hours = if (hours < 0) -hours else hours
            val totalminute = hours * 60 + min
            return totalminute > 60
        }
    }
}