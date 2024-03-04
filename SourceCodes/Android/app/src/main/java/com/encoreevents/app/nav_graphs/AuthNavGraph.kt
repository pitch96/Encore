package com.encoreevents.app.nav_graphs

import android.os.Build
import androidx.annotation.RequiresApi
import androidx.compose.runtime.Composable
import androidx.hilt.navigation.compose.hiltViewModel
import androidx.navigation.NavGraphBuilder
import androidx.navigation.NavHostController
import androidx.navigation.NavType
import androidx.navigation.compose.composable
import androidx.navigation.navArgument
import androidx.navigation.navigation
import com.encoreevents.app.ui.Graph
import com.encoreevents.app.ui.feature.dashboard.DashboardViewModel
import com.encoreevents.app.ui.feature.forgot_password.ForgotPasswordScreen
import com.encoreevents.app.ui.feature.forgot_password.ForgotPasswordViewModel
import com.encoreevents.app.ui.feature.login.LoginScreen
import com.encoreevents.app.ui.feature.login.LoginViewModel
import com.encoreevents.app.ui.feature.register.RegisterViewModel
import com.encoreevents.app.ui.feature.register.RegistrationScreen
import com.encoreevents.app.ui.feature.reset_password.ResetPasswordScreen
import com.encoreevents.app.ui.feature.reset_password.ResetPasswordViewModel
import com.encoreevents.app.ui.feature.welcome.WelcomeScreen

@RequiresApi(Build.VERSION_CODES.O)
fun NavGraphBuilder.authNavGraph(navController: NavHostController) {
    navigation(
        route = Graph.AUTH,
        startDestination = AuthScreen.Welcome.route
    ) {
        composable(AuthScreen.Welcome.route) {
            WelcomeScreenDestination(navController)
        }
        composable(AuthScreen.Login.route) {
            LoginScreenDestination(navController)
        }
        composable(AuthScreen.SignUp.route) {
            RegistrationScreenDestination(navController)
        }
        composable(AuthScreen.ForgotPassword.route) {
            ForgotPasswordDestination(navController)
        }
        composable(
            "${AuthScreen.ResetPassword.route}/{${AuthScreen.Arg.USER_EMAIL_ID}}",
            arguments = listOf(navArgument(AuthScreen.Arg.USER_EMAIL_ID) {
                type = NavType.StringType
            })
        ) {
            ResetPasswordDestination(
                navController,
                it.arguments?.getString(AuthScreen.Arg.USER_EMAIL_ID)
            )
        }
    }
}

@RequiresApi(Build.VERSION_CODES.O)
@Composable
fun WelcomeScreenDestination(navController: NavHostController) {
    val viewModel: DashboardViewModel = hiltViewModel()
    WelcomeScreen(navController = navController, mViewModel = viewModel)
}

@Composable
private fun LoginScreenDestination(navController: NavHostController) {
    val viewModel: LoginViewModel = hiltViewModel()
    LoginScreen(navController = navController, mViewModel = viewModel)
}

@Composable
private fun RegistrationScreenDestination(navController: NavHostController) {
    val viewModel: RegisterViewModel = hiltViewModel()
    RegistrationScreen(navController = navController, mViewModel = viewModel)
}

@Composable
private fun ForgotPasswordDestination(navController: NavHostController) {
    val viewModel: ForgotPasswordViewModel = hiltViewModel()
    ForgotPasswordScreen(
        navController = navController,
        mViewModel = viewModel,
        onNavigationRequested = { emailId ->
            navController.navigate("${AuthScreen.ResetPassword.route}/${emailId}") {
                popUpTo(AuthScreen.Login.route)
            }
        })
}

@Composable
private fun ResetPasswordDestination(navController: NavHostController, userEmailId: String?) {
    val viewModel: ResetPasswordViewModel = hiltViewModel()
    ResetPasswordScreen(navController = navController, mViewModel = viewModel, userEmailId)
}

sealed class AuthScreen(val route: String) {
    object Welcome : AuthScreen(route = "WELCOME")
    object Login : AuthScreen(route = "LOGIN")
    object SignUp : AuthScreen(route = "SIGNUP")
    object ForgotPassword : AuthScreen(route = "FORGOT_PASSWORD")
    object ResetPassword : AuthScreen(route = "RESET_PASSWORD")

    object Arg {
        const val USER_EMAIL_ID = "user_email_id"
    }
}