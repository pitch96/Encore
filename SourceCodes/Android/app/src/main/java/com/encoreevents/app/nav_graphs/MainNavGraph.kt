package com.encoreevents.app.nav_graphs

import android.os.Build
import androidx.annotation.RequiresApi
import androidx.compose.runtime.Composable
import androidx.hilt.navigation.compose.hiltViewModel
import androidx.navigation.NavGraphBuilder
import androidx.navigation.NavHostController
import androidx.navigation.compose.composable
import androidx.navigation.navigation
import com.encoreevents.app.ui.Graph
import com.encoreevents.app.ui.feature.bottom_bar.BottomBarScreen
import com.encoreevents.app.ui.feature.cart.CartScreen
import com.encoreevents.app.ui.feature.create_event.CreateEventScreen
import com.encoreevents.app.ui.feature.create_event.CreateEventViewModel
import com.encoreevents.app.ui.feature.dashboard.DashboardScreen
import com.encoreevents.app.ui.feature.dashboard.DashboardViewModel
import com.encoreevents.app.ui.feature.order.OrderScreen
import com.encoreevents.app.ui.feature.profile.ProfileScreen
import com.encoreevents.app.ui.feature.profile.UpdateProfileViewModel

@RequiresApi(Build.VERSION_CODES.O)
fun NavGraphBuilder.mainNavGraph(navController: NavHostController) {
    navigation(
        route = Graph.MAIN,
        startDestination = BottomBarScreen.Dashboard.route
    ) {
        composable(BottomBarScreen.Dashboard.route) {
            DashboardScreenDestination(navController = navController)
        }
        composable(BottomBarScreen.Profile.route) {
            ProfileScreenDestination()
        }
        composable(BottomBarScreen.Cart.route) {
            CartScreen()
        }
        composable(BottomBarScreen.Orders.route) {
            OrderScreen()
        }
        composable(MainScreen.CreateEvent.route) {
            CreateEventScreenDestination(navController)
        }
    }
}

@Composable
fun ProfileScreenDestination() {
    val viewModel: UpdateProfileViewModel = hiltViewModel()
    val dashViewModel: DashboardViewModel = hiltViewModel()
    ProfileScreen(viewModel, dashViewModel)
}

@RequiresApi(Build.VERSION_CODES.O)
@Composable
fun DashboardScreenDestination(navController: NavHostController) {
    val viewModel: DashboardViewModel = hiltViewModel()
    DashboardScreen(navController = navController, mViewModel = viewModel)
}

@Composable
fun CreateEventScreenDestination(navController: NavHostController) {
    val viewModel: CreateEventViewModel = hiltViewModel()
    CreateEventScreen(navController = navController, mViewModel = viewModel)
}

sealed class MainScreen(val route: String) {
    object CreateEvent : AuthScreen(route = "CREATE_EVENT")

    object Arg {
        const val USER_AUTH_TOKEN = "user_auth_token"
    }
}
