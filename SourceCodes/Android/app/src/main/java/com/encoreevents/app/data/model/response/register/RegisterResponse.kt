package com.encoreevents.app.data.model.response.register

data class RegisterResponse(
    val `data`: com.encoreevents.app.data.model.response.register.Data,
    val message: String,
    val statusCode: Int,
    val success: Boolean
)