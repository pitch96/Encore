package com.encoreevents.app.data.model.response.homepage

data class Event(
    val address: String,
    val category_id: Int,
    val city: String,
    val created_at: String,
    val deleted_at: Any,
    val description: String,
    val end_date: String,
    val end_time: String,
    val event_title: String,
    val id: Int,
    val image: String,
    val isCancelled: Int,
    val isPopular: Int,
    val organizer: String,
    val start_date: String,
    val start_time: String,
    val status: Int,
    val updated_at: String,
    val user_id: Int,
    val venue: String,
    val verifiedPromoterEvent: Int,
    val zipcode: String
)