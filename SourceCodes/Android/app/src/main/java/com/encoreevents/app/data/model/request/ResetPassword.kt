package com.encoreevents.app.data.model.request

data class ResetPassword(
    val otp: String,
    val email: String,
    val password: String,
    val password_confirmation : String
)
