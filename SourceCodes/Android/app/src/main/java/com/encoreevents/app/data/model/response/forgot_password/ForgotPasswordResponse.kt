package com.encoreevents.app.data.model.response.forgot_password

data class ForgotPasswordResponse(
    val `data`: Any,
    val message: String,
    val statusCode: Int,
    val success: Boolean
)