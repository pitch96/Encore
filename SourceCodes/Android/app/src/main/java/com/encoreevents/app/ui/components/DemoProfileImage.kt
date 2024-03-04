package com.encoreevents.app.ui.components

import androidx.compose.foundation.Image
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.shape.CircleShape
import androidx.compose.runtime.Composable
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.layout.ContentScale
import androidx.compose.ui.res.painterResource
import com.encoreevents.app.R

@Composable
fun DemoProfileImage() {
    Image(
        painter = painterResource(id = R.drawable.ic_person),
        contentDescription = "",
        modifier = Modifier
            .clip(shape = CircleShape)
            .fillMaxSize(),
        contentScale = ContentScale.Crop
    )
}