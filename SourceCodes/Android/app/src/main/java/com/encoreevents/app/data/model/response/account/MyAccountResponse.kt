package com.encoreevents.app.data.model.response.account

data class MyAccountResponse(
    val `data`: Data,
    val message: String,
    val statusCode: Int,
    val success: Boolean
)