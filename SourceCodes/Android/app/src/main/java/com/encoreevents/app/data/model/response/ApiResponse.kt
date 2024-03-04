package com.encoreevents.app.data.model.response

sealed class ApiResponse<T>(val data: T? = null, val errorMessage: String? = null) {
    class Loading<T>: ApiResponse<T>()
    class Success<T>(data: T? = null): ApiResponse<T>(data = data)
    class Error<T>(errorMessage: String? = null): ApiResponse<T>(errorMessage = errorMessage)
}
