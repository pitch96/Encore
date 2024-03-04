package com.encoreevents.app.ui.feature.forgot_password

import android.content.Context
import androidx.compose.foundation.Image
import androidx.compose.foundation.background
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.Spacer
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.height
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.text.KeyboardOptions
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.ArrowBack
import androidx.compose.material.icons.rounded.Email
import androidx.compose.material3.AlertDialog
import androidx.compose.material3.Icon
import androidx.compose.material3.IconButton
import androidx.compose.material3.Text
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
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.platform.LocalContext
import androidx.compose.ui.res.painterResource
import androidx.compose.ui.text.TextStyle
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.text.input.KeyboardType
import androidx.compose.ui.tooling.preview.Preview
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavHostController
import androidx.navigation.compose.rememberNavController
import com.encoreevents.app.R
import com.encoreevents.app.ui.components.BlackText
import com.encoreevents.app.ui.components.CustomTextField
import com.encoreevents.app.ui.components.GradientButton
import com.encoreevents.app.ui.components.LoadingDialog
import com.encoreevents.app.ui.theme.Orange
import com.encoreevents.app.ui.theme.ScreenBackground
import com.encoreevents.app.utils.Utils

@OptIn(ExperimentalComposeUiApi::class)
@Composable
fun ForgotPasswordScreen(
    navController: NavHostController,
    ctx: Context = LocalContext.current,
    mViewModel: ForgotPasswordViewModel = viewModel(),
    onNavigationRequested: (userEmailId: String) -> Unit
) {
    val openDialog = remember {
        mutableStateOf(true)
    }
    var showLoadingDialog by remember { mutableStateOf(true) }

    when (val mForgotPasswordApiResponse =
        mViewModel.forgotPasswordApiResponse.observeAsState().value) {
        is com.encoreevents.app.data.model.response.ApiResponse.Loading -> {
            if (showLoadingDialog) {
                LoadingDialog()
            }
        }

        is com.encoreevents.app.data.model.response.ApiResponse.Success -> {
            showLoadingDialog = false
            if (openDialog.value) {
                AlertDialog(
                    onDismissRequest = { openDialog.value = true },
                    title = {
                        BlackText(text = "OTP Sent")
                    },
                    text = {
                        BlackText(text = "OTP has been sent to your email id.")
                    },
                    confirmButton = {
                        TextButton(onClick = {
                            openDialog.value = false
                            onNavigationRequested(mViewModel.mEmail.value)
                        }) {
                            BlackText(text = "Ok")
                        }
                    }
                )
            }
        }

        is com.encoreevents.app.data.model.response.ApiResponse.Error -> {
            showLoadingDialog = true
            Utils.showShortToast(ctx, mForgotPasswordApiResponse.errorMessage.toString())
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
                .fillMaxSize()
                .padding(12.dp)
        ) {
            IconButton(onClick = { navController.popBackStack() }) {
                Icon(
                    imageVector = Icons.Default.ArrowBack,
                    contentDescription = "Back button",
                    tint = Orange
                )
            }
            Column(
                modifier = Modifier
                    .fillMaxSize()
                    .padding(14.dp),
                horizontalAlignment = Alignment.CenterHorizontally
            ) {
                Spacer(modifier = Modifier.height(18.dp))
                Image(
                    painter = painterResource(id = R.drawable.ic_encore_events),
                    contentDescription = "logo"
                )
                Spacer(modifier = Modifier.height(38.dp))
                Text(
                    text = "Forgot Password",
                    style = TextStyle(fontSize = 32.sp, fontWeight = FontWeight.Bold),
                    color = Orange
                )
                Spacer(modifier = Modifier.height(52.dp))

                CustomTextField(
                    value = mViewModel.mEmail,
                    placeholder = "Enter your Email Id",
                    keyboardOptions = KeyboardOptions(
                        keyboardType = KeyboardType.Email
                    ),
                    leadingIcon = {
                        Icon(imageVector = Icons.Rounded.Email, contentDescription = "Email Icon",
                            tint = Color.Black
                        )
                    },
                    modifier = Modifier.height(50.dp)
                )
                Spacer(modifier = Modifier.height(30.dp))

                GradientButton(text = "Confirm", onClick = {
                    mViewModel.forgotPassword(ctx)
                })
            }
        }
    }
}

@Preview
@Composable
fun PreviewForgotPassword() {
    ForgotPasswordScreen(navController = rememberNavController(), onNavigationRequested = {})
}