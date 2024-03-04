package com.encoreevents.app.data.model.request

data class Register(
    val user_type: Int,
    val first_name: String,
    val last_name: String,
    val email: String,
    val phone_no: String,
    val company_name: String,
    val password: String,
    val password_confirmation: String
)