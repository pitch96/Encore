package com.encoreevents.app.data.model.response.get_banners

data class BannersResponse(
    val `data`: List<BannerData>,
    val message: String,
    val statusCode: Int,
    val success: Boolean
)