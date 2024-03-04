package com.encoreevents.app.data.model.response.categories

data class CategoriesResponse(
    val `data`: List<CategoriesData>,
    val message: String,
    val statusCode: Int,
    val success: Boolean
)