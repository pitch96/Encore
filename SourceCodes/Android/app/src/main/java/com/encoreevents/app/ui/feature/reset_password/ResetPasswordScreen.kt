package com.encoreevents.app.ui.feature.reset_password

import android.content.Context
import androidx.compose.foundation.Image
import androidx.compose.foundation.background
import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.Spacer
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.height
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.layout.size
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.text.KeyboardActions
import androidx.compose.foundation.text.KeyboardOptions
import androidx.compose.foundation.verticalScroll
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.rounded.Lock
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
import androidx.compose.ui.focus.FocusDirection
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.graphics.Color.Companion.Black
import androidx.compose.ui.platform.LocalContext
import androidx.compose.ui.platform.LocalFocusManager
import androidx.compose.ui.res.painterResource
import androidx.compose.ui.text.TextStyle
import androidx.compose.ui.text.input.ImeAction
import androidx.compose.ui.text.input.KeyboardType
import androidx.compose.ui.text.input.PasswordVisualTransformation
import androidx.compose.ui.text.input.VisualTransformation
import androidx.compose.ui.tooling.preview.Preview
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavHostController
import androidx.navigation.compose.rememberNavController
import com.encoreevents.app.R
import com.encoreevents.app.ui.components.BackButton
import com.encoreevents.app.ui.components.BlackText
import com.encoreevents.app.ui.components.CustomTextField
import com.encoreevents.app.ui.components.GradientButton
import com.encoreevents.app.ui.components.LoadingDialog
import com.encoreevents.app.ui.components.TitleText
import com.encoreevents.app.ui.theme.ScreenBackground
import com.encoreevents.app.ui.theme.TextButton
import com.encoreevents.app.utils.Utils.Companion.showShortToast

@Composable
fun ResetPasswordScreen(
    navController: NavHostController,
    mViewModel: ResetPasswordViewModel = viewModel(),
    userEmailId: String?
) {
    if (userEmailId == null) {
        navController.popBackStack()
    } else mViewModel.mEmail.value = userEmailId

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
            BackButton(navController = navController)
            Column(
                modifier = Modifier
                    .fillMaxSize()
                    .verticalScroll(rememberScrollState())
                    .padding(horizontal = 14.dp),
                horizontalAlignment = Alignment.CenterHorizontally
            ) {
                Spacer(modifier = Modifier.height(18.dp))
                Image(
                    painter = painterResource(id = R.drawable.ic_encore_events),
                    contentDescription = "logo"
                )
                Spacer(modifier = Modifier.height(38.dp))

                TitleText("Reset Password", modifier = Modifier.fillMaxWidth())

                Spacer(modifier = Modifier.height(12.dp))
                Text(
                    text = "Enter the otp received on your email or phone",
                    style = TextStyle(fontSize = 12.sp, color = Color.White)
                )
                Spacer(modifier = Modifier.height(30.dp))
                Text(
                    text = "If you still not received OTP Please click on Resend OTP",
                    style = TextStyle(fontSize = 12.sp, color = Color.White)
                )
                Spacer(modifier = Modifier.height(30.dp))

                ResetPasswordForm(navController, mViewModel = mViewModel)

                Spacer(modifier = Modifier.height(30.dp))
            }
        }
    }

}

@OptIn(ExperimentalComposeUiApi::class)
@Composable
fun ResetPasswordForm(
    navController: NavHostController,
    ctx: Context = LocalContext.current,
    mViewModel: ResetPasswordViewModel = viewModel()
) {
    val passwordVisible = remember {
        mutableStateOf(false)
    }
    val confirmPasswordVisible = remember {
        mutableStateOf(false)
    }
    var showLoadingDialog by remember { mutableStateOf(true) }
    val focusManager = LocalFocusManager.current
    val mResetPasswordApiResponse = mViewModel.resetPasswordApiResponse.observeAsState().value
    val mResendOtpApiResponse = mViewModel.resendOtpApiResponse.observeAsState().value

    when (mResetPasswordApiResponse) {
        is com.encoreevents.app.data.model.response.ApiResponse.Loading -> {
            if (showLoadingDialog) {
                LoadingDialog()
            }
        }

        is com.encoreevents.app.data.model.response.ApiResponse.Success -> {
            showLoadingDialog = false
            if (mViewModel.mResetPasswordSuccessDialog.value) {
                AlertDialog(
                    onDismissRequest = { mViewModel.mResetPasswordSuccessDialog.value = true },
                    title = {
                        BlackText(text = "Password Reset Successful")
                    },
                    text = {
                        BlackText(text = "You have successfully reset your password. Please login to continue.")
                    },
                    confirmButton = {
                        TextButton(onClick = {
                            mViewModel.mResetPasswordSuccessDialog.value = false
                            navController.popBackStack()
                        }) {
                            BlackText(text = "Ok")
                        }
                    }
                )
            }
        }

        is com.encoreevents.app.data.model.response.ApiResponse.Error -> {
            showLoadingDialog = true
            showShortToast(ctx, mResetPasswordApiResponse.errorMessage.toString())
        }

        else -> {
            showLoadingDialog = true
        }
    }

    when (mResendOtpApiResponse) {
        is com.encoreevents.app.data.model.response.ApiResponse.Loading -> {
            if (showLoadingDialog) {
                LoadingDialog()
            }
        }

        is com.encoreevents.app.data.model.response.ApiResponse.Success -> {
            showLoadingDialog = false
            if (mViewModel.mResendOtpSuccessDialog.value) {
                AlertDialog(
                    onDismissRequest = { mViewModel.mResendOtpSuccessDialog.value = true },
                    title = {
                        BlackText(text = "OTP Sent")
                    },
                    text = {
                        BlackText(text = "OTP has been sent to your email id.")
                    },
                    confirmButton = {
                        TextButton(onClick = {
                            mViewModel.mResendOtpSuccessDialog.value = false
//                            navController.popBackStack()
                        }) {
                            BlackText(text = "Ok")
                        }
                    }
                )
            }
        }

        is com.encoreevents.app.data.model.response.ApiResponse.Error -> {
            showLoadingDialog = true
            showShortToast(ctx, mResendOtpApiResponse.errorMessage.toString())
        }

        else -> {
            showLoadingDialog = true
        }
    }

    // OTP text field
    CustomTextField(
        value = mViewModel.mOTP,
        placeholder = "OTP*",
        keyboardOptions = KeyboardOptions(
            imeAction = ImeAction.Next, keyboardType = KeyboardType.Phone
        ),
        keyboardActions = KeyboardActions(onNext = {
            focusManager.moveFocus(FocusDirection.Down)
        }),
        leadingIcon = {
            Icon(
                painter = painterResource(R.drawable.ic_otp), contentDescription = "Otp Icon",
                tint = Black
            )
        },
        trailingIcon = {
            Text(
                text = "Resend",
                modifier = Modifier.clickable { mViewModel.resendOtp() },
                color = TextButton
            )
        }
    )
    Spacer(modifier = Modifier.height(18.dp))

    // Password Text Field
    CustomTextField(
        value = mViewModel.mPassword,
        placeholder = "Password*",
        leadingIcon = {
            Icon(
                imageVector = Icons.Rounded.Lock, contentDescription = "Lock Icon",
                tint = Black
            )
        },
        keyboardOptions = KeyboardOptions(
            imeAction = ImeAction.Next, keyboardType = KeyboardType.Password
        ),
        keyboardActions = KeyboardActions(onNext = {
            focusManager.moveFocus(FocusDirection.Down)
        }),
        visualTransformation = if (passwordVisible.value) VisualTransformation.None else PasswordVisualTransformation(),
        trailingIcon = {
            if (passwordVisible.value) {
                IconButton(
                    modifier = Modifier.then(Modifier.size(24.dp)),
                    onClick = { passwordVisible.value = false }) {
                    Icon(
                        painter = painterResource(id = R.drawable.ic_visibility_on),
                        contentDescription = "Visibility off icon",
                        tint = Black
                    )
                }
            } else {
                IconButton(
                    modifier = Modifier.then(Modifier.size(24.dp)),
                    onClick = { passwordVisible.value = true }) {
                    Icon(
                        painter = painterResource(id = R.drawable.ic_visibility_off),
                        contentDescription = "Visibility off icon",
                        tint = Black
                    )
                }
            }
        }
    )
    Spacer(modifier = Modifier.height(18.dp))

    // Confirm Password Text Field
    CustomTextField(
        value = mViewModel.mConfirmPassword,
        placeholder = "Confirm Password*",
        leadingIcon = {
            Icon(
                imageVector = Icons.Rounded.Lock, contentDescription = "Lock Icon",
                tint = Black
            )
        },
        keyboardOptions = KeyboardOptions(
            keyboardType = KeyboardType.Password
        ),
        visualTransformation = if (confirmPasswordVisible.value) VisualTransformation.None else PasswordVisualTransformation(),
        trailingIcon = {
            if (confirmPasswordVisible.value) {
                IconButton(
                    modifier = Modifier.then(Modifier.size(24.dp)),
                    onClick = { confirmPasswordVisible.value = false }) {
                    Icon(
                        painter = painterResource(id = R.drawable.ic_visibility_on),
                        contentDescription = "Visibility off icon",
                        tint = Black
                    )
                }
            } else {
                IconButton(
                    modifier = Modifier.then(Modifier.size(24.dp)),
                    onClick = { confirmPasswordVisible.value = true }) {
                    Icon(
                        painter = painterResource(id = R.drawable.ic_visibility_off),
                        contentDescription = "Visibility off icon",
                        tint = Black
                    )
                }
            }
        }
    )
    Spacer(modifier = Modifier.height(30.dp))

    GradientButton(text = "Continue", onClick = {
        mViewModel.resetPassword(ctx)
    })
}

@Preview
@Composable
fun PreviewResetPasswordScreen() {
    ResetPasswordScreen(navController = rememberNavController(), userEmailId = "userEmailId")
}
