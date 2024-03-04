package com.encoreevents.app.ui.feature.register

import android.content.Context
import androidx.compose.foundation.Image
import androidx.compose.foundation.background
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
import androidx.compose.material.icons.rounded.Email
import androidx.compose.material.icons.rounded.Lock
import androidx.compose.material.icons.rounded.Person
import androidx.compose.material.icons.rounded.Phone
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
import androidx.compose.ui.text.input.KeyboardCapitalization
import androidx.compose.ui.text.input.KeyboardType
import androidx.compose.ui.text.input.PasswordVisualTransformation
import androidx.compose.ui.text.input.VisualTransformation
import androidx.compose.ui.tooling.preview.Preview
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.hilt.navigation.compose.hiltViewModel
import androidx.navigation.NavHostController
import androidx.navigation.compose.rememberNavController
import com.encoreevents.app.R
import com.encoreevents.app.ui.components.BackButton
import com.encoreevents.app.ui.components.BlackText
import com.encoreevents.app.ui.components.CustomHorizontalRadioGroup
import com.encoreevents.app.ui.components.CustomTextField
import com.encoreevents.app.ui.components.GradientButton
import com.encoreevents.app.ui.components.LoadingDialog
import com.encoreevents.app.ui.components.TitleText
import com.encoreevents.app.ui.theme.ScreenBackground
import com.encoreevents.app.utils.Utils

@Composable
fun RegistrationScreen(
    navController: NavHostController,
    mViewModel: RegisterViewModel = hiltViewModel()
) {
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
                TitleText("Welcome!", modifier = Modifier.fillMaxWidth())
                Spacer(modifier = Modifier.height(12.dp))
                Text(
                    text = "Hello there Sign Up to Continue",
                    style = TextStyle(fontSize = 12.sp, color = Color.White)
                )
                Spacer(modifier = Modifier.height(30.dp))

                SignUpForm(navController, mViewModel = mViewModel)

                Spacer(modifier = Modifier.height(30.dp))
            }
        }
    }
}

@OptIn(ExperimentalComposeUiApi::class)
@Composable
fun SignUpForm(
    navController: NavHostController,
    ctx: Context = LocalContext.current,
    mViewModel: RegisterViewModel
) {
    val passwordVisible = remember {
        mutableStateOf(false)
    }
    val confirmPasswordVisible = remember {
        mutableStateOf(false)
    }
    val userTypeList = listOf("User", "Promoter")
    val (selectedUserType, setSelectedUserType) = remember { mutableStateOf(userTypeList[mViewModel.mUserType.value]) }

    val openDialog = remember {
        mutableStateOf(true)
    }
    var showLoadingDialog by remember { mutableStateOf(true) }
    val focusManager = LocalFocusManager.current

    when (val mRegisterApiResponse = mViewModel.registerApiResponse.observeAsState().value) {
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
                        BlackText(text = "Successful Registration")
                    },
                    text = {
                        BlackText(text = "We have sent verification link to your account to continue with the registration process.")
                    },
                    confirmButton = {
                        TextButton(onClick = {
                            openDialog.value = false
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
            Utils.showShortToast(ctx, mRegisterApiResponse.errorMessage.toString())
        }

        else -> {
            showLoadingDialog = true
        }
    }

    // User Type Radio Buttons
    CustomHorizontalRadioGroup(
        radioOptions = userTypeList,
        selectedOption = selectedUserType,
        setSelectedUserType
    )
    Spacer(modifier = Modifier.height(18.dp))

    // First name text field
    CustomTextField(
        value = mViewModel.mFirstName,
        placeholder = "First Name*",
        keyboardOptions = KeyboardOptions(
            imeAction = ImeAction.Next, capitalization = KeyboardCapitalization.Words
        ),
        keyboardActions = KeyboardActions(onNext = {
            focusManager.moveFocus(FocusDirection.Down)
        }),
        leadingIcon = {
            Icon(
                imageVector = Icons.Rounded.Person, contentDescription = "Person Icon",
                tint = Black
            )
        }
    )
    Spacer(modifier = Modifier.height(18.dp))

    // Last name text field
    CustomTextField(
        value = mViewModel.mLastName,
        placeholder = "Last Name*",
        keyboardOptions = KeyboardOptions(
            imeAction = ImeAction.Next, capitalization = KeyboardCapitalization.Words
        ),
        keyboardActions = KeyboardActions(onNext = {
            focusManager.moveFocus(FocusDirection.Down)
        }),
        leadingIcon = {
            Icon(
                imageVector = Icons.Rounded.Person, contentDescription = "Person Icon",
                tint = Black
            )
        }
    )
    Spacer(modifier = Modifier.height(18.dp))

    // Email text field
    CustomTextField(
        value = mViewModel.mEmail,
        placeholder = "Email*",
        keyboardOptions = KeyboardOptions(
            imeAction = ImeAction.Next, keyboardType = KeyboardType.Email
        ),
        keyboardActions = KeyboardActions(onNext = {
            focusManager.moveFocus(FocusDirection.Down)
        }),
        leadingIcon = {
            Icon(
                imageVector = Icons.Rounded.Email, contentDescription = "Email Icon",
                tint = Black
            )
        }
    )
    Spacer(modifier = Modifier.height(18.dp))

    // Phone text field
    CustomTextField(
        value = mViewModel.mPhone,
        placeholder = "Phone*",
        maxLength = 10,
        keyboardOptions = KeyboardOptions(
            imeAction = ImeAction.Next, keyboardType = KeyboardType.Phone
        ),
        keyboardActions = KeyboardActions(onNext = {
            focusManager.moveFocus(FocusDirection.Down)
        }),
        leadingIcon = {
            Icon(
                imageVector = Icons.Rounded.Phone, contentDescription = "Phone Icon",
                tint = Black
            )
        }
    )
    Spacer(modifier = Modifier.height(18.dp))

    // Company Name Text Field
    CustomTextField(
        value = mViewModel.mCompanyName,
        placeholder = "Company Name*",
        keyboardOptions = KeyboardOptions(
            imeAction = ImeAction.Next,
            keyboardType = KeyboardType.Text,
            capitalization = KeyboardCapitalization.Words
        ),
        keyboardActions = KeyboardActions(onNext = {
            focusManager.moveFocus(FocusDirection.Down)
        }),
        leadingIcon = {
            Icon(
                painter = painterResource(id = R.drawable.ic_company),
                contentDescription = "Company Icon",
                tint = Black
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

    GradientButton(text = "Sign Up", onClick = {
        mViewModel.registerUser(ctx)
    })
}

@Preview
@Composable
fun PreviewRegistrationScreen() {
    RegistrationScreen(navController = rememberNavController())
}