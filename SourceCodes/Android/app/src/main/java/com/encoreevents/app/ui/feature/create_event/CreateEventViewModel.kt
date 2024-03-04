package com.encoreevents.app.ui.feature.create_event

import android.content.Context
import android.net.Uri
import android.util.Log
import androidx.compose.runtime.MutableState
import androidx.compose.runtime.mutableStateOf
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.encoreevents.app.data.model.response.ApiResponse
import com.encoreevents.app.data.model.response.create_event.CreateEventResponse
import com.encoreevents.app.data.repository.ApiRepository
import com.encoreevents.app.utils.Utils
import com.encoreevents.app.utils.Utils.Companion.getRequestBody
import dagger.hilt.android.lifecycle.HiltViewModel
import dagger.hilt.android.qualifiers.ApplicationContext
import kotlinx.coroutines.flow.catch
import kotlinx.coroutines.launch
import okhttp3.MediaType.Companion.toMediaTypeOrNull
import okhttp3.MultipartBody
import okhttp3.RequestBody.Companion.asRequestBody
import java.io.File
import java.io.FileOutputStream
import javax.inject.Inject

private const val TAG = "CreateEventViewModel"

@HiltViewModel
class CreateEventViewModel @Inject constructor(
    @ApplicationContext private val context: Context,
    private val apiRepository: ApiRepository
) :
    ViewModel() {
    private val _eventImage = mutableStateOf<MultipartBody.Part?>(null)

    //    private val _eventImageUri = mutableStateOf<Uri?>(null)
//    val eventImageUri = _eventImageUri
    private val _eventTitle = mutableStateOf("")
    val eventTitle = _eventTitle
    private val _eventCategory = mutableStateOf("")
    val eventCategory = _eventCategory
    private val _eventCategoryId = mutableStateOf(0)
    val eventCategoryId = _eventCategoryId
    private val _organizer = mutableStateOf("")
    val organizer = _organizer
    private val _startDate = mutableStateOf("")
    val startDate = _startDate
    private val _endDate = mutableStateOf("")
    val endDate = _endDate
    private val _startTime = mutableStateOf("")
    val startTime = _startTime
    private val _endTime = mutableStateOf("")
    val endTime = _endTime
    private val _venue = mutableStateOf("")
    val venue = _venue
    private val _address = mutableStateOf("")
    val address = _address
    private val _city = mutableStateOf("")
    val city = _city
    private val _zipCode = mutableStateOf("")
    val zipCode = _zipCode
    private val _description = mutableStateOf("")
    val description = _description

    val mEventCreatedSuccessDialog: MutableState<Boolean> = apiRepository.mEventCreatedSuccessDialog
    private val _createEventResult = mutableStateOf("")
    private val _createEventApiResponse = MutableLiveData<ApiResponse<CreateEventResponse>>()
    val createEventApiResponse = _createEventApiResponse

    /**
     *  @description : This method is used to create event.
     * */
    fun createEvent(
        ctx: Context,
        eventImageUri: Uri?
    ) {
        eventImageUri?.let { imgUri ->
            val file = File(context.filesDir, "event_image")

            val inputStream = context.contentResolver.openInputStream(imgUri)
            val outputStream = FileOutputStream(file)
            if (inputStream != null) {
                inputStream.copyTo(outputStream)
                inputStream.close()
            }

            val requestBody = file.asRequestBody("image/*".toMediaTypeOrNull())
            _eventImage.value = MultipartBody.Part.createFormData("image", file.name, requestBody)
        }

        if (createEventValidation()) {
            viewModelScope.launch {
                apiRepository.createEvent(
                    image = _eventImage.value,
                    category_id = getRequestBody(_eventCategoryId.value.toString()),
                    event_title = getRequestBody(_eventTitle.value.trim()),
                    organizer = getRequestBody(_organizer.value.trim()),
                    venue = getRequestBody(_venue.value.trim()),
                    address = getRequestBody(_address.value.trim()),
                    city = getRequestBody(_city.value.trim()),
                    zipcode = getRequestBody(_zipCode.value.trim()),
                    start_date = getRequestBody(_startDate.value.trim()),
                    end_date = getRequestBody(_endDate.value.trim()),
                    start_time = getRequestBody(_startTime.value.trim()),
                    end_time = getRequestBody(_endTime.value.trim()),
                    description = getRequestBody(_description.value.trim())
                ).catch { e ->
                    Log.e(TAG, "createEvent: ${e.message}")
                }.collect {
                    _createEventApiResponse.postValue(it)
                }
            }
        } else Utils.showShortToast(ctx, _createEventResult.value)
    }

    /**
     *  @user: Chetu
     *  @param : Event name
     *  @return : This method is used to return true if all create event fields are valid otherwise return false.
     *  @description : This method is used to validate create event fields.
     */
    private fun createEventValidation(): Boolean {
        return when {

            // Event Title check
            _eventTitle.value.isEmpty() -> {
                _createEventResult.value = "Event Title is required"
                false
            }

            // Event Category check
            _eventCategory.value.isEmpty() -> {
                _createEventResult.value = "Choose Category"
                false
            }

            _organizer.value.isEmpty() -> {
                _createEventResult.value = "Organizer is required"
                false
            }

            // Start Date check
            _startDate.value.isEmpty() -> {
                _createEventResult.value = "Start date is required"
                false
            }

            _endDate.value.length < 6 -> {
                _createEventResult.value = "End date is required"
                false
            }

            // Start Time check
            _startTime.value.isEmpty() -> {
                _createEventResult.value = "Start time is required"
                false
            }
            // End Time check
            _endTime.value.isEmpty() -> {
                _createEventResult.value = "End time is required"
                false
            }

            /*_eventImage.value == null -> {
                _createEventResult.value = "Image is required"
                false
            }*/

            _venue.value.isEmpty() -> {
                _createEventResult.value = "venue is required"
                false
            }

            _address.value.isEmpty() -> {
                _createEventResult.value = "address is required"
                false
            }

            _city.value.isEmpty() -> {
                _createEventResult.value = "city is required"
                false
            }

            _zipCode.value.isEmpty() -> {
                _createEventResult.value = "zipcode is required"
                false
            }

            _description.value.isEmpty() -> {
                _createEventResult.value = "description is required "
                false
            }

            else -> true
        }
    }

}