package com.encoreevents.app.ui.feature.dashboard

import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.shape.CircleShape
import androidx.compose.material.ScaffoldState
import androidx.compose.runtime.Composable
import androidx.compose.runtime.collectAsState
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.layout.ContentScale
import androidx.compose.ui.res.stringResource
import androidx.compose.ui.unit.dp
import androidx.navigation.NavHostController
import coil.compose.AsyncImage
import com.encoreevents.app.R
import com.encoreevents.app.nav_graphs.MainScreen
import com.encoreevents.app.ui.components.DemoProfileImage
import com.encoreevents.app.ui.components.MenuItem
import com.encoreevents.app.ui.components.NavDrawerHeader
import com.encoreevents.app.ui.feature.bottom_bar.BottomBarScreen
import kotlinx.coroutines.CoroutineScope
import kotlinx.coroutines.launch

@Composable
fun AdminDrawerContent(
    mViewModel: DashboardViewModel,
    navController: NavHostController,
    scaffoldState: ScaffoldState,
    scope: CoroutineScope
) {
    val userFullName =
        "${mViewModel.userFirstName.collectAsState().value} ${mViewModel.userLastName.collectAsState().value}"
    val userEmail = mViewModel.userEmail.collectAsState().value
    val userProfile = mViewModel.userProfile.collectAsState().value

    @Composable
    fun userImage() = if (!userProfile.isNullOrEmpty()) AsyncImage(
        model = userProfile,
        contentDescription = "User Image",
        modifier = Modifier
            .clip(shape = CircleShape)
            .fillMaxSize(),
        contentScale = ContentScale.Crop
    ) else DemoProfileImage()

    Column(modifier = Modifier.padding(horizontal = 10.dp)) {
        NavDrawerHeader(
            userImage = { userImage() },
            userName = userFullName,
            userEmail = userEmail
        )

        AdminNavDrawerBody(mViewModel, navController, scaffoldState, scope)
    }
}

@Composable
fun AdminNavDrawerBody(
    mViewModel: DashboardViewModel,
    navController: NavHostController,
    scaffoldState: ScaffoldState,
    scope: CoroutineScope
) {
    Column(
        modifier = Modifier.padding(vertical = 20.dp)
    ) {
        MenuItem(text = "My Account") { navController.navigate(BottomBarScreen.Profile.route) }
        MenuItem(text = "My Cart") { navController.navigate(BottomBarScreen.Cart.route) }
        MenuItem(text = "My Order") { navController.navigate(BottomBarScreen.Orders.route) }
        MenuItem(text = "Create Event") {
            navController.navigate(MainScreen.CreateEvent.route)
            scope.launch {
                scaffoldState.drawerState.close()
            }
        }
        MenuItem(text = stringResource(R.string.logout)) {
            mViewModel.showLogoutConfirmDialog(true)
        }
    }
}
