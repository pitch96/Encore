package com.encoreevents.app.data.model.response.login

data class Data(
    val company_name: String?,
    val created_at: String,
    val deleted_at: Any,
    val email: String,
    val email_verified_at: String,
    val first_name: String,
    val id: Int,
    val isVerified: Int,
    val is_email_verified: Int,
    val last_name: String,
    val phone_no: String,
    val status: Int,
    val updated_at: String,
    val user_profile: String?,
    val user_type: Int
)