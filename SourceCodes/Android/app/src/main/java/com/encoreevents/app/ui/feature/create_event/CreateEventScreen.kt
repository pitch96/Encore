package com.encoreevents.app.ui.feature.create_event

import android.annotation.SuppressLint
import android.content.Context
import android.net.Uri
import androidx.activity.compose.rememberLauncherForActivityResult
import androidx.activity.result.PickVisualMediaRequest
import androidx.activity.result.contract.ActivityResultContracts
import androidx.compose.foundation.background
import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.Spacer
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.height
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.text.KeyboardActions
import androidx.compose.foundation.text.KeyboardOptions
import androidx.compose.foundation.verticalScroll
import androidx.compose.material.DropdownMenuItem
import androidx.compose.material.ExperimentalMaterialApi
import androidx.compose.material.ExposedDropdownMenuBox
import androidx.compose.material.Icon
import androidx.compose.material.Text
import androidx.compose.material3.AlertDialog
import androidx.compose.material3.TextButton
import androidx.compose.runtime.Composable
import androidx.compose.runtime.getValue
import androidx.compose.runtime.livedata.observeAsState
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.remember
import androidx.compose.runtime.setValue
import androidx.compose.ui.Alignment
import androidx.compose.ui.ExperimentalComposeUiApi
import androidx.compose.ui.Modifier
import androidx.compose.ui.focus.FocusDirection
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.layout.ContentScale
import androidx.compose.ui.platform.LocalContext
import androidx.compose.ui.platform.LocalFocusManager
import androidx.compose.ui.res.painterResource
import androidx.compose.ui.res.stringResource
import androidx.compose.ui.text.TextStyle
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.text.input.ImeAction
import androidx.compose.ui.text.input.KeyboardCapitalization
import androidx.compose.ui.text.input.KeyboardType
import androidx.compose.ui.text.style.TextAlign
import androidx.compose.ui.unit.Dp
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.hilt.navigation.compose.hiltViewModel
import androidx.navigation.NavHostController
import coil.compose.AsyncImage
import com.encoreevents.app.R
import com.encoreevents.app.data.model.response.ApiResponse
import com.encoreevents.app.data.model.response.categories.CategoriesData
import com.encoreevents.app.ui.components.BlackText
import com.encoreevents.app.ui.components.CustomTextField
import com.encoreevents.app.ui.components.GradientButton
import com.encoreevents.app.ui.components.LoadingDialog
import com.encoreevents.app.ui.components.ScreenTopBar
import com.encoreevents.app.ui.feature.dashboard.DashboardViewModel
import com.encoreevents.app.ui.theme.Orange
import com.encoreevents.app.ui.theme.ScreenBackground
import com.encoreevents.app.utils.Utils.Companion.pickDate
import com.encoreevents.app.utils.Utils.Companion.pickTime
import com.encoreevents.app.utils.Utils.Companion.showShortToast

@Composable
fun CreateEventScreen(
    navController: NavHostController,
    mViewModel: CreateEventViewModel = hiltViewModel()
) {
    Box(
        modifier = Modifier
            .fillMaxSize()
            .background(ScreenBackground)
    ) {
        Column(
            modifier = Modifier
                .fillMaxSize()
        ) {
            // Screen Top Navigation Bar
            ScreenTopBar(title = "Create Event", navController = navController)

            Column(
                modifier = Modifier
                    .fillMaxSize()
                    .verticalScroll(rememberScrollState())
                    .padding(horizontal = 16.dp),
                horizontalAlignment = Alignment.CenterHorizontally
            ) {
                Spacer(modifier = Modifier.height(18.dp))

                CreateEventForm(navController, mViewModel = mViewModel)

                Spacer(modifier = Modifier.height(30.dp))
            }
        }
    }
}

@SuppressLint("UnrememberedMutableState")
@OptIn(ExperimentalComposeUiApi::class, ExperimentalMaterialApi::class)
@Composable
fun CreateEventForm(
    navController: NavHostController,
    mViewModel: CreateEventViewModel,
    mDashboardViewModel: DashboardViewModel = hiltViewModel(),
    ctx: Context = LocalContext.current
) {
    var showLoadingDialog by remember { mutableStateOf(true) }
    val mCategoriesApiResponse = mDashboardViewModel.categoriesApiResponse.observeAsState().value
    var mCategories: List<CategoriesData> = remember {
        mutableListOf()
    }
    var eventImageUri by remember {
        mutableStateOf<Uri?>(null)
    }
    var expanded by remember { mutableStateOf(false) }
    val mCreateEventApiResponse = mViewModel.createEventApiResponse.observeAsState().value

    val pickEventImageFromGalleryLauncher = rememberLauncherForActivityResult(
        contract = ActivityResultContracts.PickVisualMedia(),
        onResult = { uri -> eventImageUri = uri }
    )

    when (mCategoriesApiResponse) {
        is ApiResponse.Loading -> {
            if (showLoadingDialog) {
                LoadingDialog()
            }
        }

        is ApiResponse.Success -> {
            showLoadingDialog = false
            mCategoriesApiResponse.data?.let {
                if (it.success) {
                    mCategories = it.data
                }
            }
        }

        is ApiResponse.Error -> {
            showLoadingDialog = true
            showShortToast(ctx, mCategoriesApiResponse.errorMessage.toString())
        }

        else -> {
            showLoadingDialog = true
        }
    }

    when (mCreateEventApiResponse) {
        is ApiResponse.Loading -> {
            if (showLoadingDialog) {
                LoadingDialog()
            }
        }

        is ApiResponse.Success -> {
            showLoadingDialog = false
            if (mViewModel.mEventCreatedSuccessDialog.value) {
                AlertDialog(
                    onDismissRequest = { mViewModel.mEventCreatedSuccessDialog.value = true },
                    title = {
                        BlackText(text = "Event Created")
                    },
                    text = {
                        BlackText(text = "${mViewModel.eventTitle.value} was created successfully.")
                    },
                    confirmButton = {
                        TextButton(onClick = {
                            mViewModel.mEventCreatedSuccessDialog.value = false
                            navController.popBackStack()
                        }) {
                            BlackText(text = "Ok")
                        }
                    }
                )
            }
        }

        is ApiResponse.Error -> {
            showLoadingDialog = true
            showShortToast(ctx, mCreateEventApiResponse.errorMessage.toString())
        }

        else -> {
            showLoadingDialog = true
        }
    }

    Column {
        val focusManager = LocalFocusManager.current

        EventHeadingText(stringResource(R.string.event_details))

        SubHeadingText(stringResource(R.string.title))
        CustomTextField(
            value = mViewModel.eventTitle,
            keyboardOptions = KeyboardOptions(
                imeAction = ImeAction.Next, capitalization = KeyboardCapitalization.Words
            ),
            keyboardActions = KeyboardActions(onNext = {
                focusManager.moveFocus(FocusDirection.Down)
            }),
            placeholder = "Event Title"
        )

        SubHeadingText(stringResource(R.string.choose_category))
        ExposedDropdownMenuBox(expanded = expanded, onExpandedChange = { expanded = !expanded }) {
            CustomTextField(
                value = mViewModel.eventCategory,
                placeholder = "Choose Category",
                spaceBottom = 10.dp,
                readOnly = true,
                enabled = false,
                trailingIcon = {
                    Icon(
                        painter = painterResource(id = com.google.android.material.R.drawable.mtrl_ic_arrow_drop_down),
                        contentDescription = "Calender Icon",
                        tint = Color.Black
                    )
                }
            )
            ExposedDropdownMenu(
                expanded = expanded,
                onDismissRequest = {
                    expanded = false
                }
            ) {
                mCategories.forEach { selectionOption ->
                    DropdownMenuItem(
                        onClick = {
                            mViewModel.eventCategory.value = selectionOption.name
                            mViewModel.eventCategoryId.value = selectionOption.id
                            expanded = false
                        }
                    ) {
                        Text(text = selectionOption.name)
                    }
                }
            }
        }

        SubHeadingText(stringResource(R.string.organizer))
        CustomTextField(
            value = mViewModel.organizer,
            placeholder = "Organizer",
            keyboardOptions = KeyboardOptions(
                imeAction = ImeAction.Next, capitalization = KeyboardCapitalization.Words
            ),
            keyboardActions = KeyboardActions(onNext = {
                focusManager.moveFocus(FocusDirection.Down)
            }),
            spaceBottom = 10.dp
        )

        EventHeadingText(stringResource(R.string.date_time))

        SubHeadingText(stringResource(R.string.start_date))
        CustomTextField(
            value = mViewModel.startDate,
            placeholder = "Start Date",
            enabled = false,
            modifier = Modifier.clickable {
                pickDate(mViewModel.startDate, ctx)
            },
            trailingIcon = {
                Icon(
                    painter = painterResource(id = R.drawable.ic_calendar),
                    contentDescription = "Calender Icon",
                    tint = Color.Black
                )
            })

        SubHeadingText(stringResource(R.string.end_date))
        CustomTextField(
            value = mViewModel.endDate,
            placeholder = "End Date",
            enabled = false,
            modifier = Modifier.clickable {
                pickDate(mViewModel.endDate, ctx)
            },
            trailingIcon = {
                Icon(
                    painter = painterResource(id = R.drawable.ic_calendar),
                    contentDescription = "Calender Icon",
                    tint = Color.Black
                )
            })
        SubHeadingText(stringResource(R.string.start_time))
        CustomTextField(
            value = mViewModel.startTime,
            placeholder = "Start Time",
            enabled = false,
            modifier = Modifier.clickable {
                pickTime(mViewModel.startTime, ctx)
            },
            trailingIcon = {
                Icon(
                    painter = painterResource(id = com.google.android.material.R.drawable.ic_clock_black_24dp),
                    contentDescription = "Calender Icon",
                    tint = Color.Black
                )
            })

        SubHeadingText(stringResource(R.string.end_time))
        CustomTextField(
            value = mViewModel.endTime,
            placeholder = "End Time",
            enabled = false,
            modifier = Modifier.clickable {
                pickTime(mViewModel.endTime, ctx)
            },
            trailingIcon = {
                Icon(
                    painter = painterResource(id = com.google.android.material.R.drawable.ic_clock_black_24dp),
                    contentDescription = "Calender Icon",
                    tint = Color.Black
                )
            }, spaceBottom = 10.dp
        )

        EventHeadingText(stringResource(R.string.event_image))
        SubHeadingText(stringResource(R.string.upload_image))
        CustomTextField(
            value = mutableStateOf(""),
            placeholder = "Choose Image",
            spaceBottom = 10.dp,
            enabled = false,
            modifier = Modifier.clickable {
                pickEventImageFromGalleryLauncher.launch(
                    PickVisualMediaRequest(ActivityResultContracts.PickVisualMedia.ImageOnly)
                )
            }
        )
        eventImageUri.let {
            if (it != null) {
                AsyncImage(
                    model = it,
                    contentDescription = "Event Image",
                    modifier = Modifier
                        .height(180.dp)
                        .fillMaxWidth(),
                    contentScale = ContentScale.Crop
                )
            }
        }

        EventHeadingText("Location")
        SubHeadingText("Venue")
        CustomTextField(
            value = mViewModel.venue,
            keyboardOptions = KeyboardOptions(
                imeAction = ImeAction.Next, capitalization = KeyboardCapitalization.Words
            ),
            keyboardActions = KeyboardActions(onNext = {
                focusManager.moveFocus(FocusDirection.Down)
            }),
            placeholder = "Venue"
        )
        SubHeadingText("Address")
        CustomTextField(
            value = mViewModel.address,
            keyboardOptions = KeyboardOptions(
                imeAction = ImeAction.Next, capitalization = KeyboardCapitalization.Words
            ),
            keyboardActions = KeyboardActions(onNext = {
                focusManager.moveFocus(FocusDirection.Down)
            }), placeholder = "Address"
        )
        SubHeadingText("City")
        CustomTextField(
            value = mViewModel.city,
            keyboardOptions = KeyboardOptions(
                imeAction = ImeAction.Next, capitalization = KeyboardCapitalization.Words
            ),
            keyboardActions = KeyboardActions(onNext = {
                focusManager.moveFocus(FocusDirection.Down)
            }), placeholder = "City"
        )
        SubHeadingText("Zip Code")
        CustomTextField(
            value = mViewModel.zipCode,
            keyboardOptions = KeyboardOptions(
                imeAction = ImeAction.Next, keyboardType = KeyboardType.Number
            ),
            keyboardActions = KeyboardActions(onNext = {
                focusManager.moveFocus(FocusDirection.Down)
            }), placeholder = "Zip Code", spaceBottom = 10.dp
        )

        EventHeadingText("Event Description")
        SubHeadingText("Description")
        CustomTextField(
            value = mViewModel.description,
            placeholder = "Description",
            minLines = 5,
            singleLine = false,
            maxLines = 5
        )

        GradientButton(text = "Save Event", spaceTop = 20.dp) {
            mViewModel.createEvent(ctx, eventImageUri)
        }
    }
}

@Composable
fun SubHeadingText(text: String) {
    Text(
        text = text,
        modifier = Modifier.padding(start = 5.dp, top = 8.dp, bottom = 3.dp),
        color = Color.White,
    )
}

@Composable
fun EventHeadingText(
    text: String,
    spaceTop: Dp = 10.dp,
    spaceBottom: Dp = 0.dp
) {
    Spacer(modifier = Modifier.height(spaceTop))

    Text(
        text = text,
        modifier = Modifier.padding(start = 5.dp),
        style = TextStyle(
            textAlign = TextAlign.Start,
            fontSize = 18.sp,
            fontWeight = FontWeight.Normal
        ),
        color = Orange
    )

    Spacer(modifier = Modifier.height(spaceBottom))
}