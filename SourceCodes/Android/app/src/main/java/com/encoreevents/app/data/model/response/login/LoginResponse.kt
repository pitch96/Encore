package com.encoreevents.app.data.model.response.login

data class LoginResponse(
    val `data`: Data,
    val message: String,
    val statusCode: Int,
    val success: Boolean,
    val token: String
)