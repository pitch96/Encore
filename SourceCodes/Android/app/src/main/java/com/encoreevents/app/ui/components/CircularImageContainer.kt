package com.encoreevents.app.ui.components

import androidx.compose.foundation.background
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.layout.size
import androidx.compose.foundation.shape.CircleShape
import androidx.compose.runtime.Composable
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.tooling.preview.Preview
import androidx.compose.ui.unit.dp

@Composable
fun CircularImageContainer(
    image: @Composable () -> Unit
) {
    Box(
        modifier = Modifier
            .size(150.dp)
            .clip(shape = CircleShape)
            .background(Color.White)
            .padding(4.dp)
    ) {
        image()
    }
}

@Preview
@Composable
fun PreviewCircularImageContainer() {
    CircularImageContainer { DemoProfileImage() }
}