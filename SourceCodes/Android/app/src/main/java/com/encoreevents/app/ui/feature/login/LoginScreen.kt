package com.encoreevents.app.ui.feature.login

import android.content.Context
import androidx.compose.foundation.Image
import androidx.compose.foundation.background
import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.Arrangement
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
import androidx.compose.material.icons.filled.ArrowBack
import androidx.compose.material.icons.rounded.Email
import androidx.compose.material.icons.rounded.Lock
import androidx.compose.material3.Icon
import androidx.compose.material3.IconButton
import androidx.compose.material3.Text
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
import androidx.compose.ui.focus.FocusDirection
import androidx.compose.ui.graphics.Color.Companion.Black
import androidx.compose.ui.graphics.Color.Companion.White
import androidx.compose.ui.platform.LocalContext
import androidx.compose.ui.platform.LocalFocusManager
import androidx.compose.ui.res.painterResource
import androidx.compose.ui.res.stringResource
import androidx.compose.ui.text.TextStyle
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.text.input.ImeAction
import androidx.compose.ui.text.input.KeyboardType
import androidx.compose.ui.text.input.PasswordVisualTransformation
import androidx.compose.ui.text.input.VisualTransformation
import androidx.compose.ui.text.style.TextAlign
import androidx.compose.ui.tooling.preview.Preview
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavHostController
import androidx.navigation.compose.rememberNavController
import com.encoreevents.app.R
import com.encoreevents.app.data.model.response.ApiResponse
import com.encoreevents.app.nav_graphs.AuthScreen
import com.encoreevents.app.ui.components.CustomTextField
import com.encoreevents.app.ui.components.GradientButton
import com.encoreevents.app.ui.components.LoadingDialog
import com.encoreevents.app.ui.theme.Orange
import com.encoreevents.app.ui.theme.ScreenBackground
import com.encoreevents.app.utils.Utils
import com.encoreevents.app.utils.Utils.Companion.currentHour
import com.encoreevents.app.utils.Utils.Companion.currentMinute
import com.encoreevents.app.utils.Utils.Companion.showShortToast

@OptIn(ExperimentalComposeUiApi::class)
@Composable
fun LoginScreen(
    navController: NavHostController,
    ctx: Context = LocalContext.current,
    mViewModel: LoginViewModel = viewModel()
) {
    val passwordVisible = remember {
        mutableStateOf(false)
    }
    var showLoadingDialog by remember { mutableStateOf(true) }
    val focusManager = LocalFocusManager.current

    when (val mLoginApiResponse = mViewModel.loginApiResponse.observeAsState().value) {
        is ApiResponse.Loading -> {
            if (showLoadingDialog) {
                LoadingDialog()
            }
        }

        is ApiResponse.Success -> {
            showLoadingDialog = false
            mLoginApiResponse.data?.let {
                if (it.success) {
                    mViewModel.saveUserData(
                        it.token,
                        it.data.id,
                        it.data.user_type,
                        it.data.first_name,
                        it.data.last_name,
                        it.data.email,
                        it.data.phone_no,
                        it.data.company_name,
                        it.data.status,
                        Utils.USER_IMAGES_URL + it.data.user_profile,
                        "${currentHour()}:${currentMinute()}",
                        navController
                    )

                    LaunchedEffect(Unit) {
                        showShortToast(ctx, it.message)
                    }
                }
            }
        }

        is ApiResponse.Error -> {
            showLoadingDialog = true
            showShortToast(ctx, mLoginApiResponse.errorMessage.toString())
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
                    .verticalScroll(rememberScrollState())
                    .padding(32.dp),
                horizontalAlignment = Alignment.CenterHorizontally,
                verticalArrangement = Arrangement.Center
            ) {
                Image(
                    painter = painterResource(id = R.drawable.ic_encore_events),
                    contentDescription = "logo"
                )
                Spacer(modifier = Modifier.height(38.dp))
                Text(
                    text = "Welcome!",
                    style = TextStyle(fontSize = 32.sp, fontWeight = FontWeight.Bold),
                    color = Orange
                )
                Spacer(modifier = Modifier.height(12.dp))
                Text(
                    text = "Hello there login to continue",
                    style = TextStyle(fontSize = 12.sp, color = White)
                )
                Spacer(modifier = Modifier.height(30.dp))

                // Email text field
                CustomTextField(
                    value = mViewModel.mEmail,
                    placeholder = "Email",
                    keyboardOptions = KeyboardOptions(
                        imeAction = ImeAction.Next, keyboardType = KeyboardType.Email
                    ),
                    keyboardActions = KeyboardActions(onNext = {
                        focusManager.moveFocus(FocusDirection.Down)
                    }),
                    leadingIcon = {
                        Icon(
                            imageVector = Icons.Rounded.Email,
                            contentDescription = stringResource(R.string.email_icon),
                            tint = Black
                        )
                    }
                )
                Spacer(modifier = Modifier.height(32.dp))

                // Password text field
                CustomTextField(
                    value = mViewModel.mPassword,
                    placeholder = "Password",
                    leadingIcon = {
                        Icon(
                            imageVector = Icons.Rounded.Lock,
                            contentDescription = stringResource(R.string.lock_icon),
                            tint = Black
                        )
                    },
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

                Text(
                    text = "Forgot Password?",
                    modifier = Modifier
                        .padding(top = 8.dp, bottom = 12.dp)
                        .fillMaxWidth()
                        .clickable {
                            navController.navigate(AuthScreen.ForgotPassword.route)
                        },
                    style = TextStyle(textAlign = TextAlign.End, color = White)
                )
                Spacer(modifier = Modifier.height(30.dp))

                GradientButton(text = stringResource(R.string.login), onClick = {
                    mViewModel.loginUser(ctx)
                })

                Spacer(modifier = Modifier.height(36.dp))

                TextButton(onClick = { navController.navigate(AuthScreen.SignUp.route) }) {
                    Text(text = "Not Registered yet? Create an Account")
                }
            }
        }
    }
}

@Preview
@Composable
fun PreviewLoginScreen() {
    LoginScreen(navController = rememberNavController())
}