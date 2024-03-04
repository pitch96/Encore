package com.encoreevents.app.ui.components

import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Row
import androidx.compose.foundation.layout.Spacer
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.layout.width
import androidx.compose.runtime.Composable
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.tooling.preview.Preview
import androidx.compose.ui.unit.dp
import androidx.navigation.NavHostController
import androidx.navigation.compose.rememberNavController

@Composable
fun ScreenTopBar(
    title: String,
    navController: NavHostController?
) {
    Row(
        horizontalArrangement = Arrangement.SpaceBetween,
        verticalAlignment = Alignment.CenterVertically,
        modifier = Modifier.padding(vertical = 12.dp)
    ) {
        if (navController != null) BackButton(navController = navController)

        TitleText(title = title, modifier = Modifier.weight(1f))

        if (navController != null) Spacer(Modifier.width(50.dp))
    }
}

@Preview
@Composable
fun PreviewScreenTopBar() {
    ScreenTopBar("Test Title", navController = rememberNavController())
}