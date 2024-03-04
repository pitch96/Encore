package com.encoreevents.app.data.model.response.logout

data class LogoutResponse(
    val `data`: Any,
    val message: String,
    val statusCode: Int,
    val success: Boolean
)