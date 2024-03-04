package com.encoreevents.app.ui.feature.welcome

import android.annotation.SuppressLint
import android.os.Build
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
import androidx.compose.material.ScaffoldState
import androidx.compose.material.rememberScaffoldState
import androidx.compose.material3.Icon
import androidx.compose.material3.IconButton
import androidx.compose.runtime.Composable
import androidx.compose.runtime.LaunchedEffect
import androidx.compose.runtime.collectAsState
import androidx.compose.runtime.getValue
import androidx.compose.runtime.rememberCoroutineScope
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.res.painterResource
import androidx.compose.ui.tooling.preview.Preview
import androidx.compose.ui.unit.dp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavHostController
import androidx.navigation.compose.rememberNavController
import com.encoreevents.app.R
import com.encoreevents.app.nav_graphs.AuthScreen
import com.encoreevents.app.ui.Graph
import com.encoreevents.app.ui.components.GradientButton
import com.encoreevents.app.ui.components.HomePage
import com.encoreevents.app.ui.feature.dashboard.DashboardViewModel
import com.encoreevents.app.ui.theme.ScreenBackground
import kotlinx.coroutines.launch

@RequiresApi(Build.VERSION_CODES.O)
@SuppressLint("UnusedMaterialScaffoldPaddingParameter")
@Composable
fun WelcomeScreen(
    navController: NavHostController,
    mViewModel: DashboardViewModel = viewModel()
) {
    val scaffoldState = rememberScaffoldState()
    val isUserLoggedIn: Boolean by mViewModel.userLoggedIn.collectAsState()

    if (isUserLoggedIn) {
        LaunchedEffect(Unit) {
            navController.popBackStack()
            navController.navigate(Graph.MAIN)
        }
    }

    Scaffold(
        scaffoldState = scaffoldState,
        drawerContent = { WelcomeDrawerContent() },
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
                    .padding(horizontal = 12.dp)
            ) {
                WelcomeScreenTopBar(scaffoldState, navController)

                HomePage(navController = navController, mViewModel = mViewModel)
            }
        }
    }
}

@Composable
fun WelcomeScreenTopBar(scaffoldState: ScaffoldState, navController: NavHostController) {
    val scope = rememberCoroutineScope()

    Row(
        modifier = Modifier
            .fillMaxWidth()
            .padding(top = 12.dp, bottom = 8.dp),
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
        GradientButton(
            text = "Login/Sign Up",
            modifier = Modifier.padding(end = 4.dp),
            onClick = {
                navController.navigate(AuthScreen.Login.route)
            }, wrapContentWidth = true
        )
    }
}

@Preview
@Composable
fun PreviewWelcomeScreenTopBar() {
    WelcomeScreenTopBar(
        scaffoldState = rememberScaffoldState(),
        navController = rememberNavController()
    )
}