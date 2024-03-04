package com.encoreevents.app.data.model.response.reset_password

data class ResetPasswordResponse(
    val `data`: Any,
    val message: String,
    val statusCode: Int,
    val success: Boolean
)