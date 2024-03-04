package com.encoreevents.app.data.model.response.resend_otp

data class ResendOtpResponse(
    val `data`: Any,
    val message: String,
    val statusCode: Int,
    val success: Boolean
)