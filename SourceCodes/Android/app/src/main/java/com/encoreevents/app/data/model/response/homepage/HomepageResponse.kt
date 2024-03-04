package com.encoreevents.app.data.model.response.homepage

data class HomepageResponse(
    val `data`: com.encoreevents.app.data.model.response.homepage.Data,
    val message: String,
    val statusCode: Int,
    val success: Boolean
)