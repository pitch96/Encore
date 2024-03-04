package com.encoreevents.app.ui.feature.welcome

import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.padding
import androidx.compose.runtime.Composable
import androidx.compose.ui.Modifier
import androidx.compose.ui.tooling.preview.Preview
import androidx.compose.ui.unit.dp
import com.encoreevents.app.ui.components.DemoProfileImage
import com.encoreevents.app.ui.components.MenuItem
import com.encoreevents.app.ui.components.NavDrawerHeader


@Composable
fun WelcomeDrawerContent() {
    Column(modifier = Modifier.padding(horizontal = 10.dp)) {
        NavDrawerHeader(
            userImage = { DemoProfileImage() },
            userName = "",
            userEmail = ""
        )
        WelcomeNavDrawerBody()
    }
}

@Composable
fun WelcomeNavDrawerBody() {
    Column(
        modifier = Modifier.padding(vertical = 26.dp)
    ) {
        MenuItem(text = "About Us", onClick = {})
        MenuItem(text = "Contact Us", onClick = {})
        MenuItem(text = "Terms & Conditions", onClick = {})
    }
}


@Preview
@Composable
fun PreviewWelcomeDrawerContent() {
    WelcomeDrawerContent()
}
