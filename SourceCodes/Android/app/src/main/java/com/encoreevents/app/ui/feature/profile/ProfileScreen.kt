package com.encoreevents.app.ui.feature.profile

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
import androidx.compose.foundation.shape.CircleShape
import androidx.compose.foundation.verticalScroll
import androidx.compose.material3.AlertDialog
import androidx.compose.material3.TextButton
import androidx.compose.runtime.Composable
import androidx.compose.runtime.LaunchedEffect
import androidx.compose.runtime.getValue
import androidx.compose.runtime.livedata.observeAsState
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.remember
import androidx.compose.runtime.setValue
import androidx.compose.ui.Alignment
import androidx.compose.ui.ExperimentalComposeUiApi
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.layout.ContentScale
import androidx.compose.ui.platform.LocalContext
import androidx.compose.ui.unit.dp
import androidx.hilt.navigation.compose.hiltViewModel
import coil.compose.AsyncImage
import com.encoreevents.app.data.model.response.ApiResponse
import com.encoreevents.app.ui.components.BlackText
import com.encoreevents.app.ui.components.CircularImageContainer
import com.encoreevents.app.ui.components.CustomTextField
import com.encoreevents.app.ui.components.GradientButton
import com.encoreevents.app.ui.components.LoadingDialog
import com.encoreevents.app.ui.components.ScreenTopBar
import com.encoreevents.app.ui.components.SubHeadingText
import com.encoreevents.app.ui.feature.dashboard.DashboardViewModel
import com.encoreevents.app.ui.theme.ScreenBackground
import com.encoreevents.app.utils.Utils

@OptIn(ExperimentalComposeUiApi::class)
@Composable
fun ProfileScreen(
    mViewModel: UpdateProfileViewModel = hiltViewModel(),
    dashViewModel: DashboardViewModel = hiltViewModel(),
    ctx: Context = LocalContext.current
) {
    var showLoadingDialog by remember { mutableStateOf(true) }
    LaunchedEffect(Unit) {
        mViewModel.getProfileData(dashViewModel)
    }
    var profileImageUri by remember {
        mutableStateOf<Uri?>(null)
    }
    val mUpdateProfApiResponse = mViewModel.updateProfileApiResponse.observeAsState().value

    val pickEventImageFromGalleryLauncher = rememberLauncherForActivityResult(
        contract = ActivityResultContracts.PickVisualMedia(),
        onResult = { uri ->
            if (uri != null) {
                profileImageUri = uri
                mViewModel.mProfileImageModel.value = uri.toString()
            }
        }
    )

    when (mUpdateProfApiResponse) {
        is ApiResponse.Loading -> {
            if (showLoadingDialog) {
                LoadingDialog()
            }
        }

        is ApiResponse.Success -> {
            showLoadingDialog = false
            mViewModel.saveUserData(dashViewModel)
            if (mViewModel.mUpdateProfileSuccessDialog.value) {
                AlertDialog(
                    onDismissRequest = { mViewModel.mUpdateProfileSuccessDialog.value = true },
                    title = {
                        BlackText(text = "Profile Updated")
                    },
                    text = {
                        BlackText(text = "Your profile data was updated.")
                    },
                    confirmButton = {
                        TextButton(onClick = {
                            mViewModel.mUpdateProfileSuccessDialog.value = false
                        }) {
                            BlackText(text = "Ok")
                        }
                    }
                )
            }
        }

        is ApiResponse.Error -> {
            showLoadingDialog = true
            Utils.showShortToast(ctx, mUpdateProfApiResponse.errorMessage.toString())
        }

        else -> {
            showLoadingDialog = true
        }
    }

    Box(
        modifier = Modifier
            .fillMaxSize()
            .background(ScreenBackground)
    ) {

        Column(
            modifier = Modifier
                .background(ScreenBackground)
                .padding(16.dp)
                .verticalScroll(rememberScrollState())
        ) {

            ScreenTopBar(title = "Account Information", navController = null)
            Spacer(modifier = Modifier.height(12.dp))

            Box(contentAlignment = Alignment.Center, modifier = Modifier.fillMaxWidth()) {
                CircularImageContainer {
                    AsyncImage(
                        model = mViewModel.mProfileImageModel.value,
                        contentDescription = "User Image",
                        modifier = Modifier
                            .clip(shape = CircleShape)
                            .fillMaxSize()
                            .clickable {
                                pickEventImageFromGalleryLauncher.launch(
                                    PickVisualMediaRequest(ActivityResultContracts.PickVisualMedia.ImageOnly)
                                )
                            },
                        contentScale = ContentScale.Crop
                    )
                }
            }
            Spacer(modifier = Modifier.height(18.dp))
            SubHeadingText("First Name")
            CustomTextField(value = mViewModel.mFirstName, placeholder = "Enter First Name")

            Spacer(modifier = Modifier.height(10.dp))

            SubHeadingText("Last Name")
            CustomTextField(value = mViewModel.mLastName, placeholder = "Enter Last Name")
            Spacer(modifier = Modifier.height(10.dp))

            SubHeadingText("Email")
            CustomTextField(
                value = mViewModel.mEmail,
                placeholder = "Enter Email Address",
                readOnly = true,
                enabled = false
            )
            Spacer(modifier = Modifier.height(10.dp))

            SubHeadingText("Company Name")
            CustomTextField(value = mViewModel.mCompanyName, placeholder = "Enter Company Name")
            Spacer(modifier = Modifier.height(10.dp))

            SubHeadingText("Contact Number")
            CustomTextField(value = mViewModel.mPhone, placeholder = "Enter Contact Number")
            Spacer(modifier = Modifier.height(20.dp))

            GradientButton("Update") {
                mViewModel.updateUserProfile(ctx, profileImageUri)
            }

            Spacer(modifier = Modifier.height(60.dp))
        }
    }
}