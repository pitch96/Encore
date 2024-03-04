package com.encoreevents.app.ui.feature.dashboard

import android.annotation.SuppressLint
import android.os.Build
import android.util.Log
import androidx.annotation.RequiresApi
import androidx.compose.foundation.Image
import androidx.compose.foundation.background
import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.Row
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.height
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.layout.wrapContentWidth
import androidx.compose.material.Scaffold
import androidx.compose.material.rememberScaffoldState
import androidx.compose.material3.AlertDialog
import androidx.compose.material3.Icon
import androidx.compose.material3.IconButton
import androidx.compose.material3.TextButton
import androidx.compose.runtime.Composable
import androidx.compose.runtime.LaunchedEffect
import androidx.compose.runtime.collectAsState
import androidx.compose.runtime.getValue
import androidx.compose.runtime.livedata.observeAsState
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.remember
import androidx.compose.runtime.rememberCoroutineScope
import androidx.compose.runtime.setValue
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.platform.LocalContext
import androidx.compose.ui.res.painterResource
import androidx.compose.ui.unit.dp
import androidx.hilt.navigation.compose.hiltViewModel
import androidx.navigation.NavHostController
import com.encoreevents.app.R
import com.encoreevents.app.data.model.response.ApiResponse
import com.encoreevents.app.data.model.response.get_banners.BannerData
import com.encoreevents.app.ui.components.BlackText
import com.encoreevents.app.ui.components.HomePage
import com.encoreevents.app.ui.components.LoadingDialog
import com.encoreevents.app.ui.theme.ScreenBackground
import com.encoreevents.app.utils.Utils.Companion.showShortToast
import kotlinx.coroutines.launch

private const val TAG = "DashboardScreen"

enum class UserType(val type: Int) { ADMIN(1), USER(2), PROMOTER(3) }

@RequiresApi(Build.VERSION_CODES.O)
@SuppressLint("UnusedMaterialScaffoldPaddingParameter")
@Composable
fun DashboardScreen(
    navController: NavHostController,
    mViewModel: DashboardViewModel = hiltViewModel()
) {
    val ctx = LocalContext.current
    val scope = rememberCoroutineScope()
    val scaffoldState = rememberScaffoldState()
    var showLoadingDialog by remember { mutableStateOf(true) }
    val userLoggedInToken: String by mViewModel.userToken.collectAsState()
    val userType: Int by mViewModel.userType.collectAsState()
    val showLogoutConfirmDialog = mViewModel.mShowLogoutConfirmDialog.observeAsState()
    val mLogoutApiResponse = mViewModel.logoutApiResponse.observeAsState().value
    val mBannersApiResponse = mViewModel.bannersApiResponse.observeAsState().value
    val mAccountApiResponse = mViewModel.accountApiResponse.observeAsState().value
    var mBannersData: List<BannerData> = remember {
        mutableListOf()
    }

    when (mBannersApiResponse) {
        is ApiResponse.Loading -> {
            if (showLoadingDialog) {
                LoadingDialog()
            }
        }

        is ApiResponse.Success -> {
            showLoadingDialog = false
            mBannersApiResponse.data?.let {
                if (it.success) {
                    mBannersData = it.data
                }
            }
        }

        is ApiResponse.Error -> {
            showLoadingDialog = true
            showShortToast(ctx, mBannersApiResponse.errorMessage.toString())
        }

        else -> {
            showLoadingDialog = true
        }
    }

    when (mAccountApiResponse) {
        is ApiResponse.Loading -> {
            if (showLoadingDialog) {
                LoadingDialog()
            }
        }

        is ApiResponse.Success -> {
            showLoadingDialog = false
            mAccountApiResponse.data?.let {
                if (it.success) {
                    Log.d(TAG, "DashboardScreen: user Data: ${it.data}")
                    with(it.data) {
                        mViewModel.saveUserData(
                            id = id,
                            userType = user_type,
                            firstName = first_name,
                            lastName = last_name,
                            email = email,
                            phoneNo = phone_no,
                            companyName = company_name,
                            status = status,
                            userProfile = user_image
                        )
                    }
                }
            }
        }

        is ApiResponse.Error -> {
            showLoadingDialog = true
            showShortToast(ctx, mAccountApiResponse.errorMessage.toString())
        }

        else -> {
            showLoadingDialog = true
        }
    }

    when (mLogoutApiResponse) {
        is ApiResponse.Loading -> {
            if (showLoadingDialog) {
                LoadingDialog()
            }
        }

        is ApiResponse.Success -> {
            showLoadingDialog = false
            mLogoutApiResponse.data?.let {
                LaunchedEffect(Unit) {
                    showShortToast(ctx, it.message)
                    mViewModel.saveUserLoggedOut(navController)
                }
            }
        }

        is ApiResponse.Error -> {
            showLoadingDialog = true
            LaunchedEffect(Unit) {
                showShortToast(ctx, mLogoutApiResponse.errorMessage.toString())
            }
        }

        else -> {
            showLoadingDialog = true
        }
    }

    if (showLogoutConfirmDialog.value == true) {
        LogoutConfirmDialog(mViewModel, userLoggedInToken)
    }

    Scaffold(
        scaffoldState = scaffoldState,
        drawerContent = {
            when (userType) {
                UserType.ADMIN.type -> AdminDrawerContent(
                    mViewModel,
                    navController,
                    scaffoldState,
                    scope
                )

                UserType.PROMOTER.type -> AdminDrawerContent(
                    mViewModel,
                    navController,
                    scaffoldState,
                    scope
                )

                UserType.USER.type -> UserDrawerContent(
                    mViewModel,
                    navController,
                    scaffoldState,
                    scope
                )
            }
        },
        drawerBackgroundColor = ScreenBackground
    ) {
        Box(
            modifier = Modifier
                .fillMaxSize()
                .background(ScreenBackground)
        ) {
            Column(
                modifier = Modifier
                    .fillMaxSize()
                    .padding(16.dp)
            ) {
                Row(
                    modifier = Modifier.fillMaxWidth(),
                    verticalAlignment = Alignment.CenterVertically,
                    horizontalArrangement = Arrangement.SpaceBetween
                ) {
                    Row(
                        modifier = Modifier.wrapContentWidth(),
                        verticalAlignment = Alignment.CenterVertically
                    ) {
                        IconButton(onClick = {
                            scope.launch { scaffoldState.drawerState.open() }
                        }) {
                            Icon(
                                painter = painterResource(id = R.drawable.ic_toggle),
                                contentDescription = "toggle icon",
                                tint = Color.White
                            )
                        }
                        Image(
                            painter = painterResource(id = R.drawable.ic_encore_events),
                            contentDescription = "",
                            modifier = Modifier.height(40.dp)
                        )
                    }

                    /*GradientButton(text = "Logout", onClick = {
                        mViewModel.showLogoutConfirmDialog(true)
                    }, wrapContentWidth = true)*/
                }

                HomePage(navController = navController)
            }
        }
    }
}

@Composable
fun LogoutConfirmDialog(mViewModel: DashboardViewModel, userLoggedInToken: String) {
    AlertDialog(
        onDismissRequest = { mViewModel.showLogoutConfirmDialog(false) },
        title = {
            BlackText(text = "Logout")
        },
        text = {
            BlackText(text = "Are you sure you want to logout?")
        },
        confirmButton = {
            TextButton(onClick = {
                mViewModel.logoutUser(userLoggedInToken)
            }) {
                BlackText(text = "Ok")
            }
        },
        dismissButton = {
            TextButton(onClick = {
                mViewModel.showLogoutConfirmDialog(false)
            }) {
                BlackText(text = "Cancel")
            }
        }
    )
}