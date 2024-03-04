package com.encoreevents.app.ui.feature.bottom_bar

import com.encoreevents.app.R

sealed class BottomBarScreen(
    val route: String,
    val title: String, // For Future Use
    val icon: Int
) {
    object Dashboard : BottomBarScreen(
        route = "DASHBOARD_SCREEN",
        title = "Dashboard",
        icon = R.drawable.ic_home
    )

    object Profile : BottomBarScreen(
        route = "PROFILE_SCREEN",
        title = "Profile",
        icon = R.drawable.ic_person
    )

    object Cart : BottomBarScreen(
        route = "CART_SCREEN",
        title = "Cart",
        icon = R.drawable.ic_cart
    )

    object Orders : BottomBarScreen(
        route = "ORDERS_SCREEN",
        title = "Orders",
        icon = R.drawable.ic_mobile_order
    )
}
