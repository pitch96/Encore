package com.encoreevents.app.data.model.response.get_banners

data class BannerData(
    val banner_image: String,
    val created_at: String,
    val deleted_at: Any,
    val description: String,
    val id: Int,
    val status: Int,
    val updated_at: String
)