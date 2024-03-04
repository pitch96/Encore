package com.encoreevents.app.data.model.response.homepage

data class Data(
    val banner_images: List<com.encoreevents.app.data.model.response.homepage.BannerImage>,
    val categories: List<com.encoreevents.app.data.model.response.homepage.Category>,
    val events: List<com.encoreevents.app.data.model.response.homepage.Event>,
    val popular_events: List<com.encoreevents.app.data.model.response.homepage.PopularEvent>
)